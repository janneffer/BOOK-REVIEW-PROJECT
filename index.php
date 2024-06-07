<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}

include 'dbconn.php';
include 'header.php';
include 'sections/home.php';
include 'sections/trending.php';
include 'sections/devteam.php';
include 'footer.php';

$conn->close();
?>
