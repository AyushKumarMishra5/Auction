<?php
include 'navbar.php';
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
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bidify [Dashboard]</title>
    <link rel="stylesheet" href="dashboard.css">
</head>

<body>
    <div class="main-content">
        <h2 style="text-align:center; margin-bottom: 2rem;">Bidding Items</h2>

        <div class="grid">
            <?php foreach ($items as $item): ?>
                <div class="card">
                    <h3><?= $item['name'] ?></h3>
                    <img src="<?= $item['image'] ?>" alt="<?= $item['name'] ?>">
                    <p><strong>Price:</strong> <?= $item['price'] ?></p>
                    <p><?= $item['description'] ?></p>
                    <button>view details</button>
                </div>
            <?php endforeach; ?>
        </div>
    </div>


</body>

</html>