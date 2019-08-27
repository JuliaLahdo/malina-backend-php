<?php

class Database {
    private $database_host = 'mysql:host=localhost:8889;dbname=malina;charset=utf8';
    private $database_username = 'root';
    private $database_password = 'root';

    public $pdo;

    public function database_connection() {
        $this->pdo = null;

        try {
            $this->pdo = new PDO($database_host, $database_username, $database_password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $error) {
            echo 'Connection failed: ' . $error->getMessage();
        }
        return $this->pdo;
    }
}

?>