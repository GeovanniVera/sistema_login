<?php
    require_once __DIR__.'./../models/User.php';
    require_once __DIR__.'./../core/Database.php';
    require_once __DIR__.'./../core/Session.php';
    require_once __DIR__.'./../abstracts/BaseController.php';
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
            $this->render('usuarios',$usuarios);
        } 

        public function verUsuario($id){
            //Revisiar que el usuario este logueado
            $this->checkAuth();
            $usuario = $this->userModel->buscarPorId($id);
            //implementar la vista
            $this->render('ver_usuario',$usuario);
        }

    }