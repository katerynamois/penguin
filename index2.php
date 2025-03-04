<?php

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Memory game</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php if (isset($_SERVER['PHP_AUTH_USER'])): ?>
    <div class="admin">
        <a href="admin.php">Admin</a>
    </div>
<?php endif; ?>
<div class="container"></div>
<div class="title">Penguin</div>
<div class="moves"></div>
<div class="credits">
    <a href="https://github.com/madh-zealand/highscores-api" target="_blank">Highscores API Github</a>
</div>

<div class="game-board" id="gameBoard"></div>

<!-- Player name input form -->
<div id="player-name-container" style="display: none;">
    <label for="player-name">Enter your name:</label>
    <input type="text" id="player-name" placeholder="Enter your player name">
    <button id="submit-player-name">Submit</button>
</div>

<!-- Display player name & score (hidden initially) -->
<div id="player-info" style="display: none;">
    <h3>Player: <span data-player class="player"></span></h3>
    <p>Score: <span data-score class="score"></span></p>
</div>

<script>
    // Game setup
    const cardsArray = ['🐧', '🐧', '🐱', '🐱', '🐶', '🐶', '🦊', '🦊', '🐸', '🐸', '🦁', '🦁', '🐰', '🐰', '🐢', '🐢'];
    let shuffledCards = cardsArray.sort(() => 0.5 - Math.random());
    let gameBoard = document.getElementById('gameBoard');
    let flippedCards = [];
    let matchedPairs = 0;
    let moves = 0;

    shuffledCards.forEach((emoji, index) => {
        let card = document.createElement('div');
        card.classList.add('card', 'hidden');
        card.dataset.index = index;
        card.dataset.emoji = emoji;
        card.innerText = "";
        card.addEventListener('click', flipCard);
        gameBoard.appendChild(card);
    });

    // Moves display
    const movesElement = document.querySelector('.moves');
    movesElement.textContent = `Moves: ${moves}`;

    function flipCard(event) {
        let selectedCard = event.target;

        if (flippedCards.length < 2 && selectedCard.classList.contains('hidden')) {
            selectedCard.classList.remove('hidden');
            selectedCard.innerText = selectedCard.dataset.emoji;
            flippedCards.push(selectedCard);
        }

        if (flippedCards.length === 2) {
            moves++;
            movesElement.textContent = `Moves: ${moves}`;
            setTimeout(checkMatch, 800);
        }
    }

    function checkMatch() {
        if (flippedCards[0].dataset.emoji === flippedCards[1].dataset.emoji) {
            flippedCards = [];
            matchedPairs++;
            if (matchedPairs === cardsArray.length / 2) {
                setTimeout(() => {
                    alert(`Game Over! Moves: ${moves}`);
                    document.getElementById('player-name-container').style.display = 'block';
                }, 500);
            }
        } else {
            flippedCards.forEach(card => {
                card.classList.add('hidden');
                card.innerText = "";
            });
            flippedCards = [];
        }
    }

    function calculateHighscore(moves) {
        let score = 160;
        if (moves > 16) {
            score -= (moves - 16) * 5;
        }
        return Math.max(score, 0);
    }

    // Highscore Submission
    const playerElement = document.querySelector('[data-player]');
    const scoreElement = document.querySelector('[data-score]');
    const playerNameInput = document.getElementById('player-name');
    const submitPlayerNameButton = document.getElementById('submit-player-name');
    const playerInfo = document.getElementById('player-info');
    const playerNameContainer = document.getElementById('player-name-container');

    let player = 'Guest';

    submitPlayerNameButton.addEventListener('click', () => {
        player = playerNameInput.value.trim() || 'Guest';
        playerElement.textContent = player;

        const score = calculateHighscore(moves);
        scoreElement.textContent = score;

        // Hide input form & show player info
        playerNameContainer.style.display = 'none';
        playerInfo.style.display = 'block';

        // Automatically send the score
        fetch('submit-highscore.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ player: player, score: score })
        })
            .then(response => response.json())
            .then(data => {
                console.log("Highscore submitted successfully", data);
            })
            .catch(error => {
                console.error("Error submitting highscore", error);
            });
    });
</script>

</body>
</html>