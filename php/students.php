<?php
// students.php - Manage Students (Admin Only)
session_start();
require_once 'db_connect.php';
require_once 'role_nav.php';

checkRoleAccess(['admin'], $_SESSION['role']);

// CRUD operations
$action = $_GET['action'] ?? '';
if ($action === 'add' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $license_no = $_POST['license_no'];
    $progress = $_POST['progress'];
    $stmt = $conn->prepare("INSERT INTO students (name, email, phone, license_no, progress) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param('sssss', $name, $email, $phone, $license_no, $progress);
    $stmt->execute();
    header('Location: students.php');
    exit;
}
if ($action === 'delete' && isset($_GET['id'])) {
    $id = intval($_GET['id']);
    
    // Delete related records first (to avoid foreign key constraint errors)
    // Delete payments for this student's invoices
    $conn->query("DELETE p FROM payments p 
                  INNER JOIN invoices i ON p.invoice_id = i.id 
                  WHERE i.student_id = $id");
    
    // Delete invoices for this student
    $conn->query("DELETE FROM invoices WHERE student_id = $id");
    
    // Delete bookings for this student
    $conn->query("DELETE FROM bookings WHERE student_id = $id");
    
    // Delete messages sent by or to this student
    $student_stmt = $conn->prepare("SELECT email FROM students WHERE id = ?");
    $student_stmt->bind_param('i', $id);
    $student_stmt->execute();
    $student_result = $student_stmt->get_result();
    if ($student_row = $student_result->fetch_assoc()) {
        $student_email = $student_row['email'];
        // Get user_id for this student
        $user_stmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
        $user_stmt->bind_param('s', $student_email);
        $user_stmt->execute();
        $user_result = $user_stmt->get_result();
        if ($user_row = $user_result->fetch_assoc()) {
            $user_id = $user_row['id'];
            // Delete messages
            $conn->query("DELETE FROM messages WHERE sender_id = $user_id OR receiver_id = $user_id");
            // Delete user account
            $conn->query("DELETE FROM users WHERE id = $user_id");
        }
    }
    
    // Finally, delete the student
    $conn->query("DELETE FROM students WHERE id = $id");
    
    header('Location: students.php?deleted=1');
    exit;
}
// Edit
if ($action === 'edit' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $license_no = $_POST['license_no'];
    $progress = $_POST['progress'];
    $stmt = $conn->prepare("UPDATE students SET name=?, email=?, phone=?, license_no=?, progress=? WHERE id=?");
    $stmt->bind_param('sssssi', $name, $email, $phone, $license_no, $progress, $id);
    $stmt->execute();
    header('Location: students.php');
    exit;
}
// Fetch students
$res = $conn->query('SELECT * FROM students');

$page_title = "Manage Students - Origin Driving School";
$page_description = "Admin-only student management system";
include '../includes/header.php';
?>

<div class="container" style="margin-top: 6rem; padding: 2rem;">
    <h1 style="color: var(--dashboard-blue); margin-bottom: 2rem;">👥 Student Management</h1>
    
    <?php if (isset($_GET['deleted'])): ?>
        <div style="background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%); color: #155724; padding: 1.5rem; border-radius: 10px; margin-bottom: 2rem; border-left: 5px solid #28a745;">
            <strong>✅ Student deleted successfully!</strong> All related records (bookings, invoices, payments, messages) have been removed.
        </div>
    <?php endif; ?>
    
    <div style="background: white; padding: 2rem; border-radius: 15px; box-shadow: 0 5px 15px rgba(0,0,0,0.1); margin-bottom: 2rem;">
        <h2>Add Student</h2>
        <form method="post" action="?action=add">
            <div class="form-group"><label>Name</label><input type="text" name="name" required></div>
            <div class="form-group"><label>Email</label><input type="email" name="email" required></div>
            <div class="form-group"><label>Phone</label><input type="text" name="phone" required></div>
            <div class="form-group"><label>License No</label><input type="text" name="license_no" required></div>
            <div class="form-group"><label>Progress</label><input type="text" name="progress" required></div>
            <button class="btn" type="submit">➕ Add Student</button>
        </form>
    </div>
    
    <div style="background: white; padding: 2rem; border-radius: 15px; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
        <h2 style="color: var(--dashboard-blue); margin-bottom: 1.5rem;">Student List</h2>
        <table class="table">
            <tr><th>ID</th><th>Name</th><th>Email</th><th>Phone</th><th>License</th><th>Progress</th><th>Actions</th></tr>
            <?php while($row = $res->fetch_assoc()): ?>
            <tr>
                <form method="post" action="?action=edit">
                <td><?php echo $row['id']; ?><input type="hidden" name="id" value="<?php echo $row['id']; ?>"></td>
                <td><input type="text" name="name" value="<?php echo $row['name']; ?>"></td>
                <td><input type="email" name="email" value="<?php echo $row['email']; ?>"></td>
                <td><input type="text" name="phone" value="<?php echo $row['phone']; ?>"></td>
                <td><input type="text" name="license_no" value="<?php echo $row['license_no']; ?>"></td>
                <td><input type="text" name="progress" value="<?php echo $row['progress']; ?>"></td>
                <td>
                    <button class="btn" type="submit">✏️ Update</button>
                    <a class="btn btn-danger" href="?action=delete&id=<?php echo $row['id']; ?>" onclick="return confirm('Delete student?');">🗑️ Delete</a>
                </td>
                </form>
            </tr>
            <?php endwhile; ?>
        </table>
    </div>
</div>

<?php include '../includes/footer.php'; ?>
