<?php

$database_host = 'mysql:host=localhost:8889;dbname=malina;charset=utf8';
$database_username = 'root';
$database_password = 'root';

try {
    $pdo= new PDO($database_host, $database_username, $database_password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $error) {
    echo 'Connection failed: ' . $error->getMessage();
}


?>

