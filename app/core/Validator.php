<?php
// app/core/Validator.php
class Validator {
    // Validar un campo requerido
    public static function required($value, $fieldName) {
        if (empty(trim($value))) {
            return "El campo $fieldName es requerido.";
        }
        return null;
    }

    // Validar un correo electrónico
    public static function email($value, $fieldName) {
        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            return "El campo $fieldName debe ser un correo electrónico válido.";
        }
        return null;
    }

    // Validar la longitud mínima de un campo
    public static function minLength($value, $fieldName, $minLength) {
        if (strlen(trim($value)) < $minLength) {
            return "El campo $fieldName debe tener al menos $minLength caracteres.";
        }
        return null;
    }

    // Validar la longitud máxima de un campo
    public static function maxLength($value, $fieldName, $maxLength) {
        if (strlen(trim($value)) > $maxLength) {
            return "El campo $fieldName no puede tener más de $maxLength caracteres.";
        }
        return null;
    }

    // Validar que dos campos sean iguales (por ejemplo, contraseña y confirmación)
    public static function equals($value1, $value2, $fieldName1, $fieldName2) {
        if ($value1 !== $value2) {
            return "Los campos $fieldName1 y $fieldName2 no coinciden.";
        }
        return null;
    }

    // Validar un campo alfabético (solo letras y espacios)
    public static function alpha($value, $fieldName) {
        if (!preg_match('/^[a-zA-Z\s]+$/', $value)) {
            return "El campo $fieldName solo puede contener letras y espacios.";
        }
        return null;
    }
}
?>