<?php
include("conn.php");

// Truy vấn để lấy tổng số tiền từ giỏ hàng
$sql_total = "SELECT SUM(products.price * carts.amount) AS total FROM products INNER JOIN carts ON products.id = carts.product_id";
$result = $conn->query($sql_total);
$total = 0;

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $total = $row["total"];
}

echo $total;

$conn->close();
?>
