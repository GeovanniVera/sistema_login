<?php
// index.php
require_once __DIR__ . '/app/core/Session.php';
require_once __DIR__ . '/app/controllers/AuthController.php';

Session::start();

$request = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

switch ($request) {
    case '/':
        if (Session::has('usuario')) {
            header('Location: /dashboard');
            exit();
        }
        require_once __DIR__ . '/app/views/login.php';
        break;
    case '/registro':
        $authController = new AuthController();
        $authController->registro();
        break;
    case '/login':
        $authController = new AuthController();
        $authController->login();
        break;
    case '/logout':
        $authController = new AuthController();
        $authController->logout();
        break;
    case '/dashboard':
        if (!Session::has('usuario')) {
            header('Location: /login');
            exit();
        }
        require_once __DIR__ . '/app/views/dashboard.php';
        break;
    default:
    http_response_code(404); // Establece el código de estado HTTP 404
    require_once __DIR__ . '/app/views/404.php';
    break;
}
?>