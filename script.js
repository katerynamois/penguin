const cardsArray = ['🐧', '🐧', '🐱', '🐱', '🐶', '🐶', '🦊', '🦊', '🐸', '🐸', '🦁', '🦁', '🐰', '🐰', '🐢', '🐢'];
let shuffledCards = cardsArray.sort(() => 0.5 - Math.random());
let gameBoard = document.getElementById('gameBoard');
let flippedCards = [];

shuffledCards.forEach((emoji, index) => {
    let card = document.createElement('div');
    card.classList.add('card', 'hidden');
    card.dataset.index = index;
    card.dataset.emoji = emoji;
    card.innerText = emoji;
    card.addEventListener('click', flipCard);
    gameBoard.appendChild(card);
});

function flipCard(event) {
    let selectedCard = event.target;
    if (flippedCards.length < 2 && selectedCard.classList.contains('hidden')) {
        selectedCard.classList.remove('hidden');
        flippedCards.push(selectedCard);
    }
    if (flippedCards.length === 2) {
        setTimeout(checkMatch, 800);
    }
}

function checkMatch() {
    if (flippedCards[0].dataset.emoji === flippedCards[1].dataset.emoji) {
        flippedCards = [];
    } else {
        flippedCards.forEach(card => card.classList.add('hidden'));
        flippedCards = [];
    }
}