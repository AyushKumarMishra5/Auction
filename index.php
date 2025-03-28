<?php
session_start();
require_once "config/database.php";
require_once "models/User.php";
require_once "models/Item.php";
require_once "models/Bid.php";

$database = new Database();
$db = $database->getConnection();

$user = new User($db);
$item = new Item($db);
$bid = new Bid($db);

// Check if user is logged in
$isLoggedIn = isset($_SESSION['user_id']);

// Handle login
if(isset($_POST['login'])) {
    $user->email = $_POST['email'];
    $user->password = $_POST['password'];
    
    if($user->emailExists()) {
        if(password_verify($_POST['password'], $user->password)) {
            $_SESSION['user_id'] = $user->id;
            $_SESSION['user_name'] = $user->name;
            header("Location: index.php");
            exit();
        }
    }
    $loginError = "Invalid email or password";
}

// Handle registration
if(isset($_POST['register'])) {
    $user->name = $_POST['name'];
    $user->email = $_POST['email'];
    $user->password = $_POST['password'];
    
    if($user->create()) {
        $_SESSION['user_id'] = $user->id;
        $_SESSION['user_name'] = $user->name;
        header("Location: index.php");
        exit();
    } else {
        $registerError = "Registration failed. Email might already exist.";
    }
}

// Handle logout
if(isset($_GET['logout'])) {
    session_destroy();
    header("Location: index.php");
    exit();
}

// Handle item creation
if(isset($_POST['create_item']) && $isLoggedIn) {
    $item->title = $_POST['title'];
    $item->description = $_POST['description'];
    $item->starting_price = $_POST['starting_price'];
    $item->end_time = $_POST['end_time'];
    $item->seller_id = $_SESSION['user_id'];
    $item->image_url = $_POST['image_url'];
    
    if($item->create()) {
        header("Location: index.php");
        exit();
    }
}

// Handle bidding
if(isset($_POST['place_bid']) && $isLoggedIn) {
    $item->id = $_POST['item_id'];
    $item->readOne();
    
    if($_POST['amount'] > $item->current_price) {
        $bid->item_id = $_POST['item_id'];
        $bid->bidder_id = $_SESSION['user_id'];
        $bid->amount = $_POST['amount'];
        
        if($bid->create()) {
            $item->current_price = $_POST['amount'];
            $item->highest_bidder_id = $_SESSION['user_id'];
            $item->update();
            header("Location: index.php");
            exit();
        }
    }
}

// Get all active items
$stmt = $item->read();
$items = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Auction Website</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .card {
            transition: transform 0.2s;
        }
        .card:hover {
            transform: translateY(-5px);
        }
        .auth-form {
            max-width: 400px;
            margin: 2rem auto;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#">Auction Website</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <?php if($isLoggedIn): ?>
                        <li class="nav-item">
                            <span class="nav-link">Welcome, <?php echo $_SESSION['user_name']; ?></span>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="?logout">Logout</a>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <button class="btn btn-outline-light me-2" data-bs-toggle="modal" data-bs-target="#loginModal">Login</button>
                            <button class="btn btn-light" data-bs-toggle="modal" data-bs-target="#registerModal">Register</button>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <?php if($isLoggedIn): ?>
            <button class="btn btn-primary mb-4" data-bs-toggle="modal" data-bs-target="#createItemModal">
                Create New Item
            </button>
        <?php endif; ?>

        <div class="row">
            <?php foreach($items as $item): ?>
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <?php if($item['image_url']): ?>
                            <img src="<?php echo htmlspecialchars($item['image_url']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($item['title']); ?>">
                        <?php endif; ?>
                        <div class="card-body">
                            <h5 class="card-title"><?php echo htmlspecialchars($item['title']); ?></h5>
                            <p class="card-text"><?php echo htmlspecialchars($item['description']); ?></p>
                            <p class="card-text">
                                <strong>Current Price:</strong> $<?php echo number_format($item['current_price'], 2); ?><br>
                                <strong>End Time:</strong> <?php echo date('Y-m-d H:i:s', strtotime($item['end_time'])); ?><br>
                                <strong>Seller:</strong> <?php echo htmlspecialchars($item['seller_name']); ?>
                            </p>
                            <?php if($isLoggedIn && $item['seller_id'] != $_SESSION['user_id']): ?>
                                <form method="POST" class="d-inline">
                                    <input type="hidden" name="item_id" value="<?php echo $item['id']; ?>">
                                    <div class="input-group">
                                        <input type="number" name="amount" class="form-control" placeholder="Enter bid amount" step="0.01" min="<?php echo $item['current_price'] + 0.01; ?>" required>
                                        <button type="submit" name="place_bid" class="btn btn-primary">Place Bid</button>
                                    </div>
                                </form>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Login Modal -->
    <div class="modal fade" id="loginModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Login</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <?php if(isset($loginError)): ?>
                        <div class="alert alert-danger"><?php echo $loginError; ?></div>
                    <?php endif; ?>
                    <form method="POST">
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>
                        <button type="submit" name="login" class="btn btn-primary w-100">Login</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Register Modal -->
    <div class="modal fade" id="registerModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Register</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <?php if(isset($registerError)): ?>
                        <div class="alert alert-danger"><?php echo $registerError; ?></div>
                    <?php endif; ?>
                    <form method="POST">
                        <div class="mb-3">
                            <label class="form-label">Name</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>
                        <button type="submit" name="register" class="btn btn-primary w-100">Register</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Create Item Modal -->
    <div class="modal fade" id="createItemModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Create New Item</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form method="POST">
                        <div class="mb-3">
                            <label class="form-label">Title</label>
                            <input type="text" name="title" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea name="description" class="form-control" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Starting Price</label>
                            <input type="number" name="starting_price" class="form-control" step="0.01" min="0" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">End Time</label>
                            <input type="datetime-local" name="end_time" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Image URL</label>
                            <input type="url" name="image_url" class="form-control">
                        </div>
                        <button type="submit" name="create_item" class="btn btn-primary w-100">Create Item</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 