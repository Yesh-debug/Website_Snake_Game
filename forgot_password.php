<?php
session_start();
if (isset($_POST["recover"])) {
    include('database.php');
    require __DIR__ . '/vendor/autoload.php';

    $email = $_POST["email"];

    $sql = mysqli_query($conn, "SELECT * FROM User WHERE email='$email'");
    $query = mysqli_num_rows($sql);
    $fetch = mysqli_fetch_assoc($sql);

    if (mysqli_num_rows($sql) <= 0) {
        ?>
        <script>
            alert("<?php echo 'Sorry, that email does not exist.'; ?>");
        </script>
        <?php
    } else if ($fetch["status_id"] == 1) {
        ?>
        <script>
            alert("Sorry, your account must be verified first before you can recover your password!");
            window.location.replace("login.php");
        </script>
        <?php
    } else {
        $token = bin2hex(random_bytes(50));
        $_SESSION['token'] = $token;
        $_SESSION['email'] = $email;

        $mail = new \PHPMailer\PHPMailer\PHPMailer();
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->Port = 587;
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = 'tls';
        $mail->Username = 'yeshuakrysler08@gmail.com';
        $mail->Password = 'dejo tqkj whmn edcu';
        $mail->setFrom('yeshuakrysler08@gmail.com', 'Password Reset');
        $mail->addAddress($email);
        $mail->isHTML(true);
        $mail->Subject = "Recover your password";
        $mail->Body = "<b>Dear User</b>
        <h3>We received a request to reset your password.</h3>
        <p>Kindly click the below link to reset your password</p>
        http://localhost/ARCADE-SNAKE/reset_password.php";

        if (!$mail->send()) {
            ?>
            <script>
                alert("<?php echo 'Invalid Email'; ?>");
            </script>
            <?php
        } else {
            ?>
            <script>
                window.location.replace("success_message.php");
            </script>
            <?php
        }
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
    <script src="login.js" defer></script>
    <title>Snake</title>
    <link rel="icon" type="img" href="Assets/imgs/favicon-16x16.png" />
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
            <!-- Forgot Password -->
            <div class="forgot_password-form">
                <div class="form-title">
                    <span>Forgot Password</span>
                </div>
                <div class="instruction"><p>Please enter your email so we can send you a code</p></div>
                <div class="form-inputs">
                    <form action="" method="POST">
                        <div class="input-box">
                            <input type="text" class="input-field" name="email" placeholder="Email" required />
                        </div>
                        <div class="input-box">
                            <button type="submit" class="input-submit" name="recover">
                                <span>Enter</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
