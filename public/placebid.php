<?php include 'navbar.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Placed Bids</title>
  <link rel="stylesheet" href="placebid.css">
</head>
<body>
  <div class="layout">
    <div class="main-content">
      <h2>All Placed Bids</h2>

      <div class="bids-section">
        <table class="bids-table">
          <thead>
            <tr>
              <th>Item Name</th>
              <th>Min Price</th>
              <th>Max Price</th>
              <th>Bidder Name</th>
              <th>Your Bid</th>
              <th>Status</th>
            </tr>
          </thead>
          <tbody id="bidsBody"></tbody>
        </table>
      </div>
    </div>
  </div>

  <script>
    const storedBids = JSON.parse(localStorage.getItem("placedBids")) || [];
    const tbody = document.getElementById("bidsBody");

    if (storedBids.length === 0) {
      const row = document.createElement("tr");
      row.innerHTML = `<td colspan="6" style="text-align:center;">No bids placed yet.</td>`;
      tbody.appendChild(row);
    } else {
      let highestBid = Math.max(...storedBids.map(bid => bid.bid));
      storedBids.forEach(bid => {
        const row = document.createElement("tr");
        const isWinner = bid.bid === highestBid;

        row.innerHTML = `
          <td>${bid.name}</td>
          <td>₹${bid.min}</td>
          <td>₹${bid.max}</td>
          <td>${bid.user}</td>
          <td><strong style="color:${isWinner ? 'green' : 'black'};">₹${bid.bid}</strong></td>
          <td>${isWinner ? '🏆 Winner' : '-'}</td>
        `;

        if (isWinner) {
          row.style.backgroundColor = "#d4edda";
          row.style.fontWeight = "bold";
        }

        tbody.appendChild(row);
      });
      setTimeout(() => {
        localStorage.removeItem("placedBids");
        tbody.innerHTML = `<tr><td colspan="6" style="text-align:center;">Bids have been cleared.</td></tr>`;
      }, 10000);
    }
  </script>
</body>
</html>
