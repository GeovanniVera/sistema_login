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
    public function obtenerPorEmail(string $email): ?object
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
 //Este metodo mapea el arreglo para el id es para la busqueda
    protected function mapearAObjeto(array $datos): object
    {
        $usuario =  new Usuario(
            
            $datos['nombre'],
            $datos['email'],
            $datos['password'],
            $datos['id']
        );

        return $usuario;

         
    }

    protected function mapearAArreglo(object $objeto): array
    {
        if (!$objeto instanceof Usuario) {
            throw new \InvalidArgumentException("El objeto no es una instancia de Usuario");
        }

        return [
            'id' => $objeto->getId(),
            'password' => $objeto->getPassword(),
            'nombre' => $objeto->getNombre(),
            'email' => $objeto->getEmail(),
        ];
    }
}
