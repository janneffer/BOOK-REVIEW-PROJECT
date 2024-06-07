<?php
session_start();
include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT user_id, password FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($user_id, $hashed_password);
    $stmt->fetch();

    if ($stmt->num_rows > 0) {
        if (password_verify($password, $hashed_password)) {
            $_SESSION['user_id'] = $user_id;
            header("Location: index.php");
            exit();
        } else {
            $_SESSION['error'] = "password";
            header("Location: sign.php");
            exit();
        }
    } else {
        $_SESSION['error'] = "not_registered";
        header("Location: sign.php");
        exit();
    }

    $stmt->close();
    $conn->close();
}
?>
