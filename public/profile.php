<?php include 'navbar.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Profile</title>
    <link rel="stylesheet" href="profile.css">
</head>
<body>

<div class="profile-container">
    <div class="profile-card">
        <img src="default-avatar.png" alt="Profile Picture" id="profileImage">
        <h2 id="userName">User</h2>
        <p><strong>Email:</strong> <span id="userEmail">user.doe@example.com</span></p>
        <p><strong>User ID:</strong> <span id="userId">U123456</span></p>
        <p><strong>Phone:</strong> <span id="userPhone">+91 9XXXXXXXXX</span></p>
        <p><strong>Address:</strong> <span id="userAddress">123 Main St, Mumbai</span></p>
        <p><strong>Date of Birth:</strong> <span id="userDOB">1995-05-10</span></p>
        <p><strong>Gender:</strong> <span id="userGender">None</span></p>
        <p><strong>Role:</strong> <span id="userRole">Administrator</span></p>
        <button onclick="openModal()">Edit Profile</button>
    </div>
</div>

<!-- Modal -->
<div class="modal-overlay" id="modal">
    <div class="modal-content">
        <span class="close-btn" onclick="closeModal()">&times;</span>
        <h2>Edit Profile</h2>
        <form id="editForm">
            <div class="form-group">
                <label for="editImage">Profile Image</label>
                <input type="file" id="editImage" accept="image/*">
            </div>
            <div class="form-group">
                <label for="editName">Name</label>
                <input type="text" id="editName" value="John Doe">
            </div>
            <div class="form-group">
                <label for="editEmail">Email</label>
                <input type="email" id="editEmail" value="john.doe@example.com">
            </div>
            <div class="form-group">
                <label for="editId">User ID</label>
                <input type="text" id="editId" value="U123456" disabled>
            </div>
            <div class="form-group">
                <label for="editPhone">Phone</label>
                <input type="text" id="editPhone" value="+91 9876543210">
            </div>
            <div class="form-group">
                <label for="editAddress">Address</label>
                <input type="text" id="editAddress" value="123 Main St, Mumbai">
            </div>
            <div class="form-group">
                <label for="editDOB">Date of Birth</label>
                <input type="date" id="editDOB" value="1995-05-10">
            </div>
            <div class="form-group">
                <label for="editGender">Gender</label>
                <select id="editGender">
                    <option>Male</option>
                    <option>Female</option>
                    <option>Other</option>
                </select>
            </div>
            <div class="form-group">
                <label for="editRole">Role</label>
                <input type="text" id="editRole" value="Administrator">
            </div>
            <button type="button" onclick="saveChanges()">Save</button>
        </form>
    </div>
</div>

<script>
    function openModal() {
        document.getElementById("modal").style.display = "flex";
    }

    function closeModal() {
        document.getElementById("modal").style.display = "none";
    }

    function saveChanges() {
        document.getElementById('userName').innerText = document.getElementById('editName').value;
        document.getElementById('userEmail').innerText = document.getElementById('editEmail').value;
        document.getElementById('userPhone').innerText = document.getElementById('editPhone').value;
        document.getElementById('userAddress').innerText = document.getElementById('editAddress').value;
        document.getElementById('userDOB').innerText = document.getElementById('editDOB').value;
        document.getElementById('userGender').innerText = document.getElementById('editGender').value;
        document.getElementById('userRole').innerText = document.getElementById('editRole').value;

        const imageInput = document.getElementById('editImage');
        if (imageInput.files && imageInput.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('profileImage').src = e.target.result;
            }
            reader.readAsDataURL(imageInput.files[0]);
        }

        closeModal();
    }
</script>

</body>
</html>
