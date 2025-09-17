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
$res = $conn->query('SELECT * FROM invoices');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Invoices</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <header><h1>Invoices</h1></header>
    <nav>
        <a href="../dashboard.php">Dashboard</a>
        <a href="invoices.php">Invoices</a>
        <a href="../php/logout.php">Logout</a>
    </nav>
    <div class="container">
        <h2>Invoice List</h2>
        <table class="table">
            <tr><th>ID</th><th>Student</th><th>Amount</th><th>Status</th><th>Created At</th><th>Actions</th></tr>
            <?php while($row = $res->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['student_id']; ?></td>
                <td>$<?php echo number_format($row['amount'],2); ?></td>
                <td><?php echo $row['status']; ?></td>
                <td><?php echo $row['created_at']; ?></td>
                <td>
                    <?php if($row['status'] === 'Unpaid'): ?>
                        <a class="btn" href="?action=pay&id=<?php echo $row['id']; ?>">Mark as Paid</a>
                    <?php else: ?>
                        Paid
                    <?php endif; ?>
                </td>
            </tr>
            <?php endwhile; ?>
        </table>
        <h3>Financial Report</h3>
        <?php
        $res = $conn->query('SELECT SUM(amount) AS total FROM invoices WHERE status = "Paid"');
        $row = $res->fetch_assoc();
        $income = $row['total'] ? $row['total'] : 0.00;
        $res = $conn->query('SELECT SUM(amount) AS pending FROM invoices WHERE status = "Unpaid"');
        $row = $res->fetch_assoc();
        $pending = $row['pending'] ? $row['pending'] : 0.00;
        ?>
        <p>Total Income: $<?php echo number_format($income,2); ?></p>
        <p>Pending Payments: $<?php echo number_format($pending,2); ?></p>
    </div>
    <footer>&copy; 2025 Origin Driving School</footer>
</body>
</html>
