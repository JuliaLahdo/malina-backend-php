<?php

class Database {
    private $database_host = 'mysql:host=localhost:8889;dbname=malina;charset=utf8';
    private $database_username = 'root';
    private $database_password = 'root';

    public function database_connection() {
        try {
            $pdo= new PDO($database_host, $database_username, $database_password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $pdo;
        } catch (PDOException $error) {
            echo 'Connection failed: ' . $error->getMessage();
            exit;
        }
    }
}

?>