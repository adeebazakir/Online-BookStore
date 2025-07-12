<?php
session_start();
if (!isset($_SESSION["admin_logged_in"])) {
    header("Location: login.php");
    exit();
}

include '../includes/db.php';

$id = $_GET['id'] ?? null;
if (!$id || !is_numeric($id)) {
    header("Location: view_books.php");
    exit();
}

// Fetch book
$stmt = $conn->prepare("SELECT * FROM books WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$book = $result->fetch_assoc();

if (!$book) {
    header("Location: view_books.php");
    exit();
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $title = trim($_POST["title"]);
    $description = trim($_POST["description"]);
    $price = floatval($_POST["price"]);

    if (!empty($_FILES["image"]["name"])) {
        $image = basename($_FILES["image"]["name"]);
        $temp = $_FILES["image"]["tmp_name"];
        $uploadPath = "../assets/images/" . $image;

        if (move_uploaded_file($temp, $uploadPath)) {
            // Delete old image
            if (!empty($book['image']) && file_exists("../assets/images/" . $book['image'])) {
                unlink("../assets/images/" . $book['image']);
            }

            $update = $conn->prepare("UPDATE books SET title=?, description=?, price=?, image=? WHERE id=?");
            $update->bind_param("ssdsi", $title, $description, $price, $image, $id);
        } else {
            die("Image upload failed.");
        }
    } else {
        $update = $conn->prepare("UPDATE books SET title=?, description=?, price=? WHERE id=?");
        $update->bind_param("ssdi", $title, $description, $price, $id);
    }

    if ($update->execute()) {
        header("Location: view_books.php");
        exit();
    } else {
        die("Error updating book.");
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Book</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f9fafb;
        }
        .form-container {
            max-width: 700px;
            margin: 50px auto;
            background: white;
            padding: 30px;
            border-radius: 16px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
        }
        img.preview {
            border-radius: 10px;
            max-height: 150px;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="form-container">
        <h2 class="mb-4">✏️ Edit Book</h2>
        <a href="view_books.php" class="btn btn-secondary mb-4">← Back</a>

        <form method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label class="form-label">Title:</label>
                <input type="text" name="title" class="form-control" value="<?= htmlspecialchars($book['title']) ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Description:</label>
                <textarea name="description" class="form-control" rows="3" required><?= htmlspecialchars($book['description']) ?></textarea>
            </div>
            <div class="mb-3">
                <label class="form-label">Price (₹):</label>
                <input type="number" name="price" step="0.01" class="form-control" value="<?= $book['price'] ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Current Image:</label><br>
                <img src="../assets/images/<?= htmlspecialchars($book['image']) ?>" class="preview" alt="Book Image"><br><br>

                <label class="form-label">Change Image (optional):</label>
                <input type="file" name="image" class="form-control" accept="image/*">
            </div>
            <button type="submit" class="btn btn-primary">💾 Update Book</button>
        </form>
    </div>
</div>

</body>
</html>
