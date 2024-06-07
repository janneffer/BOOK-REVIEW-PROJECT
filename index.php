<?php
session_start();
$isLoggedIn = isset($_SESSION['user_id']);
include 'dbconn.php';
include 'header.php';
include 'sections/home.php';
include 'sections/trending.php';
include 'sections/devteam.php';
include 'footer.php';
$conn->close();
?>
