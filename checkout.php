<?php
session_start();

// Restrict access if user is not logged in
if (!isset($_SESSION['user'])) {
    $_SESSION['error'] = "Please login to proceed to checkout.";
    header("Location: login.php");
    exit();
}

$cart = $_SESSION['cart'] ?? [];
$total = 0;
?>
<!DOCTYPE html>
<html>
<head>
    <title>Checkout</title>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f9f9fb;
            font-family: 'Segoe UI', sans-serif;
        }
        .container {
            background: #fff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.06);
        }
        h2 {
            color: #333;
            font-weight: 600;
            margin-bottom: 30px;
        }
        table {
            background: #fff;
        }
        th {
            background-color: #f0f0f0;
        }
        td, th {
            vertical-align: middle;
        }
        .btn {
            border-radius: 8px;
        }
        .btn-success {
            background-color: #28a745;
        }
    </style>
</head>
<body>
<div class="container mt-5">
    <h2>🧾 Checkout</h2>

    <?php if (!empty($cart)) { ?>
        <table class="table table-bordered align-middle">
            <thead class="table-light">
                <tr>
                    <th>📚 Book</th>
                    <th>💰 Price</th>
                    <th>🔢 Quantity</th>
                    <th>💵 Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($cart as $item): 
                    $subtotal = $item['price'] * $item['quantity'];
                    $total += $subtotal;
                ?>
                    <tr>
                        <td><?= htmlspecialchars($item['title']) ?></td>
                        <td>₹<?= number_format($item['price'], 2) ?></td>
                        <td><?= intval($item['quantity']) ?></td>
                        <td>₹<?= number_format($subtotal, 2) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <h4 class="mt-4">🧮 Total Amount: ₹<?= number_format($total, 2) ?></h4>

        <form action="payment.php" method="post" class="mt-4">
            <input type="hidden" name="amount" value="<?= $total ?>">
            <button type="submit" class="btn btn-success">💳 Proceed to Dummy Payment</button>
        </form>
    <?php } else { ?>
        <div class="alert alert-info">Your cart is empty.</div>
        <a href="index.php" class="btn btn-primary mt-3">📚 Continue Shopping</a>
    <?php } ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
