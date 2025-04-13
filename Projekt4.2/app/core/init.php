<?php

// Application Initializer

// --- 1. Load Configuration ---
if (!isset($conf)) { $conf = new stdClass(); }
require_once dirname(__FILE__).'/../../config.php'; // Загружаем config.php

// --- 2. Setup Environment ---
// Error reporting (Development vs Production)
if (!empty($conf->debug)) { // Проверяем, установлена ли и истинна ли conf->debug
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
} else {
    error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED); // Скрываем notice/deprecated на продакшене
    ini_set('display_errors', 0);
}

// --- 3. Calculate Paths and URLs ---
// Определяем root_path на основе расположения этого init.php (предполагаем, что он в app/core/)
$conf->root_path = dirname(dirname(dirname(__FILE__))); // Поднимаемся на два уровня от app/core к корню проекта

// Собираем базовые URL из конфигурации
$conf->app_url = $conf->protocol.'://'.$conf->server_name.$conf->app_root;
$conf->action_root = $conf->app_root.'/index.php?action='; // Используем index.php для действий
$conf->action_url = $conf->protocol.'://'.$conf->server_name.$conf->action_root;

// Определяем пути Smarty, используя DIRECTORY_SEPARATOR для совместимости
// Убеждаемся, что путь заканчивается разделителем каталогов
$conf->smarty_template_dir = $conf->root_path . DIRECTORY_SEPARATOR . 'templates' . DIRECTORY_SEPARATOR;
$conf->smarty_compile_dir  = $conf->root_path . DIRECTORY_SEPARATOR . 'templates_c' . DIRECTORY_SEPARATOR; // Убедитесь, что папка существует и доступна для записи
$conf->smarty_cache_dir    = $conf->root_path . DIRECTORY_SEPARATOR . 'cache' . DIRECTORY_SEPARATOR;       // Убедитесь, что папка существует и доступна для записи

// --- 4. Register Autoloader ---
// Подключаем определение ClassLoader ПЕРЕД его использованием
require_once $conf->root_path . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . 'core' . DIRECTORY_SEPARATOR . 'ClassLoader.class.php';
$loader = new \app\core\ClassLoader();

// Определяем сопоставления пространств имен (измените пути, если ваша структура отличается)
$loader->addNamespace('app\\controllers', $conf->root_path . DIRECTORY_SEPARATOR . 'controllers');
$loader->addNamespace('app\\models',      $conf->root_path . DIRECTORY_SEPARATOR . 'models');
$loader->addNamespace('app\\core',        $conf->root_path . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . 'core');
// Добавьте другие пространства имен, если у вас есть больше директорий (например, 'lib', 'services')

// Регистрируем автозагрузчик
$loader->register();

// --- 5. Start Session ---
// Должно быть вызвано до любого вывода
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// --- 6. Load NON-namespaced Libraries/Helpers ---
// Smarty может не следовать PSR-4 относительно нашей структуры, оставляем его require
require_once $conf->root_path . DIRECTORY_SEPARATOR . 'lib' . DIRECTORY_SEPARATOR . 'smarty' . DIRECTORY_SEPARATOR . 'Smarty.class.php'; // Убедитесь, что Smarty здесь
// Оставляем подключение файла с функциями
require_once $conf->root_path . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . 'core' . DIRECTORY_SEPARATOR . 'functions.php';
// Messages.class.php будет загружен автозагрузчиком

// --- 7. Optional: Initialize Global Objects ---
// Example: $conf->messages = new \app\models\Messages(); // Можно создать глобальный объект сообщений

// --- 8. Make Configuration Globally Accessible (if not already) ---
// Эта функция упрощает доступ к $conf из любого места после подключения init.php.
function &getConf(){ global $conf; return $conf; }

// --- End of Initialization ---
