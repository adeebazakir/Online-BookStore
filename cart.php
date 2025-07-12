<?php
session_start();
$cart = $_SESSION['cart'] ?? [];
$total = 0;
?>
<!DOCTYPE html>
<html>
<head>
    <title>Your Cart</title>
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
        .btn-primary {
            background-color: #007bff;
        }
        .btn-success {
            background-color: #28a745;
        }
        .btn-danger {
            background-color: #dc3545;
        }
    </style>
</head>
<body>

<div class="container mt-5">

    <!-- ✅ Success Message -->
    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= $_SESSION['success']; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php unset($_SESSION['success']); ?>
    <?php endif; ?>

    <!-- ⚠️ Error Message -->
    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?= $_SESSION['error']; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <h2>🛒 Your Shopping Cart</h2>

    <?php if (!empty($cart)) { ?>
        <form action="update_cart.php" method="post">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>📚 Book</th>
                        <th>💰 Price</th>
                        <th>🔢 Quantity</th>
                        <th>💵 Subtotal</th>
                        <th>❌ Action</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($cart as $id => $item): 
                    $subtotal = $item['price'] * $item['quantity'];
                    $total += $subtotal;
                ?>
                    <tr>
                        <td><?= htmlspecialchars($item['title']) ?></td>
                        <td>₹<?= number_format($item['price'], 2) ?></td>
                        <td style="max-width: 90px;">
                            <input type="number" name="quantities[<?= $id ?>]" value="<?= $item['quantity'] ?>" min="1" class="form-control">
                        </td>
                        <td>₹<?= number_format($subtotal, 2) ?></td>
                        <td>
                            <a href="remove_from_cart.php?id=<?= $id ?>" class="btn btn-danger btn-sm">Remove</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>

            <div class="d-flex justify-content-between align-items-center mt-4">
                <h4>Total: ₹<?= number_format($total, 2) ?></h4>
                <div>
                    <button type="submit" class="btn btn-primary me-2">🔁 Update Quantities</button>
                    <a href="checkout.php" class="btn btn-success me-2">✅ Proceed to Checkout</a>
                    <a href="index.php" class="btn btn-secondary">➕ Add More Books</a>
                </div>
            </div>
        </form>
    <?php } else { ?>
        <div class="alert alert-info">
            <p>Your cart is empty.</p>
        </div>
        <a href="index.php" class="btn btn-primary">📚 Browse Books</a>
    <?php } ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
