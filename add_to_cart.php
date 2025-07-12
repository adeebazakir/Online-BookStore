<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize and validate inputs
    $book_id = (int) $_POST['book_id'];
    $title = htmlspecialchars(trim($_POST['title']));
    $price = (float) $_POST['price'];
    $quantity = (int) $_POST['quantity'];

    // Initialize cart if not already
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    // If book already in cart, update quantity
    if (isset($_SESSION['cart'][$book_id])) {
        $_SESSION['cart'][$book_id]['quantity'] += $quantity;
    } else {
        $_SESSION['cart'][$book_id] = [
            'title' => $title,
            'price' => $price,
            'quantity' => $quantity
        ];
    }

    // ✅ Set a success message
    $_SESSION['success'] = "✅ <strong>" . $title . "</strong> added to cart successfully!";

    // Redirect to avoid resubmission
    header("Location: cart.php");
    exit();
} else {
    // If accessed directly, redirect to homepage
    header("Location: index.php");
    exit();
}
?>
