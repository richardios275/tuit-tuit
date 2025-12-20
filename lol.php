<?php
require 'config/db.php';

$stmt = $pdo->prepare("UPDATE users SET password = ? WHERE username = ?");
$stmt->execute([password_hash('12345678', PASSWORD_DEFAULT), "vespin_p"]);
$result = $stmt->fetchAll();

?>