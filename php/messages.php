<?php
// messages.php - Messaging System
session_start();
require_once 'db_connect.php';
if (!isset($_SESSION['user_id'])) {
    header('Location: ../login.php');
    exit;
}
$user_id = $_SESSION['user_id'];
$action = $_GET['action'] ?? '';
if ($action === 'send' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $receiver_id = $_POST['receiver_id'];
    $message = $_POST['message'];
    $stmt = $conn->prepare("INSERT INTO messages (sender_id, receiver_id, message) VALUES (?, ?, ?)");
    $stmt->bind_param('iis', $user_id, $receiver_id, $message);
    $stmt->execute();
    header('Location: messages.php');
    exit;
}
// Fetch users for messaging
$users = $conn->query('SELECT id, username FROM users WHERE id != '.$user_id);
// Fetch messages
$res = $conn->query('SELECT m.*, u1.username AS sender, u2.username AS receiver FROM messages m JOIN users u1 ON m.sender_id=u1.id JOIN users u2 ON m.receiver_id=u2.id WHERE m.sender_id='.$user_id.' OR m.receiver_id='.$user_id.' ORDER BY m.created_at DESC');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Messages</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <header><h1>Messages</h1></header>
    <nav>
        <a href="../dashboard.php">Dashboard</a>
        <a href="messages.php">Messages</a>
        <a href="../php/logout.php">Logout</a>
    </nav>
    <div class="container">
        <h2>Send Message</h2>
        <form method="post" action="?action=send">
            <div class="form-group"><label>To</label><select name="receiver_id" required>
                <?php while($u = $users->fetch_assoc()): ?>
                <option value="<?php echo $u['id']; ?>"><?php echo $u['username']; ?></option>
                <?php endwhile; ?>
            </select></div>
            <div class="form-group"><label>Message</label><textarea name="message" required></textarea></div>
            <button class="btn" type="submit">Send</button>
        </form>
        <h2>Message History</h2>
        <table class="table">
            <tr><th>From</th><th>To</th><th>Message</th><th>Date</th></tr>
            <?php while($row = $res->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row['sender']; ?></td>
                <td><?php echo $row['receiver']; ?></td>
                <td><?php echo $row['message']; ?></td>
                <td><?php echo $row['created_at']; ?></td>
            </tr>
            <?php endwhile; ?>
        </table>
        <p><em>Email/SMS notification placeholder.</em></p>
    </div>
    <footer>&copy; 2025 Origin Driving School</footer>
</body>
</html>
