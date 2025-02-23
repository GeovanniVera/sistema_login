<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Database;
use App\Interfaces\AuthInterface;
// app/models/User.php
class User extends BaseModel implements AuthInterface
{
    private $id;
    private $nombre;
    private $email;
    private $password;

    public function __construct(\PDO $conn)
    {
        parent::__construct($conn);
        $this->table = "usuarios"; // Define la tabla
    }

    // Métodos de AuthInterface

    public function login(string $email, string $password): array
    {
        try {
            $usuario = $this->obtenerPorEmail($email);

            if (!$usuario || !password_verify($password, $usuario['password'])) {

                return ['success' => false, 'user' => null]; // Usuario no autenticado
            }

            return ['success' => true, 'user' => $usuario]; // Usuario autenticado con éxito
        } catch (\Exception $e) {
            error_log("Error en login: " . $e->getMessage());
            return ['success' => false, 'user' => null]; // Error en autenticación
        }
    }


    public function registrar(array $datos): bool
    {
        //Consulta SQL para registrar al usuario
        $query = "INSERT INTO $this->table (nombre,email,password) VALUES ( :nombre, :email, :password)";
        $stmt = $this->conn->prepare($query);
        //Saniitizar los parametros
        $this->nombre = htmlspecialchars(strip_tags($datos['nombre']));
        $this->email = htmlspecialchars(strip_tags($datos['email']));
        $this->password = password_hash($datos['password'], PASSWORD_BCRYPT);
        //
        $stmt->bindParam(':nombre', $this->nombre);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':password', $this->password);
        //ejecutar la sentencia sql
        return $stmt->execute();
    }

    public function buscarPorId($id): ?array
    {
        $query = "SELECT * FROM $this->table WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC) ?: null;
    }
    // Método específico (no está en la interfaz)
    private function obtenerPorEmail(string $email): ?array
    {
        $query = "SELECT * FROM $this->table WHERE email = :email";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":email", $email);
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC) ?: null;
    }

    public function eliminar(int $id): bool
    {
        // Validación robusta del ID
        if ($id <= 0) {
            throw new \InvalidArgumentException("ID inválido: debe ser un entero positivo");
        }

        // Consulta segura con placeholder
        $query = "DELETE FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);

        // Vinculación segura del parámetro
        $stmt->bindParam(":id", $id, \PDO::PARAM_INT);

        return $stmt->execute();
    }
}
