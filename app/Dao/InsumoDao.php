<?php
/*Implementar la Dao en este metodo */
namespace App\Dao;
use App\Dao\BaseDao;
use App\Models\Insumo;

class InsumoDao extends BaseDao{
    public function __construct()
    {
        parent::__construct("insumo");
    }

    //Aqui implementa los datos para este tipo de conexion a base de datos
    protected function mapearAObjeto(array $datos): object
    {
        return new Insumo(
            $datos['id'],
            $datos['nombre'],
            $datos['email']
        );
    }

    protected function mapearAArreglo(object $objeto): array
    {
        if (!$objeto instanceof Insumo) {
            throw new \InvalidArgumentException("El objeto no es una instancia de Usuario");
        }

        return [
            'id' => $objeto->getId(),
            'nombre' => $objeto->getNombre(),
            'email' => $objeto->getEmail(),
        ];
    }   
}