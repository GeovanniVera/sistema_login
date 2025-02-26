<?php

namespace App\Interfaces;

interface DaoInterface{
    public function crear(array $datos) : bool;
    public function eliminar(int $id) : bool;
    public function actualizar(int $id, array $datos) : bool;
    public function buscarPorId(int $id) : ?array ;
    public function obtenerTodos() : ?array;  
}