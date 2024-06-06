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
            <h2><a href="index.php#" class="logo">ReadRater</a></h2>
            <!-- ========== NAVBAR MENU ========== -->
            <ul class="navbar">
                <li><a href="index.php#trending">Trending</a></li>
                <li><a href="browse.php#">Browse</a></li>
                <li><a href="#contact">Contact</a></li>
            </ul>
            <div class="login-profile-container">
                <a href="sign.html" class="btn-signing-container">
                    <button class="btn-signing">Login</button>
                </a>
                <div class="navbar-profile">
                    <div class="nav-profile-link">
                        <img src="asset/picture/Catching_fire.jpeg" alt="Profile Picture" class="nav-profile-pic" id="profile-pic">
                    </div>
                    <div class="nav-profile-dropdown" id="nav-profile-dropdown">
                        <a href="profil.html">Profile</a>
                        <a href="#">Logout</a>
                    </div>
                </div>
            </div>           
        </header>