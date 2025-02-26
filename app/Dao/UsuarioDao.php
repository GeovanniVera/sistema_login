<?php

namespace App\Dao;

use App\Dao\BaseDao;

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

        $usuario = $stmt->fetch(\PDO::FETCH_ASSOC); // <- retorna un arreglo si existe y un false si no existe

        var_dump($usuario);

        return $usuario == null ? null : $usuario; 
    }
}
