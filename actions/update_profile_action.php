<?php
require_once '../config/db.php';

if (!isset($_SESSION["logged_in"]) || $_SESSION["logged_in"] !== true) {
    header("Location: ../login");
    exit();
}
if(isset($_POST['oldPasswordInput'])&&$_POST['oldPasswordInput']!==null){
    if (password_verify($_POST['oldPasswordInput'], $user['password'])) {
        $stmt = $pdo->prepare("UPDATE `users` 
                                SET 
                                displayname='".$_POST['displayNameInput']."',
                                pronouns='".$_POST['pronounsInput']."',
                                bio='".$_POST['bioInput']."',
                                password='".password_hash($_POST['newPasswordInput'], PASSWORD_DEFAULT)."'

                                WHERE username=?");
        $stmt->execute([$username]);
    } else {
        echo("old password does not match");
    }
}

unset($_POST['displayNameInput']);
unset($_POST['pronounsInput']);
unset($_POST['bioInput']);  
unset($_POST['oldPasswordInput']);
unset($_POST['newPasswordInput']);


?>