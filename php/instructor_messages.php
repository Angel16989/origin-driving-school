<?php
// instructor_messages.php - Instructor Messages
session_start();
require_once 'db_connect.php';
require_once 'role_nav.php';

checkRoleAccess(['instructor'], $_SESSION['role']);

$user_id = $_SESSION['user_id'];

// Get instructor ID
$stmt = $conn->prepare("SELECT i.id, i.name FROM instructors i JOIN users u ON u.username = i.email WHERE u.id = ?");
$stmt->bind_param('i', $user_id);
$stmt->execute();
$instructor_result = $stmt->get_result();
$instructor = $instructor_result->fetch_assoc();

if (!$instructor) {
    header('Location: ../dashboard.php?error=instructor_not_found');
    exit;
}

$instructor_id = $instructor['id'];

// Handle message sending
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['send_message'])) {
    $recipient_type = $_POST['recipient_type']; // 'student' or 'admin'
    $recipient_id = $_POST['recipient_id'];
    $message = $_POST['message'];
    $subject = $_POST['subject'];
    
    $stmt = $conn->prepare("INSERT INTO messages (sender_type, sender_id, recipient_type, recipient_id, subject, message, created_at) VALUES ('instructor', ?, ?, ?, ?, ?, NOW())");
    $stmt->bind_param('isiss', $instructor_id, $recipient_type, $recipient_id, $subject, $message);
    $stmt->execute();
    
    header('Location: instructor_messages.php?sent=1');
    exit;
}

