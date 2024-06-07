<?php
session_start();
include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Check if email already exists
    $sql = "SELECT email FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
        $_SESSION['error'] = "Email already exists.";
        header("Location: sign.php");
        exit();
    }
    $stmt->close();

    // Insert new user
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);
    $sql = "INSERT INTO users (first_name, last_name, email, password) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $first_name, $last_name, $email, $hashed_password);

    if ($stmt->execute()) {
        $_SESSION['user_id'] = $stmt->insert_id;
        header("Location: index.php");
        exit();
    } else {
        $_SESSION['error'] = "Registration failed.";
        header("Location: sign.php");
        exit();
    }

    $stmt->close();
    $conn->close();
}
?>
