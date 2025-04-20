<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>My Winnings</title>
  <link rel="stylesheet" href="winning.css"> 
</head>
<body>
  <?php include 'navbar.php'; ?>

  <div class="main-content">
    <h2>My Winnings</h2>

    <div class="summary-cards">
      <div class="summary-card" id="totalBets">Total Bets: 0</div>
      <div class="summary-card" id="totalWins">Total Wins: 0</div>
      <div class="summary-card" id="revenue">Revenue: ₹0</div>
    </div>

    <div class="grid" id="winnerCards"></div>
  </div>

  <script>
    const winnerBids = JSON.parse(localStorage.getItem("winnerBids")) || [];

    const totalBets = winnerBids.length;
    const totalWins = winnerBids.length;
    const revenue = winnerBids.reduce((sum, bid) => sum + parseInt(bid.bid), 0);

    document.getElementById("totalBets").textContent = `Total Bets: ${totalBets}`;
    document.getElementById("totalWins").textContent = `Total Wins: ${totalWins}`;
    document.getElementById("revenue").textContent = `Revenue: ₹${revenue.toLocaleString()}`;

    const container = document.getElementById("winnerCards");

    if (winnerBids.length === 0) {
      container.innerHTML = `<p class="no-wins">No winning bids found.</p>`;
    } else {
      winnerBids.forEach(bid => {
        const card = document.createElement("div");
        card.className = "card";
        card.innerHTML = `
          <img src="${bid.image || 'images/default.jpg'}" alt="${bid.name}">
          <div class="card-content">
            <h3>${bid.name}</h3>
            <p><span>Bid:</span> ₹${bid.bid}</p>
            <p><span>Min:</span> ₹${bid.min} &nbsp; | &nbsp; <span>Max:</span> ₹${bid.max}</p>
            <p><span>Winner:</span> ${bid.user}</p>
          </div>
        `;
        container.appendChild(card);
      });
    }
  </script>
</body>
</html>
