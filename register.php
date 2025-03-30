<?php
session_start();
require __DIR__ . '/vendor/autoload.php';

include('database.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = mysqli_real_escape_string($conn, trim($_POST["email"]));
    $password = trim($_POST["password"]);
    $confirm_password = trim($_POST["confirm_password"]);
    $name = mysqli_real_escape_string($conn, trim($_POST["name"]));

    // Check if email already exists
    $check_query = mysqli_query($conn, "SELECT * FROM user WHERE email ='$email'");
    $rowCount = mysqli_num_rows($check_query);

    if (!empty($email) && !empty($password) && !empty($confirm_password) && !empty($name)) {
        if ($rowCount > 0) {
            echo "<script>alert('User with that email already exists!');</script>";
        } elseif ($password !== $confirm_password) {
            echo "<script>alert('Passwords do not match!');</script>";
        } else {
            // Hash the password
            $password_hash = password_hash($password, PASSWORD_BCRYPT);

            // Default status_id for new users (e.g., '1' for unverified)
            $default_status_id = 1;

            // Insert user into the database
            $result = mysqli_query($conn, "INSERT INTO user (name, email, password, status_id) VALUES ('$name', '$email', '$password_hash', $default_status_id)");

            if ($result) {
                // Generate OTP
                $otp = rand(100000, 999999);
                $_SESSION['otp'] = $otp;
                $_SESSION['mail'] = $email;

                // Send OTP email
                $mail = new \PHPMailer\PHPMailer\PHPMailer();

                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->Port = 587;
                $mail->SMTPAuth = true;
                $mail->SMTPSecure = 'tls';

                $mail->Username = "yeshuakrysler08@gmail.com"; // Your email
                $mail->Password = "dejo tqkj whmn edcu";       // Your email password
                $mail->setFrom('yeshuakrysler08@gmail.com', 'OTP Verification');
                $mail->addAddress($email);

                $mail->isHTML(true);
                $mail->Subject = "Your verify code";
                $mail->Body = "<p>Dear user, </p> <h3>Your verification OTP code is $otp <br>";

                if (!$mail->send()) {
                    echo "<script>alert('Registration failed. Invalid email address.');</script>";
                } else {
                    echo "<script>
                            alert('Registered successfully! OTP sent to $email');
                            window.location.replace('verification.php');
                          </script>";
                }
            } else {
                echo "<script>alert('Something went wrong during registration. Please try again.');</script>";
            }
        }
    } else {
        echo "<script>alert('All fields are required.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Fonts from Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins&family=Press+Start+2P&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="login_register.css">
    <title>Snake</title>
    <link rel="icon" type="image/png" href="Assets/imgs/favicon-16x16.png">
</head>
<body>
    <img src="Assets/imgslogin/1.png" class="bg">
    <div class="FormContainer">
        <div class="col col-1">
            <div class="imagelayer">
                <img src="Assets/imgslogin/white-outline.png" class="form-image-main">
                <img src="Assets/imgslogin/dots.png" class="form-image dots">
                <img src="Assets/imgslogin/cloud.png" class="form-image cloud">
                <img src="Assets/imgslogin/coin.png" class="form-image coin">
                <img src="Assets/imgslogin/rocket.png" class="form-image rocket">
                <img src="Assets/imgslogin/spring.png" class="form-image spring">
                <img src="Assets/imgslogin/stars.png" class="form-image stars">
            </div>
            <p class="featured">
                Come and Play Our Game! <span>-Yeshua and Diane-</span>
            </p>
        </div>
        <div class="col col-2">
            <div class="btn-box">
                <button class="btn btn-1" id="login">
                    <a href="login.php">Sign In?</a>
                </button>
                <button class="btn btn-2" id="register">
                    <a href="register.php">Sign Up?</a>
                </button>
            </div>
            <!-- Register form container -->
            <div class="register-form">
                <div class="form-title">
                    <span>Create Account</span>
                </div>
                <div class="form-inputs">
                    <form method="post" id="signup" novalidate>
                        <div class="input-box">
                            <input type="text" class="input-field" name="email" placeholder="Email" required>
                        </div>
                        <div class="input-box">
                            <input type="text" class="input-field" name="name" placeholder="Username" required>
                        </div>
                        <div class="input-box">
                            <input type="password" class="input-field" name="password" placeholder="Password" required>
                        </div>
                        <div class="input-box">
                            <input type="password" class="input-field" name="confirm_password" placeholder="Confirm Password" required>
                        </div>
                        <div class="input-box">
                            <button class="input-submit" name="register"><span>Sign Up</span></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
