<?php
// login.php - User Login
session_start();
require_once 'php/db_connect.php';
$msg = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($row = $result->fetch_assoc()) {
        if (password_verify($password, $row['password'])) {
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['role'] = $row['role'];
            header('Location: dashboard.php');
            exit;
        } else {
            $msg = 'Invalid password.';
        }
    } else {
        $msg = 'User not found.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login - Origin Driving School</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <header><h1>Login</h1></header>
    <nav>
        <a href="index.php">🏠 Home</a>
        <a href="login.php">🔐 Login</a>
        <a href="register.php">📝 Register</a>
        <a href="test_setup.php">🔧 Test Setup</a>
    </nav>
    <div class="container">
        <form method="post">
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" required>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" required>
            </div>
            <button class="btn" type="submit">🔐 Login</button>
        </form>
        <?php if($msg): ?>
        <div class="message error"><?php echo $msg; ?></div>
        <?php endif; ?>
        <div style="text-align: center; margin-top: 1.5rem;">
            <p>Don't have an account? <a href="register.php" style="color: var(--secondary-color); text-decoration: none; font-weight: 600;">Register here</a></p>
        </div>
    </div>
    <footer>&copy; 2025 Origin Driving School</footer>
</body>
</html>
