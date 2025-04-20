<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Sidebar Menu</title>
  <link rel="stylesheet" href="navbar.css">
  <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />
</head>

<body>
  <div class="container">
    <aside class="sidebar">
      <div class="sidebar-header">
        <img src="image/progile.png" alt="logo" />
        <h2>Bidworks</h2>
      </div>
      <ul class="sidebar-links">
        <h4>
          <span>Main Menu</span>
          <div class="divider"></div>
        </h4>
        <li>
          <a href="dashboard.php">
            <span class="material-symbols-outlined"> dashboard </span>
            Dashboard
          </a>
        </li>
        <li>
          <a href="auction.php">
            <span class="material-symbols-outlined"> gavel </span>
            Auction
          </a>
        </li>
        <li>
          <a href="placebid.php">
            <span class="material-symbols-outlined"> receipt_long </span>
            Placed Bids
          </a>
        </li>
        <li>
          <a href="winning.php">
            <span class="material-symbols-outlined"> emoji_events </span>
            Winning
          </a>
        </li>
        <li>
          <a href="reverse.php">
            <span class="material-symbols-outlined"> compare_arrows </span>
            Reverse Auction
          </a>
        </li>
        <li>
          <a href="cart.php">
            <span class="material-symbols-outlined"> shopping_cart </span>
            Cart
          </a>
        </li>


        <h4>
          <span>Account</span>
          <div class="divider"></div>
        </h4>
        <li>
          <a href="profile.php">
            <span class="material-symbols-outlined"> account_circle </span>
            Profile
          </a>
        </li>
        <li>
          <a href="settings.php">
            <span class="material-symbols-outlined"> settings </span>
            Settings
          </a>
        </li>
        <li>
          <a href="support.php">
            <span class="material-symbols-outlined"> help </span>
            Support
          </a>
        </li>
        <li>
          <a href="Logout.php">
            <span class="material-symbols-outlined"> logout </span>
            Logout
          </a>
        </li>
      </ul>

      <div class="user-account">
        <div class="user-detail" style="display: flex; align-items: center; gap: 8px; padding: 1rem;">
          <h3 style="margin: 0;">Ayush Kumar Mishra</h3>
        </div>
      </div>
    </aside>
  </div>
</body>

</html>