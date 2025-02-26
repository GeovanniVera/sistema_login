<?php

namespace App\Dao;

use App\Interfaces\DaoInterface;
use App\Core\Database;


class BaseDao implements DaoInterface
{

    protected $conn;
    protected string $tabla;

    public function __construct(string $tabla)
    {
        $database = new Database();
        $this->conn = $database->getConnection();
        $this->tabla = $tabla;
    }

    public function crear(array $datos): bool
    {
        $query = "INSERT INTO " . $this->tabla . " SET ";
        $incerciones = [];
        foreach ($datos as $key => $value) {
            $incerciones[] = "$key = :$key";
        }
        $query .= implode(', ', $incerciones);
        $stmt = $this->conn->prepare($query);

        foreach ($datos as $key => $value) {
            $stmt->bindParam(":" . $key, htmlspecialchars($value));
        }

        return $stmt->execute();
    }

    public function eliminar(int $id): bool
    {
        $query = "DELETE FROM ".$this->tabla." WHERE id = :id";
        $stmt=$this->conn->prepare($query);
        $stmt->bindParam(":id",htmlspecialchars($id));
        return $stmt->execute();
    }

    public function buscarPorId(int $id): ?array
    {
        $query = "SELECT * FROM ".$this->tabla." WHERE id = :id LIMIT 1" ;
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id",htmlspecialchars($id));
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC) ?: null;
       
    }

    public function actualizar(int $id, array $datos): bool
    {
        $query = "UPDATE ".$this->tabla." SET ";
        $columns = [];
        foreach($datos as $key => $value){
            $columns[] = " $key = :$key";
        }
        $query.=implode(", ", $columns);
        $query .= " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        foreach($datos as $key => $value){
            $stmt->bindParam(":".$key, htmlspecialchars($value));
        }
        $stmt->bindParam(':id',htmlspecialchars($id),\PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function obtenerTodos(): ?array
    {
        $query = "SELECT * FROM ".$this->tabla;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}
