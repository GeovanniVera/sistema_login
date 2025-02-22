<?php
namespace App\Core;

class Database {
    private $host = "localhost";
    private $db_name = "sistema_login";
    private $username = "root";
    private $password = "vera230901";
    public $conn;

    public function getConnection(){
        $this->conn = null;
        try{
            $this->conn = new PDO("mysql:hots=".$this->host.";dbname=".$this->db_name, $this->username,$this->password);
            $this->conn->exec("set names utf8");
        }catch(PDOException $exception){
            echo "Error de conexio: ". $exception->getMessage();
        }
        return $this->conn;
    }
}

?>