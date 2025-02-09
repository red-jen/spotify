<?php



// Ensure error reporting is on for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Set base directory
$base_dir = __DIR__;

// Require necessary files
require_once $base_dir . '../config/config.php';
require_once $base_dir . '../model/user.php';
require_once $base_dir . '../model/Player.php';
require_once $base_dir . '../model/Artist.php';
require_once $base_dir . '../reposetries/userReposetrie.php';
require_once $base_dir . '../controller/AuthController.php';

// Get the request URI
$request_uri = $_SERVER['REQUEST_URI'];

// Remove query string
$request_uri = strtok($request_uri, '?');

// Remove leading and trailing slashes
$request_uri = trim($request_uri, '/');

// Create AuthController
$authController = new AuthController();

// Simple routing logic
try {
    switch ($request_uri) {
        case 'login':
            $authController->login();
            break;
        case 'register':
            $authController->register();
            break;
        case 'logout':
            $authController->logout();
            break;
        case '':
            // Default to login page
            $authController->login();
            break;
        default:
            // 404 handling
            http_response_code(404);
            echo "404 Not Found";
            break;
    }
} catch (Exception $e) {
    // Error handling
    http_response_code(500);
    echo "Server Error: " . $e->getMessage();
}











// require_once '../config/config.php';
// require_once '../model/user.php';
// require_once '../model/Player.php';
// require_once '../model/Artist.php';
// require_once '../reposetries/userReposetrie.php';
// require_once '../controller/AuthController.php';

// $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// echo $uri;

// $authController = new AuthController();

// switch ($uri) {
//     case '/login':
      
//         $authController->login();
//         break;
//     case '/register':
//         $authController->register();
//         break;
//     case '/logout':
//         $authController->logout();
//         break;
//     default:
//          header('../viewer/index.html');
 
//         break;
// }



