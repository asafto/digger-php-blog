<?php 
require_once 'app/helpers.php';

if ( isset($_SESSION['user_id']) ){
    
    if ( ! isset($link) ) {
        $link = mysqli_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PWD, MYSQL_DB);
        mysqli_query($link, "SET NAMES utf8");
    }
    
    $uid1 = $_SESSION['user_id'];
    $sql1 = "SELECT profile_image FROM users WHERE id = $uid1";
    $result1 = mysqli_query($link,$sql1);
    if($result1 && mysqli_num_rows($result1) == 1) {
        $user = mysqli_fetch_assoc($result1);
    }
    
}

 
?>

<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"
        integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <!-- fontawasome icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
    <title>digger | <?= $page_title; ?>
    </title>
</head>

<body>
    <header>
        <nav class="navbar navbar-expand-md navbar-dark bg-primary">
            <div class="container">
                <a class="navbar-brand text-white" href="./">Digger</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse"
                    data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item">
                            <a class="nav-link text-white" href="about.php">About</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="blog.php">Blog</a>
                        </li>
                    </ul>
                    <ul class="navbar-nav ml-auto">
                        <?php if ( !isset($_SESSION['user_id']) ): ?>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="signin.php">Signin</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="signup.php">Signup</a>
                        </li>
                        <?php else : ?>
                        <li class="nav-item d-flex align-items-center">
                            <a class="nav-link text-white" href="user_profile.php?uid=<?= $uid1 ?>"><img
                                    class="rounded-circle mr-1" src="images/<?= $user['profile_image']; ?>" width="30"
                                    height="30">
                                <?= htmlentities($_SESSION['user_name']); ?>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="logout.php">Logout</a>
                        </li>

                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </nav>
    </header>
