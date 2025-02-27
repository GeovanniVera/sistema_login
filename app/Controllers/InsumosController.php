<?php

namespace App\Controllers;

use App\Models\Insumo;
use App\Core\Session;
use App\Validators\InsumosValidator;
use App\Controllers\BaseController;
use App\Models\Inventario;

class InsumosController extends BaseController{
    private $insumo;
    private $invetario;
    //constructor 
    public function __construct(Insumo $insumo, Inventario $inventario)
    {
        $this->insumo = $insumo;
        $this->invetario = $inventario;
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
        $insumos=$this->insumo->obtenerTodos();
        $this->render('insumos/index', ['insumos'=>$insumos,'mensaje'=>$mensaje]);
    }

    public function insumoForm(){
        $error = null;
        //Si existe un mensaje de error
        if(Session::has('error')){
            $error = Session::get('error');
            Session::delete('error');
        }
        $inventarios = $this->invetario->obtenerTodos();
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

    public function eliminar($id): void
    {

        $this->checkAuth(); 

        $errores = [];
        // Validación del ID
        if ($error = insumosValidator::validarInt($id, 'ID')) $errores[] = $error;

        if (!empty($errores)) {
            Session::set('error', implode('\n', $errores));
            header('Location: /insumos');
            exit;
        }

        try {
            $resultado = $this->insumo->eliminar($id);
            if(!$resultado) Session::set('error', 'Error al eliminar el insumo');
            Session::set('mensaje', 'Insumo eliminado correctamente');
        } catch (\Exception $e) {
            Session::set('error', 'Error en la base de datos: ' . $e->getMessage());
        }
        
        header('Location: /insumos');
        exit;
    }

    public function ver($id)
    {
        //Revisar que el usuario este logueado
        $this->checkAuth();

        // Validaciones
        $errores = [];
        if ($error = InsumosValidator::validarInt($id, 'ID de insumo')) $errores[] = $error;
       
        if (!empty($errores)) {
            Session::set('error', implode('\n', $errores));
            header('Location: /insumos');
            exit;
        }

        $insumo = $this->insumo->buscarPorId($id);

        if (!$insumo) {
            Session::set('error', 'Usuario no encontrado');
            header("Location: /insumos");
            exit;
        }

        //implementar la vista
        $this->render('insumos/ver_insumo', $insumo);
    }

    
}