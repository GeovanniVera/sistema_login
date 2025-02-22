<?php
namespace App\Models;
use App\Models\BaseModel;
use App\Interfaces\FullCRUDInterface;

class Insumo extends BaseModel implements FullCRUDInterface{

    private $id;
    private $clave;
    private $nombre;

    public function __construct(PDO $conn)
    {
        parent::__construct($conn);
        $this->table = "insumo"; // Define la tabla

    }
/**
 * Registrar usuario
 */
    public function crear($datos) : bool {
        $query = "INSERT INTO " . $this->table . " SET nombre=:nombre, clave=:clave";
        $stmt = $this->conn->prepare($query);
        $this->nombre = htmlspecialchars($datos['nombre']);
        $this->clave = htmlspecialchars($datos['clave']);
        $stmt-> bindParam(":nombre",$this->nombre);
        $stmt-> bindParam(":clave",$this->clave);
        return $stmt->execute();
    }

    /** Corregir este metodo */
    public function buscarPorId($id): array
    {
        $query = "SELECT * FROM ". $this->table." WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $this->id = filter_var($id,FILTER_VALIDATE_INT);
        $stmt->bindParam(":id",$this->id,PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    public function actualizar(int $id, array $datos): bool {
        $this->id = filter_var($id, FILTER_VALIDATE_INT);

        // More robust update query:
        $query = "UPDATE " . $this->table . " SET ";
        $updates = [];
        foreach ($datos as $key => $value) {
            if ($key !== 'id') { // Don't update the ID
                $updates[] = $key . " = :" . $key;
            }
        }
        $query .= implode(", ", $updates);
        $query .= " WHERE id = :id";


        $stmt = $this->conn->prepare($query);

        foreach ($datos as $key => $value) {
             if ($key !== 'id') {
                $stmt->bindValue(":" . $key, htmlspecialchars($value)); // Sanitize each value
            }
        }
        $stmt->bindValue(":id", $this->id, PDO::PARAM_INT);

        return $stmt->execute();
    }


    public function eliminar(int $id): bool
    {
        $this->id = filter_var($id,FILTER_VALIDATE_INT);
        $query="DELETE FROM ". $this->table . " WHERE id = $id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id",$this->id,PDO::PARAM_INT);
        return $stmt->execute();
    }

   
}