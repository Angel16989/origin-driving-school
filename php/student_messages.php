<?php
// student_messages.php - Student Messages
session_start();
require_once 'db_connect.php';
require_once 'role_nav.php';

checkRoleAccess(['student'], $_SESSION['role']);

$user_id = $_SESSION['user_id'];

// Get student ID
$stmt = $conn->prepare("SELECT s.id, s.name FROM students s JOIN users u ON u.username = s.email WHERE u.id = ?");
$stmt->bind_param('i', $user_id);
$stmt->execute();
$student_result = $stmt->get_result();
$student = $student_result->fetch_assoc();

if (!$student) {
    header('Location: ../dashboard.php?error=student_not_found');
    exit;
}

$student_id = $student['id'];

// Handle message sending
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['send_message'])) {
    $recipient_type = $_POST['recipient_type']; // 'instructor' or 'admin'
    $recipient_id = $_POST['recipient_id'];
    $message = $_POST['message'];
    $subject = $_POST['subject'];
    
    $stmt = $conn->prepare("INSERT INTO messages (sender_type, sender_id, recipient_type, recipient_id, subject, message, created_at) VALUES ('student', ?, ?, ?, ?, ?, NOW())");
    $stmt->bind_param('isiss', $student_id, $recipient_type, $recipient_id, $subject, $message);
    $stmt->execute();
    
    header('Location: student_messages.php?sent=1');
    exit;
}