// Get messages for instructor
$messages_query = $conn->prepare("
    SELECT m.*, 
           CASE 
               WHEN m.sender_type = 'admin' THEN 'System Admin'
               WHEN m.sender_type = 'student' THEN s.name
               ELSE 'Unknown'
           END as sender_name,
           CASE 
               WHEN m.recipient_type = 'admin' THEN 'System Admin'
               WHEN m.recipient_type = 'student' THEN s2.name
               ELSE 'Unknown'
           END as recipient_name
    FROM messages m
    LEFT JOIN students s ON m.sender_type = 'student' AND m.sender_id = s.id
    LEFT JOIN students s2 ON m.recipient_type = 'student' AND m.recipient_id = s2.id
    WHERE (m.recipient_type = 'instructor' AND m.recipient_id = ?) 
       OR (m.sender_type = 'instructor' AND m.sender_id = ?)
    ORDER BY m.created_at DESC
");
$messages_query->bind_param('ii', $instructor_id, $instructor_id);
$messages_query->execute();
$messages = $messages_query->get_result();

// Get students for messaging
$students_query = $conn->prepare("
    SELECT DISTINCT s.id, s.name 
    FROM students s 
    JOIN bookings b ON s.id = b.student_id 
    WHERE b.instructor_id = ?
    ORDER BY s.name
");
$students_query->bind_param('i', $instructor_id);
$students_query->execute();
$students = $students_query->get_result();
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
        <p>Communicate with students and administrators</p>
    </header>
    
    <?php renderNavigation($_SESSION['role']); ?>
    
    <div class="container">
        <?php if (isset($_GET['sent'])): ?>
        <div class="message success">
            <strong>✅ Message Sent Successfully!</strong> Your message has been delivered.
        </div>
        <?php endif; ?>
        
        <h2>📨 Send New Message</h2>
        <form method="post" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); padding: 2rem; border-radius: 20px; margin-bottom: 2rem;">
            <div class="form-group">
                <label for="recipient_type">📍 Send To:</label>
                <select name="recipient_type" id="recipient_type" required onchange="toggleRecipients()">
                    <option value="">Select recipient type...</option>
                    <option value="student">📚 Student</option>
                    <option value="admin">⚙️ Administrator</option>
                </select>
            </div>
            
            <div class="form-group" id="student-select" style="display: none;">
                <label for="student_id">👤 Select Student:</label>
                <select name="recipient_id" id="student_id">
                    <option value="">Choose student...</option>
                    <?php while($student = $students->fetch_assoc()): ?>
                    <option value="<?php echo $student['id']; ?>"><?php echo htmlspecialchars($student['name']); ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
            
            <input type="hidden" name="admin_id" value="1"> <!-- Default admin ID -->
            
            <div class="form-group">
                <label for="subject">📋 Subject:</label>
                <input type="text" name="subject" id="subject" required placeholder="Enter message subject...">
            </div>
            
            <div class="form-group">
                <label for="message">💬 Message:</label>
                <textarea name="message" id="message" rows="6" required placeholder="Type your message here..."></textarea>
            </div>
            
            <button type="submit" name="send_message" class="btn btn-success">📤 Send Message</button>
        </form>
        
        <h2>📥 Message History</h2>
        
        <?php if ($messages->num_rows > 0): ?>
        <div style="display: flex; flex-direction: column; gap: 1.5rem;">
            <?php while($msg = $messages->fetch_assoc()): ?>
            <div class="message-card" style="background: <?php echo ($msg['sender_type'] === 'instructor' && $msg['sender_id'] == $instructor_id) ? 'linear-gradient(135deg, #e8f5e8 0%, #d4edda 100%)' : 'linear-gradient(135deg, #fff 0%, #f8f9fa 100%)'; ?>; padding: 1.5rem; border-radius: 15px; border-left: 5px solid <?php echo ($msg['sender_type'] === 'instructor' && $msg['sender_id'] == $instructor_id) ? 'var(--green-light)' : 'var(--blue-light)'; ?>;">
                <div style="display: flex; justify-content: between; align-items: flex-start; margin-bottom: 1rem;">
                    <div>
                        <h4 style="margin: 0; color: var(--text-dark);">
                            <?php if ($msg['sender_type'] === 'instructor' && $msg['sender_id'] == $instructor_id): ?>
                                📤 <strong>You</strong> → <?php echo htmlspecialchars($msg['recipient_name']); ?>
                            <?php else: ?>
                                📥 <strong><?php echo htmlspecialchars($msg['sender_name']); ?></strong> → You
                            <?php endif; ?>
                        </h4>
                        <div style="font-size: 0.9rem; opacity: 0.7; margin-top: 0.3rem;">
                            📅 <?php echo date('M j, Y g:i A', strtotime($msg['created_at'])); ?>
                        </div>
                    </div>
                    <span class="status-badge <?php echo ($msg['sender_type'] === 'instructor' && $msg['sender_id'] == $instructor_id) ? 'success' : 'info'; ?>">
                        <?php echo ($msg['sender_type'] === 'instructor' && $msg['sender_id'] == $instructor_id) ? 'Sent' : 'Received'; ?>
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
        
        <!-- Quick Actions -->
        <div style="background: linear-gradient(135deg, var(--orange-signal) 0%, #ff9f43 100%); color: white; padding: 2rem; border-radius: 20px; margin: 2rem 0; text-align: center;">
            <h3>📞 Communication Hub</h3>
            <p>Stay connected with students and administration. Use messages for lesson feedback, scheduling updates, and important announcements.</p>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem; margin-top: 1.5rem;">
                <a href="my_students.php" class="btn" style="background: rgba(255,255,255,0.2); border: 2px solid rgba(255,255,255,0.3);">
                    👥 My Students
                </a>
                <a href="my_schedule.php" class="btn" style="background: rgba(255,255,255,0.2); border: 2px solid rgba(255,255,255,0.3);">
                    📅 My Schedule
                </a>
                <a href="../dashboard.php" class="btn" style="background: rgba(255,255,255,0.2); border: 2px solid rgba(255,255,255,0.3);">
                    🏠 Dashboard
                </a>
            </div>
        </div>
    </div>
    
    <footer>&copy; 2025 Origin Driving School - Instructor Portal</footer>
    
    <script>
        function toggleRecipients() {
            const recipientType = document.getElementById('recipient_type').value;
            const studentSelect = document.getElementById('student-select');
            const studentDropdown = document.getElementById('student_id');
            
            if (recipientType === 'student') {
                studentSelect.style.display = 'block';
                studentDropdown.required = true;
                studentDropdown.name = 'recipient_id';
            } else if (recipientType === 'admin') {
                studentSelect.style.display = 'none';
                studentDropdown.required = false;
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
            } else {
                studentSelect.style.display = 'none';
                studentDropdown.required = false;
            }
        }
    </script>
</body>
</html>
