<?php
$host = '127.0.0.1';  // Using '127.0.0.1' instead of 'localhost'
$user = 'root';        // Default user in XAMPP
$pass = '';            // Default empty password in XAMPP
$dbname = 'clothing_store';  // Your database name
$port = 3306;          // Default MySQL port

// Enable error reporting for debugging during development
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {
    // Create connection using OOP style
    $conn = new mysqli($host, $user, $pass, $dbname, $port);
    
    // Set charset to ensure proper encoding
    $conn->set_charset("utf8mb4");

} catch (mysqli_sql_exception $e) {
    // Catch and display error message in a controlled manner
    die("Database connection failed: " . $e->getMessage());
}
?>