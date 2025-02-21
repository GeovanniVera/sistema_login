<?php
// app/controllers/AuthController.php
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../core/Database.php';
require_once __DIR__ . '/../core/Session.php';
require_once __DIR__.'/../core/Validator.php';
require_once __DIR__.'/../abstracts/BaseController.php';

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
            $usuario = $this->userModel->login($email, $password);
            if($usuario){
                Session::set('usuario', [
                    'id' => $usuario['id'],
                    'nombre' => $usuario['nombre'],
                    'email' => $usuario['email']
                ]);
                Session::regenerate(); // Prevención de fixation
                var_dump($_SESSION);
                exit;
                header('Location: /dashboard');
            }else{
                Session::set('error','Credenciales Incorrectas');
                header('Location: /');
            }
        }
    }

    //procesar login
    public function registro(): void {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $datos = [
                'nombre' => htmlspecialchars($_POST['nombre']),
                'email' => htmlspecialchars($_POST['email']),
                'password' => $_POST['password']
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
        $this->render('registro');
    }
}

?>