<?php
session_start();
require_once '../config/db.php';

echo('deleted '.$_POST['input']);

/*
// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

//INSERT INTO `posts` (`id`, `parent_id`, `body`, `user_username`, `status`, `created_at`) VALUES (DEFAULT, NULL, 'This is a new post.', 'vespin_p', 'online', CURRENT_TIMESTAMP);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $body = $_POST['body'];

    //$pdo=new PDO('mysql:host=localhost;port=3306;dbname=tuituit','root', '');
    $sql="
        
        "
        ;

    try {
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array(
            ':body' => $_POST['body'],
            ':user_id' => $_SESSION['user_id']));

        header('Location: ' . $_SERVER['HTTP_REFERER']);
    }
    catch (PDOException $e) {
        echo ''. $e->getMessage() .'';
    }
}
*/