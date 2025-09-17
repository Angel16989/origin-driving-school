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
    $id = $_GET['id'];
    $conn->query("DELETE FROM students WHERE id = $id");
    header('Location: students.php');
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
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Students</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <header><h1>👥 Student Management</h1><p>Admin-only student management system</p></header>
    <?php renderNavigation($_SESSION['role']); ?>
    <div class="container">
        <h2>Add Student</h2>
        <form method="post" action="?action=add">
            <div class="form-group"><label>Name</label><input type="text" name="name" required></div>
            <div class="form-group"><label>Email</label><input type="email" name="email" required></div>
            <div class="form-group"><label>Phone</label><input type="text" name="phone" required></div>
            <div class="form-group"><label>License No</label><input type="text" name="license_no" required></div>
            <div class="form-group"><label>Progress</label><input type="text" name="progress" required></div>
            <button class="btn" type="submit">➕ Add Student</button>
        </form>
        <h2>Student List</h2>
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
    <footer>&copy; 2025 Origin Driving School</footer>
</body>
</html>
