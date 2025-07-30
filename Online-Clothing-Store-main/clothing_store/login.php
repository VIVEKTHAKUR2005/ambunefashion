<?php
// login.php
include 'db.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Admin login check (hardcoded credentials for admin)
    if ($email == "admin@admin.com" && $password == "admin123") {
        $_SESSION['admin'] = true;
        header("Location: admin_dashboard.php");  // Redirect to admin dashboard
        exit;  // Stop further execution, as we don't want to check for normal users if it's admin
    }

    // Check if the user exists in the database (for normal users)
    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        
        // Verify the password for normal users
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['user_id'];  // Store the user_id in session
            $_SESSION['username'] = $user['username'];  // Store username in session
            header("Location: index.html");  // Redirect to the homepage
            exit;  // Stop further execution
        } else {
            echo "Invalid email or password.";
        }
    } else {
        echo "No user found with this email.";
    }
    $conn->close();
}
?>
