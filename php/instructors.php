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
    $id = $_GET['id'];
    $conn->query("DELETE FROM instructors WHERE id = $id");
    header('Location: instructors.php');
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
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Instructors</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <header><h1>Instructors</h1></header>
    <nav>
        <a href="../dashboard.php">🏠 Dashboard</a>
        <a href="students.php">👥 Students</a>
        <a href="instructors.php">👨‍🏫 Instructors</a>
        <a href="bookings.php">📅 Bookings</a>
        <a href="invoices.php">💰 Invoices</a>
        <a href="messages.php">💬 Messages</a>
        <a href="logout.php">🚪 Logout</a>
    </nav>
    <div class="container">
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
        <h2>Instructor List</h2>
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
    <footer>&copy; 2025 Origin Driving School</footer>
</body>
</html>
