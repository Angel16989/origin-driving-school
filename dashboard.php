<?php
// dashboard.php - Main Dashboard
session_start();
require_once 'php/db_connect.php';
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}
// Statistics
$stats = [
    'students' => 0,
    'instructors' => 0,
    'bookings' => 0,
    'revenue' => 0.00
];
$res = $conn->query('SELECT COUNT(*) AS cnt FROM students');
$stats['students'] = $res->fetch_assoc()['cnt'];
$res = $conn->query('SELECT COUNT(*) AS cnt FROM instructors');
$stats['instructors'] = $res->fetch_assoc()['cnt'];
$res = $conn->query('SELECT COUNT(*) AS cnt FROM bookings');
$stats['bookings'] = $res->fetch_assoc()['cnt'];
$res = $conn->query('SELECT SUM(amount) AS total FROM invoices WHERE status = "Paid"');
$row = $res->fetch_assoc();
$stats['revenue'] = $row['total'] ? $row['total'] : 0.00;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - Origin Driving School</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <header><h1>Dashboard</h1></header>
    <nav>
        <a href="index.php">Home</a>
        <a href="dashboard.php">Dashboard</a>
        <a href="php/students.php">Students</a>
        <a href="php/instructors.php">Instructors</a>
        <a href="php/bookings.php">Bookings</a>
        <a href="php/invoices.php">Invoices</a>
        <a href="php/messages.php">Messages</a>
        <a href="php/logout.php">Logout</a>
    </nav>
    <div class="container">
        <h2>Dashboard Overview</h2>
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-number"><?php echo $stats['students']; ?></div>
                <div class="stat-label">Students</div>
            </div>
            <div class="stat-card">
                <div class="stat-number"><?php echo $stats['instructors']; ?></div>
                <div class="stat-label">Instructors</div>
            </div>
            <div class="stat-card">
                <div class="stat-number"><?php echo $stats['bookings']; ?></div>
                <div class="stat-label">Bookings</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">$<?php echo number_format($stats['revenue'],0); ?></div>
                <div class="stat-label">Revenue</div>
            </div>
        </div>
        <h3>Quick Navigation</h3>
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem; margin-top: 2rem;">
            <a href="php/students.php" class="btn">👥 Manage Students</a>
            <a href="php/instructors.php" class="btn">👨‍🏫 Manage Instructors</a>
            <a href="php/bookings.php" class="btn">📅 Manage Bookings</a>
            <a href="php/invoices.php" class="btn btn-success">💰 Manage Invoices</a>
            <a href="php/messages.php" class="btn">💬 Messages</a>
        </div>
    </div>
    <footer>&copy; 2025 Origin Driving School</footer>
</body>
</html>
