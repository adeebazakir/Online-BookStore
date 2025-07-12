<?php
session_start();
if (!isset($_SESSION["admin_logged_in"])) {
    header("Location: login.php");
    exit();
}

include '../includes/db.php';

// Handle delete
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];

    // Get image name to delete file
    $stmt = $conn->prepare("SELECT image FROM books WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    if ($row) {
        $imagePath = '../assets/images/' . $row['image'];
        if (file_exists($imagePath)) {
            unlink($imagePath); // Delete image file
        }

        $delStmt = $conn->prepare("DELETE FROM books WHERE id = ?");
        $delStmt->bind_param("i", $id);
        $delStmt->execute();
    }

    header("Location: view_books.php");
    exit();
}

$books = $conn->query("SELECT * FROM books");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Books</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .table-wrapper {
            overflow-x: auto;
        }

        img.book-cover {
            width: 80px;
            height: auto;
            object-fit: cover;
            border-radius: 4px;
        }

        .btn-sm {
            margin-right: 5px;
        }
    </style>
</head>
<body>
<div class="container mt-5">
    <h2 class="mb-4">📚 All Books</h2>
    <a href="dashboard.php" class="btn btn-secondary mb-3">← Back to Dashboard</a>

    <div class="table-wrapper">
        <table class="table table-bordered table-striped">
            <thead class="table-light">
                <tr>
                    <th>Cover</th>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Price (₹)</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($books->num_rows > 0): ?>
                    <?php while ($row = $books->fetch_assoc()): ?>
                        <tr>
                            <td>
                                <?php
                                    $imgPath = "../assets/images/" . $row['image'];
                                    if (file_exists($imgPath) && !empty($row['image'])) {
                                        echo "<img src='$imgPath' class='book-cover'>";
                                    } else {
                                        echo "<span class='text-muted'>No Image</span>";
                                    }
                                ?>
                            </td>
                            <td><?= htmlspecialchars($row['title']) ?></td>
                            <td><?= htmlspecialchars($row['description']) ?></td>
                            <td>₹<?= number_format($row['price'], 2) ?></td>
                            <td>
                                <a href="edit_book.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-primary">✏️ Edit</a>
                                <a href="view_books.php?delete=<?= $row['id'] ?>" class="btn btn-sm btn-danger"
                                   onclick="return confirm('Are you sure you want to delete this book?');">🗑️ Delete</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="text-center text-muted">No books available. Add one from the dashboard.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
</body>
</html>
