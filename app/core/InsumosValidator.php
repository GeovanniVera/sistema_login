<?php
//importamos la clase generica para validaciones
require_once __DIR__.'./../core/Validator.php';

class InsumosValidator{

    public static function validarNombre($nombre){
        if(Validator::required($nombre,'nombre')){
            return "El nombre es requerido";
        }
        if(Validator::alpha($nombre,'nombre')){
            return "El nombre solo puede contener letras y espacios";
        }
        if(Validator::maxLength($nombre,'nombre',20)){
            return "El nombre no puede tener mas de 20 caracteres";
        }
        if(Validator::minLength($nombre,'nombre',3)){
            return "El nombre debe de tener almenos 3 caracteres";
        }

        return null;
    }

    public static function validarClave($clave){
        if(Validator::required($clave,'clave')){
            return "La clave es requerido";
        }
        if(Validator::maxLength($clave,'clave',14)){
            return "La clave no puede tener mas de 14 caracteres";
        }
        return null;
        
    }



}
