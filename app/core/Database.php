<?php
namespace App\Core;

class Database {
    private $host = "localhost";
    private $db_name = "sistema_login";
    private $username = "root";
    private $password = "root";
    private $port = "3307";  // Puerto 3307
    public $conn;

    public function getConnection(){
        $this->conn = null;
        try{
            // Se incluye el puerto 3307 en la cadena de conexión
            $dsn = "mysql:host=".$this->host.";dbname=".$this->db_name.";port=".$this->port;
            $this->conn = new \PDO($dsn, $this->username, $this->password);
            // Configurar el modo de error de PDO para que lance excepciones
            $this->conn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            // Establecer el conjunto de caracteres en UTF-8
            $this->conn->exec("set names utf8");
        }catch(\PDOException $exception){
            // Registrar el error y mostrar un mensaje genérico
            error_log("Error de conexión a la base de datos: " . $exception->getMessage());
            echo "Error de conexión a la base de datos. Por favor intente más tarde.";
        }
        return $this->conn;
    }

    // Método opcional para cerrar la conexión
    public function closeConnection() {
        $this->conn = null;
    }
}
