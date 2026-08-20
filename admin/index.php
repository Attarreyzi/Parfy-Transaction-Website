<?php
require_once __DIR__ . '/../config/database.php';

$uri = rawurldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
$clean = preg_replace('#^.*/admin#i', '', $uri);
$clean = trim($clean, '/');

if (empty($clean) || $clean === 'login' || $clean === 'login.php' || $clean === 'index.php') {
    require_once __DIR__ . '/login.php';
    exit;
}

$file = __DIR__ . '/' . $clean;
if (file_exists($file . '.php')) {
    require_once $file . '.php';
    exit;
}

if (file_exists($file) && is_file($file)) {
    require_once $file;
    exit;
}

require_once __DIR__ . '/login.php';
