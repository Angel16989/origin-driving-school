<?php
// debug_analytics_data.php - Check what data analytics should be showing
require_once 'php/db_connect.php';

echo "<h2>🔍 Analytics Data Debug</h2>";

// Check current date range (what analytics.php uses)
$date_from = date('Y-m-01'); // First day of current month
$date_to = date('Y-m-d'); // Today

echo "<p><strong>Date Range:</strong> {$date_from} to {$date_to}</p>";

// Check revenue data
echo "<h3>💰 Revenue Data</h3>";
$revenue_query = "SELECT 
    DATE(paid_at) as date,
    SUM(amount) as daily_revenue,
    COUNT(*) as transactions
FROM payments 
WHERE paid_at BETWEEN '$date_from' AND '$date_to'
GROUP BY DATE(paid_at)
ORDER BY date ASC";

$result = $conn->query($revenue_query);
if ($result && $result->num_rows > 0) {
    echo "<table border='1' style='border-collapse: collapse; width: 100%;'>";
    echo "<tr><th>Date</th><th>Revenue</th><th>Transactions</th></tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr><td>{$row['date']}</td><td>$" . number_format($row['daily_revenue'], 2) . "</td><td>{$row['transactions']}</td></tr>";
    }
    echo "</table>";
} else {
    echo "<p>❌ No revenue data found for current month</p>";
}

// Check ALL revenue data
echo "<h3>💵 ALL Revenue Data (Last 12 months)</h3>";
$all_revenue_query = "SELECT 
    DATE(paid_at) as date,
    SUM(amount) as daily_revenue,
    COUNT(*) as transactions
FROM payments 
WHERE paid_at >= DATE_SUB(NOW(), INTERVAL 12 MONTH)
GROUP BY DATE(paid_at)
ORDER BY date DESC
LIMIT 10";

$result = $conn->query($all_revenue_query);
if ($result && $result->num_rows > 0) {
    echo "<table border='1' style='border-collapse: collapse; width: 100%;'>";
    echo "<tr><th>Date</th><th>Revenue</th><th>Transactions</th></tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr><td>{$row['date']}</td><td>$" . number_format($row['daily_revenue'], 2) . "</td><td>{$row['transactions']}</td></tr>";
    }
    echo "</table>";
} else {
    echo "<p>❌ No revenue data found at all</p>";
}

// Check booking data
echo "<h3>📅 Booking Data (Current Month)</h3>";
$booking_query = "SELECT 
    DATE(date) as date,
    COUNT(*) as total_bookings,
    SUM(CASE WHEN status = 'Completed' THEN 1 ELSE 0 END) as completed,
    SUM(CASE WHEN status = 'Cancelled' THEN 1 ELSE 0 END) as cancelled
FROM bookings 
WHERE date BETWEEN '$date_from' AND '$date_to'
GROUP BY DATE(date)
ORDER BY date ASC";

$result = $conn->query($booking_query);
if ($result && $result->num_rows > 0) {
    echo "<table border='1' style='border-collapse: collapse; width: 100%;'>";
    echo "<tr><th>Date</th><th>Total</th><th>Completed</th><th>Cancelled</th></tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr><td>{$row['date']}</td><td>{$row['total_bookings']}</td><td>{$row['completed']}</td><td>{$row['cancelled']}</td></tr>";
    }
    echo "</table>";
} else {
    echo "<p>❌ No booking data for current month</p>";
}

// Check ALL booking data  
echo "<h3>📋 ALL Booking Data (Last 12 months)</h3>";
$all_booking_query = "SELECT 
    DATE(date) as date,
    COUNT(*) as total_bookings
FROM bookings 
WHERE date >= DATE_SUB(NOW(), INTERVAL 12 MONTH)
GROUP BY DATE(date)
ORDER BY date DESC
LIMIT 10";

$result = $conn->query($all_booking_query);
if ($result && $result->num_rows > 0) {
    echo "<table border='1' style='border-collapse: collapse; width: 100%;'>";
    echo "<tr><th>Date</th><th>Total Bookings</th></tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr><td>{$row['date']}</td><td>{$row['total_bookings']}</td></tr>";
    }
    echo "</table>";
} else {
    echo "<p>❌ No booking data found</p>";
}

// Check student enrollment
echo "<h3>👥 Student Enrollment (Current Month)</h3>";
$student_query = "SELECT 
    DATE(created_at) as date,
    COUNT(*) as new_students
FROM students 
WHERE created_at BETWEEN '$date_from' AND '$date_to'
GROUP BY DATE(created_at)
ORDER BY date ASC";

$result = $conn->query($student_query);
if ($result && $result->num_rows > 0) {
    echo "<table border='1' style='border-collapse: collapse; width: 100%;'>";
    echo "<tr><th>Date</th><th>New Students</th></tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr><td>{$row['date']}</td><td>{$row['new_students']}</td></tr>";
    }
    echo "</table>";
} else {
    echo "<p>❌ No student enrollment for current month</p>";
}

// Summary stats
echo "<h3>📊 Summary Statistics</h3>";
$total_students = $conn->query("SELECT COUNT(*) as count FROM students")->fetch_assoc()['count'];
$total_bookings = $conn->query("SELECT COUNT(*) as count FROM bookings")->fetch_assoc()['count'];
$total_revenue = $conn->query("SELECT SUM(amount) as total FROM payments")->fetch_assoc()['total'];

echo "<ul>";
echo "<li><strong>Total Students:</strong> {$total_students}</li>";
echo "<li><strong>Total Bookings:</strong> {$total_bookings}</li>";
echo "<li><strong>Total Revenue:</strong> $" . number_format($total_revenue, 2) . "</li>";
echo "</ul>";

// Check what date range would show data
echo "<h3>🎯 Suggested Date Range for Analytics</h3>";
$earliest_payment = $conn->query("SELECT MIN(paid_at) as earliest FROM payments")->fetch_assoc()['earliest'];
$latest_payment = $conn->query("SELECT MAX(paid_at) as latest FROM payments")->fetch_assoc()['latest'];
$earliest_booking = $conn->query("SELECT MIN(date) as earliest FROM bookings")->fetch_assoc()['earliest'];
$latest_booking = $conn->query("SELECT MAX(date) as latest FROM bookings")->fetch_assoc()['latest'];

echo "<p><strong>Payment Date Range:</strong> {$earliest_payment} to {$latest_payment}</p>";
echo "<p><strong>Booking Date Range:</strong> {$earliest_booking} to {$latest_booking}</p>";
echo "<p><strong>💡 Recommendation:</strong> Set analytics date range to show data from {$earliest_payment} to {$latest_payment}</p>";

$conn->close();
?>