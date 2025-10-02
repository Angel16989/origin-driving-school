<?php
// add_dummy_data.php - Add comprehensive dummy data for analytics testing
require_once 'php/db_connect.php';

echo "🚀 Adding Comprehensive Dummy Data for Analytics...\n\n";

// Sample data arrays
$first_names = ['John', 'Sarah', 'Michael', 'Emma', 'David', 'Lisa', 'Chris', 'Anna', 'Robert', 'Maria', 'James', 'Jennifer', 'William', 'Jessica', 'Daniel', 'Amy', 'Matthew', 'Rachel', 'Andrew', 'Sophia'];
$last_names = ['Smith', 'Johnson', 'Williams', 'Brown', 'Jones', 'Garcia', 'Miller', 'Davis', 'Rodriguez', 'Martinez', 'Hernandez', 'Lopez', 'Gonzales', 'Wilson', 'Anderson', 'Thomas', 'Taylor', 'Moore', 'Jackson', 'Martin'];
$progress_stages = ['Registered', 'Theory Completed', 'Practical Started', 'Practical Scheduled', 'Test Ready', 'Licensed'];
$booking_statuses = ['Pending', 'Confirmed', 'Completed', 'Cancelled'];
$payment_methods = ['Cash', 'Credit Card', 'Bank Transfer', 'PayPal'];

// Clear existing data first (optional - remove if you want to keep existing data)
echo "🗑️ Clearing existing dummy data...\n";
$conn->query("DELETE FROM payments WHERE id > 3");
$conn->query("DELETE FROM invoices WHERE id > 5");
$conn->query("DELETE FROM bookings WHERE id > 4");
$conn->query("DELETE FROM students WHERE id > 9");

// Reset auto-increment
$conn->query("ALTER TABLE students AUTO_INCREMENT = 10");
$conn->query("ALTER TABLE bookings AUTO_INCREMENT = 5");
$conn->query("ALTER TABLE invoices AUTO_INCREMENT = 6");
$conn->query("ALTER TABLE payments AUTO_INCREMENT = 4");

echo "✅ Existing data cleared.\n\n";

// Add 20 students with historical data spanning 12 months
echo "👥 Adding 20 students with historical data...\n";

