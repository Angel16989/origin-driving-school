<?php
// instructors.php - Manage Instructors
session_start();
require_once 'db_connect.php';
if (!isset($_SESSION['user_id'])) {
    header('Location: ../login.php');
    exit;
}
$action = $_GET['action'] ?? '';
if ($action === 'add' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $qualifications = $_POST['qualifications'];
    $schedule = $_POST['schedule'];
    $branch_id = $_POST['branch_id'];
    $stmt = $conn->prepare("INSERT INTO instructors (name, email, qualifications, schedule, branch_id) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param('ssssi', $name, $email, $qualifications, $schedule, $branch_id);
    $stmt->execute();
    header('Location: instructors.php');
    exit;
}
if ($action === 'delete' && isset($_GET['id'])) {
    $id = intval($_GET['id']);
    
    // Delete related records first (to avoid foreign key constraint errors)
    // Delete bookings for this instructor
    $conn->query("DELETE FROM bookings WHERE instructor_id = $id");
    
    // Delete messages sent by or to this instructor
    $instructor_stmt = $conn->prepare("SELECT email FROM instructors WHERE id = ?");
    $instructor_stmt->bind_param('i', $id);
    $instructor_stmt->execute();
    $instructor_result = $instructor_stmt->get_result();
    if ($instructor_row = $instructor_result->fetch_assoc()) {
        $instructor_email = $instructor_row['email'];
        // Get user_id for this instructor
        $user_stmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
        $user_stmt->bind_param('s', $instructor_email);
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
    
    // Finally, delete the instructor
    $conn->query("DELETE FROM instructors WHERE id = $id");
    
    header('Location: instructors.php?deleted=1');
    exit;
}
if ($action === 'edit' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $qualifications = $_POST['qualifications'];
    $schedule = $_POST['schedule'];
    $branch_id = $_POST['branch_id'];
    $stmt = $conn->prepare("UPDATE instructors SET name=?, email=?, qualifications=?, schedule=?, branch_id=? WHERE id=?");
    $stmt->bind_param('ssssii', $name, $email, $qualifications, $schedule, $branch_id, $id);
    $stmt->execute();
    header('Location: instructors.php');
    exit;
}
$res = $conn->query('SELECT i.*, b.name as branch_name FROM instructors i LEFT JOIN branches b ON i.branch_id = b.id');
$branches = $conn->query('SELECT * FROM branches');

$page_title = "Manage Instructors - Origin Driving School";
$page_description = "Manage driving school instructors";
include '../includes/header.php';
?>

<div class="container" style="margin-top: 6rem; padding: 2rem;">
    <h1 style="color: var(--dashboard-blue); margin-bottom: 2rem;">👨‍🏫 Manage Instructors</h1>
    
    <?php if (isset($_GET['deleted'])): ?>
        <div style="background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%); color: #155724; padding: 1.5rem; border-radius: 10px; margin-bottom: 2rem; border-left: 5px solid #28a745;">
            <strong>✅ Instructor deleted successfully!</strong> All related records (bookings, messages) have been removed.
        </div>
    <?php endif; ?>
    
    <div style="background: white; padding: 2rem; border-radius: 15px; box-shadow: 0 5px 15px rgba(0,0,0,0.1); margin-bottom: 2rem;">
        <h2>Add Instructor</h2>
        <form method="post" action="?action=add">
            <div class="form-group"><label>Name</label><input type="text" name="name" required></div>
            <div class="form-group"><label>Email</label><input type="email" name="email" required></div>
            <div class="form-group"><label>Qualifications</label><input type="text" name="qualifications" required></div>
            <div class="form-group"><label>Schedule</label><input type="text" name="schedule" required></div>
            <div class="form-group"><label>Branch</label><select name="branch_id" required>
                <?php 
                $branches_for_add = $conn->query('SELECT * FROM branches');
                while($b = $branches_for_add->fetch_assoc()): ?>
                <option value="<?php echo $b['id']; ?>"><?php echo $b['name']; ?></option>
                <?php endwhile; ?>
            </select></div>
            <button class="btn" type="submit">➕ Add Instructor</button>
        </form>
    </div>
    
    <div style="background: white; padding: 2rem; border-radius: 15px; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
        <h2 style="color: var(--dashboard-blue); margin-bottom: 1.5rem;">Instructor List</h2>
        <table class="table">
            <tr><th>ID</th><th>Name</th><th>Email</th><th>Qualifications</th><th>Schedule</th><th>Branch</th><th>Actions</th></tr>
            <?php while($row = $res->fetch_assoc()): ?>
            <tr>
                <form method="post" action="?action=edit">
                <td><?php echo $row['id']; ?><input type="hidden" name="id" value="<?php echo $row['id']; ?>"></td>
                <td><input type="text" name="name" value="<?php echo $row['name']; ?>"></td>
                <td><input type="email" name="email" value="<?php echo $row['email']; ?>"></td>
                <td><input type="text" name="qualifications" value="<?php echo $row['qualifications']; ?>"></td>
                <td><input type="text" name="schedule" value="<?php echo $row['schedule']; ?>"></td>
                <td><?php echo $row['branch_name'] ?? 'No Branch'; ?><input type="hidden" name="branch_id" value="<?php echo $row['branch_id']; ?>"></td>
                <td>
                    <button class="btn" type="submit">✏️ Update</button>
                    <a class="btn btn-danger" href="?action=delete&id=<?php echo $row['id']; ?>" onclick="return confirm('Delete instructor?');">🗑️ Delete</a>
                </td>
                </form>
            </tr>
            <?php endwhile; ?>
        </table>
    </div>
</div>

<?php include '../includes/footer.php'; ?>
