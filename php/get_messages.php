<?php
// php/get_messages.php - Get chat messages between users
session_start();
require_once 'db_connect.php';

header('Content-Type: application/json');

$current_user_id = $_SESSION['user_id'] ?? 0;
$other_user_id = intval($_GET['user_id'] ?? 0);

if (!$current_user_id || !$other_user_id) {
    echo json_encode([]);
    exit;
}

// Get messages between these two users
$query = "SELECT m.*, 
          CASE WHEN m.sender_id = ? THEN 1 ELSE 0 END as is_sent,
          DATE_FORMAT(m.sent_at, '%h:%i %p') as time
          FROM messages m
          WHERE (m.sender_id = ? AND m.receiver_id = ?)
             OR (m.sender_id = ? AND m.receiver_id = ?)
          ORDER BY m.sent_at ASC
          LIMIT 50";

$stmt = $conn->prepare($query);
$stmt->bind_param("iiiii", $current_user_id, $current_user_id, $other_user_id, $other_user_id, $current_user_id);
$stmt->execute();
$result = $stmt->get_result();

$messages = [];
while ($row = $result->fetch_assoc()) {
    $messages[] = [
        'id' => $row['id'],
        'message' => htmlspecialchars($row['message']),
        'is_sent' => (bool)$row['is_sent'],
        'time' => $row['time'],
        'read' => (bool)$row['is_read']
    ];
}

// Mark received messages as read
if (count($messages) > 0) {
    $update_query = "UPDATE messages SET is_read = 1 
                     WHERE receiver_id = ? AND sender_id = ? AND is_read = 0";
    $update_stmt = $conn->prepare($update_query);
    $update_stmt->bind_param("ii", $current_user_id, $other_user_id);
    $update_stmt->execute();
}

echo json_encode($messages);
$conn->close();
?>
