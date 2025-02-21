<?php
class Insumo{
    private $conn;
    private $table = "insumo";

    private $id;
    private $clave;
    private $nombre;

    public function __construct($db)
    {
        $this->conn = $db;
    }
/**
 * Registrar usuario
 */
    public function registrarInsumo(){
        $query = "INSERT INTO " . $this->table . "SET nombre=:nombre, clave=:clave";
        $stmt = $this->conn->prepare($query);
        $stmt-> bindParam(":nombre",$this->nombre);
        $stmt-> bindParam(":clave",$this->clave);
        return $stmt->execute();
    }

    
}