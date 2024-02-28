<?php
include("conn.php");
$json_data = file_get_contents('shoes.json');
$data = json_decode($json_data, true);

foreach ($data['shoes'] as $product) {
    $name = $product['name'];
    $description = $product['description'];
    $price = $product['price'];
    $image = $product['image'];

    $sql = "INSERT INTO products (name, description, price, image) 
            VALUES ('$name', '$description', '$price', '$image')";
    if ($conn->query($sql) === TRUE) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();