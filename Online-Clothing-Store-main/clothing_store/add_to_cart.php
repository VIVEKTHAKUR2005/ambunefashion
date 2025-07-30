<?php
// add_to_cart.php
include 'db.php';
session_start();

$product_id = $_POST['product_id'];
$user_id = 1; // static for now

$sql = "INSERT INTO cart (user_id, product_id, quantity) VALUES ($user_id, $product_id, 1)
        ON DUPLICATE KEY UPDATE quantity = quantity + 1";

if ($conn->query($sql) === TRUE) {
    header("Location: cart.php");
} else {
    echo "Error: " . $conn->error;
}
$conn->close();
?>
