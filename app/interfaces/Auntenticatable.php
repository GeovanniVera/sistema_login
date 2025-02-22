<?php
namespace App\Interfaces;
interface Authenticatable
{
    public function checkAuth(): void;
}
