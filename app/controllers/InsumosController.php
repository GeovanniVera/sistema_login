<?php

namespace App\Controllers;

use App\Models\Insumo;
use App\Core\Database;
use App\Core\Session;
use App\Core\InsumosValidator;
use App\Controllers\BaseController;

class InsumosController extends BaseController{
    private $insumo;
    public function __construct()
    {
        $database = new Database();
        $db = $database->getConnection();
        $this->insumo = new Insumo($db);
        Session::start();
    }

    public function listarInsumos(){
        $this->checkAuth();
        $insumos=$this->insumo->listar();
        $this->render('insumos/index', $insumos);
    }

    public function insumoForm(){
        $this->render('insumos/insumoForm');
    }

    public function registrar(){
        if($_SERVER['REQUEST_METHOD']==='POST'){
            $nombre = htmlspecialchars($_POST['nombre']);
            $clave = htmlspecialchars($_POST['clave']);

            //Validaciones 
            $errores = [];
            //Validamos capmos nulos
            $errorNombre = InsumosValidator::validarNombre($nombre);
            $errorClave = InsumosValidator::validarClave($clave);

            if($errorNombre){
                $errores[] = $errorNombre;
            }
            if($errorClave){
                $errores[]= $errorClave;
            }
            //Redireccionamos los errores para que se muestren en la vista
            if(!empty($errores)){
                Session::set('error', implode('/n',$errores));
                header('Location: /nuevoInsumo');
                exit;
            }
            //Si no hay errores
            $datos = [
                'nombre' => $nombre,
                'clave' => $clave
            ];


            if($this->insumo->crear($datos)){
                Session::set('mensaje','Insumo Creado Correctamente' );
                header('Location: /insumos');
                exit;
            }else{
                Session::set('mensaje','Error al registrar al usuario');
                header('Location: /insumos');
                exit;
            }            

        }
    }

    
}