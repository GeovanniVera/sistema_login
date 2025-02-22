<?php
    require_once __DIR__.'./../models/User.php';
    require_once __DIR__.'./../core/Database.php';
    require_once __DIR__.'./../core/Session.php';
    require_once __DIR__.'./../core/Validator.php';
    require_once __DIR__.'./../controllers/BaseController.php';
    
    class UserController extends BaseController{
        //atributo del objeto Usuario
        private $userModel;

        public function __construct()
        {
            $database = new Database;
            $this->userModel = new User($database->getConnection());
            Session::start();
        }

        //Metodos del controlador
        public function listarUsuarios(){
            //Revisar que el usuario este logueado
            $this->checkAuth();
            $usuarios = $this->userModel->listar();
            //implementar la vista
            $this->render('usuarios/index', $usuarios);
        } 

        public function verUsuario($id){
            //Revisar que el usuario este logueado
            $this->checkAuth();
            
            // Validaciones
            $errores = [];
            if ($error = Validator::required($id, 'ID de usuario')) $errores[] = $error;
            if (!empty($errores)) {
                Session::set('error', implode('\n', $errores));
                header('Location: /usuarios');
                exit;
            }
            
            $usuario = $this->userModel->buscarPorId($id);
            
            if (!$usuario) {
                Session::set('error', 'Usuario no encontrado');
                header('Location: /usuarios');
                exit;
            }
            
            //implementar la vista
            $this->render('usuarios/ver_usuario', $usuario);
        }
    }
