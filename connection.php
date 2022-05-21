<?php

    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    $host = '127.1.0.1';
    $db = 'shopify';
    $user = 'root';
    $pass = '';
    $charset = 'utf8mb4';
    $dsn = "mysql:host=$host;dbname=$db;charset=$charset";

    try{
        $conn = new PDO($dsn, $user, $pass);

    } catch(PDOException $e){
        echo "Connection failed: " . $e->getMessage();
    }
 
?>    