<?php

namespace App\Validators;

use App\Validators\Validator;

class UsuariosValidator
{
    //Valida emails
    private static function validarEmail($email, $fieldName)
    {
        if (Validator::required($email, $fieldName)) {
            return "El  $fieldName es obligatorio";
        }
        if (Validator::email($email, $fieldName)) {
            return "El  $fieldName es un formato invalido";
        }
        if (Validator::minLength($email, $fieldName, 3)) {
            return "los caracteres especiales deben del $fieldName deben de ser 3";
        }
        return null;
    }
    //Valida Contraseñas
    private static function validarContraseña($password, $fieldName)
    {
        if (Validator::required($password, 'Contraseña')) {
            return "El  $fieldName es Obligatorio";
        }
        if (Validator::minLength($password, 'Contraseña', 6)) {
            return "La  $fieldName debe de ser de minimo 6 caracteres";
        }
        return null;
    }
    //Valida nombres
    private static function validarNombre($nombre,$fieldName){
        if (Validator::required($nombre, 'Nombre')){
            return "El  $fieldName es Obligatorio";
        } 
        if (Validator::alpha($nombre, 'Nombre')) {
            return "El  $fieldName tiene un formato invalido";
        }
        return null;
    }

    //Validacion de Registro
    public static function validarRegistro($nombre,$password,$email){
        $errores=[];
        if($error = self::validarEmail($email,'Email')){
            $error[] = $error;
        }
        if($error = self::validarNombre($nombre,'Nombre')){
            $errores[] = $error;
        }
        
        if($error=self::validarContraseña($password,'Contraseña')){
            $errores[]=$error;
        }
        return $errores;
    }
    
    //Validacion de login
    public static function validarLogin($password,$email){
        $errores=[];
        
        if($error = self::validarEmail($email,'Email')){
            $errores[] = $error;
        }
        if($error = self::validarContraseña($password,'Contraseña') ){
            $errores[]=$error;
        }
        return $errores;
    }
    
}
