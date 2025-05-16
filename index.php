<?php
define('BASE_PATH', __DIR__."/");

if (!file_exists('.env')){
    throw new Exception(".env file not found");
}
$lines = file('.env', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

foreach($lines as $line){
    if ($line === '' || substr($line, 0, 1) === '#') {
        continue;
    }
    if (strpos($line, '=') !== false) {
        list($name, $value) = explode('=', $line, 2);
        $name = trim($name);
        $value = trim($value, " \t\n\r\0\x0B\"'");

        if (!defined($name)) {
            define($name, $value);
        }
    }
}

spl_autoload_register(function ($class) {
    $class = str_replace('\\', DIRECTORY_SEPARATOR, $class);
    require_once __DIR__ . "/$class.php";
});

require_once __DIR__ . '/routes/web.php';

use App\Core\Route;
$method = $_SERVER['REQUEST_METHOD'];
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
Route::dispatch($method,$uri);
