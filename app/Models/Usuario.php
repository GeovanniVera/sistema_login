<?php

declare(strict_types=1);

namespace App\Models;

use App\Dao\AutenticationDao;
use App\Dao\UsuarioDao;
use App\Interfaces\UsuarioCRUDInterface;
use PDOException;
use RuntimeException;
use InvalidArgumentException;

class Usuario implements UsuarioCRUDInterface
{
  

    private  $dao;
    private $daoAuth;

    public function __construct( private string $nombre = "", private string $email = "", private string $password = "" , private ?int $id = 0)
    {   
        
        $this->nombre = $nombre;
        $this->email = $email;
        $this->password = $password;
        $this->id = $id; 
         
        $this->dao = new UsuarioDao;
    }


    // Getters y Setters

    public function getId():?int
    {
        return $this->id;
    }

    public function setId(string $id): void
    {
        $this->nombre = $id;
    }

    public function getNombre(): string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre): void
    {
        $this->nombre = $nombre;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException("El email no es válido");
        }
        $this->email = $email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): void
    {
        if (strlen($password) < 8) {
            throw new InvalidArgumentException("La contraseña debe tener al menos 8 caracteres");
        }
        $this->password = password_hash($password, PASSWORD_BCRYPT);
    }

    /**
     * Crea un nuevo usuario en la base de datos.
     *
     * @param array $datos Los datos del usuario a crear.
     * @return bool True si la operación fue exitosa, false en caso contrario.
     * @throws RuntimeException Si ocurre un error en la base de datos.
     */
    public function crear(array $datos): bool
    {
        try {
            $this->daoAuth = new AutenticationDao();
            $this->setNombre($datos['nombre']);
            $this->setEmail($datos['email']);
            $this->setPassword($datos['password']);


            // Enviar el objeto Usuario al DAO
            return $this->daoAuth->crear($this);
        } catch (PDOException $e) {
            throw new RuntimeException("Error al crear el usuario: " . $e->getMessage());
        }
    }

    /**
     * Obtiene todos los usuarios de la base de datos.
     *
     * @return array|null Un array de objetos Usuario o null si no hay registros.
     * @throws RuntimeException Si ocurre un error en la base de datos.
     */
    public function obtenerTodos(): ?array
    {
        try {
            return $this->dao->obtenerTodos();
        } catch (PDOException $e) {
            throw new RuntimeException("Error al obtener los usuarios: " . $e->getMessage());
        }
    }

    /**
     * Busca un usuario por su ID.
     *
     * @param int $id El ID del usuario a buscar.
     * @return Usuario|null Una instancia de Usuario si se encuentra, o null si no existe.
     * @throws RuntimeException Si ocurre un error en la base de datos.
     */
    public function buscarPorId(int $id): ?Usuario
    {
        try {
            return $this->dao->buscarPorId($id);
        } catch (PDOException $e) {
            throw new RuntimeException("Error al buscar el usuario: " . $e->getMessage());
        }
    }

    /**
     * Actualiza un usuario en la base de datos.
     *
     * @param int $id El ID del usuario a actualizar.
     * @param array $datos Los nuevos datos del usuario.
     * @return bool True si la operación fue exitosa, false en caso contrario.
     * @throws RuntimeException Si ocurre un error en la base de datos.
     */
    public function actualizar(int $id, array $datos): bool
    {
        try {
            $this->daoAuth = new AutenticationDao();
            $this->setNombre($datos['nombre']);
            $this->setEmail($datos['email']);
            if (isset($datos['password'])) {
                $this->setPassword($datos['password']);
            }

            // Enviar el objeto Usuario al DAO
            return $this->daoAuth->actualizar($id, $this);
        } catch (PDOException $e) {
            throw new RuntimeException("Error al actualizar el usuario: " . $e->getMessage());
        }
    }

    /**
     * Obtiene un usuario por su email.
     *
     * @param string $email El email del usuario a buscar.
     * @return Usuario|null Una instancia de Usuario si se encuentra, o null si no existe.
     * @throws RuntimeException Si ocurre un error en la base de datos.
     */
    public function obtenerPorEmail(string $email): ?Usuario
    {
        try {
            return $this->dao->obtenerPorEmail($email);
        } catch (PDOException $e) {
            throw new RuntimeException("Error al obtener el usuario por email: " . $e->getMessage());
        }
    }

    /**
     * Elimina un usuario de la base de datos.
     *
     * @param int $id El ID del usuario a eliminar.
     * @return bool True si la operación fue exitosa, false en caso contrario.
     * @throws RuntimeException Si ocurre un error en la base de datos.
     */
    public function eliminar(int $id): bool
    {
        try {
            return $this->dao->eliminar($id);
        } catch (PDOException $e) {
            throw new RuntimeException("Error al eliminar el usuario: " . $e->getMessage());
        }
    }
    public function obtenerEmail(string $email):?object{
        try{
            return $this->dao->obtenerPorEmail($email);
        }catch(PDOException $e){
            throw new RuntimeException("Error al recuperar el usuario: ". $e->getMessage());
        }
    }
}