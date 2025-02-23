<?php
namespace App\Interfaces;

interface Authenticable
{
    public function checkAuth(): void;
}
