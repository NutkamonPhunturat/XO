<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Pixelify+Sans&display=swap">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel='stylesheet' href="CSS/SigninSignup.css">

    <style>
        body {
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            height: 100vh;
            margin: 0;
        }
        
        #board {
            display: grid;
            grid-template-columns: repeat(3, 100px);
            grid-gap: 0;
            border-collapse: collapse;
        }

        @keyframes glow {
            0% {
                box-shadow: 0 0 5px #EA0789;
            }
            50% {
                box-shadow: 0 0 20px #EA0789, 0 0 30px #EA0789;
            }
            100% {
                box-shadow: 0 0 5px #EA0789;
            }
        }

        /* Apply the animation to the grid cells */
        .cell {
            width: 100px;
            height: 100px;
            font-size: 24px;
            text-align: center;
            line-height: 100px;
            border: 1px solid #EA0789;
            cursor: pointer;
            animation: glow 1s infinite; /* Adjust the duration and other properties as needed */
        }

        .cell:not(:last-child) {
            border-right: 1px solid #EA0789; /* Inner right border for all cells except the last in a row */
        }

        .cell:not(:nth-child(3n)) {
            border-bottom: 1px solid #EA0789; /* Inner bottom border for all cells except the last in a column */
        }

        .X {
            font-size: 64px;
            color: #A0EEF1; /* Set the color for X */
            text-shadow: 0 0 10px rgba(160, 238, 241, 0.8)
        }

        .O {
            font-size: 64px;
            color: #FF9B9D; /* Set the color for O */
            text-shadow: 0 0 10px rgba(255, 155, 257, 0.8)
        }

        .cell:not(:last-child) {
            border-right: 1px solid #EA0789; /* Inner right border for all cells except the last in a row */
        }

        .cell:not(:nth-child(3n)) {
            border-bottom: 1px solid #EA0789; /* Inner bottom border for all cells except the last in a column */
        }

        #turn {
            margin-top: 20px;
            font-size: 20px;
        }
        #score {
            margin-top: 20px;
            font-size: 20px;
        }
        #resetButton {
            margin-top: 20px;
            padding: 10px;
            font-size: 16px;
            cursor: pointer;
        }
    </style>
    <title> XO | Game </title>
</head>
<body>

<?php
session_start();
?>

<div style='font-size: 22px; color: #F6D100' class="pixel" id="turn">TEAM X'S TURN!</div> <br>
<div id="board"></div>

<div class="container">
    <div class='row align-items-center justify-content-center mt-3'>
        <div class='col-md-2 text-center team-x-container'
             style='background-color: #1A1F44; border: 2px solid #4F659C; border-radius: 200px;'>
            <div style="color: white; text-shadow: 0 0 10px rgba(255, 255, 255, 0.8)" class="team-x-score pixel"> TEAM X
                : 0
            </div>
        </div>
    </div>
</div>

<div class="container">
    <div class='row align-items-center justify-content-center mt-3'>
        <div class='col-md-2 text-center team-o-container'
             style='background-color: #1A1F44; border: 2px solid #4F659C; border-radius: 200px;'>
            <div style="color: white; text-shadow: 0 0 10px rgba(255, 255, 255, 0.8)" class="team-o-score pixel"> TEAM O : 0
            </div>
        </div>
    </div>
</div>

<br>

<button class="btn btn-primary pixel" style="font-size: 32px;" id="resetButton"> NEW GAME </button>

