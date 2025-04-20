<?php include 'navbar.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Settings</title>
    <link rel="stylesheet" href="settings.css">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</head>
<body>

<div class="settings-container">
    <h1>User Settings</h1>
    <div class="settings-grid">
        <div class="setting-card" onclick="openModal('selectAddressModal')">
            <i class="fas fa-map-marker-alt"></i>
            <p>Select Address</p>
            <div id="selectedAddress" class="sub-info">No address selected</div>
        </div>
        <div class="setting-card" onclick="openModal('editAddressModal')">
            <i class="fas fa-edit"></i>
            <p>Edit Address</p>
        </div>
        <div class="setting-card" onclick="openModal('paymentModal')">
            <i class="fas fa-credit-card"></i>
            <p>Payment</p>
        </div>
        <div class="setting-card" onclick="openModal('billModal')">
            <i class="fas fa-file-invoice-dollar"></i>
            <p>Bills</p>
        </div>
        <div class="setting-card" onclick="openModal('winningModal')">
            <i class="fas fa-trophy"></i>
            <p>Winnings</p>
        </div>
        <div class="setting-card" onclick="openModal('helpModal')">
            <i class="fas fa-question-circle"></i>
            <p>Help</p>
        </div>
    </div>
</div>

<!-- Select Address Modal -->
<div class="modal-overlay" id="selectAddressModal">
    <div class="modal-content">
        <span class="close-btn" onclick="closeModal('selectAddressModal')">&times;</span>
        <h2>Your Selected Address</h2>
        <p id="displayAddress">No address selected yet.</p>
    </div>
</div>

<!-- Edit Address Modal -->
<div class="modal-overlay" id="editAddressModal">
    <div class="modal-content">
        <span class="close-btn" onclick="closeModal('editAddressModal')">&times;</span>
        <h2>Edit Address</h2>
        <input type="text" id="fullName" placeholder="Full Name">
        <input type="text" id="phoneNumber" placeholder="Phone Number">
        <input type="text" id="street" placeholder="Street Address">
        <input type="text" id="city" placeholder="City">
        <input type="text" id="pincode" placeholder="Pincode">
        <input type="text" id="state" placeholder="State">
        <input type="text" id="country" placeholder="Country">
        <button onclick="saveAddress()">Save Address</button>
    </div>
</div>

<!-- Payment Modal -->
<div class="modal-overlay" id="paymentModal">
    <div class="modal-content">
        <span class="close-btn" onclick="closeModal('paymentModal')">&times;</span>
        <h2>Payment Settings</h2>
        <p>Manage your payment methods.</p>
        <button>Add Payment Method</button>
    </div>
</div>

<!-- Bills Modal -->
<div class="modal-overlay" id="billModal">
    <div class="modal-content">
        <span class="close-btn" onclick="closeModal('billModal')">&times;</span>
        <h2>Your Bills</h2>
        <p>No bills available.</p>
    </div>
</div>

<!-- Winnings Modal -->
<div class="modal-overlay" id="winningModal">
    <div class="modal-content">
        <span class="close-btn" onclick="closeModal('winningModal')">&times;</span>
        <h2>Your Winnings</h2>
        <p>View your recent winnings here.</p>
    </div>
</div>

<!-- Help Modal -->
<div class="modal-overlay" id="helpModal">
    <div class="modal-content">
        <span class="close-btn" onclick="closeModal('helpModal')">&times;</span>
        <h2>Help & Contact</h2>
        <ul>
            <li><i class="fas fa-phone"></i> Customer Care: +91 9876543210</li>
            <li><i class="fas fa-phone"></i> Technical Support: +91 9123456780</li>
            <li><i class="fas fa-envelope"></i> Email: support@example.com</li>
        </ul>
    </div>
</div>

<script>
    function openModal(id) {
        document.getElementById(id).style.display = "flex";
    }

    function closeModal(id) {
        document.getElementById(id).style.display = "none";
    }

    function saveAddress() {
        const name = document.getElementById('fullName').value;
        const phone = document.getElementById('phoneNumber').value;
        const street = document.getElementById('street').value;
        const city = document.getElementById('city').value;
        const pincode = document.getElementById('pincode').value;
        const state = document.getElementById('state').value;
        const country = document.getElementById('country').value;

        const formattedAddress = `${name}, ${phone}, ${street}, ${city}, ${state} - ${pincode}, ${country}`;
        document.getElementById('selectedAddress').innerText = formattedAddress;
        document.getElementById('displayAddress').innerText = formattedAddress;
        closeModal('editAddressModal');
    }
</script>

</body>
</html>
