<?php
// index.php
require __DIR__."./../sistema_login/index.php";
use App\Core\Session;
use App\Controllers\AuthController;
use App\Controllers\UserController;
use App\Controllers\InsumosController;

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
        require_once __DIR__ . '/app/views/auth/login.php';
        break;
    case '/registro':
        $authController = new AuthController();
        $authController->registroForm();
        $authController->registro();
        break;
    case '/login':
        $authController = new AuthController();
        $authController->loginForm();
        $authController->login();
        break;
    case '/logout':
        $authController = new AuthController();
        $authController->logout();
        break;
    case '/dashboard':
        if (!Session::has('usuario')) {
            header('Location: /');
            exit();
        }
        require_once __DIR__ . '/app/views/auth/dashboard.php';
        break;
    case '/usuarios':
        $userController = new UserController();
        $userController->listarUsuarios();
        break;
    case '/insumos':
        $insumosController = new InsumosController;
        $insumosController->listarInsumos();
        break;
    case '/nuevoInsumo':
        $insumosController = new InsumosController;
        $insumosController->insumoForm();
        $insumosController->registrar();
        break;
    default:
    http_response_code(404); // Establece el código de estado HTTP 404
    require_once __DIR__ . '/app/views/404.php';
    break;
}
?>