<?php
// invoices.php - Manage Invoices
session_start();
require_once 'db_connect.php';
if (!isset($_SESSION['user_id'])) {
    header('Location: ../login.php');
    exit;
}
$action = $_GET['action'] ?? '';
if ($action === 'pay' && isset($_GET['id'])) {
    $id = $_GET['id'];
    $conn->query("UPDATE invoices SET status='Paid' WHERE id=$id");
    $conn->query("INSERT INTO payments (invoice_id, amount, method, paid_at) VALUES ($id, 100.00, 'Cash', NOW())");
    header('Location: invoices.php');
    exit;
}
$res = $conn->query('SELECT i.*, s.name as student_name FROM invoices i LEFT JOIN students s ON i.student_id = s.id');

$page_title = "Manage Invoices - Origin Driving School";
$page_description = "Manage and track student invoices";
include '../includes/header.php';
?>

<div class="container" style="margin-top: 6rem; padding: 2rem;">
    <h1 style="color: var(--dashboard-blue); margin-bottom: 2rem;">💰 Manage Invoices</h1>
    
    <div style="background: white; padding: 2rem; border-radius: 15px; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
        <h2 style="color: var(--dashboard-blue); margin-bottom: 1.5rem;">Invoice List</h2>
        <table class="table">
            <tr><th>ID</th><th>Student</th><th>Amount</th><th>Status</th><th>Created At</th><th>Actions</th></tr>
            <?php while($row = $res->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['student_name'] ?? 'Unknown'; ?></td>
                <td>$<?php echo number_format($row['amount'],2); ?></td>
                <td><?php echo $row['status']; ?></td>
                <td><?php echo $row['created_at']; ?></td>
                <td>
                    <?php if($row['status'] === 'Unpaid'): ?>
                        <a class="btn btn-success" href="?action=pay&id=<?php echo $row['id']; ?>">💳 Mark as Paid</a>
                    <?php else: ?>
                        <span style="color: var(--success-color); font-weight: 600;">✅ Paid</span>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endwhile; ?>
        </table>
    </div>
    
    <div style="background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%); padding: 2rem; border-radius: 15px; margin-top: 2rem; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
        <h3 style="color: var(--dashboard-blue); margin-bottom: 1rem;">📊 Financial Report</h3>
        <?php
        $res = $conn->query('SELECT SUM(amount) AS total FROM invoices WHERE status = "Paid"');
        $row = $res->fetch_assoc();
        $income = $row['total'] ? $row['total'] : 0.00;
        $res = $conn->query('SELECT SUM(amount) AS pending FROM invoices WHERE status = "Unpaid"');
        $row = $res->fetch_assoc();
        $pending = $row['pending'] ? $row['pending'] : 0.00;
        ?>
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem; margin-top: 1rem;">
            <div style="background: rgba(40, 167, 69, 0.1); padding: 1.5rem; border-radius: 10px; border-left: 5px solid #28a745;">
                <div style="font-size: 0.9rem; color: #666; margin-bottom: 0.5rem;">Total Income</div>
                <div style="font-size: 2rem; font-weight: 700; color: #28a745;">$<?php echo number_format($income,2); ?></div>
            </div>
            <div style="background: rgba(255, 193, 7, 0.1); padding: 1.5rem; border-radius: 10px; border-left: 5px solid #ffc107;">
                <div style="font-size: 0.9rem; color: #666; margin-bottom: 0.5rem;">Pending Payments</div>
                <div style="font-size: 2rem; font-weight: 700; color: #ffc107;">$<?php echo number_format($pending,2); ?></div>
            </div>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>
