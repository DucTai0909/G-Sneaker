<?php
include("conn.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Lấy product_id từ yêu cầu POST
    $product_id = $_POST["product_id"];

    // Thực hiện truy vấn để thêm sản phẩm vào giỏ hàng (trong trường hợp này, chúng ta chỉ cần lưu product_id vào giỏ hàng)
    $sql = "INSERT INTO carts (product_id, amount) VALUES ('$product_id', 1)";

    if ($conn->query($sql) === TRUE) {
        echo "success"; // Trả về "success" nếu thêm sản phẩm vào giỏ hàng thành công
    } else {
        echo "error: " . $conn->error; // Trả về thông báo lỗi nếu có lỗi xảy ra
    }
}

$conn->close();
?>