// Get messages for student
$messages_query = $conn->prepare("
    SELECT m.*, 
           CASE 
               WHEN m.sender_type = 'admin' THEN 'System Admin'
               WHEN m.sender_type = 'instructor' THEN i.name
               ELSE 'Unknown'
           END as sender_name,
           CASE 
               WHEN m.recipient_type = 'admin' THEN 'System Admin'
               WHEN m.recipient_type = 'instructor' THEN i2.name
               ELSE 'Unknown'
           END as recipient_name
    FROM messages m
    LEFT JOIN instructors i ON m.sender_type = 'instructor' AND m.sender_id = i.id
    LEFT JOIN instructors i2 ON m.recipient_type = 'instructor' AND m.recipient_id = i2.id
    WHERE (m.recipient_type = 'student' AND m.recipient_id = ?) 
       OR (m.sender_type = 'student' AND m.sender_id = ?)
    ORDER BY m.created_at DESC
");
$messages_query->bind_param('ii', $student_id, $student_id);
$messages_query->execute();
$messages = $messages_query->get_result();

// Get instructors for messaging (instructors who have taught this student)
$instructors_query = $conn->prepare("
    SELECT DISTINCT i.id, i.name 
    FROM instructors i 
    JOIN bookings b ON i.id = b.instructor_id 
    WHERE b.student_id = ?
    ORDER BY i.name
");
$instructors_query->bind_param('i', $student_id);
$instructors_query->execute();
$instructors = $instructors_query->get_result();
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
        <p>Communicate with instructors and administrators</p>
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
                    <option value="instructor">👨‍🏫 Instructor</option>
                    <option value="admin">⚙️ Administrator</option>
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
            <div class="message-card" style="background: <?php echo ($msg['sender_type'] === 'student' && $msg['sender_id'] == $student_id) ? 'linear-gradient(135deg, #e8f5e8 0%, #d4edda 100%)' : 'linear-gradient(135deg, #fff 0%, #f8f9fa 100%)'; ?>; padding: 1.5rem; border-radius: 15px; border-left: 5px solid <?php echo ($msg['sender_type'] === 'student' && $msg['sender_id'] == $student_id) ? 'var(--green-light)' : 'var(--blue-light)'; ?>;">
                <div style="display: flex; justify-content: between; align-items: flex-start; margin-bottom: 1rem;">
                    <div>
                        <h4 style="margin: 0; color: var(--text-dark);">
                            <?php if ($msg['sender_type'] === 'student' && $msg['sender_id'] == $student_id): ?>
                                📤 <strong>You</strong> → <?php echo htmlspecialchars($msg['recipient_name']); ?>
                            <?php else: ?>
                                📥 <strong><?php echo htmlspecialchars($msg['sender_name']); ?></strong> → You
                            <?php endif; ?>
                        </h4>
                        <div style="font-size: 0.9rem; opacity: 0.7; margin-top: 0.3rem;">
                            📅 <?php echo date('M j, Y g:i A', strtotime($msg['created_at'])); ?>
                        </div>
                    </div>
                    <span class="status-badge <?php echo ($msg['sender_type'] === 'student' && $msg['sender_id'] == $student_id) ? 'success' : 'info'; ?>">
                        <?php echo ($msg['sender_type'] === 'student' && $msg['sender_id'] == $student_id) ? 'Sent' : 'Received'; ?>
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
        
        <!-- Message Templates -->
        <div style="background: linear-gradient(135deg, var(--green-light) 0%, #26de81 100%); color: white; padding: 2rem; border-radius: 20px; margin: 2rem 0;">
            <h3>💡 Quick Message Templates</h3>
            <p>Click on any template to use it:</p>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 1rem; margin-top: 1.5rem;">
                <button onclick="useTemplate('Lesson Rescheduling Request', 'I would like to reschedule my upcoming lesson due to a scheduling conflict. Please let me know available times.')" class="btn" style="background: rgba(255,255,255,0.2); border: 2px solid rgba(255,255,255,0.3); text-align: left; padding: 1rem;">
                    📅 <strong>Reschedule Lesson</strong><br><small>Request lesson time change</small>
                </button>
                <button onclick="useTemplate('Lesson Feedback', 'Thank you for the excellent lesson today. I have some questions about the parking techniques we covered.')" class="btn" style="background: rgba(255,255,255,0.2); border: 2px solid rgba(255,255,255,0.3); text-align: left; padding: 1rem;">
                    💭 <strong>Lesson Feedback</strong><br><small>Share feedback or ask questions</small>
                </button>
                <button onclick="useTemplate('Progress Inquiry', 'I would like to know about my current progress and what areas I should focus on for improvement.')" class="btn" style="background: rgba(255,255,255,0.2); border: 2px solid rgba(255,255,255,0.3); text-align: left; padding: 1rem;">
                    📊 <strong>Progress Check</strong><br><small>Ask about your driving progress</small>
                </button>
            </div>
        </div>
        
        <!-- Quick Actions -->
        <div style="background: linear-gradient(135deg, var(--blue-light) 0%, #3d4de8 100%); color: white; padding: 2rem; border-radius: 20px; margin: 2rem 0; text-align: center;">
            <h3>🚗 Student Hub</h3>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem; margin-top: 1.5rem;">
                <a href="my_bookings.php" class="btn" style="background: rgba(255,255,255,0.2); border: 2px solid rgba(255,255,255,0.3);">
                    📅 My Lessons
                </a>
                <a href="my_profile.php" class="btn" style="background: rgba(255,255,255,0.2); border: 2px solid rgba(255,255,255,0.3);">
                    👤 My Profile
                </a>
                <a href="../dashboard.php" class="btn" style="background: rgba(255,255,255,0.2); border: 2px solid rgba(255,255,255,0.3);">
                    🏠 Dashboard
                </a>
            </div>
        </div>
    </div>
    
    <footer>&copy; 2025 Origin Driving School - Student Portal</footer>
    
    <script>
        function toggleRecipients() {
            const recipientType = document.getElementById('recipient_type').value;
            const instructorSelect = document.getElementById('instructor-select');
            const instructorDropdown = document.getElementById('instructor_id');
            
            if (recipientType === 'instructor') {
                instructorSelect.style.display = 'block';
                instructorDropdown.required = true;
                instructorDropdown.name = 'recipient_id';
            } else if (recipientType === 'admin') {
                instructorSelect.style.display = 'none';
                instructorDropdown.required = false;
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
                instructorSelect.style.display = 'none';
                instructorDropdown.required = false;
            }
        }
        
        function useTemplate(subject, message) {
            document.getElementById('subject').value = subject;
            document.getElementById('message').value = message;
            // Scroll to form
            document.querySelector('form').scrollIntoView({ behavior: 'smooth' });
        }
    </script>
</body>
</html>
