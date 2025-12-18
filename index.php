<?php
session_start();
if (!isset($_SESSION["logged_in"]) || $_SESSION["logged_in"] !== true) {
    header("Location: login.php");
} else {
    header("Location: home2.php");
}

$page = $_GET['page'] ?? 'home';
$pagePath = "pages/$page.php";

if (!file_exists($pagePath)) {
    $pagePath = "pages/404.php";
}
?>