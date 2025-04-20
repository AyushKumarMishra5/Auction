<?php
include 'navbar.php';
$auction_items = [
    [
        'name' => 'Antique Clock',
        'image' => 'images/11.avif',
        'min' => 500,
        'max' => 5000
    ],
    [
        'name' => 'Vintage Radio',
        'image' => 'images/12.jpg',
        'min' => 1000,
        'max' => 8000
    ],
    [
        'name' => 'Classic Sculpture',
        'image' => 'images/14.jpg',
        'min' => 1500,
        'max' => 10000
    ],
    [
        'name' => 'Retro Fan',
        'image' => 'images/15.jpg',
        'min' => 700,
        'max' => 4000
    ],
    [
        'name' => 'Art Deco Mirror',
        'image' => 'images/16.jpg',
        'min' => 1200,
        'max' => 6000
    ],
    [
        'name' => 'Ceramic Tea Set',
        'image' => 'images/17.jpg',
        'min' => 900,
        'max' => 3500
    ],
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Auction Items</title>
    <link rel="stylesheet" href="auction.css">
</head>
<body>
    <div class="main-content">
        <h2 class="heading">Ongoing Auction</h2>

        <div class="grid">
            <?php foreach ($auction_items as $index => $item): ?>
                <div class="card">
                    <h3><?= $item['name'] ?></h3>
                    <img src="<?= $item['image'] ?>" alt="<?= $item['name'] ?>">
                    <p><strong>Min Bid:</strong> ₹<?= $item['min'] ?> | <strong>Max Bid:</strong> ₹<?= $item['max'] ?></p>
                    <form onsubmit="handleBid(event, '<?= $item['name'] ?>', <?= $item['min'] ?>, <?= $item['max'] ?>, <?= $index ?>)">
                        <input type="text" name="username" placeholder="Enter your name" required />
                        <input type="number" name="bid" placeholder="Enter your bid" required />
                        <button type="submit">Place Bid</button>
                        <div class="timer" id="timer-<?= $index ?>"></div>
                    </form>
                </div>
            <?php endforeach; ?>
        </div>

        <section class="bids-section" id="placedBidsSection" style="display: none;">
            <h3>Placed Bids</h3>
            <table class="bids-table" id="bidsTable">
                <thead>
                    <tr>
                        <th>Item Name</th>
                        <th>Min Price</th>
                        <th>Max Price</th>
                        <th>Your Name</th>
                        <th>Your Bid</th>
                    </tr>
                </thead>
                <tbody id="bidsBody"></tbody>
            </table>
        </section>
    </div>

    <script>
        const bids = [];
        const timers = {};
        const countdowns = {};

        function handleBid(event, itemName, min, max, index) {
            event.preventDefault();
            const form = event.target;
            const nameInput = form.querySelector('input[name="username"]');
            const bidInput = form.querySelector('input[name="bid"]');
            const timerDisplay = document.getElementById(`timer-${index}`);

            const username = nameInput.value.trim();
            const bidValue = parseInt(bidInput.value);
            const imageSrc = form.closest('.card').querySelector('img').src;

            if (!username || isNaN(bidValue)) {
                alert("Please enter valid name and bid.");
                return;
            }

            if (bidValue < min || bidValue > max) {
                alert(`Bid must be between ₹${min} and ₹${max}`);
                return;
            }

            alert("✅ Bid placed!");
            bids.push({ name: itemName, min, max, bid: bidValue, user: username });
            localStorage.setItem("placedBids", JSON.stringify(bids));

            document.getElementById("placedBidsSection").style.display = "block";
            const row = document.createElement("tr");
            row.innerHTML = `
                <td>${itemName}</td>
                <td>₹${min}</td>
                <td>₹${max}</td>
                <td>${username}</td>
                <td><strong>₹${bidValue}</strong></td>
            `;
            document.getElementById("bidsBody").appendChild(row);

            nameInput.value = "";
            bidInput.value = "";

            if (timers[index]) clearInterval(timers[index]);
            countdowns[index] = 30;
            timerDisplay.textContent = `⏳ Time left to outbid: ${countdowns[index]}s`;

            timers[index] = setInterval(() => {
                countdowns[index]--;
                if (countdowns[index] <= 0) {
                    clearInterval(timers[index]);
                    timerDisplay.textContent = `🏆 Auction Ended. Winner: ${username}`;
                    alert(`🎉 Auction for "${itemName}" won by ${username}!`);

                    // Save winner
                    let winnerBids = JSON.parse(localStorage.getItem("winnerBids")) || [];
                    winnerBids.push({
                        name: itemName,
                        bid: bidValue,
                        user: username,
                        min: min,
                        max: max,
                        image: imageSrc
                    });
                    localStorage.setItem("winnerBids", JSON.stringify(winnerBids));
                } else {
                    timerDisplay.textContent = `⏳ Time left to outbid: ${countdowns[index]}s`;
                }
            }, 1000);
        }
    </script>
</body>
</html>
