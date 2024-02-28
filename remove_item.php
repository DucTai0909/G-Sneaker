<?php
include("conn.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Lấy thông tin sản phẩm từ yêu cầu POST
    $productId = $_POST["product_id"];

    // Xóa sản phẩm khỏi giỏ hàng
    $sql = "DELETE FROM carts WHERE product_id = $productId";
    if ($conn->query($sql) === TRUE) {
        // Trả về thông tin JSON về trạng thái xóa và ID của sản phẩm đã xóa
        echo json_encode(array("status" => "success", "productId" => $productId));
    } else {
        echo json_encode(array("status" => "error"));
    }
} else {
    echo json_encode(array("status" => "error", "message" => "Invalid request"));
}
?>
