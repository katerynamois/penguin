<!DOCTYPE html>
<html lang="da">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Memory Game</title>
    <link rel="stylesheet" href="style.css">
    <script src="script.js" defer></script>
    <style>
        * {
            font-family: Arial, sans-serif;
            text-align: center;
            margin: 0;
        }
        .game-board {
            display: grid;
            grid-template-columns: repeat(4, 80px);
            gap: 10px;
            justify-content: center;
            margin-bottom: 20px;
        }
        .card {
            width: 80px;
            height: 80px;
            background-color: #ddd;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2em;
            cursor: pointer;
            border-radius: 5px;
        }
        .hidden {
            background-color: #444;
            color: #444;
        }
        .container {
            display: flex;
            flex-direction: column;
            gap: 24px;
            align-items: center;
        }
        .player {
            font-size: 32px;
        }
        .score {
            font-size: 72px;
        }
        .send-button {
            background-image: linear-gradient(92.88deg, #75dad1 9.16%, #43b7cc 43.89%, #3fc5d7 64.72%);
            border-radius: 8px;
            border-style: none;
            color: #FFFFFF;
            cursor: pointer;
            font-size: 16px;
            height: 4rem;
            padding: 0 1.6rem;
            text-align: center;
            transition: all .5s;
        }
        .send-button:hover {
            box-shadow: rgba(80, 63, 205, 0.5) 0 1px 30px;
            transition-duration: .1s;
        }
    </style>
</head>
<body>
<div class="game-board" id="gameBoard"></div>
<div class="container">
    <div data-player class="player"></div>
    <div data-score class="score"></div>
    <button data-send-button class="send-button">Send</button>
</div>
<script>
    // Array of card emojis, each appearing twice to form pairs
    const cardsArray = ['🐧', '🐧', '🐱', '🐱', '🐶', '🐶', '🦊', '🦊', '🐸', '🐸', '🦁', '🦁', '🐰', '🐰', '🐢', '🐢'];

    // Shuffle the cards randomly
    let shuffledCards = cardsArray.sort(() => 0.5 - Math.random());
    let gameBoard = document.getElementById('gameBoard');
    let flippedCards = [];
    let matchedPairs = 0;
    let moves = 0;

    // Create card elements dynamically
    shuffledCards.forEach((emoji, index) => {
        let card = document.createElement('div');
        card.classList.add('card', 'hidden');
        card.dataset.index = index;
        card.dataset.emoji = emoji;
        card.innerText = "";
        card.addEventListener('click', flipCard);
        gameBoard.appendChild(card);
    });

    // Function to flip a card
    function flipCard(event) {
        let selectedCard = event.target;
        if (flippedCards.length < 2 && selectedCard.classList.contains('hidden')) {
            selectedCard.classList.remove('hidden');
            selectedCard.innerText = selectedCard.dataset.emoji;
            flippedCards.push(selectedCard);
        }
        if (flippedCards.length === 2) {
            moves++;
            setTimeout(checkMatch, 800);
        }
    }

    // Function to check if two flipped cards match
    function checkMatch() {
        if (flippedCards[0].dataset.emoji === flippedCards[1].dataset.emoji) {
            flippedCards = [];
            matchedPairs++;
            if (matchedPairs === cardsArray.length / 2) {
                setTimeout(() => alert(`Game Over! Moves: ${moves}`), 500);
            }
        } else {
            flippedCards.forEach(card => {
                card.classList.add('hidden');
                card.innerText = "";
            });
            flippedCards = [];
        }
    }

    // Function to generate a random pirate penguin name
    function generatePirateName() {
        const firstNames = ["Frosty", "Icy", "Snowbeard", "Captain Waddle", "Blizzard", "Chilly", "Arctic", "Flipper", "Glacier", "Stormy"];
        const lastNames = ["McIceberg", "Snowboots", "Krillchaser", "Deepfreezer", "Squawkbeard", "Fishmonger", "Icetooth", "Winterfeather", "Driftbeak", "Coldfin"];
        return `${firstNames[Math.floor(Math.random() * firstNames.length)]} ${lastNames[Math.floor(Math.random() * lastNames.length)]}`;
    }

    // Display random pirate name and random score
    document.querySelector('[data-player]').textContent = generatePirateName();
    document.querySelector('[data-score]').textContent = Math.round(Math.random() * 1000).toString();
</script>
</body>
</html>
