// 1. Fungsi Pencarian Real-time untuk Menu Game di Landing Page
function filterGames() {
    let input = document.getElementById('searchGame').value.toLowerCase();
    let cards = document.querySelectorAll('.game-card');

    cards.forEach(card => {
        let gameName = card.querySelector('h3').innerText.toLowerCase();
        if (gameName.includes(input)) {
            card.style.display = "block";
        } else {
            card.style.display = "none";
        }
    });
}

// 2. Alert Otomatis Hilang (Jika menggunakan Flash Message di masa depan)
document.addEventListener("DOMContentLoaded", function() {
    const alerts = document.querySelectorAll('.alert-box');
    alerts.forEach(alert => {
        setTimeout(() => {
            alert.style.opacity = '0';
            setTimeout(() => alert.remove(), 500);
        }, 3000);
    });
});
