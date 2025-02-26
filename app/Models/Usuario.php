<?php

declare(strict_types=1);

namespace App\Models;

use App\Dao\UsuarioDao;
use App\Interfaces\FullCRUDInterface;

// app/models/User.php
class Usuario implements FullCRUDInterface
{
    private $dao;

    public function __construct()
    {
        $this->dao = new UsuarioDao();
    }

    public function crear(array $datos): bool
    {
        $datos['password'] = password_hash($datos['password'],PASSWORD_BCRYPT);
        return $this->dao->crear($datos);
    }
    public function obtenerTodos() : ?array{
        return $this->dao->obtenerTodos();
    }

    public function buscarPorId(int $id): ?array
    {
        return $this->dao->buscarPorId($id);
    }

    public function actualizar(int $id,array $datos): bool{
        return $this->dao->actualizar($id,$datos);
    }

    public function obtenerPorEmail(string $email): ?array
    {
        return $this->dao->obtenerPorEmail($email);
    }

    public function eliminar(int $id): bool
    {
        return $this->dao->eliminar($id);
    }

    
}
