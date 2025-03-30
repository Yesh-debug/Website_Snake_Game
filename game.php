<?php
session_start();

if (isset($_SESSION["user_id"])) {
    $mysqli = require __DIR__ . "/database.php";

    $stmt = $mysqli->prepare("SELECT * FROM user WHERE id = ?");
    $stmt->bind_param("i", $_SESSION["user_id"]);
    $stmt->execute();

    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    $stmt->close();
}

// Debugging
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
    <link rel="stylesheet" href="game.css" />
    <script defer src="game.js"></script>
    <title>Snake</title>
    <link rel="icon" type="img" href="Assets/imgs/favicon-16x16.png" />
  </head>
  <body>
    <h1 class="title">SNAKE</h1>
    <div class="nav_bar">
  <?php if (isset($user)): ?>
    <div class="user_info" id="logout">
      <p><a href="about_us.php" class="about_us">About Us</a></p>
      <p class="user_name"><?= htmlspecialchars($user["name"]) ?></p>
      <p><a href="logout.php" class="logout_link">Log out</a></p>
    </div>
  <?php endif; ?>
</div>
</div>
    <span class="Score GameScore" id="GameScore">000</span>
    <span class="Score HighScore" id="HighScore">000</span>
    <div id="GameBoard"></div>
    <div class="ItLg" id="ItLg">
      <h3 class="Instruction" id="Instruction">
        Press Space key to start/pause the game
      </h3>
      <img
        src="Assets/imgs/snake-game-ai-gen.png"
        alt="Snake-Logo"
        class="lg"
      />
    </div>
    <img src="Assets/imgs/machine.png" alt="Arcade-Machine" class="bg" />
    <div class="Vignett"></div>
    <audio src="Assets/snds/sounds_apple.mp3" id="AppleSound"></audio>
    <audio src="Assets/snds/sounds_lose.mp3" id="GameOverSound"></audio>
    <audio src="Assets/snds/snakeMovementSound.mp4" id="MovementSound"></audio>
    <audio
      src="Assets/snds/game-countdown-62-199828.mp3"
      id="Resume-Sound"
    ></audio>
    <audio src="Assets/snds/StartPause.mp4" id="Start-Pause-Sound"></audio>
    <audio
      controls
      autoplay
      loop
      hidden
      src="Assets/snds/very-lush-and-swag-loop-74140.mp3"
      id="bg-Music"
    ></audio>
    <img src="Assets/imgs/2.jpg" class="bg-blue" />
  </body>
 
</html>