<!-- Winner Modal -->
<div class="modal" tabindex="-1" role="dialog" id="winnerModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-body" id="winnerMessage"></div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const board = document.getElementById('board');
        const turnDisplay = document.getElementById('turn');
        const resetButton = document.getElementById('resetButton');
        const winnerModal = document.getElementById('winnerModal');
        const winnerMessage = document.getElementById('winnerMessage');
        let currentPlayer = 'X';
        let scoreX = 0;
        let scoreO = 0;

        // Create the game board
        for (let i = 0; i < 3; i++) {
            for (let j = 0; j < 3; j++) {
                const cell = document.createElement('div');
                cell.classList.add('cell');
                cell.dataset.row = i;
                cell.dataset.col = j;
                cell.addEventListener('click', handleCellClick);
                board.appendChild(cell);
            }
        }

        // Handle cell click
        function handleCellClick(event) {
            const cell = event.target;

            // Check if the cell is empty and the game is not over
            if (cell.textContent === '' && !checkGameOver()) {
                cell.textContent = currentPlayer;
                cell.classList.add(currentPlayer); // Add class for styling

                // Check for a win or draw
                if (checkWin()) {
                    handleGameResult(currentPlayer);
                } else if (checkTie()) {
                    handleGameResult('Tie');
                } else {
                    // Switch to the next player
                    currentPlayer = currentPlayer === 'X' ? 'O' : 'X';
                    updateTurnDisplay();

                    // If the current player is the bot (O), make a random move after a short delay
                    if (currentPlayer === 'O') {
                        setTimeout(makeBotMove, 500);
                    }
                }
            }
        }


        // Make a random move for the bot
        function makeBotMove() {
            const emptyCells = document.querySelectorAll('.cell:empty');
            if (emptyCells.length > 0) {
                const randomIndex = Math.floor(Math.random() * emptyCells.length);
                const botCell = emptyCells[randomIndex];
                botCell.textContent = 'O';
                botCell.classList.add('O');
                if (checkWin()) {
                    handleGameResult('O');
                } else if (checkTie()) {
                    handleGameResult('Tie');
                } else {
                    currentPlayer = 'X';
                    updateTurnDisplay();
                }
            }
        }

        // Update the turn display
        function updateTurnDisplay() {
            turnDisplay.textContent = `TEAM ${currentPlayer}'S TURN!`;
        }

        // Check for a win
        function checkWin() {
            const cells = document.querySelectorAll('.cell');

            // Check rows
            for (let i = 0; i < 3; i++) {
                if (
                    cells[i * 3].textContent !== '' &&
                    cells[i * 3].textContent === cells[i * 3 + 1].textContent &&
                    cells[i * 3].textContent === cells[i * 3 + 2].textContent
                ) {
                    return true;
                }
            }

            // Check columns
            for (let i = 0; i < 3; i++) {
                if (
                    cells[i].textContent !== '' &&
                    cells[i].textContent === cells[i + 3].textContent &&
                    cells[i].textContent === cells[i + 6].textContent
                ) {
                    return true;
                }
            }

            // Check diagonals
            if (
                cells[0].textContent !== '' &&
                cells[0].textContent === cells[4].textContent &&
                cells[0].textContent === cells[8].textContent
            ) {
                return true;
            }

            if (
                cells[2].textContent !== '' &&
                cells[2].textContent === cells[4].textContent &&
                cells[2].textContent === cells[6].textContent
            ) {
                return true;
            }

            return false;
        }

        // Check for a draw
        function checkTie() {
            const cells = document.querySelectorAll('.cell');
            for (const cell of cells) {
                if (cell.textContent === '') {
                    return false; // There's still an empty cell, so the game is not a tie
                }
            }
            return true; // All cells are filled, it's a tie
        }

        // Check if the game is over (win or draw)
        function checkGameOver() {
            return checkWin() || checkTie();
        }

        // Handle the game result
        function handleGameResult(winner) {
            if (winner === 'X') {
                scoreX++;
            } else if (winner === 'O') {
                scoreO++;
            }
            
            // Update session variables
            sessionStorage.setItem('winner', winner);
            sessionStorage.setItem('scoreX', scoreX);
            sessionStorage.setItem('scoreO', scoreO);

            // Redirect to GameResult.php
            location.href = 'GameAIResult.php';
        }

        // Show the winner modal
        function showWinnerModal(message) {
            winnerMessage.textContent = message;
            $(winnerModal).modal('show');
        }

        // Reset the game
        function resetGame() {
            const cells = document.querySelectorAll('.cell');
            for (const cell of cells) {
                cell.textContent = '';
                cell.classList.remove('X', 'O');
            }
            currentPlayer = 'X';
            updateTurnDisplay();
        }

        // Event listener for the reset button
        resetButton.addEventListener('click', () => {
            resetGame();
        });
    });
</script>
<!-- Bootstrap JS and jQuery -->
<script src="https://code.jquery.com/jquery-3.6.2.slim.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
        crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-lZ8iO46FDL2gir4Kf5cHDo5R9nMpK8d3bzrMvH85Ck5I7Jk4tQqj3VCp3ArmKpF1"
        crossorigin="anonymous"></script>
</body>

</html>
