//Create JS representation from the DOM
const foodSound = document.getElementById("AppleSound");
const moveSound = document.getElementById("MovementSound");
const start_pause = document.getElementById("Start-Pause-Sound");
const bgMusic = document.getElementById("bg-Music");
const snakeItLg = document.getElementById("ItLg");
const board = document.getElementById("GameBoard");
const score = document.getElementById("GameScore");
const highScoreText = document.getElementById("HighScore");
const gameOverSound = document.getElementById("GameOverSound");
document.addEventListener("keydown", handleKeyPress);

//Game Variables
let snake = [{ x: 16, y: 11 }];
let food = generateFood();
let highScore = 0;
let direction = "right";
let gameInterval;
let gameSpeedDelay = 200;
let gameRunning = false;
let gamePaused = false;
let velocityX = 1,
  velocityY = 0;

//Draw game map, snake, food
function draw() {
  board.innerHTML = "";
  drawSnake();
  drawFood();
  updateScore();
}

//Draw Snake
function drawSnake() {
  if (gameRunning) {
    snake.forEach((segment) => {
      const snakeElement = createGameElement("div", "snake");
      setPosition(snakeElement, segment);
      board.appendChild(snakeElement);
    });
  }
}

//Create a snake or food cube/div
function createGameElement(tag, className) {
  const element = document.createElement(tag);
  element.className = className;
  return element;
}

//Set position of the snake or the food
function setPosition(element, position) {
  element.style.gridColumnStart = position.x;
  element.style.gridRowStart = position.y;
}

//Draw food function
function drawFood() {
  if (gameRunning) {
    const foodElement = createGameElement("div", "food");
    setPosition(foodElement, food);
    board.appendChild(foodElement);
  }
}

//Generate food
function generateFood() {
  let newFoodPosition;
  let isValidPosition = false;

  while (!isValidPosition) {
    newFoodPosition = {
      x: Math.floor(Math.random() * 31) + 1,
      y: Math.floor(Math.random() * 20) + 1,
    };

    isValidPosition = !snake.some(
      (segment) =>
        segment.x === newFoodPosition.x && segment.y === newFoodPosition.y
    );
  }

  return newFoodPosition;
}

//Moving the snake
function move() {
  const head = { ...snake[0] };
  head.x += velocityX;
  head.y += velocityY;

  // Wrap the snake's position when it crosses the border
  if (head.x < 1) {
    head.x = 31;
  } else if (head.x > 31) {
    head.x = 1;
  }
  if (head.y < 1) {
    head.y = 20;
  } else if (head.y > 20) {
    head.y = 1;
  }

  snake.unshift(head);

  if (head.x === food.x && head.y === food.y) {
    foodSound.play();
    increaseSpeed();
    food = generateFood();
    clearInterval(gameInterval);
    gameInterval = setInterval(() => {
      move();
      checkCollision();
      draw();
    }, gameSpeedDelay);
  } else {
    snake.pop();
  }
}

//Snake speed function
function increaseSpeed() {
  if (gameSpeedDelay > 150) {
    gameSpeedDelay -= 5;
  } else if (gameSpeedDelay > 125) {
    gameSpeedDelay -= 3;
  } else if (gameSpeedDelay > 100) {
    gameSpeedDelay -= 2;
  } else if (gameSpeedDelay > 75) {
    gameSpeedDelay -= 1;
  }
}

//Collision function
function checkCollision() {
  const head = snake[0];

  for (let i = 1; i < snake.length; i++) {
    if (head.x === snake[i].x && head.y === snake[i].y) {
      resetGame();
    }
  }
}

//Score function
function updateScore() {
  const GameScore = snake.length - 1;
  score.textContent = GameScore.toString().padStart(3, "0");
}

//HighScore function
function updateHighScore() {
  const GameScore = snake.length - 1;
  if (GameScore > highScore) {
    highScore = GameScore;
    highScoreText.textContent = highScore.toString().padStart(3, "0");
  }
}

//Reset game function
function resetGame() {
  updateHighScore();
  stopGame();
  snake = [{ x: 16, y: 11 }];
  food = generateFood();
  direction = "right";
  gameSpeedDelay = 200;
  updateScore();
  gameOverSound.play();
}

//Start Game function
function startGame() {
  gameRunning = true;
  gamePaused = false;
  snakeItLg.style.display = "none";
  start_pause.play();
  bgMusic.volume = 0.1;
  gameInterval = setInterval(() => {
    move();
    checkCollision();
    draw();
  }, gameSpeedDelay);
}

//Stop Game function
function stopGame() {
  clearInterval(gameInterval);
  gameRunning = false;
  snakeItLg.style.display = "block";
  bgMusic.volume = 1;
}

//Pause Game function
function pauseGame() {
  if (gameRunning && !gamePaused) {
    clearInterval(gameInterval);
    gamePaused = true;
    snakeItLg.style.display = "block"; // Display paused screen
    bgMusic.volume = 0.5; // Reduce music volume while paused
  } else if (gamePaused) {
    gamePaused = false;
    snakeItLg.style.display = "none"; // Hide paused screen
    bgMusic.volume = 0.1; // Restore music volume
    gameInterval = setInterval(() => {
      move();
      checkCollision();
      draw();
    }, gameSpeedDelay);
  }
}

//Keypress event listener
function handleKeyPress(event) {
  if (event.code === "Space") {
    if (gameRunning) {
      pauseGame();
    } else {
      startGame();
    }
  } else {
    switch (event.key) {
      case "ArrowUp":
        if (velocityY === 0) {
          moveSound.play();
          direction = "up";
          velocityX = 0;
          velocityY = -1;
        }
        break;
      case "ArrowDown":
        if (velocityY === 0) {
          moveSound.play();
          direction = "down";
          velocityX = 0;
          velocityY = 1;
        }
        break;
      case "ArrowLeft":
        if (velocityX === 0) {
          moveSound.play();
          direction = "left";
          velocityX = -1;
          velocityY = 0;
        }
        break;
      case "ArrowRight":
        if (velocityX === 0) {
          moveSound.play();
          direction = "right";
          velocityX = 1;
          velocityY = 0;
        }
        break;
    }
  }
}
