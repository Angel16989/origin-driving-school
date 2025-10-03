<?php
// debug_analytics_queries.php - Debug why charts are still empty
require_once 'php/db_connect.php';

echo "<h2>🔍 Analytics Query Debug - Why Charts Are Empty</h2>";

// Get the exact date range that analytics.php uses
$date_from = date('Y-m-d', strtotime('-12 months')); // 12 months ago
$date_to = date('Y-m-d'); // Today

echo "<p><strong>Analytics Date Range:</strong> {$date_from} to {$date_to}</p>";

// Test the EXACT queries from analytics.php
echo "<h3>1. 📊 Revenue Query Test</h3>";
$revenue_query = "SELECT 
    DATE(paid_at) as date,
    SUM(amount) as daily_revenue,
    COUNT(*) as transactions
FROM payments 
WHERE paid_at BETWEEN '{$date_from}' AND '{$date_to}'
GROUP BY DATE(paid_at)
ORDER BY date ASC";

echo "<strong>Query:</strong><br><code>{$revenue_query}</code><br><br>";

$result = $conn->query($revenue_query);
if ($result && $result->num_rows > 0) {
    echo "<strong>✅ Revenue Data Found ({$result->num_rows} rows):</strong><br>";
    $count = 0;
    while ($row = $result->fetch_assoc() && $count < 5) {
        echo "- {$row['date']}: $" . number_format($row['daily_revenue'], 2) . " ({$row['transactions']} transactions)<br>";
        $count++;
    }
    if ($result->num_rows > 5) echo "... and " . ($result->num_rows - 5) . " more rows<br>";
} else {
    echo "❌ No revenue data found!<br>";
}

echo "<h3>2. 📅 Booking Query Test</h3>";
$booking_query = "SELECT 
    DATE(date) as date,
    COUNT(*) as total_bookings,
    SUM(CASE WHEN status = 'Confirmed' THEN 1 ELSE 0 END) as confirmed,
    SUM(CASE WHEN status = 'Completed' THEN 1 ELSE 0 END) as completed,
    SUM(CASE WHEN status = 'Cancelled' THEN 1 ELSE 0 END) as cancelled
FROM bookings 
WHERE date BETWEEN '{$date_from}' AND '{$date_to}'
GROUP BY DATE(date)
ORDER BY date ASC";

echo "<strong>Query:</strong><br><code>{$booking_query}</code><br><br>";

$result = $conn->query($booking_query);
if ($result && $result->num_rows > 0) {
    echo "<strong>✅ Booking Data Found ({$result->num_rows} rows):</strong><br>";
    $count = 0;
    while ($row = $result->fetch_assoc() && $count < 5) {
        echo "- {$row['date']}: {$row['total_bookings']} total ({$row['completed']} completed, {$row['cancelled']} cancelled)<br>";
        $count++;
    }
    if ($result->num_rows > 5) echo "... and " . ($result->num_rows - 5) . " more rows<br>";
} else {
    echo "❌ No booking data found!<br>";
}

echo "<h3>3. 👨‍🏫 Instructor Query Test</h3>";
$instructor_query = "SELECT 
    i.name,
    COUNT(DISTINCT b.id) as total_lessons,
    SUM(CASE WHEN b.status = 'Completed' THEN 1 ELSE 0 END) as completed_lessons,
    AVG(CASE WHEN b.status = 'Completed' THEN inv.amount ELSE NULL END) as avg_revenue
FROM instructors i
LEFT JOIN bookings b ON i.id = b.instructor_id AND b.date BETWEEN '{$date_from}' AND '{$date_to}'
LEFT JOIN invoices inv ON b.student_id = inv.student_id AND inv.created_at BETWEEN '{$date_from}' AND '{$date_to}'
GROUP BY i.id, i.name
ORDER BY total_lessons DESC";

echo "<strong>Query:</strong><br><code>{$instructor_query}</code><br><br>";

$result = $conn->query($instructor_query);
if ($result && $result->num_rows > 0) {
    echo "<strong>✅ Instructor Data Found ({$result->num_rows} rows):</strong><br>";
    while ($row = $result->fetch_assoc()) {
        echo "- {$row['name']}: {$row['total_lessons']} lessons ({$row['completed_lessons']} completed)<br>";
    }
} else {
    echo "❌ No instructor data found!<br>";
}

echo "<h3>4. 📈 Enrollment Query Test</h3>";
$enrollment_query = "SELECT 
    DATE_FORMAT(created_at, '%Y-%m') as month,
    COUNT(*) as new_students
FROM students 
WHERE created_at BETWEEN '{$date_from}' AND '{$date_to}'
GROUP BY DATE_FORMAT(created_at, '%Y-%m')
ORDER BY month ASC";

echo "<strong>Query:</strong><br><code>{$enrollment_query}</code><br><br>";

$result = $conn->query($enrollment_query);
if ($result && $result->num_rows > 0) {
    echo "<strong>✅ Enrollment Data Found ({$result->num_rows} rows):</strong><br>";
    while ($row = $result->fetch_assoc()) {
        echo "- {$row['month']}: {$row['new_students']} students<br>";
    }
} else {
    echo "❌ No enrollment data found!<br>";
}

// Check JavaScript data arrays that analytics.php would generate
echo "<h3>5. 🔧 JavaScript Data Arrays (What analytics.php sees)</h3>";

// Revenue data array
$revenue_data = [];
$result = $conn->query($revenue_query);
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $revenue_data[] = $row;
    }
}

// Booking data array  
$booking_data = [];
$result = $conn->query($booking_query);
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $booking_data[] = $row;
    }
}

// Instructor data array
$instructor_data = [];
$result = $conn->query($instructor_query);
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $instructor_data[] = $row;
    }
}

// Enrollment data array
$enrollment_data = [];
$result = $conn->query($enrollment_query);
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $enrollment_data[] = $row;
    }
}

echo "<strong>Revenue Array:</strong> " . count($revenue_data) . " items<br>";
echo "<strong>Booking Array:</strong> " . count($booking_data) . " items<br>";
echo "<strong>Instructor Array:</strong> " . count($instructor_data) . " items<br>";
echo "<strong>Enrollment Array:</strong> " . count($enrollment_data) . " items<br>";

echo "<h3>6. 🎯 Raw Data Check</h3>";
$total_payments = $conn->query("SELECT COUNT(*) as count FROM payments")->fetch_assoc()['count'];
$total_bookings = $conn->query("SELECT COUNT(*) as count FROM bookings")->fetch_assoc()['count'];
$total_students = $conn->query("SELECT COUNT(*) as count FROM students")->fetch_assoc()['count'];
$total_instructors = $conn->query("SELECT COUNT(*) as count FROM instructors")->fetch_assoc()['count'];

echo "💰 Total Payments: {$total_payments}<br>";
echo "📅 Total Bookings: {$total_bookings}<br>";
echo "👥 Total Students: {$total_students}<br>";
echo "👨‍🏫 Total Instructors: {$total_instructors}<br>";

// Generate the EXACT JavaScript that analytics.php would output
echo "<h3>7. 📱 Generated JavaScript Arrays</h3>";
echo "<code>";
echo "const revenueData = " . json_encode($revenue_data) . ";<br>";
echo "const bookingData = " . json_encode($booking_data) . ";<br>";
echo "const instructorData = " . json_encode($instructor_data) . ";<br>";
echo "const enrollmentData = " . json_encode($enrollment_data) . ";<br>";
echo "</code>";

$conn->close();
?>