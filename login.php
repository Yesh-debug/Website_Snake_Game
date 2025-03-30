<?php
session_start();
include('database.php');

if (isset($_POST["login"])) {
    $email = mysqli_real_escape_string($conn, trim($_POST['email']));
    $password = trim($_POST['password']);

    $sql = mysqli_query($conn, "SELECT * FROM user WHERE email = '$email'");
    $count = mysqli_num_rows($sql);

    if ($count > 0) {
        $fetch = mysqli_fetch_assoc($sql);
        $hashpassword = $fetch["password"];

        if ($fetch["status_id"] == 1) {
            ?>
            <script>
                alert("Please verify your email account before logging in.");
            </script>
            <?php
        } else if (password_verify($password, $hashpassword)) {
            // Start the session and store user information
            $_SESSION["user_id"] = $fetch["id"];
            $_SESSION["user_name"] = $fetch["name"];
            ?>
            <script>
                alert("Login successful.");
                window.location.replace("game.php");
            </script>
            <?php
        } else {
            ?>
            <script>
                alert("Email or Password invalid. Please try again.");
            </script>
            <?php
        }
    } else {
        ?>
        <script>
            alert("Email or Password invalid. Please try again.");
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
    <!--Fonts from google fonts-->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Poppins&family=Press+Start+2P&display=swap"
      rel="stylesheet"
    />
    <link rel="stylesheet" href="login_register.css" />
    <title>Snake</title>
    <link rel="icon" type="img" href="Assets/imgs/favicon-16x16.png" />
  </head>
  <body>
    <img src="Assets/imgslogin/1.png" class="bg" />
    <div class="FormContainer">
      <div class="col col-1">
        <div class="imagelayer">
          <img
            src="Assets/imgslogin/white-outline.png"
            class="form-image-main"
          />
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
        <div class="btn-box">
          <button class="btn btn-1" id="login">
            <a href="login.php">Sign In?</a>
          </button>
          <button class="btn btn-2" id="register">
            <a href="register.php">Sign Up?</a>
          </button>
        </div>
        <!--Login form container-->
        <div class="login-form">
          <div class="form-title">
            <span>Sign In</span>
          </div>
          <div class="form-inputs">
          <form action="#" method="POST" name="login">
              <div class="input-box">
                <input
                  type="text"
                  class="input-field"
                  name="email"
                  placeholder="Email"
                  id="email_address"
                  required
                />
              </div>
              <div class="input-box">
                <input
                  type="password"
                  class="input-field"
                  name="password"
                  placeholder="Password"
                  id="password"
                  required
                />
              </div>
              <div class="forgot_pw"><a href="forgot_password.php">Forgot Password?</a></div>
              <div class="input-box">
                <button type="submit" class="input-submit" name="login">
                  <span>Sign In</span>
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
    const password = document.getElementById('password');

    toggle.addEventListener('click', function(){
        if(password.type === "password"){
            password.type = 'text';
        }else{
            password.type = 'password';
        }
        this.classList.toggle('bi-eye');
    });
</script>