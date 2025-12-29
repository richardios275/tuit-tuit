<?php
session_start();
require '../config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $username = $_GET['username'];

    // Fetch user from DB
    $stmt = $pdo->prepare("SELECT username, displayname, bio, profile_pic, created_at, pronouns FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Convert to JSON
    extract($user);
    $data = array(
        "username"=> $user["username"],
        "displayname"=> $user["displayname"],
        "bio"=> $user["bio"],
        "profile_pic"=> $user["profile_pic"],
        "created_at"=> $user["created_at"],
        "pronouns"=> $user["pronouns"],
    );
    echo json_encode($data);
}

