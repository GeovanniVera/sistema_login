<?php
require_once __DIR__.'./../interfaces/ReadInterface.php';
// app/core/Abstract/BaseModel.php
abstract class BaseModel implements ReadInterface {
    protected $conn;
    protected $table;

    public function __construct(PDO $conn) {
        $this->conn = $conn;
    }

    // Implementación por defecto de ReadInterface
    public function listar(): array {
        $query = "SELECT * FROM $this->table";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerPorId(int $id): ?array {
        $query = "SELECT * FROM $this->table WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }
}
?>