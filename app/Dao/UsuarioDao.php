<?php

namespace App\Dao;

use App\Dao\BaseDao;
use App\Models\Usuario;

class UsuarioDao extends BaseDao
{
    public function __construct()
    {
        parent::__construct("usuarios");
    }
    //Metodo especifico para usuario
    public function obtenerPorEmail(string $email): ?array
    {
        $query = "SELECT * FROM " . $this->tabla . " WHERE email = :email";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(":email", htmlspecialchars($email));
        $stmt->execute();
        $datos = $stmt->fetch(\PDO::FETCH_ASSOC); // <- retorna un arreglo si existe y un false si no existe
        if($datos){
            return $this->mapearAObjeto($datos);
        }


        return null;
    }

    protected function mapearAObjeto(array $datos): object
    {
        return new Usuario(
            $datos['id'],
            $datos['nombre'],
            $datos['email']
        );
    }

    protected function mapearAArreglo(object $objeto): array
    {
        if (!$objeto instanceof Usuario) {
            throw new \InvalidArgumentException("El objeto no es una instancia de Usuario");
        }

        return [
            'id' => $objeto->getId(),
            'nombre' => $objeto->getNombre(),
            'email' => $objeto->getEmail(),
        ];
    }
}
