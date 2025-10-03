<?php
// add_more_revenue_data.php - Add way more revenue data to make charts fuller
require_once 'php/db_connect.php';

echo "💰 Adding MORE Revenue Data for Fuller Charts...\n\n";

// Add additional high-value transactions for the past 12 months
$revenue_boosts = [
    // October 2025 (current month)
    ['2025-10-01', 450.00, 'Credit Card'],
    ['2025-10-01', 300.00, 'Bank Transfer'],
    ['2025-10-02', 275.00, 'PayPal'],
    ['2025-10-02', 500.00, 'Credit Card'],
    
    // September 2025 - Peak month
    ['2025-09-15', 800.00, 'Credit Card'],
    ['2025-09-16', 650.00, 'Bank Transfer'],
    ['2025-09-20', 920.00, 'Credit Card'],
    ['2025-09-22', 750.00, 'PayPal'],
    ['2025-09-25', 600.00, 'Cash'],
    ['2025-09-28', 850.00, 'Credit Card'],
    
    // August 2025 - Summer intensive
    ['2025-08-05', 1200.00, 'Credit Card'],
    ['2025-08-10', 950.00, 'Bank Transfer'],
    ['2025-08-15', 780.00, 'PayPal'],
    ['2025-08-20', 1100.00, 'Credit Card'],
    ['2025-08-25', 890.00, 'Cash'],
    
    // July 2025 - Holiday packages
    ['2025-07-01', 1500.00, 'Credit Card'],
    ['2025-07-05', 1200.00, 'Bank Transfer'],
    ['2025-07-10', 980.00, 'Credit Card'],
    ['2025-07-15', 1350.00, 'PayPal'],
    ['2025-07-20', 760.00, 'Cash'],
    ['2025-07-25', 1180.00, 'Credit Card'],
    
    // June 2025 - Mid-year boost
    ['2025-06-01', 690.00, 'Credit Card'],
    ['2025-06-05', 540.00, 'Bank Transfer'],
    ['2025-06-10', 720.00, 'PayPal'],
    ['2025-06-15', 650.00, 'Credit Card'],
    ['2025-06-20', 800.00, 'Cash'],
    ['2025-06-25', 580.00, 'Bank Transfer'],
    
    // May 2025 - Spring packages
    ['2025-05-01', 450.00, 'Credit Card'],
    ['2025-05-08', 620.00, 'PayPal'],
    ['2025-05-15', 750.00, 'Bank Transfer'],
    ['2025-05-22', 680.00, 'Credit Card'],
    ['2025-05-29', 540.00, 'Cash'],
    
    // April 2025
    ['2025-04-05', 380.00, 'Credit Card'],
    ['2025-04-12', 520.00, 'Bank Transfer'],
    ['2025-04-18', 460.00, 'PayPal'],
    ['2025-04-25', 590.00, 'Credit Card'],
    
    // March 2025
    ['2025-03-03', 720.00, 'Credit Card'],
    ['2025-03-10', 650.00, 'Bank Transfer'],
    ['2025-03-17', 580.00, 'PayPal'],
    ['2025-03-24', 740.00, 'Credit Card'],
    ['2025-03-31', 620.00, 'Cash'],
    
    // February 2025
    ['2025-02-05', 340.00, 'Credit Card'],
    ['2025-02-12', 480.00, 'Bank Transfer'],
    ['2025-02-19', 560.00, 'PayPal'],
    ['2025-02-26', 420.00, 'Credit Card'],
    
    // January 2025 - New Year packages
    ['2025-01-01', 1000.00, 'Credit Card'],
    ['2025-01-05', 850.00, 'Bank Transfer'],
    ['2025-01-10', 920.00, 'PayPal'],
    ['2025-01-15', 780.00, 'Credit Card'],
    ['2025-01-20', 650.00, 'Cash'],
    ['2025-01-25', 740.00, 'Bank Transfer'],
    ['2025-01-30', 680.00, 'Credit Card'],
    
    // December 2024 - Holiday specials
    ['2024-12-01', 1200.00, 'Credit Card'],
    ['2024-12-05', 950.00, 'Bank Transfer'],
    ['2024-12-10', 1100.00, 'PayPal'],
    ['2024-12-15', 890.00, 'Credit Card'],
    ['2024-12-20', 1350.00, 'Cash'],
    ['2024-12-25', 760.00, 'Bank Transfer'],
    ['2024-12-30', 1180.00, 'Credit Card'],
    
    // November 2024 - Black Friday deals
    ['2024-11-01', 690.00, 'Credit Card'],
    ['2024-11-08', 540.00, 'Bank Transfer'],
    ['2024-11-15', 720.00, 'PayPal'],
    ['2024-11-22', 650.00, 'Credit Card'],
    ['2024-11-29', 800.00, 'Cash'],
];

echo "Adding " . count($revenue_boosts) . " new revenue transactions...\n\n";

foreach ($revenue_boosts as $transaction) {
    $date = $transaction[0];
    $amount = $transaction[1];
    $method = $transaction[2];
    
    // Create a corresponding invoice first
    $stmt = $conn->prepare("INSERT INTO invoices (student_id, amount, status, created_at) VALUES (?, ?, 'Paid', ?)");
    $random_student = rand(10, 29); // Random existing student
    $stmt->bind_param('ids', $random_student, $amount, $date);
    $stmt->execute();
    $invoice_id = $conn->insert_id;
    
    // Add the payment
    $stmt = $conn->prepare("INSERT INTO payments (invoice_id, amount, method, paid_at) VALUES (?, ?, ?, ?)");
    $stmt->bind_param('idss', $invoice_id, $amount, $method, $date);
    $stmt->execute();
    
    echo "✅ Added: $" . number_format($amount, 2) . " on {$date} via {$method}\n";
}

// Calculate new totals
echo "\n📊 NEW TOTALS:\n";
echo "================\n";

$total_payments = $conn->query("SELECT COUNT(*) as count FROM payments")->fetch_assoc()['count'];
$total_revenue = $conn->query("SELECT SUM(amount) as total FROM payments")->fetch_assoc()['total'];
$avg_transaction = $total_revenue / $total_payments;

echo "💰 Total Payments: {$total_payments}\n";
echo "💵 Total Revenue: $" . number_format($total_revenue, 2) . "\n";
echo "📈 Average Transaction: $" . number_format($avg_transaction, 2) . "\n";

// Monthly breakdown for verification
echo "\n📅 MONTHLY REVENUE BREAKDOWN:\n";
echo "==============================\n";

$monthly_revenue = $conn->query("
    SELECT 
        DATE_FORMAT(paid_at, '%Y-%m') as month,
        COUNT(*) as transactions,
        SUM(amount) as revenue
    FROM payments 
    WHERE paid_at >= DATE_SUB(NOW(), INTERVAL 12 MONTH)
    GROUP BY month 
    ORDER BY month DESC
");

while ($row = $monthly_revenue->fetch_assoc()) {
    echo "{$row['month']}: {$row['transactions']} transactions, $" . number_format($row['revenue'], 2) . " revenue\n";
}

echo "\n🎉 Revenue data expansion complete!\n";
echo "📊 Your analytics charts will now be much fuller and more impressive!\n";

$conn->close();
?>