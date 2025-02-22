<?php
// app/controllers/AuthController.php
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../core/Database.php';
require_once __DIR__ . '/../core/Session.php';
require_once __DIR__.'/../core/Validator.php';
require_once __DIR__.'/../controllers/BaseController.php';

class AuthController extends BaseController{
    private $userModel;

    //Constructor 
    public function __construct()
    {
        $database = new Database;
        $this->userModel = new User($database->getConnection());
        Session::start();
    }

    public function loginForm(): void {
        $this->render('auth/login');
    }

    // Procesar login
    public function login(): void {
        if($_SERVER['REQUEST_METHOD'] === "POST"){
            $email = htmlspecialchars($_POST['email']);
            $password = $_POST['password'];
            
            // Validaciones
            $errores = [];
            if ($error = Validator::required($email, 'Email')) $errores[] = $error;
            if ($error = Validator::email($email, 'Email')) $errores[] = $error;
            if ($error = Validator::required($password, 'Contraseña')) $errores[] = $error;

            if (!empty($errores)) {
                Session::set('error', implode('\n', $errores));
                header('Location: /');
                exit;
            }
            
            $usuario = $this->userModel->login($email, $password);
            
            if($usuario['success']){
                Session::set('usuario', [
                    'id' => $usuario['user']['id'],
                    'nombre' => $usuario['user']['nombre'],
                    'email' => $usuario['user']['email']
                ]);
                Session::regenerate(); // Prevención de fixation
                
                header('Location: /dashboard');
            }else{
                Session::set('error','Credenciales Incorrectas');
                header('Location: /');
            }
        }
    }

    // Procesar registro
    public function registro(): void {
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
                Session::set('error', implode('\\n', $errores));
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

    public function logout() : void{
        Session::destroy();
        header('Location: /');
    }

    public function registroForm(): void {
        $this->render('auth/registro');
    }
}

?>
