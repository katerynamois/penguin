<?php

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Highscore API Connection</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="title">
    Highscore API Connection
</div>
<div class="moves"></div>
<?php if (isset($_SERVER['PHP_AUTH_USER'])): ?>
    <div class="admin">
        <a href="admin.php">Admin</a>
    </div>
<?php endif; ?>
<div class="credits">
    <a href="https://github.com/madh-zealand/highscores-api" target="_blank">Highscores API Github</a>
</div>
<div class="game-board" id="gameBoard"></div>
<div class="container">
    <div data-player class="player"></div>
    <div data-score class="score"></div>
    <button data-send-button class="send-button">Send</button>
    <pre data-response-preview class="response-preview"></pre>
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


    const playerElement = document.querySelector('[data-player]');
    const scoreElement = document.querySelector('[data-score]');
    const sendButton = document.querySelector('[data-send-button]');
    const responsePreviewElement = document.querySelector('[data-response-preview]');

    const player = generatePirateName();
    const score = Math.round(Math.random() * 1000);

    playerElement.textContent = player;
    scoreElement.textContent = score.toString();


    function generatePirateName() {
        const firstNames = ["Blackbeard", "Salty", "One-Eyed", "Mad", "Captain", "Peg-Leg", "Red", "Stormy", "Jolly", "Barnacle"];
        const lastNames = ["McScurvy", "Silverhook", "Rumbelly", "Seadog", "Plankwalker", "Bones", "Squidbeard", "Driftwood", "Sharkbait", "Bootstraps"];

        const randomFirstName = firstNames[Math.floor(Math.random() * firstNames.length)];
        const randomLastName = lastNames[Math.floor(Math.random() * lastNames.length)];

        return `${randomFirstName} ${randomLastName}`;
    }

    sendButton.addEventListener('click', () => {
        fetch(
            'submit-highscore.php',
            {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    player: player,
                    score: score,
                }),
            }
        )
            .then(function (response) {
                return response.json();
            })
            .then(function (data) {
                console.log(data);
                responsePreviewElement.textContent = JSON.stringify(data, null, 2);
            })
            .catch(function (error){
                console.error(error);
                responsePreviewElement.textContent = JSON.stringify(error, null, 2);
            });
    });
</script>
</body>
</html>
