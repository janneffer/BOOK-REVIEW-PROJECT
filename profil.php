<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: sign.php");
    exit();
}

include 'db_connect.php';

$user_id = $_SESSION['user_id'];
$sql = "SELECT first_name, last_name, email, profile_picture FROM users WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($first_name, $last_name, $email, $profile_picture);
$stmt->fetch();
$stmt->close();
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <!-- ========== META ========== -->
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="A platform to review and rate books.">
    <meta name="keywords" content="books, reviews, ratings, ReadRater">

    <!-- ========== TITLE ========== -->
    <title>User Profile - ReadRater</title>

    <!-- ========== LINK TO CSS ==========  -->
    <link rel="stylesheet" href="asset/css/style.css">
    
    <!-- ========== LINK TO BOX ICONS ========== -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
</head>

<body>
    <!-- ==================== HEADER / NAVBAR ==================== -->
    <header>
        <div class="bx bx-menu" id="burger-menu"></div>
        <h2><a href="index.php" class="logo">ReadRater</a></h2>
        <!-- ========== NAVBAR MENU ========== -->
        <ul class="navbar">
            <li><a href="index.php#trending">Trending</a></li>
            <li><a href="browse.php">Browse</a></li>
            <li><a href="#contact">Contact</a></li>
        </ul>
    </header>

    <!-- ==================== PROFILE SECTION ==================== -->
    <section class="profile" id="profile">
        <div class="profile-box">
            <h2>User Profile</h2>

            <div class="profile-menu">
                <a href="#" class="menu-link">
                    <i class='bx bxs-user-circle'></i>
                    User info
                </a>
                <a href="logout.php" class="menu-link">
                    <i class='bx bx-log-out-circle'></i>
                    Logout
                </a>
            </div>
        </div>

        <div class="edit-box">
            <img src="<?php echo htmlspecialchars($profile_picture); ?>" alt="photo-profile">
            <div class="profile-details">
                <h2 class="user-name"><?php echo htmlspecialchars($first_name . ' ' . $last_name); ?></h2>
                <p class="profil-email"><?php echo htmlspecialchars($email); ?></p>
            </div>

            <div class="edit-profile">
                <form action="update_profile.php" method="POST" enctype="multipart/form-data">
                    <div class="e-container">
                        <label>First Name</label>
                        <input type="text" name="first_name" value="<?php echo htmlspecialchars($first_name); ?>" required>
                    </div>
                    <div class="e-container">
                        <label>Last Name</label>
                        <input type="text" name="last_name" value="<?php echo htmlspecialchars($last_name); ?>" required>
                    </div>
                    <div class="e-container">
                        <label>Email</label>
                        <input type="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required>
                    </div>
                    <div class="e-container">
                        <label>Profile Picture</label>
                        <input type="file" name="profile_picture">
                    </div>
                    <div class="e-container">
                        <label>Password</label>
                        <input type="password" name="password" placeholder="New Password">
                    </div>
                    <button type="submit" class="save-button">Save Changes</button>
                </form>
            </div>
        </div>
    </section>

    <!-- ==================== LINK TO JAVASCRIPT ==================== -->
    <script src="asset/js/script.js"></script>
</body>
</html>
