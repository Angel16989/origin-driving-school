<?php
// php/send_message.php - Send a chat message
session_start();
require_once 'db_connect.php';

header('Content-Type: application/json');

$sender_id = $_SESSION['user_id'] ?? 0;
$receiver_id = intval($_POST['to_user_id'] ?? 0);
$message = trim($_POST['message'] ?? '');

if (!$sender_id || !$receiver_id || empty($message)) {
    echo json_encode(['success' => false, 'error' => 'Invalid data']);
    exit;
}

// Insert message
$query = "INSERT INTO messages (sender_id, receiver_id, message, sent_at, is_read) 
          VALUES (?, ?, ?, NOW(), 0)";

$stmt = $conn->prepare($query);
$stmt->bind_param("iis", $sender_id, $receiver_id, $message);

if ($stmt->execute()) {
    echo json_encode([
        'success' => true,
        'message_id' => $conn->insert_id
    ]);
} else {
    echo json_encode([
        'success' => false,
        'error' => $conn->error
    ]);
}

$conn->close();
?>
