<?php
namespace App\Models;

use App\Interfaces\FullCRUDInterface;
use App\models\BaseModel;
use App\Core\Session;


class Inventario extends BaseModel implements FullCRUDInterface{
    private $id;
    private $nombre;
    private $cantidad;

    public function __construct(\PDO $conn)
    {
        parent::__construct($conn);
        $this->table = "inventario";
    }

    public function crear(array $datos): bool
    {
        try{
            $query = "INSERT INTO ".$this->table." SET ";
            $insercions = [];
            foreach($datos as $key => $value){
                $insercions = $key."= :".$key;
            }
            $query .= implode(", ",$insercions);
            var_dump($query);
            $stmt = $this->conn->prepare($query);
            
            foreach($datos as $key ){
                $stmt->bindParam(":".$key,htmlspecialchars($value));
            }
            return $stmt->execute();

        }catch(\Exception $e){
            Session::set('error',"Error en la base de datos".$e->getMessage());
        }
    }

    public function actualizar(int $id, array $datos): bool
    {
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
        $stmt->bindValue(":id", $this->id, \PDO::PARAM_INT);

        return $stmt->execute();
    }

    public function eliminar(int $id): bool
    {
        $this->id = filter_var($id, FILTER_VALIDATE_INT);
        $query = "DELETE FROM " . $this->table . " WHERE id = $id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $this->id, \PDO::PARAM_INT);
        return $stmt->execute();
    }


}


?>