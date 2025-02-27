<?php

namespace App\Dao;
use App\Dao\BaseDao;
use App\Models\Inventario;

class InventarioDao extends BaseDao{
    public function __construct()
    {
        parent::__construct("inventario");
    }

    //Aqui implementa los datos para este tipo de conexion a base de datos
    protected function mapearAObjeto(array $datos): object
    {
        return new Inventario(
            $datos['id'],
            $datos['nombre']
        );
    }

    protected function mapearAArreglo(object $objeto): array
    {
        if (!$objeto instanceof Inventario) {
            throw new \InvalidArgumentException("El objeto no es una instancia de Usuario");
        }

        return [
            'id' => $objeto->getId(),
            'nombre' => $objeto->getNombre()
        ];
    } 
}