<?php
session_start();
require __DIR__ . '/vendor/autoload.php'; // Include Composer's autoload file

include('database.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['register'])) {
        $email = $_POST["email"];
        $password = $_POST["password"];
        $name = $_POST["name"]; 

        $check_query = mysqli_query($conn, "SELECT * FROM user WHERE email ='$email'");
        $rowCount = mysqli_num_rows($check_query);

        if (!empty($email) && !empty($password) && !empty($name)) {
            if ($rowCount > 0) {
                echo "<script>alert('User with that email already exists!');</script>";
            } else {
                $password_hash = password_hash($password, PASSWORD_BCRYPT);

                // Insert user with 'Pending' status
                $result = mysqli_query($conn, "INSERT INTO user (name, email, password, status_id) VALUES ('$name', '$email', '$password_hash', 1)");

                if ($result) {
                    $otp = rand(100000, 999999);
                    $_SESSION['otp'] = $otp;
                    $_SESSION['mail'] = $email;

                    $mail = new \PHPMailer\PHPMailer\PHPMailer();

                    $mail->isSMTP();
                    $mail->Host = 'smtp.gmail.com';
                    $mail->Port = 587;
                    $mail->SMTPAuth = true;
                    $mail->SMTPSecure = 'tls';

                    $mail->Username = "yeshuakrysler08@gmail.com";
                    $mail->Password = "dejo tqkj whmn edcu";
                    $mail->setFrom('yeshuakrysler08@gmail.com', 'OTP Verification');
                    $mail->addAddress($_POST["email"]);

                    $mail->isHTML(true);
                    $mail->Subject = "Your verify code";
                    $mail->Body = "<p>Dear user, </p> <h3>Your verification OTP code is $otp <br>";

                    if (!$mail->send()) {
                        echo "<script>alert('Register Failed, Invalid Email');</script>";
                    } else {
                        echo "<script>
                                alert('Registered Successfully, OTP sent to $email');
                                window.location.replace('verify.php');
                              </script>";
                    }
                }
            }
        }
    } elseif (isset($_POST['verify'])) {
        $otp = $_SESSION['otp'];
        $email = $_SESSION['mail'];
        $otp_code = $_POST['otp_code'];

        if ($otp != $otp_code) {
            echo "<script>alert('Invalid OTP code');</script>";
        } else {
            // Update user status to 'Active'
            mysqli_query($conn, "UPDATE user SET status_id = 2 WHERE email = '$email'");
            echo "<script>
                    alert('Verification completed. You may now sign in');
                    window.location.replace('login.php');
                  </script>";
        }
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
          
        <!-- Verify form container -->
        <div class="verify-form">
            <div class="form-title">
                <span>Verify Account</span>
            </div>
            <div class="form-inputs">
                <form method="post" id="verify" novalidate>
                    <div class="input-box">
                        <input type="text" class="input-field" name="otp_code" placeholder="Enter OTP" required>
                    </div>
                    <div class="input-box">
                        <button class="input-submit" name="verify"><span>Submit</span></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
