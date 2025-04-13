<?php

namespace app\core; // Помещаем класс в пространство имен app\core

class ClassLoader {
    private $prefixLengthsPsr4 = [];
    private $prefixDirsPsr4 = [];
    private $fallbackDirsPsr4 = [];
    private $registered = false;

    /**
     * Регистрирует автозагрузчик.
     */
    public function register() {
        if ($this->registered) {
            return;
        }
        // Используем spl_autoload_register для добавления нашего метода 'loadClass' в очередь автозагрузки
        spl_autoload_register([$this, 'loadClass'], true, true); // true, true = throw exceptions, prepend autoloader
        $this->registered = true;
    }

    /**
     * Отменяет регистрацию автозагрузчика.
     */
    public function unregister() {
        if (!$this->registered) {
            return;
        }
        spl_autoload_unregister([$this, 'loadClass']);
        $this->registered = false;
    }

    /**
     * Добавляет базовую директорию для префикса пространства имен (PSR-4).
     *
     * @param string $prefix Префикс пространства имен (например, 'app\\controllers\\').
     * @param string $baseDir Базовая директория для файлов классов в этом пространстве имен (например, '/path/to/controllers').
     */
    public function addNamespace(string $prefix, string $baseDir) {
        $prefix = trim($prefix, '\\') . '\\';
        // Убеждаемся, что путь заканчивается разделителем
        $baseDir = rtrim($baseDir, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;
        // Оптимизация: группируем по первой букве префикса
        if (isset($prefix[0])) {
            $this->prefixLengthsPsr4[$prefix[0]][$prefix] = strlen($prefix);
            $this->prefixDirsPsr4[$prefix] = $baseDir;
        }
    }

    /**
     * Добавляет резервную директорию для поиска классов (если не найдено через namespace).
     *
     * @param string $baseDir Базовая директория для поиска.
     */
     public function addFallbackDir(string $baseDir) {
         $this->fallbackDirsPsr4[] = rtrim($baseDir, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;
     }

    /**
     * Загружает файл класса для заданного имени класса.
     * Этот метод вызывается PHP автоматически.
     *
     * @param string $class Полное имя класса (с пространством имен).
     * @return string|false Путь к файлу класса в случае успеха, иначе false.
     */
    public function loadClass(string $class) {
        $class = trim($class, '\\'); // Убираем возможный ведущий слэш
        $file = $this->findFile($class);

        if ($file) {
            // Используем require_once для безопасности и предотвращения повторной загрузки
            require_once $file;
            return $file; // Возвращаем путь к файлу
        }
        // Если файл не найден, возвращаем false, чтобы PHP мог попробовать другие автозагрузчики
        return false;
    }

    /**
     * Находит путь к файлу, соответствующему имени класса.
     *
     * @param string $class Полное имя класса.
     * @return string|false Путь к файлу, если найден, иначе false.
     */
    private function findFile(string $class) {
        // PSR-4 поиск
        // Предполагаем, что файлы классов имеют суффикс .class.php
        $logicalPathPsr4 = strtr($class, '\\', DIRECTORY_SEPARATOR) . '.class.php';

        // Проверяем совпадения с зарегистрированными префиксами пространств имен
        $first = $class[0] ?? null; // Первая буква класса (для оптимизации)
        if (isset($this->prefixLengthsPsr4[$first])) {
            foreach ($this->prefixLengthsPsr4[$first] as $prefix => $length) {
                // Если имя класса начинается с префикса
                if (0 === strpos($class, $prefix)) {
                    $baseDir = $this->prefixDirsPsr4[$prefix];
                    // Формируем полный путь к файлу
                    // substr($logicalPathPsr4, $length) - часть пути после префикса
                    $file = $baseDir . substr($logicalPathPsr4, $length);
                    // Проверяем, существует ли файл
                    if (file_exists($file)) {
                        return $file;
                    }
                }
            }
        }

        // Поиск в резервных директориях (если есть)
        foreach ($this->fallbackDirsPsr4 as $baseDir) {
            $file = $baseDir . $logicalPathPsr4;
            if (file_exists($file)) {
                return $file;
            }
        }

        // Файл класса не найден ни одним из способов
        return false;
    }
}
