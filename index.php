<?php
// index.php
require_once __DIR__ . '/app/core/Session.php';
require_once __DIR__ . '/app/controllers/AuthController.php';
require_once __DIR__ . '/app/controllers/UserController.php';

Session::start();

$request = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

//Menejar rutas dinamicas
if (preg_match('/^\/usuario\/(\d+)$/', $request, $matches)) {
    $id = $matches[1]; // Capturar el ID
    $userController = new UserController();
    $userController->verUsuario($id);
    exit();
}

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
        $authController->registroForm();
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
    case '/usuarios':
        $userController = new UserController();
        $userController->listarUsuarios();
        break;
    default:
    http_response_code(404); // Establece el código de estado HTTP 404
    require_once __DIR__ . '/app/views/404.php';
    break;
}
?>