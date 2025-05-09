<?php

    class Database{
        private $host = "82.29.56.140:3600";
        private $db_name = "qualify";
        private $username = "root";
        private $password = "myadmin123";

        public $conn;

        public function getConnection(){
            $this->conn = null;

            try{
                $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
                $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            }catch(PDOException $exception){
                echo "Erro de conexão " . $exception->getMessage();
            }
            return $this->conn;
        }
    }
?>