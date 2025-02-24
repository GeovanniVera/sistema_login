<?php

namespace App\Controllers;

use App\Models\Insumo;
use App\Core\Database;
use App\Core\Session;
use App\Validators\InsumosValidator;
use App\Controllers\BaseController;
use App\Models\Inventario;

class InsumosController extends BaseController{
    private $insumo;
    private $invetario;
    //constructor 
    public function __construct()
    {
        $database = new Database();
        $db = $database->getConnection();
        $this->insumo = new Insumo($db);
        $this->invetario = new Inventario($db);
        Session::start();
    }

    public function listarInsumos(){
        $this->checkAuth();
        $mensaje = null;
        //Si existen un mensaje de exito
        if(Session::has('mensaje')){
            $mensaje = Session::get('mensaje');
            Session::delete('mensaje'); 
        }
        $insumos=$this->insumo->listar();
        $this->render('insumos/index', ['insumos'=>$insumos,'mensaje'=>$mensaje]);
    }

    public function insumoForm(){
        $error = null;
        //Si existe un mensaje de error
        if(Session::has('error')){
            $error = Session::get('error');
            Session::delete('error');
        }
        $inventarios = $this->invetario->listar();
        $this->render('insumos/insumoForm',['inventarios'=>$inventarios,'error'=>$error]);
    }

    public function registrar(){
        if($_SERVER['REQUEST_METHOD']==='POST'){
            //Datos de la vista
            $nombre = htmlspecialchars($_POST['nombre']);
            $clave = htmlspecialchars($_POST['clave']);
            $idInventario = htmlspecialchars($_POST['id_inventario']);
            
            //Validaciones 
            $errores = [];

            //Validamos campos nulos
            if($error = InsumosValidator::validarNombre($nombre)) $errores[] =$error;
            if($error = InsumosValidator::validarClave($clave))$errores[]=$error;
            if($error= InsumosValidator::validarInt($idInventario,'id del inventario'))$errores[]=$error;

            //Redireccionamos los errores para que se muestren en la vista
            if(!empty($errores)){
                Session::set('error', implode('/n',$errores));
                header('Location: /nuevoInsumo');
                exit;
            }
            //Si no hay errores
            $datos = [
                'nombre' => $nombre,
                'clave' => $clave,
                'id_inventario'=>$idInventario
            ];

            /*Revisar las alertas */
            if(!$this->insumo->crear($datos)){
                Session::set('error','Error al registrar al usuario');
                header('Location: /insumosForm');
                exit;
            }

            Session::set('mensaje','Insumo Creado Correctamente' );               
                header('Location: /insumos');
                exit;

        }
    }

    
}