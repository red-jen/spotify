<?php
// index.php

// Define base directory
define('BASE_DIR', __DIR__);

// Require the autoloader
require_once BASE_DIR . '/autoload/Autoloader.php';

// Register the autoloader
Autoloader::register();

// Error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Initialize routing
$request_uri = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');

// Basic routing logic
$routes = [
    'login' => ['controller' => 'AuthController', 'action' => 'login'],
    'register' => ['controller' => 'AuthController', 'action' => 'register'],
    'logout' => ['controller' => 'AuthController', 'action' => 'logout'],
    'artist' => ['controller' => 'ArtistController', 'action' => 'index'],
    'admin' => ['controller' => 'AdminController', 'action' => 'index'],
    '' => ['controller' => 'AuthController', 'action' => 'login']  // default route
];

try {
    if (isset($routes[$request_uri])) {
        $controllerName = $routes[$request_uri]['controller'];
        $actionName = $routes[$request_uri]['action'];
        
        $controller = new $controllerName();
        $controller->$actionName();
    } else {
        http_response_code(404);
        require BASE_DIR . '/views/404.php';
    }
} catch (Exception $e) {
    error_log($e->getMessage());
    http_response_code(500);
    require BASE_DIR . '/views/500.php';
}