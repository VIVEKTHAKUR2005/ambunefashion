<?php
include 'db.php';

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$search = isset($_GET['query']) ? mysqli_real_escape_string($conn, $_GET['query']) : "";

$sql = "SELECT * FROM products WHERE product_name LIKE '%$search%'";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
  <title>Search Results - Ambune Fashion</title>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <style>
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        background-color: #f8f8f8;
    }

    header {
        background-color: #000;
        color: white;
        padding: 20px 30px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
    }

    header h1 {
        margin: 0;
        font-size: 1.5em;
        flex: 1 1 100%;
    }

    .nav-buttons {
        margin-top: 10px;
    }

    .nav-buttons a {
        color: white;
        text-decoration: none;
        margin-left: 10px;
        font-weight: bold;
        background-color: #333;
        padding: 8px 16px;
        border-radius: 5px;
        transition: background-color 0.3s;
    }

    .nav-buttons a:hover {
        background-color: #555;
    }

    .search-bar {
        margin-top: 10px;
        display: flex;
        align-items: center;
    }

    .search-bar input[type="text"] {
        padding: 8px;
        font-size: 16px;
        border: none;
        border-radius: 5px 0 0 5px;
        width: 200px;
    }

    .search-bar button {
        padding: 8px 12px;
        font-size: 16px;
        background-color: #333;
        color: white;
        border: none;
        border-radius: 0 5px 5px 0;
        cursor: pointer;
    }

    .container {
        padding: 40px;
        max-width: 1200px;
        margin: 0 auto;
    }

    h2 {
        margin-bottom: 20px;
    }

    .product {
        border: 1px solid #ddd;
        padding: 15px;
        margin: 15px;
        background-color: white;
        display: inline-block;
        width: 220px;
        vertical-align: top;
        border-radius: 10px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }

    .product img {
        width: 100%;
        height: auto;
        border-radius: 6px;
    }

    .product h2 {
        font-size: 1.1em;
        margin: 10px 0 5px;
    }

    .product p {
        font-size: 1em;
        color: #444;
    }

    .product form {
        margin-top: 10px;
    }

    .product input[type="submit"] {
        background-color: #000;
        color: white;
        padding: 8px 12px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-weight: bold;
        transition: background-color 0.3s;
    }

    .product input[type="submit"]:hover {
        background-color: #333355;
    }

    footer {
        background-color: #000;
        color: white;
        padding: 15px;
        text-align: center;
        position: fixed;
        bottom: 0;
        width: 100%;
    }
  </style>
</head>
<body>

  <header>
    <h1>Search Results for "<?php echo htmlspecialchars($search); ?>"</h1>
    <div class="search-bar">
      <form method="GET" action="search.php">
        <input type="text" name="query" placeholder="Search..." value="<?php echo htmlspecialchars($search); ?>" />
        <button type="submit"><i class="fas fa-search"></i></button>
      </form>
    </div>
    <div class="nav-buttons">
        <a href="index.html">Home</a>
        <a href="cart.php">Cart</a>
    </div>
  </header>

  <div class="container">
  <?php
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo '<div class="product">';
            
            $imagePath =$row['product_image'];
            if (!file_exists($imagePath) || empty($row['product_image'])) {
                $imagePath = 'images/default.png';
            }

            echo '<img src="' . htmlspecialchars($imagePath) . '" alt="' . htmlspecialchars($row['product_name']) . '" />';
            echo '<h2>' . htmlspecialchars($row['product_name']) . '</h2>';
            echo '<p>₹' . htmlspecialchars($row['product_price']) . '</p>';
            echo '<form method="POST" action="add_to_cart.php">';
            echo '<input type="hidden" name="product_id" value="' . htmlspecialchars($row['product_id']) . '" />';
            echo '<input type="submit" value="Add to Cart" />';
            echo '</form>';
            echo '</div>';
        }
    } else {
        echo "<p>No results found.</p>";
    }
    $conn->close();
  ?>
  </div>

  <footer>
    <p>&copy; 2025 Ambune Fashion. All rights reserved.</p>
  </footer>

</body>
</html>
