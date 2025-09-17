<?php
// bookings.php - Manage Bookings
session_start();
require_once 'db_connect.php';
if (!isset($_SESSION['user_id'])) {
    header('Location: ../login.php');
    exit;
}
$action = $_GET['action'] ?? '';
if ($action === 'add' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $student_id = $_POST['student_id'];
    $instructor_id = $_POST['instructor_id'];
    $date = $_POST['date'];
    $time = $_POST['time'];
    // Prevent double booking
    $stmt = $conn->prepare("SELECT id FROM bookings WHERE instructor_id=? AND date=? AND time=?");
    $stmt->bind_param('iss', $instructor_id, $date, $time);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
        $msg = 'Instructor already booked for this slot.';
    } else {
        $stmt = $conn->prepare("INSERT INTO bookings (student_id, instructor_id, date, time, status) VALUES (?, ?, ?, ?, 'Confirmed')");
        $stmt->bind_param('iiss', $student_id, $instructor_id, $date, $time);
        $stmt->execute();
        // Create invoice
        $stmt = $conn->prepare("INSERT INTO invoices (student_id, amount, status) VALUES (?, 100.00, 'Unpaid')");
        $stmt->bind_param('i', $student_id);
        $stmt->execute();
        header('Location: bookings.php');
        exit;
    }
}
if ($action === 'delete' && isset($_GET['id'])) {
    $id = $_GET['id'];
    $conn->query("DELETE FROM bookings WHERE id = $id");
    header('Location: bookings.php');
    exit;
}
$res = $conn->query('SELECT * FROM bookings');
$students = $conn->query('SELECT * FROM students');
$instructors = $conn->query('SELECT * FROM instructors');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Bookings</title>
    <link rel="stylesheet" href="../css/styles.css">
    <script src="../js/scripts.js"></script>
</head>
<body>
    <header><h1>Bookings</h1></header>
    <nav>
        <a href="../dashboard.php">Dashboard</a>
        <a href="bookings.php">Bookings</a>
        <a href="../php/logout.php">Logout</a>
    </nav>
    <div class="container">
        <h2>Add Booking</h2>
        <form method="post" action="?action=add">
            <div class="form-group"><label>Student</label><select name="student_id" required>
                <?php while($s = $students->fetch_assoc()): ?>
                <option value="<?php echo $s['id']; ?>"><?php echo $s['name']; ?></option>
                <?php endwhile; ?>
            </select></div>
            <div class="form-group"><label>Instructor</label><select name="instructor_id" required>
                <?php while($i = $instructors->fetch_assoc()): ?>
                <option value="<?php echo $i['id']; ?>"><?php echo $i['name']; ?></option>
                <?php endwhile; ?>
            </select></div>
            <div class="form-group"><label>Date</label><input type="date" name="date" required></div>
            <div class="form-group"><label>Time</label><input type="time" name="time" required></div>
            <button class="btn" type="submit">Add Booking</button>
        </form>
        <?php if(isset($msg)) echo '<p style="color:red;">'.$msg.'</p>'; ?>
        <h2>Booking List</h2>
        <table class="table">
            <tr><th>ID</th><th>Student</th><th>Instructor</th><th>Date</th><th>Time</th><th>Status</th><th>Actions</th></tr>
            <?php while($row = $res->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['student_id']; ?></td>
                <td><?php echo $row['instructor_id']; ?></td>
                <td><?php echo $row['date']; ?></td>
                <td><?php echo $row['time']; ?></td>
                <td><?php echo $row['status']; ?></td>
                <td><a class="btn" href="?action=delete&id=<?php echo $row['id']; ?>" onclick="return confirm('Delete booking?');">Delete</a></td>
            </tr>
            <?php endwhile; ?>
        </table>
        <button class="btn" onclick="showCalendar()">Show Calendar</button>
    </div>
    <footer>&copy; 2025 Origin Driving School</footer>
</body>
</html>
