<?php
// Application Configuration

// --- Basic Settings ---
$conf->debug = true; // Установите false на рабочем сервере
$conf->server_name = 'localhost'; // Адрес сервера (обычно localhost для XAMPP)
$conf->protocol = 'http';           // http или https

// *** ВАЖНО: Убедитесь, что это имя папки вашего проекта внутри htdocs ***
// *** БЕЗ СЛЭША '/' В КОНЦЕ ***
$conf->app_root = '/Projekt4.2'; // <-- Проверьте это значение!

// --- Derived URLs (constructed in init.php) ---
// $conf->root_path (set automatically in init.php)
// $conf->app_url
// $conf->action_root
// $conf->action_url

// --- Smarty Settings ---
// Directory paths relative to $conf->root_path (set in init.php)
// $conf->smarty_template_dir
// $conf->smarty_compile_dir
// $conf->smarty_cache_dir

// --- Role Management ---
$conf->roles = ['guest', 'user', 'admin']; // Определите доступные роли
$conf->default_role = 'guest';           // Роль по умолчанию для неавторизованных пользователей

// --- Database Settings (Example - if needed later) ---
// $conf->db_type = 'mysql';
// $conf->db_server = 'localhost';
// $conf->db_name = 'your_db_name';
// $conf->db_user = 'your_db_user';
// $conf->db_pass = 'your_db_password';
// $conf->db_charset = 'utf8';
// $conf->db_port = '3306';
// $conf->db_option = [ PDO::ATTR_CASE => PDO::CASE_NATURAL, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION ];

// --- Global object placeholders (initialized in init.php) ---
// $conf->smarty // Smarty instance might be stored here
// $conf->messages // Global messages object might be stored here
