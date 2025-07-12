<?php
session_start();
if (!isset($_SESSION["admin_logged_in"])) {
    header("Location: login.php");
    exit();
}

include '../includes/db.php';

$success = $error = '';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $title = $_POST["title"];
    $description = $_POST["description"];
    $price = $_POST["price"];

    $image = $_FILES["image"]["name"];
    $image_tmp = $_FILES["image"]["tmp_name"];
    $target_dir = "../assets/images/" . basename($image);

    if (move_uploaded_file($image_tmp, $target_dir)) {
        $stmt = $conn->prepare("INSERT INTO books (title, description, price, image) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssds", $title, $description, $price, $image);

        if ($stmt->execute()) {
            $success = "✅ Book added successfully!";
        } else {
            $error = "❌ Error inserting into database.";
        }
    } else {
        $error = "❌ Failed to upload image.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add New Book</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: #f1f5f9;
            font-family: 'Segoe UI', sans-serif;
        }
        .form-container {
            background: #fff;
            padding: 40px;
            border-radius: 16px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08);
            max-width: 700px;
            margin: 60px auto;
        }
        h2 {
            font-weight: 600;
            color: #333;
        }
        label {
            font-weight: 500;
        }
        .btn-success {
            border-radius: 8px;
        }
        .btn-secondary {
            border-radius: 8px;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="form-container">
        <h2 class="mb-4 text-center">📚 Add New Book</h2>

        <?php if ($success): ?>
            <div class="alert alert-success text-center"><?= $success ?></div>
        <?php endif; ?>
        <?php if ($error): ?>
            <div class="alert alert-danger text-center"><?= $error ?></div>
        <?php endif; ?>

        <form method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label class="form-label">Title:</label>
                <input type="text" name="title" class="form-control" placeholder="Enter book title" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Description:</label>
                <textarea name="description" class="form-control" rows="3" placeholder="Short description..." required></textarea>
            </div>
            <div class="mb-3">
                <label class="form-label">Price (₹):</label>
                <input type="number" name="price" step="0.01" class="form-control" placeholder="e.g. 399.00" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Upload Image:</label>
                <input type="file" name="image" class="form-control" accept="image/*" required>
            </div>
            <div class="d-flex justify-content-between">
                <button type="submit" class="btn btn-success">➕ Add Book</button>
                <a href="dashboard.php" class="btn btn-secondary">← Back to Dashboard</a>
            </div>
        </form>
    </div>
</div>
</body>
</html>
