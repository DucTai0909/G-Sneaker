<?php
  include("conn.php");
  $sql = "SELECT * FROM products";
  $products = $conn->query($sql);

  $sql_cart = "SELECT products.*, carts.amount FROM products INNER JOIN carts ON products.id = carts.product_id";
  $carts = $conn->query($sql_cart);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Nike Store</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="container">
    <header class="header">
    </header>
    <main class="main">
      <section class="products">
        <img src="/resource/nike.png" style="height: 40px; width:40px;" alt="Nike Logo" class="nike-logo">

        <h2 class="products-title">Our Products</h2>
        <div class="">
          <?php
            

            if ($products->num_rows > 0) {
              // Bắt đầu vòng lặp để hiển thị sản phẩm
              while ($product = $products->fetch_assoc()) {
                echo '<div class="App_shopItem_3FgVU">';
                echo '    <div class="App_shopItemImage_341iU" style="background-color: rgb(225, 231, 237);">';
                echo '        <img class="img_product" src="' . $product["image"] . '">';
                echo '    </div>';
                echo '    <div class="App_shopItemDetails">';
                echo '        <div class="App_shopItemName_1_FJR" style="font-size: 20px; margin-bottom:18px;"><strong>' . $product["name"] . '</strong></div>';
                echo '        <div class="App_shopItemDescription_1EIVK" style="color: #777777; font-size: 15px;margin-bottom:18px;">' . $product["description"] . '</div>';
                echo '        <div class="App_shopItemBottom_3401_" style="display: flex; align-items: center;">';
                echo '            <div class="App_shopItemPrice_2SLiG" style="font-size: 20px; margin-right: auto;"><strong>$' . $product["price"] . '</strong></div>';
                echo '            <div class="App_shopItemButton_23FO1" style="border-radius: 15px; overflow: hidden;">';
                echo '                <button onclick="addToCart(' . $product["id"] . ')" style="border: none; padding: 5px 10px; cursor: pointer; background-color: #ffd700;">ADD TO CART</button>';
                echo '            </div>';
                echo '        </div>';
                echo '    </div>';
                echo '</div>';
                
              }
          } else {
              echo "0 results";
          }
          ?>
            
            
        </div>
      </section>
      <section class="cart">
        <img src="/resource/nike.png" style="height: 40px; width:40px;" alt="Nike Logo" class="nike-logo">
        <h2 class="cart-title">Your Cart</h2>
        <ul class="cart-list">
          <?php
          if ($carts->num_rows > 0) {
            while ($cart = $carts->fetch_assoc()) {
              echo '<li>';
              echo '  <div class="cart-item" id="cart-item-'.$cart["id"].'">';
              echo '    <div class="cart-item-image">';
              echo '      <div class="img-background">';
              echo '        <img class="img_cart" src="' . $cart["image"] . '" alt="' . $cart["name"] . '">';
              echo '      </div>';
              echo '    </div>';
              echo '    <div class="cart-item-details">';
              echo '      <p class="cart-item-name">' . $cart["name"] . '</p>';
              echo '      <p class="cart-item-price">$' . $cart["price"] . '</p>';
              echo '      <div class="cart-item-actions">';
              echo '        <button class="quantity-decrease" onclick="decreaseQuantity(' . $cart['id'] . ')">-</button>';
              echo '        <span class="quantity" id="quantity-' . $cart['id'] . '">' . $cart["amount"] . '</span>';
              echo '        <button class="quantity-increase" onclick="increaseQuantity(' . $cart['id'] . ')">+</button>';
              echo '        <button class="remove-item" onclick="removeItem(' . $cart['id'] . ')">Remove</button>';
              echo '      </div>';
              echo '    </div>';
              echo '  </div>';
              echo '</li>';

            }
          } else {
            echo '<p>Your cart is empty</p>';
          }
          ?>
        </ul>
        <p class="cart-total">Total: $<span id="cart-total">0.00</span></p>
      </section>

    </main>
  </div>
  <script>
    function addToCart(productId) {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            var response = this.responseText;
            if (response == "success") {
                var button = document.querySelector('button[onclick="addToCart(' + productId + ')"]');
                button.innerHTML = "✓";
                button.disabled = true;
                // Sau khi thêm sản phẩm vào giỏ hàng thành công, cập nhật lại phần hiển thị của giỏ hàng
                updateCartDisplay();
            } else {
                alert("Failed to add product to cart");
            }
        }
    };
    xhttp.open("POST", "add_to_cart.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("product_id=" + productId);
}

function updateCartDisplay() {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            var cartList = document.querySelector('.cart-list');
            cartList.innerHTML = this.responseText;
            updateTotalPrice();
        }
    };
    xhttp.open("GET", "get_cart.php", true);
    xhttp.send();
}

    // JavaScript
    function decreaseQuantity(productId) {
        var quantityElement = document.getElementById('quantity-' + productId);
        var quantity = parseInt(quantityElement.innerText);
        if (quantity > 1) {
            quantity--;
            updateQuantity(productId, quantity);
        }else{
          // quantityElement.parentNode.removeChild(quantityElement);
          removeItem(productId);
        }
    }

    function increaseQuantity(productId) {
        var quantityElement = document.getElementById('quantity-' + productId);
        var quantity = parseInt(quantityElement.innerText);
        quantity++;
        updateQuantity(productId, quantity);
    }

    function updateQuantity(productId, quantity) {
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                var response = this.responseText;
                if (response == "success") {
                    var quantityElement = document.getElementById('quantity-' + productId);
                    quantityElement.innerText = quantity;
                    updateTotalPrice()
                } else {
                    alert("Failed to update quantity");
                }
            }
        };
        xhttp.open("POST", "update_quantity.php", true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send("product_id=" + productId + "&quantity=" + quantity);
    }

    function removeItem(productId) {
      var xhttp = new XMLHttpRequest();
      xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
          var response = JSON.parse(this.responseText);
          if (response.status === "success") {
            var removedProductId = response.productId;
            var cartItem = document.getElementById('cart-item-' + removedProductId);
            if (cartItem) {
              cartItem.parentNode.removeChild(cartItem);
              updateTotalPrice()
            }
          } else {
            alert("Failed to remove item from cart");
          }
        }
      };
      xhttp.open("POST", "remove_item.php", true);
      xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
      xhttp.send("product_id=" + productId);
    }

    function updateTotalPrice() {
      var total = 0;
      var cartItems = document.querySelectorAll('.cart-item');

      cartItems.forEach(function(cartItem) {
        var priceElement = cartItem.querySelector('.cart-item-price');
        var quantityElement = cartItem.querySelector('.quantity');
        var price = parseFloat(priceElement.innerText.slice(1));
        var quantity = parseInt(quantityElement.innerText);
        total += price * quantity;
      });

      document.getElementById('cart-total').innerText = total.toFixed(2);
    }
    window.addEventListener('load', function() {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            var total = parseFloat(this.responseText);
            if (!isNaN(total)) {
                document.getElementById('cart-total').innerText = total.toFixed(2);
            } else {
                document.getElementById('cart-total').innerText = '0.00';
            }
        }
    };
    xhttp.open("GET", "get_cart_total.php", true);
    xhttp.send();
});


  </script>
</body>
</html>
