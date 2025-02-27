<?php
namespace App\Interfaces;

interface FullCRUDInterface 
{
    public function crear(array $datos): bool;
    public function actualizar(int $id, array $datos): bool;
    public function eliminar(int $id): bool;
    public function obtenerTodos() : ?array;
    public function buscarPorId(int $id) : mixed;
}
