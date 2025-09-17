<?php
// register.php - Student Registration
require_once 'php/db_connect.php';
$msg = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $license_no = $_POST['license_no'];
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    // Check if username exists
    $stmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
        $msg = 'Username already exists.';
    } else {
        // Insert into students
        $stmt = $conn->prepare("INSERT INTO students (name, email, phone, license_no, progress) VALUES (?, ?, ?, ?, 'Registered')");
        $stmt->bind_param('ssss', $name, $email, $phone, $license_no);
        $stmt->execute();
        $student_id = $stmt->insert_id;
        // Insert into users
        $stmt = $conn->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, 'student')");
        $stmt->bind_param('ss', $username, $password);
        $stmt->execute();
        $msg = 'Registration successful! You can now login.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register - Origin Driving School</title>
    <link rel="stylesheet" href="css/styles.css">
    <script src="js/scripts.js"></script>
</head>
<body>
    <header><h1>Student Registration</h1></header>
    <nav>
        <a href="index.php">🏠 Home</a>
        <a href="login.php">🔐 Login</a>
        <a href="register.php">📝 Register</a>
        <a href="test_setup.php">🔧 Test Setup</a>
    </nav>
    <div class="container">
        <form method="post" onsubmit="return validateRegistrationForm();">
            <div class="form-group">
                <label>Name</label>
                <input type="text" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label>Phone</label>
                <input type="text" id="phone" name="phone" required>
            </div>
            <div class="form-group">
                <label>License No</label>
                <input type="text" id="license_no" name="license_no" required>
            </div>
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" required>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" required>
            </div>
            <button class="btn" type="submit">📝 Register</button>
        </form>
        <?php if($msg): ?>
        <div class="message <?php echo (strpos($msg, 'successful') !== false) ? 'success' : 'error'; ?>"><?php echo $msg; ?></div>
        <?php endif; ?>
        <div style="text-align: center; margin-top: 1.5rem;">
            <p>Already have an account? <a href="login.php" style="color: var(--secondary-color); text-decoration: none; font-weight: 600;">Login here</a></p>
        </div>
    </div>
    <footer>&copy; 2025 Origin Driving School</footer>
</body>
</html>
