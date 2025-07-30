<?php
include 'db.php';
session_start();
$user_id = 1; // Static for now

// Handle updates and removals
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['update_quantity'])) {
        $product_id = $_POST['product_id'];
        $new_quantity = $_POST['quantity'];
        $stmt = $conn->prepare("UPDATE cart SET quantity = ? WHERE product_id = ? AND user_id = ?");
        $stmt->bind_param("iii", $new_quantity, $product_id, $user_id);
        $stmt->execute();
        $stmt->close();
    } elseif (isset($_POST['remove_item'])) {
        $product_id = $_POST['product_id'];
        $stmt = $conn->prepare("DELETE FROM cart WHERE product_id = ? AND user_id = ?");
        $stmt->bind_param("ii", $product_id, $user_id);
        $stmt->execute();
        $stmt->close();
    }
}

// Fetch cart items
$stmt = $conn->prepare("SELECT p.product_id, p.product_name, p.product_price, c.quantity FROM products p JOIN cart c ON p.product_id = c.product_id WHERE c.user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$cart_items = [];
$total_price = 0;

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $row['total'] = $row['product_price'] * $row['quantity'];
        $total_price += $row['total'];
        $cart_items[] = $row;
    }
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Your Cart - Ambune Fashion</title>
    <link rel="stylesheet" href="css/styles.css" />
    <style>
        /* Custom Styling */
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
        }

        header {
            background-color: #333;
            color: white;
            padding: 20px 0;
            text-align: center;
        }

        header h1 {
            margin: 0;
            font-size: 2em;
        }

        nav a {
            color: white;
            margin: 0 15px;
            text-decoration: none;
        }

        nav a:hover {
            text-decoration: underline;
        }

        main {
            padding: 40px;
            background-color: white;
            box-shadow: 0px 2px 10px rgba(0, 0, 0, 0.1);
            margin: 30px auto;
            max-width: 1200px;
            border-radius: 8px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 15px;
            text-align: center;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f0f0f0;
        }

        .total {
            text-align: right;
            margin-top: 20px;
            font-size: 1.2em;
            font-weight: bold;
            color: #333;
        }

        .empty-message {
            margin-top: 40px;
            font-size: 1.1em;
            text-align: center;
        }

        .cart-actions button {
            background-color: #5cb85c;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .cart-actions button:hover {
            background-color: #4cae4c;
        }

        .cart-actions button:active {
            background-color: #398439;
        }

        .cart-actions input {
            padding: 5px 10px;
            width: 50px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .proceed-btn-container {
            text-align: center;
            margin-top: 30px;
        }

        .proceed-btn {
            background-color: #000;
            color: white;
            padding: 12px 30px;
            text-decoration: none;
            font-size: 16px;
            font-weight: bold;
            border-radius: 8px;
            display: inline-block;
            transition: background-color 0.3s, transform 0.2s;
        }

        .proceed-btn:hover {
            background-color: #333355;
            transform: translateY(-2px);
        }

        .proceed-btn:active {
            transform: scale(0.98);
        }

        footer {
            background-color: #333;
            color: white;
            padding: 10px;
            text-align: center;
            position: fixed;
            bottom: 0;
            width: 100%;
        }
    </style>
</head>
<body>
    <header>
        <h1>Your Cart</h1>
        <nav>
            <a href="index.html">Home</a>
        </nav>
    </header>

    <main>
        <?php if (!empty($cart_items)): ?>
            <form method="POST">
                <table>
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Price (₹)</th>
                            <th>Quantity</th>
                            <th>Total (₹)</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($cart_items as $item): ?>
                            <tr>
                            <form method="POST">
                                <td><?= htmlspecialchars($item['product_name']) ?></td>
                                <td><?= htmlspecialchars($item['product_price']) ?></td>
                                <td>
                                    <input type="number" name="quantity" value="<?= htmlspecialchars($item['quantity']) ?>" min="1" />
                                    <input type="hidden" name="product_id" value="<?= $item['product_id'] ?>" />
                                </td>
                                <td><?= htmlspecialchars($item['total']) ?></td>
                                <td class="cart-actions">
                                    <button type="submit" name="update_quantity">Add</button>
                                    <button type="submit" name="remove_item">Remove</button>
                                </td>
                                </form>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <div class="total">Grand Total: ₹<?= $total_price ?></div>
            </form>
            <div class="proceed-btn-container">
                <a href="payment.php?total=<?= $total_price ?>" class="proceed-btn">Proceed to Pay</a>
            </div>
        <?php else: ?>
            <div class="empty-message">Your cart is empty.</div>
        <?php endif; ?>
    </main>

    <footer>
        <p>&copy; 2025 Ambune Fashion. All rights reserved.</p>
    </footer>
</body>
</html>
