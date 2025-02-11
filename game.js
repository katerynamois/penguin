// Select canvas
const canvas = document.getElementById("gameCanvas");
const ctx = canvas.getContext("2d");

canvas.width = 400;
canvas.height = 400;

// Maze grid (1 = wall, 0 = path)
const maze = [
    [1,1,1,1,1,1,1,1,1,1],
    [1,0,0,0,1,0,0,0,0,1],
    [1,0,1,0,1,0,1,1,0,1],
    [1,0,1,0,0,0,0,1,0,1],
    [1,0,1,1,1,1,0,1,0,1],
    [1,0,0,0,0,1,0,0,0,1],
    [1,1,1,1,0,1,1,1,0,1],
    [1,0,0,0,0,0,0,1,0,1],
    [1,0,1,1,1,1,0,0,0,1],
    [1,1,1,1,1,1,1,1,1,1]
];

// Tile size
const tileSize = canvas.width / maze.length;

// Penguin character
const penguin = {
    x: 1,
    y: 1,
    size: tileSize * 0.8,
    color: "dark blue"
};

// Goal position
const goal = {
    x: 8,
    y: 8,
    color: "gold"
};

// Draw the maze
function drawMaze() {
    for (let row = 0; row < maze.length; row++) {
        for (let col = 0; col < maze[row].length; col++) {
            if (maze[row][col] === 1) {
                ctx.fillStyle = "black";
                ctx.fillRect(col * tileSize, row * tileSize, tileSize, tileSize);
            }
        }
    }
}

// Draw the penguin
function drawPenguin() {
    ctx.fillStyle = penguin.color;
    ctx.beginPath();
    ctx.arc(
        penguin.x * tileSize + tileSize / 2,
        penguin.y * tileSize + tileSize / 2,
        penguin.size / 2,
        0, Math.PI * 2
    );
    ctx.fill();
}

// Draw the goal
function drawGoal() {
    ctx.fillStyle = goal.color;
    ctx.fillRect(goal.x * tileSize + 5, goal.y * tileSize + 5, tileSize - 10, tileSize - 10);
}

// Handle movement
document.addEventListener("keydown", function(event) {
    let newX = penguin.x;
    let newY = penguin.y;

    if (event.key === "ArrowUp") newY--;
    if (event.key === "ArrowDown") newY++;
    if (event.key === "ArrowLeft") newX--;
    if (event.key === "ArrowRight") newX++;

    // Check for collisions
    if (maze[newY][newX] !== 1) {
        penguin.x = newX;
        penguin.y = newY;
    }

    // Check if reached goal
    if (penguin.x === goal.x && penguin.y === goal.y) {
        alert("🎉 You Win! The penguin made it home!");
        penguin.x = 1;
        penguin.y = 1;
    }

    updateGame();
});

// Update the game
function updateGame() {
    ctx.clearRect(0, 0, canvas.width, canvas.height);
    drawMaze();
    drawGoal();
    drawPenguin();
}

// Start the game
updateGame();
