<?php

$host = "localhost:3306";
$db = "tuituit";
$user = "root";
$pass = "";

$dsn = "mysql:host=$host;dbname=$db";

try {
    $pdo = new PDO($dsn, $user, $pass);
} catch (PDOException $e) {
    echo "" . $e->getMessage();
}

?>