<?php
$items = [
    [
        'name' => 'Antique Vase',
        'image' => 'images/1.jpg',
        'price' => '₹26,500',
        'description' => 'Beautiful handcrafted antique vase.'
    ],
    [
        'name' => 'Vintage Camera',
        'image' => 'images/2.jpg',
        'price' => '₹7,800',
        'description' => 'Classic camera from the 70s, fully functional.'
    ],
    [
        'name' => 'Old Coin Collection',
        'image' => 'images/3.jpg',
        'price' => '₹1,200',
        'description' => 'Set of rare vintage coins.'
    ],
    [
        'name' => 'Wooden Clock',
        'image' => 'images/4.webp',
        'price' => '₹3,100',
        'description' => 'Handcrafted wooden wall clock.'
    ],
    [
        'name' => 'Painting - Sunset',
        'image' => 'images/5.jpeg',
        'price' => '₹6,000',
        'description' => 'Original acrylic painting on canvas.'
    ],
    [
        'name' => 'Leather Armchair',
        'image' => 'images/6.jpeg',
        'price' => '₹9,500',
        'description' => 'Vintage leather armchair, very comfy.'
    ],
    [
        'name' => 'Gramophone',
        'image' => 'images/7.webp',
        'price' => '₹12,000',
        'description' => 'Fully working retro gramophone.'
    ],
    [
        'name' => 'Chess Set',
        'image' => 'images/8.jpg',
        'price' => '₹2,200',
        'description' => 'Wooden carved chess board with pieces.'
    ],
    [
        'name' => 'Typewriter',
        'image' => 'images/9.jpg',
        'price' => '₹4,500',
        'description' => 'Vintage typewriter in great condition.'
    ],
    [
        'name' => 'Decorative Lamp',
        'image' => 'images/10.jpg',
        'price' => '₹1,800',
        'description' => 'Old-style decorative lamp.'
    ]
];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bidify [Dashboard]</title>
    <link rel="stylesheet" href="dashboard.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
</head>

<body>

    <?php include 'navbar.php'; ?>

    <div class="main-content">
        <h2 style="text-align:center; margin-bottom: 2rem;">Bidding Items</h2>
        <div class="grid">
            <?php foreach ($items as $item): ?>
                <div class="card">
                    <h3><?= $item['name'] ?></h3>
                    <img src="<?= $item['image'] ?>" alt="<?= $item['name'] ?>">
                    <p><strong>Price:</strong> <?= $item['price'] ?></p>
                    <p><?= $item['description'] ?></p>
                    <button class="view-btn">View Details</button>
                    <button class="cart-btn"
                        data-name="<?= htmlspecialchars($item['name']) ?>"
                        data-image="<?= htmlspecialchars($item['image']) ?>"
                        data-price="<?= htmlspecialchars($item['price']) ?>"
                    >Add to Cart</button>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Modal -->
    <div id="itemModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <img id="modalImage" src="" alt="">
            <h3 id="modalTitle"></h3>
            <p id="modalPrice"></p>
            <p id="modalDesc"></p>
        </div>
    </div>

    <script>
        // View Details Modal
        const modal = document.getElementById("itemModal");
        const modalImage = document.getElementById("modalImage");
        const modalTitle = document.getElementById("modalTitle");
        const modalPrice = document.getElementById("modalPrice");
        const modalDesc = document.getElementById("modalDesc");
        const closeBtn = document.querySelector(".close");

        document.querySelectorAll(".view-btn").forEach(button => {
            button.addEventListener("click", () => {
                const card = button.parentElement;
                modalTitle.textContent = card.querySelector("h3").textContent;
                modalImage.src = card.querySelector("img").src;
                modalPrice.textContent = card.querySelector("p").textContent;
                modalDesc.textContent = card.querySelectorAll("p")[1].textContent;
                modal.style.display = "block";
            });
        });

        closeBtn.onclick = () => modal.style.display = "none";
        window.onclick = e => { if (e.target === modal) modal.style.display = "none"; };

        // Add to Cart + Toastify
        document.querySelectorAll(".cart-btn").forEach(button => {
            button.addEventListener("click", () => {
                const name = button.dataset.name;
                const image = button.dataset.image;
                const price = button.dataset.price;

                let cart = JSON.parse(localStorage.getItem("cart")) || [];
                cart.push({ name, image, price });
                localStorage.setItem("cart", JSON.stringify(cart));

                Toastify({
                    text: `${name} added to cart`,
                    duration: 3000,
                    gravity: "top",
                    position: "right",
                    backgroundColor: "#4CAF50",
                    close: false,
                    stopOnFocus: false,
                    className: "cart-toast"
                }).showToast();
            });
        });

        // Sidebar animation (optional)
        const sidebar = document.querySelector('.sidebar');
        const mainContent = document.querySelector('.main-content');
        if (sidebar) {
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
