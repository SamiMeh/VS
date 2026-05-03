<?php 
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: register.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="flip.css">
    <title>Flip Game</title>
</head>
<body>
    <div class="container">
        <div class="controls">
            <h2>Flip</h2>

            <label>Bet Amount</label>
            <input type="number" id="betAmount" value="1" min="0.01" step="0.01">

            <label>Choose Side</label>
            <select id="chooseSide">
                <option value="heads">HEADS</option>
                <option value="tails">TAILS</option>
            </select>

            <button id="betBtn">Bet</button>
            <p id="status">Choose side and click Bet</p>
        </div>

      
        <div class="play-area">
            <div class="coin-wrapper">
                <div class="coin" id="coin">?</div>
                <div class="coin-text" id="coinText">Ready to flip!</div>
            </div>
        </div>
    </div>
    <script src="Flip.js"></script>
    <script>
        // Pass login status to JavaScript
        document.body.dataset.loggedIn = 'true';
    </script>
</body>
</html>