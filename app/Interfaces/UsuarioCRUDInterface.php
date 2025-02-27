<?php

namespace App\Interfaces;
use App\Interfaces\FullCRUDInterface;
use App\Models\Usuario;

interface UsuarioCRUDInterface extends FullCRUDInterface
{
    public function buscarPorId(int $id): ?Usuario; // Devuelve un objeto Usuario
}