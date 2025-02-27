<?php
// 1. Incluir el autoloader de Composer
require __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';



// 2. Configuración global (opcional)
define('BASE_PATH', realpath(__DIR__ . '/../'));

// 3. Importar las clases necesarias
use App\Core\Session;
use App\Controllers\AuthController;
use App\Controllers\UserController;
use App\Controllers\InsumosController;
use App\Dao\InsumoDao;
use App\Dao\UsuarioDao;
use App\Models\Autenticable;
use App\Models\Insumo;
use App\Models\Inventario;
use App\Models\Usuario;

// 4. Iniciar la sesión

Session::start();


try {
    // 5. Obtener la ruta solicitada
    $request = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

    // 6. Manejar rutas dinámicas
    if (preg_match('/^\/usuarios\/eliminar\/(\d+)$/', $request, $matches)) {
        $id = $matches[1];
        $userDao = new UsuarioDao();
        $userModel = new Usuario($userDao);
        $userController = new UserController($userModel);
        $userController->eliminarUsuario($id);
        exit;
    }

    if (preg_match('/^\/usuarios\/ver\/(\d+)$/', $request, $matches)) {
        $id = $matches[1];
        $userDao = new UsuarioDao();
        $userModel = new Usuario($userDao);
        $userController = new UserController($userModel);
        $userController->verUsuario($id);
        exit();
    }
    // Resto de rutas dinámicas (ej: ver usuario)
    if (preg_match('/^\/insumos\/ver\/(\d+)$/', $request, $matches)) {
        $id = $matches[1];
        $insumoDao = new InsumoDao();
        $insumoModel = new Insumo($insumoDao);
        $inventarioModel = new Inventario;
        $insumosController = new InsumosController($insumoModel, $inventarioModel);
        $insumosController->ver($id);
        exit();
    }

    if (preg_match('/^\/insumos\/eliminar\/(\d+)$/', $request, $matches)) {
        $id = $matches[1];
        $insumoDao = new InsumoDao();
        $insumoModel = new Insumo($insumoDao);
        $inventarioModel = new Inventario;
        $insumosController = new InsumosController($insumoModel, $inventarioModel);
        $insumosController->eliminar($id);
        exit;
    }


    if (preg_match('/^\/insumos\/actualizar\/(\d+)$/', $request, $matches)) {
        $id = $matches[1];
        $insumoDao = new InsumoDao();
        $insumoModel = new Insumo($insumoDao);
        $inventarioModel = new Inventario;
        $insumosController = new InsumosController($insumoModel, $inventarioModel);
        $insumosController->ver($id);
        exit();
    }

    // 7. Manejar rutas estáticas
    switch ($request) {
        case '/':
            if (Session::has('usuario')) {
                header('Location: /dashboard');
                exit();
            }
            require __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . 'auth' . DIRECTORY_SEPARATOR . 'login.php';

            break;

        case '/registro':
            $userDao = new UsuarioDao();
            $userModel = new Usuario($userDao);
            $authModel = new Autenticable;
            $authController = new AuthController($userModel, $authModel);
            $authController->registroForm();
            $authController->registro();
            break;

        case '/login':
            $userDao = new UsuarioDao();
            $userModel = new Usuario($userDao);
            $authModel = new Autenticable;
            $authController = new AuthController($userModel, $authModel);
            $authController->loginForm();
            $authController->login();
            break;

        case '/logout':
            $userDao = new UsuarioDao();
            $userModel = new Usuario($userDao);
            $authModel = new Autenticable;
            $authController = new AuthController($userModel, $authModel);
            $authController->logout();
            break;

        case '/dashboard':
            $userDao = new UsuarioDao();
            $userModel = new Usuario($userDao);
            $authModel = new Autenticable;
            $authController = new AuthController($userModel, $authModel);
            $authController->dashboard();
            break;

        case '/usuarios':
            $userDao = new UsuarioDao();
            $userModel = new Usuario($userDao);
            $userController = new UserController($userModel);
            $userController->listarUsuarios();
            break;
        case '/insumos':
            $insumoDao = new InsumoDao();
            $insumoModel = new Insumo($insumoDao);
            $inventarioModel = new Inventario;
            $insumosController = new InsumosController($insumoModel, $inventarioModel);
            $insumosController->listarInsumos();
            break;

        case '/nuevoInsumo':
            $insumoDao = new InsumoDao();
            $insumoModel = new Insumo($insumoDao);
            $inventarioModel = new Inventario;
            $insumosController = new InsumosController($insumoModel, $inventarioModel);
            $insumosController->insumoForm();
            $insumosController->registrar();
            break;

        default:
            http_response_code(404);
            require __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . 'errors' . DIRECTORY_SEPARATOR . '404.php';
            break;
    }
} catch (Exception $e) {
    // Manejo de errores global
    error_log("Error en index.php: " . $e->getMessage());
    http_response_code(500);
    require __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . 'errors' . DIRECTORY_SEPARATOR . '500.php';
}
