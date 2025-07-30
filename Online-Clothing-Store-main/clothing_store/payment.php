<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Checkout - Ambune Fashion</title>
  <link rel="stylesheet" href="css/styles.css" />
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      margin: 0;
      background: #f8f8f8;
      color: #333;
    }
    header {
      background: #1e1e2f;
      color: #fff;
      padding: 20px;
      text-align: center;
      font-size: 1.5em;
    }
    .checkout-container {
      max-width: 500px;
      margin: 50px auto;
      background: #fff;
      padding: 30px;
      border-radius: 12px;
      box-shadow: 0 4px 16px rgba(0,0,0,0.1);
    }
    h2 {
      margin-bottom: 20px;
      color: #1e1e2f;
    }
    label {
      display: block;
      margin-top: 15px;
      font-weight: bold;
    }
    input[type="text"],
    input[type="number"],
    input[type="email"] {
      width: 100%;
      padding: 10px;
      margin-top: 5px;
      border: 1px solid #ccc;
      border-radius: 6px;
      font-size: 1em;
    }
    button {
      margin-top: 30px;
      width: 100%;
      background-color: #1e1e2f;
      color: white;
      padding: 12px;
      border: none;
      border-radius: 6px;
      font-size: 1.1em;
      font-weight: bold;
      cursor: pointer;
      transition: background-color 0.3s;
    }
    button:hover {
      background-color: #ffcc00;
      color: #1e1e2f;
    }
    .note {
      text-align: center;
      margin-top: 15px;
      font-size: 0.9em;
      color: #777;
    }
    footer {
      background: #1e1e2f;
      color: #fff;
      text-align: center;
      padding: 20px;
      margin-top: 40px;
    }
  </style>
</head>
<body>

<header>Ambune Fashion - Checkout</header>

<div class="checkout-container">
  <h2>Billing & Payment</h2>
  <form action="process_payment.php" method="POST">
    <label for="name">Full Name</label>
    <input type="text" id="name" name="name" required />

    <label for="email">Email Address</label>
    <input type="email" id="email" name="email" required />

    <label for="address">Shipping Address</label>
    <input type="text" id="address" name="address" required />

    <label for="card">Card Number</label>
    <input type="text" id="card" name="card_number" maxlength="16" placeholder="1234 5678 9012 3456" required />

    <label for="exp">Expiry Date</label>
    <input type="text" id="exp" name="expiry" placeholder="MM/YY" required />

    <label for="cvv">CVV</label>
    <input type="number" id="cvv" name="cvv" maxlength="3" required />

    <button type="submit">Pay Now</button>
  </form>
  <div class="note">This is a demo checkout. No real transactions will occur.</div>
</div>

<footer>&copy; 2025 Ambune Fashion. All rights reserved.</footer>

</body>
</html>
