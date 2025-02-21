<?php
require_once __DIR__.'./../models/Insumo.php';
require_once __DIR__.'./../core/Database.php';
require_once __DIR__.'./../core/Session.php';
require_once __DIR__.'./../core/Validator.php';

class InsumosController{
    private $insumo;
    public function __construct()
    {
        $database = new Database();
        $db = $database->getConnection();
        $this->insumo = new Insumo($db);
        Session::start();
    }
}