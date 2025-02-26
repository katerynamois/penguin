<!DOCTYPE html>
<html lang="da">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Memory Game</title>
    <link rel="stylesheet" href="style.css">
    <script src="script.js" defer></script>
</head>
<body>
<div class="game-board" id="gameBoard"></div>

<div class="container" id="highscoreContainer">
    <h2>Ny Highscore!</h2>
    <p>Score: <span id="score">0</span></p>
    <input type="text" id="name" placeholder="Indtast dit navn">
    <button id="submit" disabled>Gem Highscore</button>
</div>
</body>
</html>
