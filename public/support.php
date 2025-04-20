<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Support Form</title>
    <link rel="stylesheet" href="support.css">
    <script src="https://cdn.jsdelivr.net/npm/emailjs-com@3/dist/email.min.js"></script>
    <script>
        (function() {
            emailjs.init("zMf3Yqk508ERlLJT4"); 
        })();
    </script>
</head>
<body>
    <div class="form-container">
        <h2>Contact Support</h2>
        <form id="support-form">
            <div class="form-group">
                <label for="name">Full Name</label>
                <input type="text" id="name" name="name" placeholder="Enter your full name" required>
            </div>
            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" id="email" name="email" placeholder="Enter your email" required>
            </div>
            <div class="form-group">
                <label for="message">Message</label>
                <textarea id="message" name="message" placeholder="Enter your message" required></textarea>
            </div>
            <button type="submit">Send Message</button>
        </form>
        <div class="form-footer">
            <p>We will get back to you as soon as possible!</p>
        </div>
    </div>

    <script>
        document.getElementById('support-form').addEventListener('submit', function(e) {
            e.preventDefault();

            emailjs.sendForm('service_guigx4e', 'template_b54d09h', this)
                .then(function(response) {
                    alert("Message sent successfully!");
                    document.getElementById("support-form").reset();
                }, function(error) {
                    alert("Failed to send message: " + JSON.stringify(error));
                });
        });
    </script>
</body>
</html>
