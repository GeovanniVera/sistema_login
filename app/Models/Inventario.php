<?php
namespace App\Models;

use App\Dao\InsumoDao;
use App\Interfaces\FullCRUDInterface;
use App\Dao\InventarioDao;
use PDOException;
use RuntimeException;

class Inventario implements FullCRUDInterface{
    private InventarioDao $dao;
    
    
    public function __construct(private int $id = 0, private string $nombre = "")
    {
        $this->dao = new InventarioDao();
    }

    public function setId(int $id) : void{
        $this->id = $id;
    }

    public function getId() : int{
        return $this->id;
    }

    public function setNombre(string $nombre) : void {
        $this->nombre = $nombre;
    }

    function getNombre() : string {
        return $this->nombre ;
    }


    public function crear(array $datos): bool
    {
        try{
            $this->setNombre($datos['nombre']); 
            return $this->dao->crear($this);
        }catch(PDOException $e){
            throw new RuntimeException("Error al crear un inventario en la base de datos " . $e->getMessage());
        }
    }

    public function obtenerTodos(): ?array{
        try{
            return $this->dao->obtenerTodos();        
        }catch(PDOException $e){
            throw new RuntimeException("Error al obtener inventarios en la base de datos " . $e->getMessage());
        }
    }
    public function buscarPorId(int $id): ?array
    {
        try{
            return $this->dao->buscarPorId($id);        
        }catch(PDOException $e){
            throw new RuntimeException("Error al obtener un inventario en la base de datos " . $e->getMessage());
        }    
    }

    public function actualizar(int $id, array $datos): bool
    {
        try{
            return $this->dao->actualizar($id,$this);       
        }catch(PDOException $e){
            throw new RuntimeException("Error al Modificar un inventario en la base de datos " . $e->getMessage());
        }
    }
    public function eliminar(int $id): bool
    {
        try{
            return $this->dao->eliminar($id);       
        }catch(PDOException $e){
            throw new RuntimeException("Error al eliminar un inventario en la base de datos " . $e->getMessage());
        }    
    }

}


?>