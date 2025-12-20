<?php

$host = "localhost:3306";
$db = "tuituit";
$user = "server";
$pass = "12345678";

$dsn = "mysql:host=$host;dbname=$db";

try {
    $pdo = new PDO($dsn, $user, $pass);
} catch (PDOException $e) {
    echo "" . $e->getMessage();
}

?>