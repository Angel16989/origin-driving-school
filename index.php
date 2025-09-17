<?php
// index.php - Home Page
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Origin Driving School</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <header>
        <h1>Origin Driving School Online Management System</h1>
    </header>
    <nav>
        <a href="index.php">Home</a>
        <a href="login.php">Login</a>
        <a href="register.php">Register</a>
        <a href="dashboard.php">Dashboard</a>
    </nav>
    <div class="container">
        <h2>Welcome!</h2>
        <p>This is a demo management system for Origin Driving School. Please login or register to continue.</p>
        <ul>
            <li>Student & Instructor Management</li>
            <li>Booking System</li>
            <li>Invoices & Payments</li>
            <li>Messaging & Notifications</li>
        </ul>
    </div>
    <footer>
        &copy; 2025 Origin Driving School
    </footer>
</body>
</html>
