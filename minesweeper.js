document.addEventListener("DOMContentLoaded", function () {
    const board = document.getElementById("game-board");
    const rows = 10;
    const cols = 10;

    // A játékadatok betöltése PHP-ból
    fetch("minesweeper.php")
        .then(response => response.json())
        .then(grid => {
            renderBoard(grid);
        });

    function renderBoard(grid) {
        board.style.gridTemplateColumns = `repeat(${cols}, 30px)`;
        board.innerHTML = "";

        for (let x = 0; x < rows; x++) {
            for (let y = 0; y < cols; y++) {
                const cell = document.createElement("div");
                cell.classList.add("cell", "hidden");
                cell.dataset.x = x;
                cell.dataset.y = y;

                // Cellakattintás
                cell.addEventListener("click", function () {
                    revealCell(cell, grid);
                });

                board.appendChild(cell);
            }
        }
    }

    function revealCell(cell, grid) {
        const x = parseInt(cell.dataset.x);
        const y = parseInt(cell.dataset.y);
        const value = grid[x][y];

        cell.classList.remove("hidden");

        if (value === -1) {
            cell.classList.add("mine");
            cell.textContent = "*";
            alert("Vesztettél!");
        } else if (value > 0) {
            cell.textContent = value;
        } else {
            cell.style.backgroundColor = "#fff";
        }
    }
});
