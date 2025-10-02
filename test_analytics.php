<?php
// test_analytics.php - Temporary analytics test without login
require_once 'php/db_connect.php';

// Simulate admin session
$_SESSION['user_id'] = 1;
$_SESSION['role'] = 'admin';
$_SESSION['name'] = 'Test Admin';

echo "🔄 Redirecting to analytics with admin session...<br>";
echo "<a href='php/analytics.php'>Click here to view Analytics Dashboard</a><br><br>";

echo "Or try these links:<br>";
echo "📊 <a href='php/analytics.php'>Direct Analytics Link</a><br>";
echo "🏠 <a href='dashboard.php'>Dashboard</a><br>";
echo "👤 <a href='login.php'>Login Page</a><br>";

// Also show current user session
echo "<br>Current Session:<br>";
echo "User ID: " . ($_SESSION['user_id'] ?? 'Not set') . "<br>";
echo "Role: " . ($_SESSION['role'] ?? 'Not set') . "<br>";
echo "Name: " . ($_SESSION['name'] ?? 'Not set') . "<br>";

// Test database connection
echo "<br>Database Test:<br>";
$test_query = $conn->query("SELECT COUNT(*) as count FROM students");
if ($test_query) {
    $count = $test_query->fetch_assoc()['count'];
    echo "✅ Database connected - {$count} students found<br>";
} else {
    echo "❌ Database error: " . $conn->error . "<br>";
}
?>