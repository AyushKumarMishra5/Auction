<?php include 'navbar.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Cart - Bidify</title>
  <link rel="stylesheet" href="cart.css"/>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
  <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
  <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
</head>
<body>

  <h2>Your Cart Items</h2>
  <div class="cart-container" id="cartContainer"></div>

  <div class="cart-summary">
    <h3>Total: ₹<span id="totalAmount">0</span></h3>
    <button class="checkout-btn" onclick="checkout()">Proceed to Checkout</button>
  </div>

  <script>
    let cart = JSON.parse(localStorage.getItem("cart")) || [];

    const cartContainer = document.getElementById("cartContainer");
    const totalAmount = document.getElementById("totalAmount");

    function renderCart() {
      cartContainer.innerHTML = "";
      if (cart.length === 0) {
        cartContainer.innerHTML = "<p class='empty-cart'>No items in cart.</p>";
        totalAmount.textContent = "0";
        return;
      }

      let total = 0;

      cart.forEach((item, index) => {
        if (!item.quantity) item.quantity = 1;

        const itemPrice = parseInt(item.price.replace("₹", "").replace(",", ""));
        const itemTotal = itemPrice * item.quantity;
        total += itemTotal;

        const div = document.createElement("div");
        div.className = "cart-item";
        div.innerHTML = `
          <img src="${item.image}" alt="${item.name}">
          <div class="cart-details">
            <div class="top-row">
              <h3>${item.name}</h3>
              <i class="fas fa-trash delete-icon" onclick="removeItem(${index})"></i>
            </div>
            <p><strong>Price:</strong> ${item.price}</p>
            <div class="quantity-controls">
              <button onclick="decreaseQty(${index})">−</button>
              <input type="text" value="${item.quantity}" readonly>
              <button onclick="increaseQty(${index})">+</button>
            </div>
            <p><strong>Subtotal:</strong> ₹${itemTotal.toLocaleString()}</p>
            ${item.quantity > 1 ? "<p class='warning'>⚠️ Can only buy a single piece of this item.</p>" : ""}
          </div>
        `;
        cartContainer.appendChild(div);
      });

      totalAmount.textContent = total.toLocaleString();
      localStorage.setItem("cart", JSON.stringify(cart));
    }

    function increaseQty(index) {
      if (cart[index].quantity === 1) {
        cart[index].quantity++;
        renderCart();
      } else {
        showToast("Can only buy a single piece of this item.", "warning");
      }
    }

    function decreaseQty(index) {
      if (cart[index].quantity > 1) {
        cart[index].quantity--;
      } else {
        cart.splice(index, 1);
        showToast(`${cart[index].name} removed from the cart.`, "error");
      }
      renderCart();
    }

    function removeItem(index) {
      const itemName = cart[index].name;
      cart.splice(index, 1);
      renderCart();
      showToast(`${itemName} removed from the cart.`, "error");
    }

    function showToast(message, type) {
      const backgroundColor = type === "warning" ? "#ff9800" : "#f44336"; // Orange for warning, Red for error
      Toastify({
        text: message,
        duration: 3000,
        close: false,
        gravity: "top",
        position: "right",
        backgroundColor: backgroundColor,
        stopOnFocus: false
      }).showToast();
    }

    function checkout() {
      if (cart.length === 0) {
        showToast("Your cart is empty. Add items before proceeding to checkout.", "warning");
      } else {
        window.location.href = "checkout.php"; // Redirect to checkout page (you can change this to your actual checkout page)
      }
    }

    renderCart();
  </script>

</body>
</html>
