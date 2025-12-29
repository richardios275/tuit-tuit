<?php
session_start();
require_once '../config/db.php';

// Temp
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    unset($_SESSION['regist_errors']);

    $errors = [] ;

    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    // Validation
    if (strlen($username) < 3) {
        $errors[] = 'Username must be at least 3 characters long';
    }

    if (strlen($password) < 8) {
        $errors[] = 'Password must be at least 8 characters long';
    }

    if (empty($errors)) {
        try {
            $stmt = $pdo->prepare("SELECT username FROM users WHERE username = ?");
            $stmt->execute([$username]);
            if ($stmt->rowCount() > 0) {
                $errors[] = "Username already exists.";
            }
        } catch (PDOException $e) {
            $errors[] = "Server error: " . $e->getMessage();
        }
    }

    if (empty($errors)) {
        try {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare(query: "INSERT INTO users (username, password) VALUES (?, ?)");
            $stmt->execute([$username, $hashed_password]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            // Setup session and redirect
            $_SESSION['user_id'] = $user['username'];
            $_SESSION['logged_in'] = true;
            header("Location: ../home2.php");
            exit();

        } catch (PDOException $e) {
            $errors[] = "Server error: " . $e->getMessage();
        }
    }

    if (!empty($errors)) {
        $_SESSION['regist_errors'] = $errors;
        header('Location: ../register');
        exit();
    }

} else {
    header('Location: ../register');
    exit;
}

?>