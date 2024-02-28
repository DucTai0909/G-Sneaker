<?php
// Include file connection
include("conn.php");

// Truy vấn dữ liệu giỏ hàng từ cơ sở dữ liệu
$sql_cart = "SELECT products.*, carts.amount FROM products INNER JOIN carts ON products.id = carts.product_id";
$carts = $conn->query($sql_cart);

// Tạo HTML cho phần hiển thị của giỏ hàng
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

// Đóng kết nối cơ sở dữ liệu
$conn->close();
?>
