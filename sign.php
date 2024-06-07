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
    <title>ReadRater</title>
    <!-- <link rel="icon" href="asset/picture/profile/avatarA_bgred.png" type="image/x-icon"> -->
    
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
            <li><a href="index.php#contact">Contact</a></li>
        </ul>
    </header>

    <section class="login-page" id="login-page">
        <div class="login-container">
            <div class="form-box login">
                <h2>Login</h2>
                <form action="login.php" method="POST">
                    <div class="input-box">
                        <i class='bx bx-envelope'></i>
                        <input type="email" name="email" required>
                        <label>Email</label>
                    </div>
                    <div class="input-box">
                        <i class='bx bx-lock-alt'></i>
                        <input type="password" name="password" required>
                        <label>Password</label>
                    </div>
                    <div class="remember-forget">
                        <label>
                            <input type="checkbox">Remember me
                        </label>
                        <a href="#">Forgot Password?</a>
                    </div>
                    <button type="submit" class="btn">Login</button>
                    <div class="login-register">
                        <p>Don't have an account?</p>
                        <a href="#" class="register-link" id="register-link">Register</a>
                    </div>
                </form>
            </div>

            <div class="form-box register">
                <h2>Registration</h2>
                <form action="register.php" method="POST">
                    <div class="input-box">
                        <input type="text" name="first_name" required>
                        <label>First Name</label>
                    </div>
                    <div class="input-box">
                        <input type="text" name="last_name" required>
                        <label>Last Name</label>
                    </div>
                    <div class="input-box">
                        <i class='bx bx-envelope'></i>
                        <input type="email" name="email" required>
                        <label>Email</label>
                    </div>
                    <div class="input-box">
                        <i class='bx bx-lock-alt'></i>
                        <input type="password" name="password" required>
                        <label>Password</label>
                    </div>
                    <button type="submit" class="btn">Register</button>
                    <div class="login-register">
                        <p>Already have an account?</p>
                        <a href="#" class="login-link" id="login-link">Login</a>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <!-- ==================== LINK TO JAVASCRIPT ==================== -->
    <script>
        <?php
        session_start();
        if (isset($_SESSION['error'])) {
            echo "alert('" . addslashes($_SESSION['error']) . "');";
            unset($_SESSION['error']);
        }
        ?>
    </script>
    <script src="asset/js/script.js"></script>
</body>
</html>
