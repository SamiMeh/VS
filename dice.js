const slider = document.getElementById("slider");
const multiplierEl = document.getElementById("multiplier");
const rollOverEl = document.getElementById("rollOver");
const winChanceEl = document.getElementById("winChance");
const rollBtn = document.getElementById("rollBtn");
const resultEl = document.getElementById("result");
const betInput = document.getElementById("betAmount");


function updateOdds() {
    const rollOver = parseInt(slider.value);
    const winChance = 100 - rollOver;
    const multiplier = (100 / winChance) * HOUSE_EDGE;

    rollOverEl.textContent = rollOver;
    winChanceEl.textContent = winChance.toFixed(2);
    multiplierEl.textContent = multiplier.toFixed(2);
}

slider.addEventListener("input", updateOdds);

rollBtn.addEventListener("click", () => {
    const bet = parseFloat(betInput.value);
    if (bet <= 0 || isNaN(bet)) return;

    const roll = Math.random() * 100;
    const rollOver = parseInt(slider.value);
    const multiplier = parseFloat(multiplierEl.textContent);

    if (roll > rollOver) {
        const win = bet * multiplier;
        resultEl.textContent = `🎉 Win! Rolled ${roll.toFixed(2)} → +${win.toFixed(2)}`;
    } else {
        resultEl.textContent = `💥 Lost! Rolled ${roll.toFixed(2)}`;
    }
});


updateOdds();
