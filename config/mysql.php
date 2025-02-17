<?php
$host = '127.0.0.1';  
$dbname = 'notes_app';  
$username = 'root'; 
$password = '';  
$port = 3307;  

try {
    $pdo = new PDO("mysql:host=$host;port=$port;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("MySQL connection failed: " . $e->getMessage());
}
