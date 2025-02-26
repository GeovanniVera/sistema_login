<?php

namespace App\Models;
use App\Dao\InsumoDao;

use App\Interfaces\FullCRUDInterface;


class Insumo implements FullCRUDInterface
{
    private $dao;

    public function __construct()
    {
        $this->dao = new InsumoDao();
    }

    public function crear(array $datos): bool
    {
        return $this->dao->crear($datos);
    }

    public function obtenerTodos(): ?array
    {
        return $this->dao->obtenerTodos();
    }
    public function buscarPorId(int $id): ?array
    {
        return $this->dao->buscarPorId($id);
    }
    public function actualizar(int $id, array $datos): bool
    {
        return $this->dao->actualizar($id,$datos);
    }
    public function eliminar(int $id): bool
    {
        return $this->dao->eliminar($id);
    }

    
}
