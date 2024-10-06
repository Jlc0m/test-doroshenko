<?php

require_once __DIR__ . '/vendor/autoload.php';

use Dotenv\Dotenv;
use App\Controllers\HomeController;
use App\Controllers\AuthController;
use App\Controllers\AdminController;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

session_start();

$db = require __DIR__ . '/config/database.php';
$stmt = $db->query("SHOW TABLES");
if ($stmt->rowCount() == 0) {
    require_once __DIR__ . '/seeder.php';
}

$controller = new HomeController();
$authController = new AuthController();
$adminController = new AdminController();

$request = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

switch ($request) {
    case '/':
        $controller->index();
        break;
    case '/login':
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $authController->showLoginForm();
        } elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $authController->login();
        }
        break;
    case '/register':
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $authController->showRegistrationForm();
        } elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $authController->register();
        }
        break;
    case '/logout':
        $authController->logout();
        break;
    case '/admin':
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit;
        }
        $adminController->index();
        break;
    case '/admin/add-course':
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit;
        }
        $adminController->addCourse();
        break;
    case '/admin/add-lesson':
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit;
        }
        $adminController->addLesson();
        break;
    case '/add-file':
        $controller->addFile();
        break;
    case (preg_match('/^\/delete-file\/(\d+)$/', $request, $matches) ? true : false):
        $controller->deleteFile($matches[1]);
        break;
    case (preg_match('/^\/update-file\/(\d+)$/', $request, $matches) ? true : false):
        $controller->updateFile($matches[1]);
        break;
    default:
        http_response_code(404);
        echo "404 Not Found";
        break;
}