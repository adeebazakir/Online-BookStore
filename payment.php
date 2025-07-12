<?php
session_start();

// Simulate successful payment and clear cart
$amount = $_POST['amount'] ?? 0;
unset($_SESSION['cart']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Payment Success</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: #f8fafc;
            font-family: 'Segoe UI', sans-serif;
        }
        .success-card {
            background: #ffffff;
            padding: 40px;
            border-radius: 16px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08);
            margin-top: 100px;
        }
        .success-icon {
            font-size: 4rem;
            color: #28a745;
        }
        .btn-primary {
            border-radius: 8px;
        }
    </style>
</head>
<body>
    <div class="container d-flex justify-content-center">
        <div class="success-card text-center">
            <div class="success-icon">✅</div>
            <h2 class="text-success mt-3">Payment Successful!</h2>
            <p class="lead">Thank you for your purchase. We hope you enjoy your books!</p>
            <h4>Total Paid: ₹<?= htmlspecialchars($amount) ?></h4>
            <a href="index.php" class="btn btn-primary mt-4">📚 Continue Shopping</a>
        </div>
    </div>
</body>
</html>
