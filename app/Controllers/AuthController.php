<?php

namespace App\Controllers;

use App\Core\Session;
use App\Validators\UsuariosValidator;
use App\Controllers\BaseController;
use App\Models\Autenticable;
use App\Models\Usuario;

include __DIR__ . "/../helpers/funciones.php";
class AuthController extends BaseController
{
    private $userModel;
    private $autenticationModel;
    // Constructor
    public function __construct()
    {
        $this->userModel = new Usuario();
        $this->autenticationModel = new Autenticable();
        Session::start();
    }

    public function loginForm(): void
    {
        // Obtener y limpiar mensajes de la sesió
        $errores = Session::get('error', []);
        $mensaje = Session::get('mensaje');

        Session::delete('error');
        Session::delete('mensaje');

        $this->render('auth/login', [
            'errores' => $errores,
            'mensaje' => $mensaje
        ]);
    }

    // Procesar login
    public function login(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === "POST") {
            $email = htmlspecialchars($_POST['email']);
            $password = $_POST['password'];
            
            // Validaciones
            $errores = [];
            if ($error = UsuariosValidator::validarLogin($password, $email)) {
                foreach($error as $err){
                    $errores[]=$err;
                }
            }



            if (!empty($errores)) {
                Session::set('error', $errores);
                header('Location: /login');
                exit;
            }

            $usuario = $this->autenticationModel->verificarCredenciales($email, $password);


            if (!$usuario['success']) {
                Session::set('error', ['Usuario no encontrado']);
                header('Location: /login');
                exit;
            }

            if (!$usuario['successPass']) {
                Session::set('error', ['Contraseña Incorrecta']);
                header('Location: /login');
                exit;
            }


            Session::set('usuario', [
                'id' => $usuario['usuario']->getId(),
                'nombre' => $usuario['usuario']->getNombre(),
                'email' => $usuario['usuario']->getEmail()
            ]);


            Session::regenerate(); // Prevención de fixation
            header("Location: /dashboard");
        }
    }

    public function dashboard()
    {
        $this->checkAuth();
        $usuarioInfo = Session::get('usuario');
        $this->render("auth/dashboard", $usuarioInfo);
    }

    // Procesar registro
    public function registro(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombre = htmlspecialchars($_POST['nombre']);
            $email = htmlspecialchars($_POST['email']);
            $password = $_POST['password'];

            // Validaciones
            $errores = [];
            if ($error = UsuariosValidator::validarRegistro($nombre, $password, $email)) {
                foreach($error as $err){
                    $errores[]=$err;
                }
            }
           

            if (!empty($errores)) {
                Session::set('error', $errores);
                header('Location: /registro');
                exit;
            }

            $datos = [
                'nombre' => $nombre,
                'email' => $email,
                'password' => $password
            ];
           
            $usuario = $this->userModel->crear($datos);

            if (!$usuario) {
                Session::set('error', 'Error al registrar');
                header('Location: /registro');
                exit;
            }

            Session::set('mensaje', '¡Registro exitoso! Inicia sesión');
            header('Location: /login');
            exit;
        }
    }

    public function logout(): void
    {
        Session::destroy();
        header('Location: /');
    }

    public function registroForm(): void
    {
        // Obtener mensajes de la sesión
        $error = Session::get('error');

        // Limpiar los mensajes después de obtenerlos
        Session::delete('error');
        Session::delete('mensaje');
        // Renderizar la vista de registro
        $this->render('auth/registro', ['error' => $error]);
    }
}
