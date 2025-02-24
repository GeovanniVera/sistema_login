<?php
//importamos la clase generica para validaciones
namespace App\Validators;
use App\Validators\Validator;

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
            return "La clave es requerida";
        }
        if(Validator::maxLength($clave,'clave',14)){
            return "La clave no puede tener mas de 14 caracteres";
        }
        return null;
        
    }

    public static function validarInt($value,$fieldName){
        if(Validator::isInt($value,$fieldName)){
            return "El parametro $fieldName no es un entero";
        }
        if(Validator::required($value,$fieldName)){
            return "El parametro $fieldName es Obligatorio";
        }
        return null;

    }



}
