
        document.addEventListener("DOMContentLoaded", () => {
            const betAmount = document.getElementById('betAmount');
            const betBtn = document.getElementById("betBtn");
            const status = document.getElementById('status');
            const coin = document.getElementById('coin');
            const coinText = document.getElementById('coinText');
            const chooseSide = document.getElementById('chooseSide');

            betBtn.addEventListener("click", () => {
                const bet = parseFloat(betAmount.value);
                
                if (bet <= 0 || isNaN(bet)) {
                    status.textContent = 'Enter a valid bet amount';
                    return;
                }

                const playerChoice = chooseSide.value;
                const isHeads = Math.random() < 0.5;
                const result = isHeads ? "heads" : "tails";

                betBtn.disabled = true;
                status.textContent = "Flipping...";

                setTimeout(() => {
                    if (result === "heads") {
                        coin.textContent = "H";
                        coin.style.background = "linear-gradient(145deg, #ffd700, #ffed4e)";
                        coinText.textContent = "HEADS";
                    } else {
                        coin.textContent = "T";
                        coin.style.background = "linear-gradient(145deg, #c0c0c0, #e8e8e8)";
                        coinText.textContent = "TAILS";
                    }

                    if (playerChoice === result) {
                        status.textContent = "YOU WIN! ";
                        status.style.color = "#00ff00";
                    } else {
                        status.textContent =  "YOU LOSE!"; 
                        status.style.color = "#ff0000";
                    }

                    betBtn.disabled = false;
                }, 500);
            });
        });