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
        <h2>🚗 Welcome to Origin Driving School!</h2>
        <p style="font-size: 1.2rem; text-align: center; margin-bottom: 2rem; color: var(--text-dark);">
            Your premier destination for professional driving instruction and management.
        </p>
        
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 2rem; margin: 2rem 0;">
            <div style="text-align: center; padding: 2rem; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border-radius: 15px; box-shadow: 0 8px 30px rgba(102, 126, 234, 0.3);">
                <h3>👥 Student Management</h3>
                <p>Complete student profile management with progress tracking and licensing information.</p>
            </div>
            <div style="text-align: center; padding: 2rem; background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); color: white; border-radius: 15px; box-shadow: 0 8px 30px rgba(240, 147, 251, 0.3);">
                <h3>👨‍🏫 Instructor Management</h3>
                <p>Manage qualified instructors, schedules, and branch assignments efficiently.</p>
            </div>
            <div style="text-align: center; padding: 2rem; background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); color: white; border-radius: 15px; box-shadow: 0 8px 30px rgba(79, 172, 254, 0.3);">
                <h3>📅 Booking System</h3>
                <p>Advanced booking system with calendar integration and double-booking prevention.</p>
            </div>
            <div style="text-align: center; padding: 2rem; background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%); color: white; border-radius: 15px; box-shadow: 0 8px 30px rgba(67, 233, 123, 0.3);">
                <h3>💰 Financial Management</h3>
                <p>Complete invoice and payment tracking with comprehensive financial reporting.</p>
            </div>
        </div>

        <div style="text-align: center; margin-top: 3rem;">
            <a href="login.php" class="btn" style="font-size: 1.2rem; padding: 1rem 2.5rem; margin: 0.5rem;">🔐 Login to System</a>
            <a href="register.php" class="btn" style="font-size: 1.2rem; padding: 1rem 2.5rem; margin: 0.5rem;">📝 Register as Student</a>
        </div>
    </div>
    <footer>
        &copy; 2025 Origin Driving School
    </footer>
</body>
</html>
