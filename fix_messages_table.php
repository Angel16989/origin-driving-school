<?php
// fix_messages_table.php - Update messages table structure
require_once 'php/db_connect.php';

echo "<h2>Fixing Messages Table Structure</h2>";

// Drop the existing messages table
$drop_result = $conn->query("DROP TABLE IF EXISTS messages");
if ($drop_result) {
    echo "<p style='color: green;'>✅ Dropped old messages table</p>";
} else {
    echo "<p style='color: red;'>❌ Error dropping table: " . $conn->error . "</p>";
}

// Create new messages table with proper structure
$create_sql = "CREATE TABLE messages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    sender_type ENUM('admin', 'instructor', 'student') NOT NULL,
    sender_id INT NOT NULL,
    recipient_type ENUM('admin', 'instructor', 'student') NOT NULL,
    recipient_id INT NOT NULL,
    subject VARCHAR(255) NOT NULL,
    message TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    read_status BOOLEAN DEFAULT FALSE,
    INDEX idx_recipient (recipient_type, recipient_id),
    INDEX idx_sender (sender_type, sender_id),
    INDEX idx_created (created_at)
)";

$create_result = $conn->query($create_sql);
if ($create_result) {
    echo "<p style='color: green;'>✅ Created new messages table with proper structure</p>";
} else {
    echo "<p style='color: red;'>❌ Error creating table: " . $conn->error . "</p>";
}

// Insert sample messages for testing
$sample_messages = [
    // Admin to student
    [
        'sender_type' => 'admin',
        'sender_id' => 1,
        'recipient_type' => 'student', 
        'recipient_id' => 1,
        'subject' => 'Welcome to Origin Driving School!',
        'message' => 'Welcome John! We are excited to have you as our student. Your instructor Mike Brown will be in touch soon to schedule your first lesson.'
    ],
    // Instructor to student
    [
        'sender_type' => 'instructor',
        'sender_id' => 1, 
        'recipient_type' => 'student',
        'recipient_id' => 1,
        'subject' => 'First Lesson Scheduled',
        'message' => 'Hi John, I have scheduled your first driving lesson for tomorrow at 10 AM. Please bring your learner\'s permit and be ready 15 minutes early. Looking forward to working with you!'
    ],
    // Student to instructor
    [
        'sender_type' => 'student',
        'sender_id' => 1,
        'recipient_type' => 'instructor', 
        'recipient_id' => 1,
        'subject' => 'Question about parking',
        'message' => 'Hi Mike, thank you for the lesson today. I have a question about parallel parking - could you give me some additional tips for next time?'
    ]
];

$stmt = $conn->prepare("INSERT INTO messages (sender_type, sender_id, recipient_type, recipient_id, subject, message) VALUES (?, ?, ?, ?, ?, ?)");

foreach ($sample_messages as $msg) {
    $stmt->bind_param('sisiss', $msg['sender_type'], $msg['sender_id'], $msg['recipient_type'], $msg['recipient_id'], $msg['subject'], $msg['message']);
    if ($stmt->execute()) {
        echo "<p style='color: green;'>✅ Added sample message: " . htmlspecialchars($msg['subject']) . "</p>";
    } else {
        echo "<p style='color: red;'>❌ Error adding message: " . $stmt->error . "</p>";
    }
}

echo "<h3>New Messages Table Structure:</h3>";
$result = $conn->query('DESCRIBE messages');
if ($result) {
    echo "<table border='1' style='border-collapse: collapse; margin: 1rem 0;'>";
    echo "<tr style='background: #f0f0f0;'><th style='padding: 8px;'>Field</th><th style='padding: 8px;'>Type</th><th style='padding: 8px;'>Null</th><th style='padding: 8px;'>Key</th><th style='padding: 8px;'>Default</th></tr>";
    while($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td style='padding: 8px; font-weight: bold;'>" . $row['Field'] . "</td>";
        echo "<td style='padding: 8px;'>" . $row['Type'] . "</td>";
        echo "<td style='padding: 8px;'>" . $row['Null'] . "</td>";
        echo "<td style='padding: 8px;'>" . $row['Key'] . "</td>";
        echo "<td style='padding: 8px;'>" . $row['Default'] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
}

echo "<h3>Sample Messages Added:</h3>";
$messages_result = $conn->query('SELECT * FROM messages ORDER BY created_at DESC');
if ($messages_result && $messages_result->num_rows > 0) {
    while($row = $messages_result->fetch_assoc()) {
        echo "<div style='background: #f9f9f9; padding: 1rem; margin: 1rem 0; border-left: 4px solid #007bff;'>";
        echo "<h4>" . htmlspecialchars($row['subject']) . "</h4>";
        echo "<p><strong>From:</strong> " . ucfirst($row['sender_type']) . " #" . $row['sender_id'] . " <strong>To:</strong> " . ucfirst($row['recipient_type']) . " #" . $row['recipient_id'] . "</p>";
        echo "<p>" . nl2br(htmlspecialchars($row['message'])) . "</p>";
        echo "<small>Sent: " . $row['created_at'] . "</small>";
        echo "</div>";
    }
} else {
    echo "<p>No messages found.</p>";
}

echo "<p style='background: #d4edda; padding: 1rem; border-radius: 5px; margin: 2rem 0;'><strong>✅ Messages table fixed!</strong> The messaging system should now work properly.</p>";
?>
