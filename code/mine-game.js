const grid = document.getElementById("grid");
const betBtn = document.getElementById("betBtn");
const mineSelect = document.getElementById("mineCount");
const statusText = document.getElementById("status");
const betInput = document.getElementById("betAmount");
const betDisplay = document.getElementById("betDisplay");
let currentBet = 0;

const TOTAL_CELLS = 25;
let mines = [];
let gameActive = false;

function startGame() {
    currentBet = parseFloat(betInput.value);

    if (isNaN(currentBet) || currentBet <= 0) {
        statusText.textContent = "Enter a valid bet amount.";
        return;
    }

    betDisplay.textContent = currentBet.toFixed(2);
    
    grid.innerHTML = "";
    mines = [];
    gameActive = true;
    statusText.textContent = "Game started! Pick a tile.";

    const mineCount = parseInt(mineSelect.value);

    while (mines.length < mineCount) {
        let rand = Math.floor(Math.random() * TOTAL_CELLS);
        if (!mines.includes(rand)) mines.push(rand);
    }

    for (let i = 0; i < TOTAL_CELLS; i++) {
        const cell = document.createElement("div");
        cell.classList.add("cell");
        cell.dataset.index = i;
        cell.addEventListener("click", () => revealCell(cell));
        grid.appendChild(cell);
    }
}

function revealCell(cell) {
    if (!gameActive || cell.classList.contains("revealed")) return;

    const index = parseInt(cell.dataset.index);
    cell.classList.add("revealed");

    if (mines.includes(index)) {
        cell.textContent = "💣";
        cell.classList.add("mine");
        statusText.textContent = "You hit a mine! Game over.";
        revealAllMines();
        gameActive = false;
    } else {
        cell.textContent = "💎";
        cell.classList.add("gem");
    }
}

function revealAllMines() {
    document.querySelectorAll(".cell").forEach(cell => {
        const index = parseInt(cell.dataset.index);
        if (mines.includes(index)) {
            cell.textContent = "💣";
            cell.classList.add("mine");
        }
    });
}

betBtn.addEventListener("click", startGame);