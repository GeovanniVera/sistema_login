<?php
namespace App\Interfaces;

interface ReadInterface{
    public function listar() : array;
    public function buscarPorId(int $id) : ?array;
}