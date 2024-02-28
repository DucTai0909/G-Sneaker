<?php
include("conn.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Lấy thông tin sản phẩm và số lượng từ yêu cầu POST
    $productId = $_POST["product_id"];
    $quantity = $_POST["quantity"];

    // Cập nhật số lượng của sản phẩm trong giỏ hàng
    $sql = "UPDATE carts SET amount = $quantity WHERE product_id = $productId";
    if ($conn->query($sql) === TRUE) {
        echo "success";
    } else {
        echo "error";
    }
} else {
    echo "Invalid request";
}
?>
