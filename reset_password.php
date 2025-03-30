<?php
session_start();
include('database.php');

if (!isset($_SESSION['token']) || !isset($_SESSION['email'])) {
    ?>
    <script>
        alert("Session expired or invalid access.");
        window.location.replace("forgot_password.php");
    </script>
    <?php
    exit();
}

if (isset($_POST["reset"])) {
    $psw = $_POST["new_password"];
    $confirmPsw = $_POST["confirm_password"];

    if ($psw === $confirmPsw) {
        $token = $_SESSION['token'];
        $Email = $_SESSION['email'];

        $hash = password_hash($psw, PASSWORD_DEFAULT);

        $sql = mysqli_query($conn, "SELECT * FROM User WHERE email='$Email'");
        $query = mysqli_num_rows($sql);
        $fetch = mysqli_fetch_assoc($sql);

        if ($Email) {
            $new_pass = $hash;
            mysqli_query($conn, "UPDATE User SET password='$new_pass' WHERE email='$Email'");
            ?>
            <script>
                alert("Your password has been reset successfully.");
                window.location.replace("login.php");
            </script>
            <?php
        } else {
            ?>
            <script>
                alert("Please try again");
            </script>
            <?php
        }
    } else {
        ?>
        <script>
            alert("Passwords do not match");
        </script>
        <?php
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- Fonts from Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Poppins&family=Press+Start+2P&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="login_register.css" />
    <title>Snake</title>
    <link rel="icon" type="image/png" href="Assets/imgs/favicon-16x16.png" />
</head>
<body>
    <img src="Assets/imgslogin/1.png" class="bg" />
    <div class="FormContainer">
        <div class="col col-1">
            <div class="imagelayer">
                <img src="Assets/imgslogin/white-outline.png" class="form-image-main" />
                <img src="Assets/imgslogin/dots.png" class="form-image dots" />
                <img src="Assets/imgslogin/cloud.png" class="form-image cloud" />
                <img src="Assets/imgslogin/coin.png" class="form-image coin" />
                <img src="Assets/imgslogin/rocket.png" class="form-image rocket" />
                <img src="Assets/imgslogin/spring.png" class="form-image spring" />
                <img src="Assets/imgslogin/stars.png" class="form-image stars" />
            </div>
            <p class="featured">
                Come and Play Our Game! <span>-Yeshua and Diane-</span>
            </p>
        </div>
        <div class="col col-2">
            <!-- New Password -->
            <div class="login-form">
                <div class="form-title">
                    <span>Create New Password</span>
                </div>
                <div class="form-inputs">
                    <form action="" method="POST">
                        <div class="input-box">
                            <input type="password" class="input-field" id="new_password" name="new_password" placeholder="New Password" required />
                        </div>
                        <div class="input-box">
                            <input type="password" class="input-field" id="confirm_password" name="confirm_password" placeholder="Confirm Password" required />
                        </div>
                        <div class="input-box">
                            <button type="submit" class="input-submit" name="reset">
                                <span>Confirm</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

<script>
const toggle = document.getElementById('togglePassword');
const password = document.getElementById('new_password');

if (toggle) {
    toggle.addEventListener('click', function() {
        if (password.type === "password") {
            password.type = 'text';
        } else {
            password.type = 'password';
        }
        this.classList.toggle('bi-eye');
    });
}
</script>
