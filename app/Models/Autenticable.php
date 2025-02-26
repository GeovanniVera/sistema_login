<?php
namespace App\Models;
use App\Dao\AutenticationDao;
use App\Interfaces\AuthInterface;

class Autenticable implements AuthInterface{
    private $dao;

    public function __construct()
    {
        $this->dao = new AutenticationDao();
    }

    public function verificarCredenciales($email,$password):?array{
        return $this->dao->verificarCredenciales($email,$password);
    }
}