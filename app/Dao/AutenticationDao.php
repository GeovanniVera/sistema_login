<?php

namespace App\Dao;
use App\Models\Usuario;
use App\Dao\UsuarioDao;

class AutenticationDao extends UsuarioDao
{
    public function __construct()
    {
        parent::__construct("usuarios");
    }

    public function verificarCredenciales($email, $password): ?array
    {
        $dao = new UsuarioDao;
        $usuario = $dao->obtenerPorEmail($email);
        // checa si existe el usuario
        if ($usuario->getEmail() === "" ) {  // Corrected condition
            return ['success' => false, 'successPass' => false, 'usuario' => null];
        }

        // Checa si la contraseña es correcta
        if (!password_verify($password, $usuario->getPassword())) {
            return ['success' => true, 'successPass' => false, 'usuario' => null];
        }

        return ['success' => true, 'successPass' => true, 'usuario' => $usuario];
    }

    protected function mapearAArreglo(object $objeto): array
    {
        if (!$objeto instanceof Usuario) {
            throw new \InvalidArgumentException("El objeto no es una instancia de Usuario");
        }

        return [
            'password' => $objeto->getPassword(),
            'nombre' => $objeto->getNombre(),
            'email' => $objeto->getEmail(),
        ];

    }

    protected function mapearAObjeto(array $datos): object
    {
        $usuario =  new Usuario(
            $datos['nombre'],
            $datos['email'],
            $datos['password']
        );

        $usuario->setId($datos['id']);
        return $usuario;

         
    }
}
