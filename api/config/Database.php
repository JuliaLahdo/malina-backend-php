<?php

class Database {
    private $database_host = "localhost:8889";
    private $db_name = "malina";
    private $database_username = 'root';
    private $database_password = 'root';
    public $pdo;

    public function database_connection() {
        $this->pdo = null;
        try {
    
            $this->pdo = new PDO("mysql:host=" . $this->database_host . ";dbname=" . $this->db_name, $this->database_username, $this->database_password);
            $this->pdo->exec("Set names UTF8");
        } catch (PDOException $error) {
            echo 'Connection failed: ' . $error->getMessage();
        }
        return $this->pdo;
    }
}
?>