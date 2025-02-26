<?php
namespace App\Interfaces;

interface AuthInterface {
    public function verificarCredenciales(string $email, string $password) : ?array ;
}