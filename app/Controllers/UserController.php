<?php

namespace App\Controllers;

use App\Models\User;
use App\Core\Database;
use App\Core\Session;
use App\Core\Validator;
use App\Controllers\BaseController;

class UserController extends BaseController
{
    //atributo del objeto Usuario
    private $userModel;

    public function __construct()
    {
        $database = new Database;
        $this->userModel = new User($database->getConnection());
        Session::start();
    }

    //Metodos del controlador
    public function listarUsuarios()
    {
        //Revisar que el usuario este logueado
        $this->checkAuth();

        $usuarios = $this->userModel->listar();

        $error = Session::get('error');
        $isError = !empty($error);

        if ($isError) {
            Session::delete('error');
        }
        //implementar la vista
        $this->render('usuarios/index', [
            'usuarios' => $usuarios,
            'isError' => $isError,
            'error' => $error
        ]);
    }

    public function verUsuario($id)
    {
        //Revisar que el usuario este logueado
        $this->checkAuth();

        // Validaciones
        $errores = [];
        if ($error = Validator::required($id, 'ID de usuario')) $errores[] = $error;
        if ($error = Validator::isInt($id, 'ID de usuario')) $errores[] = $error;
        if (!empty($errores)) {
            Session::set('error', implode('\n', $errores));
            header('Location: /usuarios');
            exit;
        }

        $usuario = $this->userModel->buscarPorId($id);

        if (!$usuario) {
            Session::set('error', 'Usuario no encontrado');
            header("Location: /usuarios");
            exit;
        }

        //implementar la vista
        $this->render('usuarios/ver_usuario', $usuario);
    }

    public function eliminarUsuario($id): void
    {


        $this->checkAuth(); // 🔐 Solo usuarios autenticados

        $errores = [];
        // Validación del ID
        if ($error = Validator::required($id, 'ID')) $errores[] = $error;
        if ($error = Validator::isInt($id, 'ID')) $errores[] = $error;

        if (!empty($errores)) {
            Session::set('error', implode('\n', $errores));
            header('Location: /usuarios');
            exit;
        }

        try {
            $resultado = $this->userModel->eliminar($id);

            if ($resultado) {
                Session::set('mensaje', 'Usuario eliminado correctamente');
            } else {
                Session::set('error', 'Error al eliminar el usuario');
            }
        } catch (\Exception $e) {
            Session::set('error', 'Error en la base de datos: ' . $e->getMessage());
        }
        header('Location: /usuarios');
        exit;
    }
}
