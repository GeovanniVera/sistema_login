<?php

namespace App\Controllers;

use App\Models\User;
use App\Core\Database;
use App\Core\Session;
use App\Validators\Validator;
use App\Controllers\BaseController;
use App\Models\Usuario;

class UserController extends BaseController
{
    //atributo del objeto Usuario
    private $userModel;

    public function __construct(Usuario $usuario)
    {
        $database = new Database;
        $this->userModel = $usuario;
        Session::start();
    }

    //Metodos del controlador
    public function listarUsuarios()
    {
        //Revisar que el usuario este logueado
        $this->checkAuth();

        $usuarios = $this->userModel->obtenerTodos();

        $error = Session::get('error');
        $isError = !empty($error);

        $mensaje = Session::get('mensaje');
        $isMensaje = !empty($mensaje); 

        if ($isError) Session::delete('error');
        if($isMensaje) Session::delete('mensaje');
        //implementar la vista
        $this->render('usuarios/index', [
            'usuarios' => $usuarios,
            'mensaje' => $mensaje,
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
        $this->render('usuarios/ver_usuario', [$usuario]);
    }

    public function eliminarUsuario($id): void
    {


        $this->checkAuth(); 

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
            if(!$resultado) Session::set('error', 'Error al eliminar el usuario');
            Session::set('mensaje', 'Usuario eliminado correctamente');
        } catch (\Exception $e) {
            Session::set('error', 'Error en la base de datos: ' . $e->getMessage());
        }
        
        header('Location: /usuarios');
        exit;
    }
}
