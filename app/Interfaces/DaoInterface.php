<?php

namespace App\Interfaces;

interface DaoInterface{
    public function crear(object $objeto) : bool;
    public function eliminar(int $id) : bool;
    public function actualizar(int $id, object $objeto) : bool;
    public function buscarPorId(int $id) : ?object ;
    public function obtenerTodos() : array;  
}