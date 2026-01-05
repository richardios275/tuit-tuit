<?php
session_start();
if (!isset($_SESSION["logged_in"]) || $_SESSION["logged_in"] !== true) {
    header("Location: ../login");
}
$username = $_SESSION['user_id'];

include_once('../config/db.php');
?>