for ($i = 0; $i < 20; $i++) {
    // Generate random historical date (1-12 months ago)
    $months_ago = rand(1, 12);
    $registration_date = date('Y-m-d H:i:s', strtotime("-{$months_ago} months"));
    
    $first_name = $first_names[$i];
    $last_name = $last_names[$i];
    $email = strtolower($first_name . '.' . $last_name . ($i + 10)) . '@gmail.com';
    $phone = '04' . rand(10000000, 99999999);
    $license_no = 'DL' . rand(100000, 999999);
    $progress = $progress_stages[array_rand($progress_stages)];
    
    // Insert student
    $stmt = $conn->prepare("INSERT INTO students (name, email, phone, license_no, progress, created_at) VALUES (?, ?, ?, ?, ?, ?)");
    $full_name = $first_name . ' ' . $last_name;
    $stmt->bind_param('ssssss', $full_name, $email, $phone, $license_no, $progress, $registration_date);
    $stmt->execute();
    $student_id = $conn->insert_id;
    
    echo "  ✓ Added: {$full_name} (ID: {$student_id}) - Registered: {$registration_date}\n";
    
    // Add 3-8 bookings per student spread over time
    $num_bookings = rand(3, 8);
    for ($b = 0; $b < $num_bookings; $b++) {
        // Spread bookings over time since registration
        $booking_days_after = rand(1, $months_ago * 30);
        $booking_date = date('Y-m-d', strtotime($registration_date . " + {$booking_days_after} days"));
        $booking_time = sprintf('%02d:00:00', rand(9, 17)); // 9 AM to 5 PM
        $instructor_id = rand(1, 2); // We have 2 instructors
        $status = $booking_statuses[array_rand($booking_statuses)];
        
        // Make older bookings more likely to be completed
        if (strtotime($booking_date) < strtotime('-30 days')) {
            $status = (rand(1, 10) <= 7) ? 'Completed' : 'Cancelled'; // 70% completed for old bookings
        }
        
        $stmt = $conn->prepare("INSERT INTO bookings (student_id, instructor_id, date, time, status) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param('iisss', $student_id, $instructor_id, $booking_date, $booking_time, $status);
        $stmt->execute();
        
        echo "    📅 Booking: {$booking_date} {$booking_time} - {$status}\n";
    }
    
    // Add 1-4 invoices per student
    $num_invoices = rand(1, 4);
    for ($inv = 0; $inv < $num_invoices; $inv++) {
        $invoice_days_after = rand(1, $months_ago * 30);
        $invoice_date = date('Y-m-d H:i:s', strtotime($registration_date . " + {$invoice_days_after} days"));
        $amount = [50.00, 75.00, 100.00, 150.00, 200.00][array_rand([50.00, 75.00, 100.00, 150.00, 200.00])];
        $invoice_status = (rand(1, 10) <= 8) ? 'Paid' : 'Pending'; // 80% paid
        
        $stmt = $conn->prepare("INSERT INTO invoices (student_id, amount, status, created_at) VALUES (?, ?, ?, ?)");
        $stmt->bind_param('idss', $student_id, $amount, $invoice_status, $invoice_date);
        $stmt->execute();
        $invoice_id = $conn->insert_id;
        
        echo "    💰 Invoice: $" . number_format($amount, 2) . " - {$invoice_status} ({$invoice_date})\n";
        
        // Add payment if invoice is paid
        if ($invoice_status === 'Paid') {
            $payment_days_after = rand(0, 7); // Payment within 7 days of invoice
            $payment_date = date('Y-m-d H:i:s', strtotime($invoice_date . " + {$payment_days_after} days"));
            $payment_method = $payment_methods[array_rand($payment_methods)];
            
            $stmt = $conn->prepare("INSERT INTO payments (invoice_id, amount, method, paid_at) VALUES (?, ?, ?, ?)");
            $stmt->bind_param('idss', $invoice_id, $amount, $payment_method, $payment_date);
            $stmt->execute();
            
            echo "    ✅ Payment: $" . number_format($amount, 2) . " via {$payment_method} ({$payment_date})\n";
        }
    }
    
    echo "\n";
}

// Add some additional random data for more variety
echo "🎯 Adding extra historical variety...\n";

// Add some high-value students (driving school packages)
for ($i = 0; $i < 5; $i++) {
    $months_ago = rand(6, 12);
    $registration_date = date('Y-m-d H:i:s', strtotime("-{$months_ago} months"));
    
    $first_name = ['Premium', 'VIP', 'Executive', 'Elite', 'Platinum'][$i];
    $last_name = 'Student' . ($i + 21);
    $email = strtolower($first_name . $last_name) . '@premium.com';
    $phone = '04' . rand(10000000, 99999999);
    $license_no = 'PREM' . rand(1000, 9999);
    $progress = 'Licensed';
    
    $stmt = $conn->prepare("INSERT INTO students (name, email, phone, license_no, progress, created_at) VALUES (?, ?, ?, ?, ?, ?)");
    $full_name = $first_name . ' ' . $last_name;
    $stmt->bind_param('ssssss', $full_name, $email, $phone, $license_no, $progress, $registration_date);
    $stmt->execute();
    $student_id = $conn->insert_id;
    
    // Premium package - big invoice
    $package_amount = [500.00, 750.00, 1000.00, 1200.00, 1500.00][$i];
    $stmt = $conn->prepare("INSERT INTO invoices (student_id, amount, status, created_at) VALUES (?, ?, 'Paid', ?)");
    $stmt->bind_param('ids', $student_id, $package_amount, $registration_date);
    $stmt->execute();
    $invoice_id = $conn->insert_id;
    
    // Payment for premium package
    $payment_date = date('Y-m-d H:i:s', strtotime($registration_date . " + 1 day"));
    $stmt = $conn->prepare("INSERT INTO payments (invoice_id, amount, method, paid_at) VALUES (?, ?, 'Credit Card', ?)");
    $stmt->bind_param('ids', $invoice_id, $package_amount, $payment_date);
    $stmt->execute();
    
    echo "  💎 Premium: {$full_name} - $" . number_format($package_amount, 2) . " package\n";
}

// Generate summary statistics
echo "\n📊 DATA SUMMARY:\n";
echo "================\n";

$total_students = $conn->query("SELECT COUNT(*) as count FROM students")->fetch_assoc()['count'];
$total_bookings = $conn->query("SELECT COUNT(*) as count FROM bookings")->fetch_assoc()['count'];
$total_invoices = $conn->query("SELECT COUNT(*) as count FROM invoices")->fetch_assoc()['count'];
$total_payments = $conn->query("SELECT COUNT(*) as count FROM payments")->fetch_assoc()['count'];
$total_revenue = $conn->query("SELECT SUM(amount) as total FROM payments")->fetch_assoc()['total'];

echo "👥 Total Students: {$total_students}\n";
echo "📅 Total Bookings: {$total_bookings}\n";
echo "📄 Total Invoices: {$total_invoices}\n";
echo "💰 Total Payments: {$total_payments}\n";
echo "💵 Total Revenue: $" . number_format($total_revenue, 2) . "\n";

// Monthly breakdown
echo "\n📈 MONTHLY BREAKDOWN (Last 12 months):\n";
echo "=====================================\n";

$monthly_stats = $conn->query("
    SELECT 
        DATE_FORMAT(created_at, '%Y-%m') as month,
        COUNT(*) as new_students,
        (SELECT COUNT(*) FROM bookings WHERE DATE_FORMAT(date, '%Y-%m') = month) as bookings,
        (SELECT SUM(amount) FROM payments WHERE DATE_FORMAT(paid_at, '%Y-%m') = month) as revenue
    FROM students 
    WHERE created_at >= DATE_SUB(NOW(), INTERVAL 12 MONTH)
    GROUP BY month 
    ORDER BY month DESC
");

while ($row = $monthly_stats->fetch_assoc()) {
    $revenue = $row['revenue'] ? number_format($row['revenue'], 2) : '0.00';
    echo "{$row['month']}: {$row['new_students']} students, {$row['bookings']} bookings, $" . $revenue . " revenue\n";
}

echo "\n🎉 DUMMY DATA GENERATION COMPLETE!\n";
echo "🔗 Now visit: http://localhost/Groupprojectdevelopingweb/php/analytics.php\n";
echo "📊 Your analytics charts should be full of rich data!\n";

$conn->close();
?>