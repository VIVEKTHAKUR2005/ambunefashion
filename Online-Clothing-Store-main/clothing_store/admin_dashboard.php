<?php
// admin_dashboard.php
include 'db.php';
session_start();

if (!isset($_SESSION['admin']) || $_SESSION['admin'] !== true) {
    echo "You must be an admin to access this page.";
    exit;
}

// View all products
$sql = "SELECT * FROM products";
$result = $conn->query($sql);

echo "<h3>Manage Products</h3>";
while ($product = $result->fetch_assoc()) {
    echo "Product ID: " . $product['product_id'] . " - " . $product['product_name'] . " - " . $product['product_price'] . "<br>";
}
?>
