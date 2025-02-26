// Array of card emojis, each appearing twice to form pairs
const cardsArray = ['🐧', '🐧', '🐱', '🐱', '🐶', '🐶', '🦊', '🦊', '🐸', '🐸', '🦁', '🦁', '🐰', '🐰', '🐢', '🐢'];

// Shuffle the cards randomly to ensure different order each game
let shuffledCards = cardsArray.sort(() => 0.5 - Math.random());

// Get the game board element where the cards will be placed
let gameBoard = document.getElementById('gameBoard');

// Array to store flipped cards for matching
let flippedCards = [];

// Counter to track matched pairs
let matchedPairs = 0;

// Counter to track the number of moves made
let moves = 0;

// Create card elements dynamically and add them to the game board
shuffledCards.forEach((emoji, index) => {
    let card = document.createElement('div');
    card.classList.add('card', 'hidden'); // Initially hidden
    card.dataset.index = index; // Store the index for reference
    card.dataset.emoji = emoji; // Store the emoji value for matching
    card.innerText = ""; // Card starts blank
    card.addEventListener('click', flipCard); // Add click event listener to flip card
    gameBoard.appendChild(card); // Add the card to the game board
});

// Function to flip a card when clicked
function flipCard(event) {
    let selectedCard = event.target;

    // Allow only two cards to be flipped at a time and ensure it's a hidden card
    if (flippedCards.length < 2 && selectedCard.classList.contains('hidden')) {
        selectedCard.classList.remove('hidden'); // Reveal the card
        selectedCard.innerText = selectedCard.dataset.emoji; // Display emoji
        flippedCards.push(selectedCard); // Add to flipped cards list
    }

    // If two cards are flipped, check for a match
    if (flippedCards.length === 2) {
        moves++; // Increment move counter
        setTimeout(checkMatch, 800); // Delay before checking the match
    }
}

// Function to check if flipped cards match
function checkMatch() {
    if (flippedCards[0].dataset.emoji === flippedCards[1].dataset.emoji) {
        // Cards match, so clear flippedCards array
        flippedCards = [];
        matchedPairs++; // Increase matched pairs count

        // If all pairs are matched, display high score
        if (matchedPairs === cardsArray.length / 2) {
            setTimeout(() => showHighscore(moves), 500);
        }
    } else {
        // Cards do not match, flip them back after delay
        flippedCards.forEach(card => {
            card.classList.add('hidden'); // Hide again
            card.innerText = ""; // Remove emoji
        });
        flippedCards = []; // Reset flipped cards array
    }
}

// Function to display the high score (number of moves)
function showHighscore(score) {
    document.getElementById("score").textContent = score;
    document.getElementById("highscoreContainer").style.display = "block";
}

// Enable submit button only when the name input is not empty
document.getElementById("name").addEventListener("input", function() {
    document.getElementById("submit").disabled = !this.value.trim();
});
const playerElement = document.querySelector('[data-player]');
const scoreElement = document.querySelector('[data-score]');
const sendButton = document.querySelector('[data-send-button]');
const responsePreviewElement = document.querySelector('[data-response-preview]');

const player = generatePirateName();
const score = Math.round(Math.random() * 1000);

playerElement.textContent = player;
scoreElement.textContent = score.toString();

function generatePirateName() {
    const firstNames = ["Frosty", "Icy", "Snowbeard", "Captain Waddle", "Blizzard", "Chilly", "Arctic", "Flipper", "Glacier", "Stormy"];
    const lastNames = ["McIceberg", "Snowboots", "Krillchaser", "Deepfreezer", "Squawkbeard", "Fishmonger", "Icetooth", "Winterfeather", "Driftbeak", "Coldfin"];

    // Pick a random first and last name
    const randomFirstName = firstNames[Math.floor(Math.random() * firstNames.length)];
    const randomLastName = lastNames[Math.floor(Math.random() * lastNames.length)];

    return `${randomFirstName} ${randomLastName}`;
}