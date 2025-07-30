<?php
// Simulated payment processing (no real gateway logic here)

// You can log the data, validate it, or simulate a delay if needed
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Normally you’d validate and save order here

    // Simulate order saved
    header("Location: thank_you.php");
    exit();
} else {
    echo "Invalid access.";
}
?>
