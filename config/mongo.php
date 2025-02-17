<?php
require_once __DIR__ . '/../vendor/autoload.php';  

try {
    $mongoClient = new MongoDB\Client("mongodb://127.0.0.1:27017");  
    $database = $mongoClient->selectDatabase('notes_app'); 
    $mongoCollection = $database->selectCollection('notes');  
} catch (Exception $e) {
    die("MongoDB connection failed: " . $e->getMessage());
}
