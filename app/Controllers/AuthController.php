<?php

namespace App\Controllers;

use App\Core\Session;
use App\Core\Validator;
use App\Core\Database;
use App\Models\User;
use App\Controllers\BaseController;

class AuthController extends BaseController
{
    private $userModel;

    // Constructor
    public function __construct()
    {
        $database = new Database();
        $conn = $database->getConnection();
        $this->userModel = new User($conn);
        Session::start();
    }

    public function loginForm(): void
    {
        // Obtener y limpiar mensajes de la sesió
        $errores = Session::get('error', []);
        $exito = Session::get('mensaje', '');
        Session::delete('errores');
        Session::delete('exito');

        $this->render('auth/login', [
            'errores' => $errores,
            'exito' => $exito
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
            if ($error = Validator::required($email, 'Email')) $errores[] = $error;
            if ($error = Validator::email($email, 'Email')) $errores[] = $error;
            if ($error = Validator::required($password, 'Contraseña')) $errores[] = $error;

            if (!empty($errores)) {
                Session::set('error',$errores);
                header('Location: /login');
                exit;
            }

            $usuario = $this->userModel->login($email, $password);

            if ($usuario['success']) {
                Session::set('usuario', [
                    'id' => $usuario['user']['id'],
                    'nombre' => $usuario['user']['nombre'],
                    'email' => $usuario['user']['email']
                ]);
                Session::regenerate(); // Prevención de fixation
                header('Location: /dashboard');
                exit;
            } else {
                Session::set('error', ['Credenciales Incorrectas']);
                header('Location: /login');
                exit;
            }
        }
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
            if ($error = Validator::required($nombre, 'Nombre')) $errores[] = $error;
            if ($error = Validator::alpha($nombre, 'Nombre')) $errores[] = $error;
            if ($error = Validator::required($email, 'Email')) $errores[] = $error;
            if ($error = Validator::email($email, 'Email')) $errores[] = $error;
            if ($error = Validator::required($password, 'Contraseña')) $errores[] = $error;
            if ($error = Validator::minLength($password, 'Contraseña', 6)) $errores[] = $error;

            if (!empty($errores)) {
                Session::set('error', implode('\n', $errores));
                header('Location: /registro');
                exit;
            }

            $datos = [
                'nombre' => $nombre,
                'email' => $email,
                'password' => $password
            ];

            if ($this->userModel->registrar($datos)) {
                Session::set('mensaje', '¡Registro exitoso! Inicia sesión');
                header('Location: /');
            } else {
                Session::set('error', 'Error al registrar');
                header('Location: /registro');
            }
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
        $mensaje = Session::get('mensaje');

        // Limpiar los mensajes después de obtenerlos
        Session::delete('error');
        Session::delete('mensaje');

        // Renderizar la vista de registro
        $this->render('auth/registro', ['error' => $error, 'mensaje' => $mensaje]);
    }
}
