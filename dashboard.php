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
        <h2>Statistics</h2>
        <ul>
            <li>Total Students: <?php echo $stats['students']; ?></li>
            <li>Total Instructors: <?php echo $stats['instructors']; ?></li>
            <li>Total Bookings: <?php echo $stats['bookings']; ?></li>
            <li>Total Revenue: $<?php echo number_format($stats['revenue'],2); ?></li>
        </ul>
        <h3>Quick Links</h3>
        <ul>
            <li><a href="php/students.php">Manage Students</a></li>
            <li><a href="php/instructors.php">Manage Instructors</a></li>
            <li><a href="php/bookings.php">Manage Bookings</a></li>
            <li><a href="php/invoices.php">Manage Invoices</a></li>
            <li><a href="php/messages.php">Messages</a></li>
        </ul>
    </div>
    <footer>&copy; 2025 Origin Driving School</footer>
</body>
</html>
