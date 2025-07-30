<?php
// checkout_handler.php
include 'db.php';
session_start();

$name = $_POST['name'];
$address = $_POST['address'];
$payment_method = $_POST['payment_method'];
$user_id = 1; // static for now

// Insert into orders table
$sql = "INSERT INTO orders (user_id, name, address, payment_method, order_status) VALUES ($user_id, '$name', '$address', '$payment_method', 'pending')";
if ($conn->query($sql) === TRUE) {
    // Insert order items
    $order_id = $conn->insert_id;
    $sql = "INSERT INTO order_items (order_id, product_id, quantity) SELECT $order_id, product_id, quantity FROM cart WHERE user_id = $user_id";
    if ($conn->query($sql) === TRUE) {
        // Clear cart
        $conn->query("DELETE FROM cart WHERE user_id = $user_id");
        header('Location: thank_you.php');
    } else {
        echo "Error inserting order items: " . $conn->error;
    }
} else {
    echo "Error: " . $conn->error;
}
$conn->close();
?>
