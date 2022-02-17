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
        <section class="hero-register">
            <form method="post" action="actions/register.php">
                <?php if (!empty($_GET['error'])) { ?>
                    <div class="alert alert-danger alert-styled-left">Register Error</div>
                <?php } ?>
                <div class="container">
                    <h1>Register</h1>
                    <p>Please fill in this form to create an account.</p>
                    <hr>
                    <form action="/public/actions/register.php">

                        <label for="name"><b>Full Name</b></label>
                        <input type="text" placeholder="Enter your full name" name="name" id="full-name" required>
                        <div class="full-name-error error">
                            Full Name must contains only letters without spaces!
                        </div>

                        <label for="email"><b>Email</b></label>
                        <input type="text" placeholder="Enter Email" name="email" id="email" required>
                        <div class="email-error error">
                            Must be a valid email address!
                        </div>

                        <label for="second-email"><b>Confirm Email</b></label>
                        <input type="text" placeholder="Confirm Email" name="email" id="second-email" required>
                        <div class="second-email-error error">
                            Emails must match!
                        </div>

                        <label for="password"><b>Password</b></label>
                        <input type="password" placeholder="Enter Password" name="password" id="password" required>
                        <div class="password-error error">
                            Must contain more than 4 characters!
                        </div>
                        <hr>

                        <p>By creating an account you agree to our <a href="#">Terms & Privacy</a>.</p>
                        <button id="register" type="submit" class="submit-btn" disabled="disabled">Register</button>

                    </form>
                    <div class="container signin">
                        <p>Already have an account? <a href="login.html">Sign in</a>.</p>
                    </div>
                </div>
            </form>
        </section>
    </main>
    <footer>
        <p>(c) Copyright CollegeLink 2020</p>
    </footer>
    <script src="/public/assets/js/register.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script src="https://code.jquery.com/ui/1.13.0/jquery-ui.js"></script>
    <script src="/public/assets/js/app-jquery.js"></script>
</body>

</html