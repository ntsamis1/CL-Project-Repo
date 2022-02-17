<?php

use Hotel\User;

require_once __DIR__ . '/../boot/boot.php';

//check for existing logged in user
if (!empty(User::getCurrentUserId())) {
    header('Location: /public/index.php');
    die;
}
?>


<!DOCTYPE>
<html>

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="/public/assets/css/styles.css" />
    <link rel="stylesheet" href="/public/assets/css/fontawesome-free-5.15.4-web/fontawesome-free-5.15.4-web/css/all.min.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.0/themes/base/jquery-ui.css" />
</head>

<body>
    <header>
        <div class="container-flex">
            <p class="main-logo">Hotels</p>
            <div class="primary-menu text-right">
                <ul>
                    <li>
                        <a href="index.php" target="_blank">
                            <i class="fas fa-home"></i>
                            Home
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </header>
    <main>
        <section class="hero-login">
            <div class="container">
                <form action="/public/actions/login.php" method="post">
                    <?php if (!empty($_GET['error'])) { ?>
                        <div class="alert alert-danger alert-styled-left">Login Error</div>
                    <?php } ?>
                    <div class="container form-login">
                        <form action="/public/login.php" method="get">
                            <div class="input-wrapper">

                                <label for="Email"><b>Email</b></label>
                                <input id="email" type="input" placeholder="Email" name="email" required>
                                <div class="email-error error">Must be a valid email address!</div>

                            </div>

                            <div class="input-wrapper">

                                <label for="password"><b>Password</b></label>
                                <input id="password" type="password" placeholder="Enter Password" name="password" required>
                                <div class="password-error error">
                                    Must contain more than 4 characters!
                                </div>

                            </div>
                            <label class="checkbox">
                                <input type="checkbox" checked="checked" name="remember"> Remember me
                            </label>
                            <!-- <button type="submit" value="login" name="login">Login</button> -->
                            <button id="login" type="submit" class="submit-btn" disabled="disabled">LogIn</button>
                            <button type="button" class="cancelbtn">Cancel</button>
                            <span class="psw">Forgot <a href="#">password?</a></span>
                        </form>
                    </div>
                </form>
        </section>
    </main>
    <footer>
        <p>(c) Copyright CollegeLink 2020</p>
    </footer>
    <script src="/public/assets/js/login.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script src="https://code.jquery.com/ui/1.13.0/jquery-ui.js"></script>
    <script src="/public/assets/js/app-jquery.js"></script>
</body>