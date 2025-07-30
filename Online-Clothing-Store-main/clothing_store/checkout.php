<?php
// checkout.php
include 'db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    echo "Please login to proceed to checkout.";
    exit;
}

// Get user's cart items
$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM cart WHERE user_id = $user_id";
$cart_result = $conn->query($sql);

// Total Price Calculation
$total_price = 0;
$cart_items = [];
while ($cart_item = $cart_result->fetch_assoc()) {
    $product_id = $cart_item['product_id'];
    $quantity = $cart_item['quantity'];
    $sql_product = "SELECT * FROM products WHERE product_id = $product_id";
    $product = $conn->query($sql_product)->fetch_assoc();
    $product['quantity'] = $quantity; // Add quantity for each product in the cart
    $total_price += $product['product_price'] * $quantity;
    $cart_items[] = $product; // Add product details to the cart items array
}

// Display checkout information and the checkout form
echo '<h2>Checkout</h2>';

if (empty($cart_items)) {
    echo "Your cart is empty. Please add items to your cart before proceeding.";
    exit;
}

echo "<h3>Cart Items</h3>";
foreach ($cart_items as $item) {
    echo "<p>" . $item['product_name'] . " (x" . $item['quantity'] . ") - ₹" . $item['product_price'] * $item['quantity'] . "</p>";
}

echo "<h4>Total Price: ₹" . $total_price . "</h4>";

// Replace this with the new form you provided
?>
<form method="post" action="checkout.php">
    <input type="text" name="name" placeholder="Your Name" required><br>
    <input type="text" name="address" placeholder="Shipping Address" required><br>
    <select name="payment_method" required>
        <option value="Credit Card">Credit Card</option>
        <option value="PayPal">PayPal</option>
        <option value="Cash on Delivery">Cash on Delivery</option>
    </select><br>
    <button type="submit">Confirm Payment</button>
</form>

<?php
// If form is submitted, process the checkout
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $payment_method = $_POST['payment_method'];
    $name = $_POST['name'];
    $address = $_POST['address'];

    // Insert the order into the 'orders' table
    $sql_order = "INSERT INTO orders (user_id, name, address, payment_method, order_status) 
                  VALUES ($user_id, '$name', '$address', '$payment_method', 'pending')";

    if ($conn->query($sql_order) === TRUE) {
        // Get the order ID for the newly created order
        $order_id = $conn->insert_id;

        // Add items from the cart to the 'order_items' table
        foreach ($cart_items as $cart_item) {
            $product_id = $cart_item['product_id'];
            $quantity = $cart_item['quantity'];
            $sql_order_item = "INSERT INTO order_items (order_id, product_id, quantity) 
                               VALUES ($order_id, $product_id, $quantity)";
            $conn->query($sql_order_item);
        }

        // Clear the cart after placing the order
        $conn->query("DELETE FROM cart WHERE user_id = $user_id");

        // Redirect to the thank you page
        echo "Payment successful! Your order is being processed.";
        header("Location: thank_you.php");
        exit; // Stop further code execution after redirect
    } else {
        echo "Error placing order: " . $conn->error;
    }

    // Close the connection
    $conn->close();
}
?>
