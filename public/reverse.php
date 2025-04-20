<?php
// Define auction items in an array
$auction_items = [
    [
        'name' => 'Antique Vase',
        'image' => 'images/1.jpg',
        'target_price' => 25000,
        'id' => 1
    ],
    [
        'name' => 'Vintage Camera',
        'image' => 'images/2.jpg',
        'target_price' => 8000,
        'id' => 2
    ],
    [
        'name' => 'Old Coin Collection',
        'image' => 'images/3.jpg',
        'target_price' => 1500,
        'id' => 3
    ],
    [
        'name' => 'Wooden Clock',
        'image' => 'images/4.webp',
        'target_price' => 3000,
        'id' => 4
    ],
    [
        'name' => 'Painting - Sunset',
        'image' => 'images/5.jpeg',
        'target_price' => 7000,
        'id' => 5
    ],
    [
        'name' => 'Leather Armchair',
        'image' => 'images/6.jpeg',
        'target_price' => 10000,
        'id' => 6
    ]
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reverse Auction</title>
    <link rel="stylesheet" href="reverse.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
</head>
<body>

    <h2 style="text-align:center; margin-bottom: 2rem;">Reverse Auction</h2>

    <?php include 'navbar.php' ?>
    <div class="auction-container">
        <?php foreach ($auction_items as $item): ?>
            <div class="auction-item" id="item<?= $item['id'] ?>">
                <h3><?= $item['name'] ?></h3>
                <img src="<?= $item['image'] ?>" alt="<?= $item['name'] ?>">
                <p><strong>Target Price:</strong> ₹<?= number_format($item['target_price'], 2) ?></p>

                <!-- Username and Bid Amount Input -->
                <input type="text" id="username<?= $item['id'] ?>" placeholder="Enter your username" style="width: 100%; margin-bottom: 10px;">
                <input type="number" id="bid<?= $item['id'] ?>" placeholder="Place your bid" style="width: 100%; margin-bottom: 10px;">

                <p><strong>Time Remaining: <span id="timer<?= $item['id'] ?>">30</span>s</strong></p>
                <button onclick="placeBid(<?= $item['id'] ?>)">Place Bid</button>
                <p><strong>Closest Bid:</strong> ₹<span id="closestBid<?= $item['id'] ?>">-</span></p>
            </div>
        <?php endforeach; ?>
    </div>

    <script>
        // Auction Items Array
        const auctionItems = [
            { id: 1, targetPrice: 25000 },
            { id: 2, targetPrice: 8000 },
            { id: 3, targetPrice: 1500 },
            { id: 4, targetPrice: 3000 },
            { id: 5, targetPrice: 7000 },
            { id: 6, targetPrice: 10000 }
        ];

        // Timer Logic
        auctionItems.forEach(item => {
            let timeRemaining = 30;
            const timerElement = document.getElementById(`timer${item.id}`);
            const bidInput = document.getElementById(`bid${item.id}`);
            const usernameInput = document.getElementById(`username${item.id}`);
            const closestBidElement = document.getElementById(`closestBid${item.id}`);
            let timerStarted = false;  // Flag to control timer start

            // Timer function only starts when a bid is placed
            let timerInterval = null;

            // Place Bid Logic
            window.placeBid = (itemId) => {
                const bidValue = document.getElementById(`bid${itemId}`).value;
                const username = document.getElementById(`username${itemId}`).value;

                // Ensure a valid bid is placed and username is provided
                if (bidValue === "" || isNaN(bidValue) || username === "") {
                    Toastify({
                        text: "Please enter a valid username and bid.",
                        duration: 3000,
                        close: true,
                        gravity: "top",
                        position: "right",
                        backgroundColor: "#FF6347",
                        stopOnFocus: true
                    }).showToast();
                    return;
                }

                // Start the timer if it hasn't started yet
                if (!timerStarted) {
                    timerStarted = true;
                    timerInterval = setInterval(() => {
                        if (timeRemaining > 0) {
                            timeRemaining--;
                            timerElement.textContent = timeRemaining + 's';
                        } else {
                            clearInterval(timerInterval);
                            if (closestBidElement.textContent === "-") {
                                closestBidElement.textContent = "Auction ended!";
                            }
                        }
                    }, 1000);
                }

                const closestBid = Math.abs(item.targetPrice - bidValue);

                // Update closest bid dynamically
                closestBidElement.textContent = `₹${Math.abs(item.targetPrice - closestBid)}`;
                Toastify({
                    text: `${username} placed a bid for ₹${bidValue} on ${item.name}`,
                    duration: 3000,
                    close: true,
                    gravity: "top",
                    position: "right",
                    backgroundColor: "#4CAF50",
                    stopOnFocus: true
                }).showToast();
            };
        });

        // Sidebar hover logic
        const sidebar = document.querySelector('.sidebar');
        const mainContent = document.querySelector('.auction-container');
        if (sidebar && mainContent) {
            sidebar.addEventListener('mouseenter', () => {
                mainContent.style.marginLeft = '250px';
                mainContent.style.width = 'calc(100% - 250px)';
            });
            sidebar.addEventListener('mouseleave', () => {
                mainContent.style.marginLeft = '75px';
                mainContent.style.width = 'calc(100% - 75px)';
            });
        }
    </script>

</body>
</html>
