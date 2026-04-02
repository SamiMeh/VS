<?php 
session_start();
$is_logged_in = isset($_SESSION['user_id']);
$is_admin = $is_logged_in && isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DiceRoll</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header >

        <div>
        <img src="DiceRoll.png" alt="logo.png" id="logo.png" class="logo">
        </div>
        <div class="placeholder-div">
        <input type="text" placeholder="Kërko " id="placeholder" >
        </div>
            <nav class="navigationbar">
                        <a href="#Game-id"> Games</a>
                        <a href="#Help">Help</a>
            </nav>
        
        <div class="Login-div">
        <?php if ($is_logged_in): ?>
            <?php if ($is_admin): ?>
                <a href="admin.php" class="Admin-dashboard-link">Dashboard</a>
            <?php endif; ?>
            <button id="Logout-button" onclick="location.href='logout.php'">Logout</button>
        <?php else: ?>
            <button id="Login-button" onclick="location.href='login.php'">Login</button>
            <button id="Register-button" onclick="location.href='register.php'">Register</button>
        <?php endif; ?>
        </div>
    </header>
    <hr>
    <div class="slider" >
    <div class="slides">

        <div class="slide active" style="background-image: url(banner3.jpg);">
        </div>

        <div class="slide" style="background-image: url(banner1.jpg);">

        </div>

        <div class="slide" style="background-image: url(banne2.jpg);">
           
        </div>

    </div>

    <button class="arrow left" onclick="prevSlide()">❮</button>
    <button class="arrow right" onclick="nextSlide()">❯</button>

    <div class="dots">
        <span class="dot active" onclick="goToSlide(0)"></span>
        <span class="dot" onclick="goToSlide(1)"></span>
        <span class="dot" onclick="goToSlide(2)"></span>
    </div>
</div>
<br> 
<br>
<hr>
  <section id="Game-id" class="games-selection">
    
    <h2>Games</h2>

    <div class="game-grid">
     <a href="mines.php" class="games-card">
     <img src="main.avif" alt="mineimg">
    
        </a>


        <a href="dice.php" class="games-card">
            <img src="dice.avif" alt="Diceimg">
          
        </a>

        <a href="flip.php" class="games-card">
            <img src="flip.avif" alt="flipimg">
        
        </a>

        <a href="Primedice.php" class="games-card">
            <img src="Primedice.avif" alt="Primedice">
       
        </a>
    </div>


  </section>

<script src="slider.js"></script>
</body>
</html>
