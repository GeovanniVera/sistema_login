<?php

namespace App\Dao;
use App\Dao\BaseDao;
class InventarioDao extends BaseDao{
    public function __construct()
    {
        parent::__construct("inventario");
    }

    //Aqui implementa los datos para este tipo de conexion a base de datos
    
}