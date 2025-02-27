<?php

namespace App\Models;
use App\Dao\InsumoDao;
use App\Interfaces\FullCRUDInterface;
use PDOException;
use RuntimeException;

class Insumo implements FullCRUDInterface
{
    private ?int $id;
    private string $nombre;
    private string $clave;
    private int $idInventario;

    private InsumoDao $dao;

    public function __construct(InsumoDao $dao)
    {
        $this->dao = new $dao;
    }
    /*Getters and Setters */

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


    public function setClave(string $clave) : void {
        $this->clave = $clave;
    }

    function getClave() : string {
        return $this->clave ;
    }


    public function setIdInventario(int $idInventario) : void {
        $this->idInventario = $idInventario;
    }

    function getIdInventario() : int {
        return $this->idInventario ;
    }
    /*Metodos del Dao */

    /**
     * Crea un insumo en la base de datos
     * @param array $datos los datos del insumo a crear
     * @return bool $ True si la operacion fue exitosa, false en caso contrario
     * @throws RunTimeException Si ocurre un error en la base de datos
     */
    public function crear(array $datos): bool
    {
        try{
            $this->setNombre($datos['nombre']);
            $this->setClave($datos['clave']);
            $this->setIdInventario($datos['id_inventario']);
            return $this->dao->crear($this);
        }catch(PDOException $e){
            throw new RuntimeException("Error al crear el insumo ".$e->getMessage());
        }
    }

    /**
     * Obtener todos los insumos de la base de datos
     * @return array Retorna un arreglo de objetos si fue exitoso so no null
     * @throws RunTimeException Si ocurre un error en la base de datos
     */
    public function obtenerTodos(): ?array
    {
        try{
            return $this->dao->obtenerTodos();
        }catch(PDOException $e){
            throw new RuntimeException("Error al recuperar los insumos".$e->getMessage());
        }
    }
    /**
     * Obtener un isumo de la base de datos por id
     * @param int $id el id del usuario que se va a buscar
     * @return array|null 
     */
    public function buscarPorId(int $id): ?array
    {
        try{
            return $this->dao->buscarPorId($id);
        }catch(PDOException $e){
            throw new RuntimeException("Error al recuperar el insumos con id $id".$e->getMessage());
        }
    }
    /**
     * Actualizar un isumo de la base de datos por id
     * @param int $id el id del usuario que se va a buscar
     * @return bool true si fue exitosa y false si no lo es 
     * @throws RuntimeException Si ocurre un error en la base de datos
     */
    public function actualizar(int $id, array $datos): bool
    {
        try{
            $this->setNombre($datos['nombre']);
            $this->setClave($datos['clave']);
            $this->setIdInventario($datos['id_inventario']);
            return $this->dao->actualizar($id,$this);
        }catch(PDOException $e){
            throw new RuntimeException("Error al recuperar el insumos con id $id".$e->getMessage());
        }
    }
    /**
     * Eliminar un insumo de la base de datos por id
     * @param int $id es el id del insumo que se eliminara
     * @return bool True si se completo con exito False si ocurrio un error
     * @throws RunTimeException si ocurre un error en la base de datos
     */
    public function eliminar(int $id): bool
    {
        try{

            return $this->dao->eliminar($id);
        }catch(PDOException $e){
            throw new RuntimeException("Error al eliminar el insumo ".$e->getMessage());
        }
    }

    
}
