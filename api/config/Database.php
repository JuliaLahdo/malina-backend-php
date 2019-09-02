<?php

class Database {
    private $databaseHost = "localhost:8889";
    private $databaseName = "malina";
    private $databaseUsername = 'root';
    private $databasePassword = 'root';
    public $pdo;

    public function databaseConnection() {
        $this->pdo = null;
        try {
            //$cfg['PersistentConnections'] = TRUE;
    
            $this->pdo = new PDO("mysql:host=" . $this->databaseHost . ";dbname=" . $this->databaseName, $this->databaseUsername, $this->databasePassword);
            $this->pdo->exec("Set names UTF8");
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $error) {
            echo 'Connection failed: ' . $error->getMessage();
        }
        return $this->pdo;
    }
}
?>