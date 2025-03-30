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
        <!--Login form container-->
        <div class="profile-form">
          <div class="form-title">
            <span>Sign In</span>
          </div>
          <div class="form-inputs">
          <form action="#" method="POST" name="login">
              <div class="input-box">
                <input
                  type="text"
                  class="input-field"
                  name="name"
                  placeholder="Username"
                  id="username"
                  required
                />
              </div>
              <div class="input-box">
                <input
                  type="text"
                  class="input-field"
                  name="confirm_username"
                  placeholder="Confirm Username"
                  id="confirm_username"
                  required
                />
              </div>
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