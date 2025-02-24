<?php
// 1. Incluir el autoloader de Composer
require __DIR__ . DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'vendor'.DIRECTORY_SEPARATOR.'autoload.php';



// 2. Configuración global (opcional)
define('BASE_PATH', realpath(__DIR__ . '/../'));

// 3. Importar las clases necesarias
use App\Core\Session;
use App\Controllers\AuthController;
use App\Controllers\UserController;
use App\Controllers\InsumosController;

// 4. Iniciar la sesión

Session::start();


try {
    // 5. Obtener la ruta solicitada
    $request = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

    // 6. Manejar rutas dinámicas
    if (preg_match('/^\/usuarios\/eliminar\/(\d+)$/', $request, $matches)) { 
        $id = $matches[1];
        $userController = new UserController();
        $userController->eliminarUsuario($id);
        exit;
    }

    // Resto de rutas dinámicas (ej: ver usuario)
    if (preg_match('/^\/usuarios\/ver\/(\d+)$/', $request, $matches)) { 
        $id = $matches[1];
        $userController = new UserController();
        $userController->verUsuario($id);
        exit();
    }

    // 7. Manejar rutas estáticas
    switch ($request) {
        case '/':
            if (Session::has('usuario')) {
                header('Location: /dashboard');
                exit();
            }
            require __DIR__ . DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'app'.DIRECTORY_SEPARATOR.'views'.DIRECTORY_SEPARATOR.'auth'.DIRECTORY_SEPARATOR.'login.php';

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
            $authController = new AuthController();
            $authController->dashboard();
            break;

        case '/usuarios':
            $userController = new UserController();
            $userController->listarUsuarios();
            break;
        case '/insumos':
            $insumosController = new InsumosController();
            $insumosController->listarInsumos();
            break;

        case '/nuevoInsumo':
            $insumosController = new InsumosController();
            $insumosController->insumoForm();
            $insumosController->registrar();
            break;

        default:
            http_response_code(404);
            require __DIR__ . DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'app'.DIRECTORY_SEPARATOR.'views'.DIRECTORY_SEPARATOR.'errors'.DIRECTORY_SEPARATOR.'404.php';
            break;
    }
} catch (Exception $e) {
    // Manejo de errores global
    error_log("Error en index.php: " . $e->getMessage());
    http_response_code(500);
    require __DIR__ . DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'app'.DIRECTORY_SEPARATOR.'views'.DIRECTORY_SEPARATOR.'errors'.DIRECTORY_SEPARATOR.'500.php';
}