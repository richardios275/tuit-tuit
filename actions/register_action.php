<?php
session_start();
require_once '../config/db.php';

function isValidUsername(string $username): bool
{
    return preg_match('/^[a-zA-Z0-9_-]{3,20}$/', $username) === 1;
}

function isStrongPassword(string $password): bool
{
    return preg_match('/^(?=.*[A-Z])(?=.*[0-9\W]).{8,}$/', $password) === 1;
}

// Temp
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    unset($_SESSION['regist_errors']);

    $errors = [] ;

    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    // Validation
    if (isValidUsername($username)) {
        $errors[] = 'Username must be at least 3 characters long and cannot contain special characters';
    }

    if (isStrongPassword($password)) {
        $errors[] = 'Password must be at least 8 characters long, contain at least one uppercase letter, and contain at least one number or special character';
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
            $stmt = $pdo->prepare(query: "INSERT INTO users (username, password) VALUES (?, ?);");
            $stmt->execute([$username, $hashed_password]);

            // Setup session and redirect
            $_SESSION['user_id'] = $username;
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