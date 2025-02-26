<?php
namespace App\Models;

use App\Interfaces\FullCRUDInterface;
use App\models\BaseModel;
use App\Core\Session;
use App\Dao\InventarioDao;

class Inventario implements FullCRUDInterface{
    private $dao;
    
    public function __construct()
    {
        $this->dao = new InventarioDao();
    }

    public function crear(array $datos): bool
    {
        return $this->dao->crear($datos);
    }

    public function obtenerTodos(): ?array
    {
        return $this->dao->obtenerTodos();
    }
    public function buscarPorId(int $id): ?array
    {
        return $this->dao->buscarPorId($id);
    }
    public function actualizar(int $id, array $datos): bool
    {
        return $this->dao->actualizar($id,$datos);
    }
    public function eliminar(int $id): bool
    {
        return $this->dao->eliminar($id);
    }
}


?>