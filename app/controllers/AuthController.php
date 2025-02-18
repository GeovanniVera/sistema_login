<?php
// app/controllers/AuthController.php
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../core/Database.php';
require_once __DIR__ . '/../core/Session.php';
require_once __DIR__.'/../core/Validator.php';

class AuthController{
    private $user;

    public function __construct()
    {
        $database = new Database;
        $db = $database->getConnection();
        $this->user = new User($db);
        Session::start();
    }

    public function registro() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $errors = [];

            // Validar campos
            $errors[] = Validator::required($_POST['nombre'], 'Nombre');
            $errors[] = Validator::alpha($_POST['nombre'], 'Nombre');
            $errors[] = Validator::required($_POST['email'], 'Correo Electrónico');
            $errors[] = Validator::email($_POST['email'], 'Correo Electrónico');
            $errors[] = Validator::required($_POST['password'], 'Contraseña');
            $errors[] = Validator::minLength($_POST['password'], 'Contraseña', 8);

            // Filtrar errores nulos
            $errors = array_filter($errors);

            if (empty($errors)) {
                $this->user->nombre = $_POST['nombre'];
                $this->user->email = $_POST['email'];
                $this->user->password = $_POST['password'];

                if ($this->user->registrar()) {
                    Session::set('mensaje', 'Registro exitoso. Inicia sesión.');
                    header('Location: /login');
                } else {
                    Session::set('error', 'Error en el registro.');
                }
            } else {
                Session::set('errors', $errors);
            }
        }
        require_once __DIR__ . '/../views/registro.php';
    }


    public function login() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $errors = [];

            // Validar campos
            $errors[] = Validator::required($_POST['email'], 'Correo Electrónico');
            $errors[] = Validator::email($_POST['email'], 'Correo Electrónico');
            $errors[] = Validator::required($_POST['password'], 'Contraseña');

            // Filtrar errores nulos
            $errors = array_filter($errors);

            if (empty($errors)) {
                $this->user->email = $_POST['email'];
                $this->user->password = $_POST['password'];

                $usuario = $this->user->login();
                if ($usuario) {
                    Session::set('usuario', $usuario);
                    header('Location: /dashboard');
                } else {
                    Session::set('error', 'Credenciales incorrectas.');
                }
            } else {
                Session::set('errors', $errors);
            }
        }
        require_once __DIR__ . '/../views/login.php';
    }
    public function logout() {
        Session::destroy();
        header('Location: /');
    }
}

?>