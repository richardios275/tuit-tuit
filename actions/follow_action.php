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

    // Check if following
    $following = false;
    try {
        $stmt = $pdo->prepare("
        SELECT * FROM follows
        WHERE
        `followed_user_username` = :followed_id
        AND `following_user_username` = :following_id;
        ");
        $stmt->execute(array(
            ':following_id' => $id,
            'followed_id'=> $_SESSION['user_id'],
            ));

        if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $following = true;
        }
        //header('Location: ' . $_SERVER['HTTP_REFERER']);
    }
    catch (PDOException $e) {
        $errors[] = ''. $e->getMessage() .'';
    }

    // Do Follow / Unfollow action
    if (empty($errors)) {
        if ($following) {
            try {
                $stmt = $pdo->prepare('DELETE FROM `follows` WHERE `followed_user_username` = :followed_id
                    AND `following_user_username` = :following_id;');

                $stmt->execute(array(
                ':following_id' => $id,
                'followed_id'=> $_SESSION['user_id'],
                ));

                echo 'unfollowed';
            }
            catch (PDOException $e) {
                $errors[] = ''. $e->getMessage() .'';
            }
        }
        else {
            try {
                $stmt = $pdo->prepare('INSERT INTO `follows` (`following_user_username`, `followed_user_username`) VALUES (:following_id, :followed_id);');

                $stmt->execute(array(
                ':following_id' => $id,
                'followed_id'=> $_SESSION['user_id'],
                ));
                echo 'followed';
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