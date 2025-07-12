<?php 
session_start();
include 'includes/db.php'; 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Online Bookstore</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', sans-serif;
        }
        .navbar-placeholder {
            background-color: #fff;
            padding: 15px 30px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
            border-radius: 0 0 10px 10px;
        }
        .card {
            box-shadow: 0 0 10px rgba(0,0,0,0.08);
            transition: transform 0.2s;
        }
        .card:hover {
            transform: scale(1.02);
        }
        h2 {
            font-weight: 600;
            color: #333;
        }
    </style>
</head>
<body>

<!-- 🔒 LOGIN/LOGOUT STATUS SECTION -->
<div class="navbar-placeholder d-flex justify-content-end align-items-center">
    <?php if (isset($_SESSION['user'])): ?>
        <span class="me-3">👋 Welcome, <strong><?= htmlspecialchars($_SESSION['user']['name']) ?></strong></span>
        <a href="logout.php" class="btn btn-outline-danger">Logout</a>
    <?php else: ?>
        <a href="login.php" class="btn btn-outline-primary me-2">Login</a>
        <a href="signup.php" class="btn btn-outline-success">Sign Up</a>
    <?php endif; ?>
</div>

<!-- 📚 Book Listings Section -->
<div class="container mt-5">
    <h2 class="text-center mb-4">📖 Available Books</h2>
    <div class="row">
        <?php
        $sql = "SELECT * FROM books";
        $result = $conn->query($sql);

        while ($row = $result->fetch_assoc()) {
            echo '
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <img src="assets/images/' . $row["image"] . '" class="card-img-top" style="height: 300px; object-fit: cover;">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">' . $row["title"] . '</h5>
                        <p class="card-text small">' . $row["description"] . '</p>
                        <p class="text-success fw-bold">₹' . number_format($row["price"], 2) . '</p>
                        <form method="post" action="add_to_cart.php" class="mt-auto">
                            <input type="hidden" name="book_id" value="' . $row['id'] . '">
                            <input type="hidden" name="title" value="' . htmlspecialchars($row['title']) . '">
                            <input type="hidden" name="price" value="' . $row['price'] . '">
                            <input type="hidden" name="quantity" value="1">
                            <button type="submit" class="btn btn-primary w-100">➕ Add to Cart</button>
                        </form>
                    </div>
                </div>
            </div>';
        }
        ?>
    </div>

    <!-- 🛒 View Cart Button -->
    <div class="text-end mt-4">
        <a href="cart.php" class="btn btn-success btn-lg">🛒 View Cart</a>
    </div>
</div>

</body>
</html>
