<?php
session_start();

// Dummy credentials (replace with DB check in production)
$admin_username = "admin";
$admin_password = "admin123";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"] ?? '';
    $password = $_POST["password"] ?? '';

    if ($username === $admin_username && $password === $admin_password) {
        $_SESSION["admin_logged_in"] = true;
        header("Location: dashboard.php");
        exit();
    } else {
        $error = "❌ Invalid username or password.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .login-card {
            max-width: 420px;
            margin: 80px auto;
            padding: 30px;
            border-radius: 16px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
            background-color: #ffffff;
        }

        .form-label {
            font-weight: 500;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="login-card">
        <h3 class="mb-4 text-center">🔐 Admin Login</h3>

        <?php if (!empty($error)): ?>
            <div class="alert alert-danger text-center"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <form method="post" autocomplete="off">
            <!-- Hidden field to prevent autofill -->
            <input style="display:none" type="text" name="fakeusernameremembered">
            <input style="display:none" type="password" name="fakepasswordremembered">

            <div class="mb-3">
                <label class="form-label" for="username">Username</label>
                <input type="text" name="username" id="username" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label" for="password">Password</label>
                <input type="password" name="password" id="password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">🔓 Login</button>
        </form>
    </div>
</div>
</body>
</html>
