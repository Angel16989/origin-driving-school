<?php
// my_invoices.php - Student Invoice Management
session_start();
require_once 'db_connect.php';
require_once 'role_nav.php';

checkRoleAccess(['student'], $_SESSION['role']);

$user_id = $_SESSION['user_id'];

// Get student ID
$stmt = $conn->prepare("SELECT s.id, s.name FROM students s JOIN users u ON u.username = s.email WHERE u.id = ?");
$stmt->bind_param('i', $user_id);
$stmt->execute();
$student_result = $stmt->get_result();
$student = $student_result->fetch_assoc();

if (!$student) {
    header('Location: ../dashboard.php?error=student_not_found');
    exit;
}

$student_id = $student['id'];

// Handle payment simulation (for demo purposes)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['pay_invoice'])) {
    $invoice_id = $_POST['invoice_id'];
    $stmt = $conn->prepare("UPDATE invoices SET status = 'Paid', paid_at = NOW() WHERE id = ? AND student_id = ?");
    $stmt->bind_param('ii', $invoice_id, $student_id);
    $stmt->execute();
    
    header('Location: my_invoices.php?paid=1');
    exit;
}

// Get invoices for this student
$invoices_query = $conn->prepare("
    SELECT i.*, b.date as lesson_date, b.time as lesson_time,
           ins.name as instructor_name
    FROM invoices i
    LEFT JOIN bookings b ON i.booking_id = b.id
    LEFT JOIN instructors ins ON b.instructor_id = ins.id
    WHERE i.student_id = ?
    ORDER BY i.created_at DESC
");
$invoices_query->bind_param('i', $student_id);
$invoices_query->execute();
$invoices = $invoices_query->get_result();

// Calculate statistics
$total_invoices = $invoices->num_rows;
$total_paid = 0;
$total_unpaid = 0;
$unpaid_count = 0;

$invoices->data_seek(0);
while($stats_row = $invoices->fetch_assoc()) {
    if ($stats_row['status'] === 'Paid') {
        $total_paid += $stats_row['amount'];
    } else {
        $total_unpaid += $stats_row['amount'];
        $unpaid_count++;
    }
}
$invoices->data_seek(0); // Reset for main display
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Invoices - Origin Driving School</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body class="page-transition">
    <header>
        <h1>💳 My Payments</h1>
        <p>Manage your lesson payments and financial history</p>
    </header>
    
    <?php renderNavigation($_SESSION['role']); ?>
    
    <div class="container">
        <?php if (isset($_GET['paid'])): ?>
        <div class="message success">
            <strong>✅ Payment Successful!</strong> Your payment has been processed successfully. Thank you!
        </div>
        <?php endif; ?>
        
        <h2>💰 Payment Overview</h2>
        
        <!-- Financial Statistics -->
        <div class="stats-grid">
            <div class="stat-card student-card">
                <div class="stat-number"><?php echo $total_invoices; ?></div>
                <div class="stat-label">Total Invoices</div>
            </div>
            <div class="stat-card student-card" style="background: linear-gradient(135deg, var(--green-light) 0%, #26de81 100%);">
                <div class="stat-number">$<?php echo number_format($total_paid, 2); ?></div>
                <div class="stat-label">Paid Amount</div>
            </div>
            <div class="stat-card student-card" style="background: linear-gradient(135deg, var(--orange-signal) 0%, #ff9f43 100%);">
                <div class="stat-number">$<?php echo number_format($total_unpaid, 2); ?></div>
                <div class="stat-label">Outstanding</div>
            </div>
            <div class="stat-card student-card" style="background: linear-gradient(135deg, var(--red-light) 0%, #ff3742 100%);">
                <div class="stat-number"><?php echo $unpaid_count; ?></div>
                <div class="stat-label">Unpaid Bills</div>
            </div>
        </div>
        
        <?php if ($unpaid_count > 0): ?>
        <!-- Outstanding Payments -->
        <div style="background: linear-gradient(135deg, #fff5f5 0%, #fed7d7 100%); border: 2px solid var(--red-light); padding: 2rem; border-radius: 20px; margin: 2rem 0;">
            <h3 style="color: var(--red-light); margin-bottom: 1rem;">⚠️ Outstanding Payments</h3>
            <p>You have <strong><?php echo $unpaid_count; ?></strong> unpaid invoice(s) totaling <strong>$<?php echo number_format($total_unpaid, 2); ?></strong></p>
            <p>Please make payments to continue your driving lessons without interruption.</p>
        </div>
        <?php endif; ?>
        
        <h3>📄 Invoice History</h3>
        
        <?php if ($total_invoices > 0): ?>
        <table class="table">
            <thead>
                <tr>
                    <th>📋 Invoice #</th>
                    <th>📅 Lesson Date</th>
                    <th>👨‍🏫 Instructor</th>
                    <th>💵 Amount</th>
                    <th>📊 Status</th>
                    <th>📅 Created</th>
                    <th>🎯 Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while($invoice = $invoices->fetch_assoc()): ?>
                <tr>
                    <td>
                        <strong>#<?php echo str_pad($invoice['id'], 4, '0', STR_PAD_LEFT); ?></strong>
                    </td>
                    <td>
                        <?php if ($invoice['lesson_date']): ?>
                            <div><?php echo date('M j, Y', strtotime($invoice['lesson_date'])); ?></div>
                            <small><?php echo date('g:i A', strtotime($invoice['lesson_time'])); ?></small>
                        <?php else: ?>
                            <span class="status-badge info">General</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php echo $invoice['instructor_name'] ? htmlspecialchars($invoice['instructor_name']) : 'N/A'; ?>
                    </td>
                    <td>
                        <div style="font-size: 1.3rem; font-weight: 700; color: var(--dashboard-blue);">
                            $<?php echo number_format($invoice['amount'], 2); ?>
                        </div>
                    </td>
                    <td>
                        <span class="status-badge <?php 
                            echo $invoice['status'] === 'Paid' ? 'success' : 'warning'; 
                        ?>">
                            <?php if ($invoice['status'] === 'Paid'): ?>
                                ✅ Paid
                            <?php else: ?>
                                ⏳ Unpaid
                            <?php endif; ?>
                        </span>
                    </td>
                    <td>
                        <div><?php echo date('M j, Y', strtotime($invoice['created_at'])); ?></div>
                        <?php if ($invoice['status'] === 'Paid' && $invoice['paid_at']): ?>
                            <small style="color: var(--green-light);">
                                Paid: <?php echo date('M j', strtotime($invoice['paid_at'])); ?>
                            </small>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if ($invoice['status'] === 'Unpaid'): ?>
                            <form method="post" style="display: inline;">
                                <input type="hidden" name="invoice_id" value="<?php echo $invoice['id']; ?>">
                                <button type="submit" name="pay_invoice" class="btn btn-success" 
                                        style="padding: 0.6rem 1.2rem; font-size: 0.9rem;"
                                        onclick="return confirm('Process payment of $<?php echo number_format($invoice['amount'], 2); ?>?');">
                                    💳 Pay Now
                                </button>
                            </form>
                        <?php else: ?>
                            <span class="status-badge success" style="font-size: 0.8rem;">
                                ✅ Completed
                            </span>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        
        <?php else: ?>
        <div style="text-align: center; padding: 4rem; background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border-radius: 20px; margin: 2rem 0;">
            <div style="font-size: 4rem; margin-bottom: 1rem;">💳</div>
            <h3>No Invoices Yet</h3>
            <p>Your lesson invoices will appear here once you book and complete lessons with our instructors.</p>
            <a href="my_bookings.php" class="btn" style="margin-top: 1rem;">📅 Book Your First Lesson</a>
        </div>
        <?php endif; ?>
        
        <!-- Payment Methods Info -->
        <div style="background: linear-gradient(135deg, var(--blue-light) 0%, #3d4de8 100%); color: white; padding: 3rem; border-radius: 25px; margin: 3rem 0; text-align: center;">
            <h3 style="margin-bottom: 2rem;">💳 Payment Information</h3>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 2rem; margin: 2rem 0;">
                <div style="background: rgba(255,255,255,0.1); padding: 2rem; border-radius: 15px;">
                    <div style="font-size: 3rem; margin-bottom: 1rem;">🔒</div>
                    <h4>Secure Payments</h4>
                    <p>All payments are processed securely with industry-standard encryption</p>
                </div>
                <div style="background: rgba(255,255,255,0.1); padding: 2rem; border-radius: 15px;">
                    <div style="font-size: 3rem; margin-bottom: 1rem;">📱</div>
                    <h4>Multiple Methods</h4>
                    <p>Credit card, debit card, PayPal, and online banking supported</p>
                </div>
                <div style="background: rgba(255,255,255,0.1); padding: 2rem; border-radius: 15px;">
                    <div style="font-size: 3rem; margin-bottom: 1rem;">📧</div>
                    <h4>Email Receipts</h4>
                    <p>Instant email confirmations and receipts for all transactions</p>
                </div>
            </div>
        </div>
        
        <!-- Quick Actions -->
        <div style="background: linear-gradient(135deg, var(--green-light) 0%, #26de81 100%); color: white; padding: 2rem; border-radius: 20px; margin: 2rem 0; text-align: center;">
            <h3>🚗 Student Hub</h3>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem; margin-top: 1.5rem;">
                <a href="my_bookings.php" class="btn" style="background: rgba(255,255,255,0.2); border: 2px solid rgba(255,255,255,0.3);">
                    📅 Book Lessons
                </a>
                <a href="my_profile.php" class="btn" style="background: rgba(255,255,255,0.2); border: 2px solid rgba(255,255,255,0.3);">
                    👤 My Profile
                </a>
                <a href="student_messages.php" class="btn" style="background: rgba(255,255,255,0.2); border: 2px solid rgba(255,255,255,0.3);">
                    💬 Messages
                </a>
                <a href="../dashboard.php" class="btn" style="background: rgba(255,255,255,0.2); border: 2px solid rgba(255,255,255,0.3);">
                    🏠 Dashboard
                </a>
            </div>
        </div>
    </div>
    
    <footer>&copy; 2025 Origin Driving School - Student Portal</footer>
</body>
</html>
