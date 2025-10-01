<?php
// messages.php - Messaging System (Admin View)
session_start();
require_once 'db_connect.php';
require_once 'role_nav.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: ../login.php');
    exit;
}

$user_id = $_SESSION['user_id'];
$user_role = $_SESSION['role'];

// Handle message sending
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['send_message'])) {
    $recipient_type = $_POST['recipient_type'];
    $recipient_id = $_POST['recipient_id'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];
    
    $stmt = $conn->prepare("INSERT INTO messages (sender_type, sender_id, recipient_type, recipient_id, subject, message) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param('sisiss', $user_role, $user_id, $recipient_type, $recipient_id, $subject, $message);
    
    if ($stmt->execute()) {
        header('Location: messages.php?sent=1');
    } else {
        header('Location: messages.php?error=1');
    }
    exit;
}

// Get all messages for admin (can see all messages)
if ($user_role === 'admin') {
    $messages_query = $conn->prepare("
        SELECT m.*, 
               CASE 
                   WHEN m.sender_type = 'admin' THEN CONCAT('Admin #', m.sender_id)
                   WHEN m.sender_type = 'instructor' THEN COALESCE(i.name, CONCAT('Instructor #', m.sender_id))
                   WHEN m.sender_type = 'student' THEN COALESCE(s.name, CONCAT('Student #', m.sender_id))
               END as sender_name,
               CASE 
                   WHEN m.recipient_type = 'admin' THEN CONCAT('Admin #', m.recipient_id)
                   WHEN m.recipient_type = 'instructor' THEN COALESCE(i2.name, CONCAT('Instructor #', m.recipient_id))
                   WHEN m.recipient_type = 'student' THEN COALESCE(s2.name, CONCAT('Student #', m.recipient_id))
               END as recipient_name
        FROM messages m
        LEFT JOIN instructors i ON m.sender_type = 'instructor' AND m.sender_id = i.id
        LEFT JOIN students s ON m.sender_type = 'student' AND m.sender_id = s.id
        LEFT JOIN instructors i2 ON m.recipient_type = 'instructor' AND m.recipient_id = i2.id
        LEFT JOIN students s2 ON m.recipient_type = 'student' AND m.recipient_id = s2.id
        ORDER BY m.created_at DESC
    ");
    $messages_query->execute();
    $messages = $messages_query->get_result();
} else {
    // For non-admin users, show only their messages
    $messages_query = $conn->prepare("
        SELECT m.*, 
               CASE 
                   WHEN m.sender_type = 'admin' THEN 'System Admin'
                   WHEN m.sender_type = 'instructor' THEN COALESCE(i.name, CONCAT('Instructor #', m.sender_id))
                   WHEN m.sender_type = 'student' THEN COALESCE(s.name, CONCAT('Student #', m.sender_id))
               END as sender_name,
               CASE 
                   WHEN m.recipient_type = 'admin' THEN 'System Admin'
                   WHEN m.recipient_type = 'instructor' THEN COALESCE(i2.name, CONCAT('Instructor #', m.recipient_id))
                   WHEN m.recipient_type = 'student' THEN COALESCE(s2.name, CONCAT('Student #', m.recipient_id))
               END as recipient_name
        FROM messages m
        LEFT JOIN instructors i ON m.sender_type = 'instructor' AND m.sender_id = i.id
        LEFT JOIN students s ON m.sender_type = 'student' AND m.sender_id = s.id
        LEFT JOIN instructors i2 ON m.recipient_type = 'instructor' AND m.recipient_id = i2.id
        LEFT JOIN students s2 ON m.recipient_type = 'student' AND m.recipient_id = s2.id
        WHERE (m.sender_type = ? AND m.sender_id = ?) OR (m.recipient_type = ? AND m.recipient_id = ?)
        ORDER BY m.created_at DESC
    ");
    $messages_query->bind_param('sisi', $user_role, $user_id, $user_role, $user_id);
    $messages_query->execute();
    $messages = $messages_query->get_result();
}

// Get users for messaging dropdowns
$instructors = $conn->query("SELECT id, name FROM instructors ORDER BY name");
$students = $conn->query("SELECT id, name FROM students ORDER BY name");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Messages - Origin Driving School</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body class="page-transition">
    <header>
        <h1>💬 Messages</h1>
        <p><?php echo $user_role === 'admin' ? 'System-wide messaging overview' : 'Your message center'; ?></p>
    </header>
    
    <?php renderNavigation($user_role); ?>
    
    <div class="container">
        <?php if (isset($_GET['sent'])): ?>
        <div class="message success">
            <strong>✅ Message Sent Successfully!</strong>
        </div>
        <?php elseif (isset($_GET['error'])): ?>
        <div class="message error">
            <strong>❌ Error sending message.</strong> Please try again.
        </div>
        <?php endif; ?>
        
        <h2>� Send New Message</h2>
        <form method="post" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); padding: 2rem; border-radius: 20px; margin-bottom: 2rem;">
            <div class="form-group">
                <label for="recipient_type">� Send To:</label>
                <select name="recipient_type" id="recipient_type" required onchange="toggleRecipients()">
                    <option value="">Select recipient type...</option>
                    <?php if ($user_role === 'admin'): ?>
                    <option value="instructor">�‍🏫 Instructor</option>
                    <option value="student">🎓 Student</option>
                    <?php elseif ($user_role === 'instructor'): ?>
                    <option value="admin">⚙️ Administrator</option>
                    <option value="student">🎓 Student</option>
                    <?php else: ?>
                    <option value="admin">⚙️ Administrator</option>
                    <option value="instructor">👨‍🏫 Instructor</option>
                    <?php endif; ?>
                </select>
            </div>
            
            <div class="form-group" id="instructor-select" style="display: none;">
                <label for="instructor_id">👨‍🏫 Select Instructor:</label>
                <select name="recipient_id" id="instructor_id">
                    <option value="">Choose instructor...</option>
                    <?php while($instructor = $instructors->fetch_assoc()): ?>
                    <option value="<?php echo $instructor['id']; ?>"><?php echo htmlspecialchars($instructor['name']); ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
            
            <div class="form-group" id="student-select" style="display: none;">
                <label for="student_id">🎓 Select Student:</label>
                <select name="recipient_id" id="student_id">
                    <option value="">Choose student...</option>
                    <?php while($student = $students->fetch_assoc()): ?>
                    <option value="<?php echo $student['id']; ?>"><?php echo htmlspecialchars($student['name']); ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
            
            <div class="form-group">
                <label for="subject">📋 Subject:</label>
                <input type="text" name="subject" id="subject" required placeholder="Enter message subject...">
            </div>
            
            <div class="form-group">
                <label for="message">💬 Message:</label>
                <textarea name="message" id="message" rows="6" required placeholder="Type your message here..."></textarea>
            </div>
            
            <button type="submit" name="send_message" class="btn btn-success">� Send Message</button>
        </form>
        
        <h2>📥 Message History</h2>
        
        <?php if ($messages && $messages->num_rows > 0): ?>
        <div style="display: flex; flex-direction: column; gap: 1.5rem;">
            <?php while($msg = $messages->fetch_assoc()): ?>
            <div class="message-card" style="background: <?php echo ($msg['sender_type'] === $user_role) ? 'linear-gradient(135deg, #e8f5e8 0%, #d4edda 100%)' : 'linear-gradient(135deg, #fff 0%, #f8f9fa 100%)'; ?>; padding: 1.5rem; border-radius: 15px; border-left: 5px solid <?php echo ($msg['sender_type'] === $user_role) ? 'var(--green-light)' : 'var(--blue-light)'; ?>;">
                <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 1rem;">
                    <div>
                        <h4 style="margin: 0; color: var(--text-dark);">
                            <?php if ($msg['sender_type'] === $user_role): ?>
                                📤 <strong>You</strong> → <?php echo htmlspecialchars($msg['recipient_name']); ?>
                            <?php else: ?>
                                📥 <strong><?php echo htmlspecialchars($msg['sender_name']); ?></strong> → <?php echo ($msg['recipient_type'] === $user_role) ? 'You' : htmlspecialchars($msg['recipient_name']); ?>
                            <?php endif; ?>
                        </h4>
                        <div style="font-size: 0.9rem; opacity: 0.7; margin-top: 0.3rem;">
                            📅 <?php echo date('M j, Y g:i A', strtotime($msg['created_at'])); ?>
                        </div>
                    </div>
                    <span class="status-badge <?php echo ($msg['sender_type'] === $user_role) ? 'success' : 'info'; ?>">
                        <?php echo ($msg['sender_type'] === $user_role) ? 'Sent' : 'Received'; ?>
                    </span>
                </div>
                <div style="background: rgba(255,255,255,0.7); padding: 1rem; border-radius: 10px; margin-bottom: 1rem;">
                    <strong>📋 Subject:</strong> <?php echo htmlspecialchars($msg['subject']); ?>
                </div>
                <div style="line-height: 1.6;">
                    <?php echo nl2br(htmlspecialchars($msg['message'])); ?>
                </div>
            </div>
            <?php endwhile; ?>
        </div>
        
        <?php else: ?>
        <div style="text-align: center; padding: 4rem; background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border-radius: 20px;">
            <div style="font-size: 4rem; margin-bottom: 1rem;">💬</div>
            <h3>No Messages Yet</h3>
            <p>Your message history will appear here. Send your first message using the form above!</p>
        </div>
        <?php endif; ?>
    </div>
    
    <footer>&copy; 2025 Origin Driving School</footer>
    
    <script>
        function toggleRecipients() {
            const recipientType = document.getElementById('recipient_type').value;
            const instructorSelect = document.getElementById('instructor-select');
            const studentSelect = document.getElementById('student-select');
            const instructorDropdown = document.getElementById('instructor_id');
            const studentDropdown = document.getElementById('student_id');
            
            // Hide all selects first
            instructorSelect.style.display = 'none';
            studentSelect.style.display = 'none';
            instructorDropdown.required = false;
            studentDropdown.required = false;
            
            if (recipientType === 'instructor') {
                instructorSelect.style.display = 'block';
                instructorDropdown.required = true;
                instructorDropdown.name = 'recipient_id';
                studentDropdown.name = '';
            } else if (recipientType === 'student') {
                studentSelect.style.display = 'block';
                studentDropdown.required = true;
                studentDropdown.name = 'recipient_id';
                instructorDropdown.name = '';
            } else if (recipientType === 'admin') {
                // Set admin ID (assuming admin ID is 1)
                const form = document.querySelector('form');
                let adminInput = form.querySelector('input[name="recipient_id"]');
                if (!adminInput) {
                    adminInput = document.createElement('input');
                    adminInput.type = 'hidden';
                    adminInput.name = 'recipient_id';
                    form.appendChild(adminInput);
                }
                adminInput.value = '1'; // Default admin ID
            }
        }
    </script>
</body>
</html>
