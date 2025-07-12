<?php
session_start();
if (!isset($_SESSION["admin_logged_in"])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8fafc;
            font-family: 'Segoe UI', sans-serif;
        }
        .dashboard-container {
            max-width: 600px;
            margin: 80px auto;
            padding: 40px;
            background: #ffffff;
            border-radius: 16px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.07);
        }
        h2 {
            font-weight: 600;
            color: #343a40;
            text-align: center;
            margin-bottom: 30px;
        }
        .list-group-item {
            font-size: 18px;
            padding: 15px 20px;
            border-radius: 10px;
            margin-bottom: 15px;
            transition: background 0.2s ease;
        }
        .list-group-item:hover {
            background-color: #f1f5f9;
        }
        .list-group-item-action.text-danger:hover {
            background-color: #ffe2e2;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="dashboard-container">
        <h2>📊 Admin Dashboard</h2>

        <div class="list-group">
            <a href="add_book.php" class="list-group-item list-group-item-action">➕ Add New Book</a>
            <a href="view_books.php" class="list-group-item list-group-item-action">📚 View All Books</a>
            <a href="logout.php" class="list-group-item list-group-item-action text-danger">🚪 Logout</a>
        </div>
    </div>
</div>

</body>
</html>
