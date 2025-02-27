<?php

namespace App\Controllers;

use App\Core\Session;
use App\Validators\UsuariosValidator;
use App\Controllers\BaseController;
use App\Models\Autenticable;
use App\Models\Usuario;

class AuthController extends BaseController
{
    private $userModel;
    private $autenticationModel;
    // Constructor
    public function __construct(Usuario $usuario, Autenticable $authModel)
    {
        $this->userModel = $usuario;
        $this->autenticationModel = $authModel;
        Session::start();
    }

    public function loginForm(): void
    {
        // Obtener y limpiar mensajes de la sesió
        $errores = Session::get('error', []);
        $mensaje = Session::get('mensaje');

        Session::delete('error');
        Session::delete('exito');

        $this->render('auth/login', [
            'errores' => $errores,
            'mensaje' => $mensaje
        ]);
    }

    // Procesar login
    public function login(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === "POST") 
        {
            $email = htmlspecialchars($_POST['email']);
            $password = $_POST['password'];

            // Validaciones
            $errores = [];
            if($error = UsuariosValidator::validarLogin($password,$email)) $errores[] = $error;

            

            if (!empty($errores)) {
                Session::set('error',$errores);
                header('Location: /login');
                exit;
            }

            $usuario = $this->autenticationModel->verificarCredenciales($email,$password);


            if(!$usuario['success']){
                Session::set('error', ['Usuario no encontrado']);
                header('Location: /login');
                exit;
            }

            if(!$usuario['successPass']){
                Session::set('error', ['Contraseña Incorrecta']);
                header('Location: /login');
                exit;
            }

            
            Session::set('usuario', [
                        'id' => $usuario['usuario']['id'],
                        'nombre' => $usuario['usuario']['nombre'],
                        'email' => $usuario['usuario']['email']
                    ]);
            Session::regenerate(); // Prevención de fixation
            header("Location: /dashboard");
        
        }
    }

    public function dashboard(){
        $this->checkAuth();
        $usuarioInfo = Session::get('usuario');
        $this->render("auth/dashboard",$usuarioInfo);
    }

    // Procesar registro
    public function registro(): void{
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombre = htmlspecialchars($_POST['nombre']);
            $email = htmlspecialchars($_POST['email']);
            $password = $_POST['password'];

            // Validaciones
            $errores = [];
            if ($error = UsuariosValidator::validarRegistro($nombre,$password,$email)) $errores[] = $error;


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

            if(!$this->userModel->crear($datos)){
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
        $mensaje = Session::get('mensaje');

        // Limpiar los mensajes después de obtenerlos
        Session::delete('error');
        Session::delete('mensaje');

        // Renderizar la vista de registro
        $this->render('auth/registro', ['error' => $error, 'mensaje' => $mensaje]);
    }
}
