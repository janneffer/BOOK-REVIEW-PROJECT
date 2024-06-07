<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: sign.php");
    exit();
}

include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['user_id'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Handle profile picture upload
    if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] == 0) {
        $profile_picture = 'uploads/' . basename($_FILES['profile_picture']['name']);
        move_uploaded_file($_FILES['profile_picture']['tmp_name'], $profile_picture);
    } else {
        $profile_picture = NULL;
    }

    // Update query
    $sql = "UPDATE users SET first_name = ?, last_name = ?, email = ?";
    if (!empty($password)) {
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);
        $sql .= ", password = ?";
    }
    if ($profile_picture !== NULL) {
        $sql .= ", profile_picture = ?";
    }
    $sql .= " WHERE user_id = ?";

    $stmt = $conn->prepare($sql);
    if (!empty($password) && $profile_picture !== NULL) {
        $stmt->bind_param("sssssi", $first_name, $last_name, $email, $hashed_password, $profile_picture, $user_id);
    } elseif (!empty($password)) {
        $stmt->bind_param("ssssi", $first_name, $last_name, $email, $hashed_password, $user_id);
    } elseif ($profile_picture !== NULL) {
        $stmt->bind_param("sssisi", $first_name, $last_name, $email, $profile_picture, $user_id);
    } else {
        $stmt->bind_param("sssi", $first_name, $last_name, $email, $user_id);
    }

    if ($stmt->execute()) {
        $_SESSION['success'] = "Profile updated successfully.";
    } else {
        $_SESSION['error'] = "Error updating profile.";
    }

    $stmt->close();
    $conn->close();
    header("Location: profil.php");
    exit();
}
?>
