<?php
    class User{
        private $conn;
        private $table = "usuarios";

        public $id; 
        public $nombre;
        public $email;
        public $password;

        public function __construct($db)
        {
            $this->conn = $db;
        }
        //Metodo para Registrar Usuarios
        public function registrar(){
            $query = "INSERT INTO " . $this->table ." SET nombre=:nombre,email=:email,password=:password";
            $stmt = $this->conn->prepare($query);
            $this->password = password_hash($this->password,PASSWORD_BCRYPT);
            $stmt->bindParam(":nombre",$this->nombre);
            $stmt->bindParam(":email",$this->email);
            $stmt->bindParam(":password",$this->password);
            return $stmt->execute();
        }

        //Metodo para iniciar Sesion
        public function login(){
            $query = "SELECT * FROM ".$this->table."WHERE email = :email LIMIT 1";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":email",$this->email);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if($row && password_verify($this->password,$row['password'])){
                return $row;
            }
            return false;
        }
    }
?>