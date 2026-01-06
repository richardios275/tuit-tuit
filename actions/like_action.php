<?php
session_start();
require_once '../config/db.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];

    $errors = array();

    // Check if already liked
    $liked = false;
    try {
        $stmt = $pdo->prepare("
        SELECT * FROM likes
        WHERE
        `post_id` = :post_id
        AND `user_username` = :user_id;
        ");
        $stmt->execute(array(
            ':post_id' => $id,
            'user_id'=> $_SESSION['user_id'],
            ));

        if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $liked = true;
        }
        //header('Location: ' . $_SERVER['HTTP_REFERER']);
    }
    catch (PDOException $e) {
        $errors[] = ''. $e->getMessage() .'';
    }

    // Do Follow / Unfollow action
    if (empty($errors)) {
        if ($liked) {
            try {
                $stmt = $pdo->prepare('DELETE FROM `likes` WHERE `user_username` = :user_id
                    AND `post_id` = :post_id;');

                $stmt->execute(array(
                ':post_id' => $id,
                'user_id'=> $_SESSION['user_id'],
                ));

                echo 'unliked';
            }
            catch (PDOException $e) {
                $errors[] = ''. $e->getMessage() .'';
            }
        }
        else {
            try {
                $stmt = $pdo->prepare('INSERT INTO `likes` (`user_username`, `post_id`) VALUES (:user_id, :post_id);');

                $stmt->execute(array(
                ':post_id' => $id,
                'user_id'=> $_SESSION['user_id'],
                ));
                echo 'liked';
            }
            catch (PDOException $e) {
                $errors[] = ''. $e->getMessage() .'';
            }
        }
    }

    if (empty($errors)) {
        //header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit();
    }
    else {
        Echo("<pre>\n");
        Print_r($errors);
        Echo("</pre>\n");
    }
}