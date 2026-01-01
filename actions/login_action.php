<?php
session_start();
require '../config/db.php';

// Temp
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    // Fetch user from DB
    $pdo = new PDO('mysql:host=localhost;port=3306;dbname=tuituit','root', '');
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Verify password
    if ($user && password_verify($password, $user['password'])) {
        session_regenerate_id(true);
        $_SESSION['user_id'] = $user['username'];
        $_SESSION['logged_in'] = true;

        header('Location: ../index.php');
        exit;
    } else {
        header('Location: ../login.php?error=1');
        exit;
    }
} else {
    header('Location: ../login.php');
    exit;
}

?>