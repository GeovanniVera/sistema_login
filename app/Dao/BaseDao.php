<?php

namespace App\Dao;

use App\Interfaces\DaoInterface;
use App\Core\Database;
use PDOException;
use RuntimeException;
abstract class BaseDao implements DaoInterface
{
    protected $conn;
    protected string $tabla;

    public function __construct(string $tabla)
    {
        if (!preg_match('/^[a-zA-Z0-9_]+$/', $tabla)) {
            throw new \InvalidArgumentException("El nombre de la tabla no es válido");
        }

        $database = new Database();
        $this->conn = $database->getConnection();
        $this->tabla = $tabla;
    }

    /**
     * Crea un nuevo registro en la base de datos.
     *
     * @param object $objeto El objeto a insertar.
     * @return bool True si la operación fue exitosa, false en caso contrario.
     * @throws RuntimeException Si ocurre un error en la base de datos.
     */
    public function crear(object $objeto): bool
    {
        try {
            $datos = $this->mapearAArreglo($objeto);
            $query = "INSERT INTO " . $this->tabla . " SET ";
            $incerciones = [];
            foreach ($datos as $key => $value) {
                $incerciones[] = "$key = :$key";
            }
            $query .= implode(', ', $incerciones);
            $stmt = $this->conn->prepare($query);

            foreach ($datos as $key => $value) {
                $stmt->bindValue(":" . $key, $value);
            }

            return $stmt->execute();
        } catch (PDOException $e) {
            throw new RuntimeException("Error al crear el registro: " . $e->getMessage());
        }
    }

    /**
     * Elimina un registro de la base de datos.
     *
     * @param int $id El ID del registro a eliminar.
     * @return bool True si la operación fue exitosa, false en caso contrario.
     * @throws RuntimeException Si ocurre un error en la base de datos.
     */
    public function eliminar(int $id): bool
    {
        try {
            $query = "DELETE FROM " . $this->tabla . " WHERE id = :id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindValue(":id", $id);
            return $stmt->execute();
        } catch (PDOException $e) {
            throw new RuntimeException("Error al eliminar el registro: " . $e->getMessage());
        }
    }

    /**
     * Busca un registro por su ID.
     *
     * @param int $id El ID del registro a buscar.
     * @return object|null El objeto mapeado o null si no se encuentra.
     * @throws RuntimeException Si ocurre un error en la base de datos.
     */
    public function buscarPorId(int $id): ?object
    {
        try {
            $query = "SELECT * FROM " . $this->tabla . " WHERE id = :id LIMIT 1";
            $stmt = $this->conn->prepare($query);
            $stmt->bindValue(":id", $id);
            $stmt->execute();

            $datos = $stmt->fetch(\PDO::FETCH_ASSOC);
            if ($datos) {
                return $this->mapearAObjeto($datos);
            }

            return null;
        } catch (PDOException $e) {
            throw new RuntimeException("Error al buscar el registro: " . $e->getMessage());
        }
    }

    /**
     * Actualiza un registro en la base de datos.
     *
     * @param int $id El ID del registro a actualizar.
     * @param object $objeto El objeto con los nuevos datos.
     * @return bool True si la operación fue exitosa, false en caso contrario.
     * @throws RuntimeException Si ocurre un error en la base de datos.
     */
    public function actualizar(int $id, object $objeto): bool
    {
        try {
            $datos = $this->mapearAArreglo($objeto);
            $query = "UPDATE " . $this->tabla . " SET ";
            $columns = [];
            foreach ($datos as $key => $value) {
                $columns[] = " $key = :$key";
            }
            $query .= implode(", ", $columns);
            $query .= " WHERE id = :id";
            $stmt = $this->conn->prepare($query);

            foreach ($datos as $key => $value) {
                $stmt->bindValue(":" . $key, $value);
            }
            $stmt->bindValue(':id', $id, \PDO::PARAM_INT);

            return $stmt->execute();
        } catch (PDOException $e) {
            throw new RuntimeException("Error al actualizar el registro: " . $e->getMessage());
        }
    }

    /**
     * Obtiene todos los registros de la tabla.
     *
     * @return array Un arreglo de objetos mapeados.
     * @throws RuntimeException Si ocurre un error en la base de datos.
     */
    public function obtenerTodos(): array
    {
        try {
            $query = "SELECT * FROM " . $this->tabla;
            $stmt = $this->conn->prepare($query);
            $stmt->execute();

            $resultados = [];
            while ($datos = $stmt->fetch(\PDO::FETCH_ASSOC)) {
                $resultados[] = $this->mapearAObjeto($datos);
            }

            return $resultados;
        } catch (PDOException $e) {
            throw new RuntimeException("Error al obtener los registros: " . $e->getMessage());
        }
    }

    /**
     * Mapea un arreglo de datos a un objeto.
     *
     * @param array $datos Los datos a mapear.
     * @return object El objeto mapeado.
     * @throws RuntimeException Si el método no está implementado.
     */
    abstract protected function mapearAObjeto(array $datos): object;

    /**
     * Mapea un objeto a un arreglo de datos.
     *
     * @param object $objeto El objeto a mapear.
     * @return array El arreglo de datos.
     * @throws RuntimeException Si el método no está implementado.
     */
    abstract protected function mapearAArreglo(object $objeto): array;
}