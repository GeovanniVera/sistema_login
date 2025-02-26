<?php

namespace App\Dao;

use App\Dao\UsuarioDao;

class AutenticationDao extends UsuarioDao
{
    public function __construct()
    {
        parent::__construct("usuarios");
    }

    public function verificarCredenciales($email, $password): ?array
    {
        $usuario = $this->obtenerPorEmail($email);

        // checa si existe el usuario
        if ($usuario === null || empty($email)) {  // Corrected condition
            return ['success' => false, 'successPass' => false, 'usuario' => null];
        }

        // Checa si la contraseña es correcta
        if (!password_verify($password, $usuario['password'])) {
            return ['success' => true, 'successPass' => false, 'usuario' => null];
        }

        return ['success' => true, 'successPass' => true, 'usuario' => $usuario];
    }
}
