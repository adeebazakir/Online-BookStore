<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['quantities'])) {
    foreach ($_POST['quantities'] as $id => $qty) {
        $id = intval($id);
        $qty = intval($qty);
        if (isset($_SESSION['cart'][$id]) && $qty > 0) {
            $_SESSION['cart'][$id]['quantity'] = $qty;
        }
    }
    $_SESSION['success'] = "✅ Cart updated successfully!";
} else {
    $_SESSION['error'] = "⚠️ Nothing to update.";
}

header("Location: cart.php");
exit();
