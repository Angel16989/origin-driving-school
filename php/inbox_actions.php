<?php
session_start();
require_once '../db/db_connect.php';
require_once '../includes/security.php';

// Check if user is logged in as admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit();
}

$action = $_POST['action'] ?? '';
$messageId = $_POST['id'] ?? 0;

try {
    switch ($action) {
        case 'view':
            // Mark as read and return message details
            $stmt = $conn->prepare("UPDATE contact_messages SET status = 'read' WHERE id = ? AND status = 'new'");
            $stmt->execute([$messageId]);
            
            // Get message details
            $stmt = $conn->prepare("SELECT * FROM contact_messages WHERE id = ?");
            $stmt->execute([$messageId]);
            $message = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($message) {
                $html = generateMessageHTML($message);
                echo json_encode(['success' => true, 'html' => $html]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Message not found']);
            }
            break;
            
        case 'close':
            // Close the message
            $stmt = $conn->prepare("UPDATE contact_messages SET status = 'closed' WHERE id = ?");
            $stmt->execute([$messageId]);
            
            echo json_encode(['success' => true, 'message' => 'Message closed']);
            break;
            
        case 'reply':
            // Send reply and mark as replied
            $replyText = $_POST['reply'] ?? '';
            
            if (empty($replyText)) {
                echo json_encode(['success' => false, 'message' => 'Reply text is required']);
                exit();
            }
            
            // Get message details
            $stmt = $conn->prepare("SELECT * FROM contact_messages WHERE id = ?");
            $stmt->execute([$messageId]);
            $message = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if (!$message) {
                echo json_encode(['success' => false, 'message' => 'Message not found']);
                exit();
            }
            
            // Create replies table if it doesn't exist
            $createRepliesTable = "CREATE TABLE IF NOT EXISTS message_replies (
                id INT AUTO_INCREMENT PRIMARY KEY,
                message_id INT NOT NULL,
                admin_id INT NOT NULL,
                reply_text TEXT NOT NULL,
                sent_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                FOREIGN KEY (message_id) REFERENCES contact_messages(id) ON DELETE CASCADE,
                FOREIGN KEY (admin_id) REFERENCES users(id) ON DELETE CASCADE
            )";
            $conn->exec($createRepliesTable);
            
            // Save reply to database
            $stmt = $conn->prepare("INSERT INTO message_replies (message_id, admin_id, reply_text) VALUES (?, ?, ?)");
            $stmt->execute([$messageId, $_SESSION['user_id'], $replyText]);
            
            // Update message status
            $stmt = $conn->prepare("UPDATE contact_messages SET status = 'replied' WHERE id = ?");
            $stmt->execute([$messageId]);
            
            // Send email (placeholder for now - would integrate with real SMTP)
            $emailSent = sendReplyEmail($message, $replyText);
            
            // Log the reply
            Security::logSecurityEvent('MESSAGE_REPLY_SENT', "Admin replied to message #{$messageId} from {$message['email']}");
            
            echo json_encode([
                'success' => true, 
                'message' => 'Reply sent successfully',
                'emailSent' => $emailSent
            ]);
            break;
            
        default:
            echo json_encode(['success' => false, 'message' => 'Invalid action']);
    }
    
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
}

function generateMessageHTML($message) {
    $time = new DateTime($message['created_at']);
    $formattedTime = $time->format('F d, Y \a\t g:i A');
    
    // Get replies if any
    global $conn;
    $stmt = $conn->prepare("
        SELECT mr.*, u.username 
        FROM message_replies mr 
        JOIN users u ON mr.admin_id = u.id 
        WHERE mr.message_id = ? 
        ORDER BY mr.sent_at ASC
    ");
    $stmt->execute([$message['id']]);
    $replies = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    $statusColors = [
        'new' => '#2196f3',
        'read' => '#ff9800',
        'replied' => '#4caf50',
        'closed' => '#9e9e9e'
    ];
    
    $statusColor = $statusColors[$message['status']] ?? '#9e9e9e';
    
    $html = '
    <div class="message-details">
        <div class="detail-row">
            <span class="detail-label">From:</span>
            <span class="detail-value"><strong>' . htmlspecialchars($message['name']) . '</strong></span>
        </div>
        
        <div class="detail-row">
            <span class="detail-label">Email:</span>
            <span class="detail-value">
                <a href="mailto:' . htmlspecialchars($message['email']) . '" style="color: #2196f3; text-decoration: none;">
                    ' . htmlspecialchars($message['email']) . '
                </a>
            </span>
        </div>';
    
    if (!empty($message['phone'])) {
        $html .= '
        <div class="detail-row">
            <span class="detail-label">Phone:</span>
            <span class="detail-value">
                <a href="tel:' . htmlspecialchars($message['phone']) . '" style="color: #2196f3; text-decoration: none;">
                    ' . htmlspecialchars($message['phone']) . '
                </a>
            </span>
        </div>';
    }
    
    $html .= '
        <div class="detail-row">
            <span class="detail-label">Subject:</span>
            <span class="detail-value"><strong>' . htmlspecialchars($message['subject']) . '</strong></span>
        </div>
        
        <div class="detail-row">
            <span class="detail-label">Received:</span>
            <span class="detail-value">' . $formattedTime . '</span>
        </div>
        
        <div class="detail-row">
            <span class="detail-label">Status:</span>
            <span class="detail-value">
                <span style="background: ' . $statusColor . '; color: white; padding: 0.3rem 0.8rem; border-radius: 20px; font-size: 0.85rem; font-weight: 600;">
                    ' . ucfirst($message['status']) . '
                </span>
            </span>
        </div>';
    
    if ($message['newsletter_signup']) {
        $html .= '
        <div class="detail-row">
            <span class="detail-label">Newsletter:</span>
            <span class="detail-value" style="color: #4caf50; font-weight: 600;">
                ✅ Subscribed
            </span>
        </div>';
    }
    
    $html .= '
    </div>
    
    <div style="margin: 1.5rem 0;">
        <h3 style="color: #0c2461; margin-bottom: 1rem;">💬 Message:</h3>
        <div class="message-body">
            ' . nl2br(htmlspecialchars($message['message'])) . '
        </div>
    </div>';
    
    // Show previous replies if any
    if (!empty($replies)) {
        $html .= '
        <div style="margin: 2rem 0;">
            <h3 style="color: #0c2461; margin-bottom: 1rem;">📨 Previous Replies:</h3>';
        
        foreach ($replies as $reply) {
            $replyTime = new DateTime($reply['sent_at']);
            $html .= '
            <div style="background: #e8f5e9; padding: 1.5rem; border-radius: 10px; margin-bottom: 1rem; border-left: 4px solid #4caf50;">
                <div style="display: flex; justify-content: space-between; margin-bottom: 0.5rem;">
                    <strong style="color: #2e7d32;">👤 ' . htmlspecialchars($reply['username']) . '</strong>
                    <span style="color: #666; font-size: 0.9rem;">' . $replyTime->format('M d, Y g:i A') . '</span>
                </div>
                <div style="color: #333; line-height: 1.6;">
                    ' . nl2br(htmlspecialchars($reply['reply_text'])) . '
                </div>
            </div>';
        }
        
        $html .= '</div>';
    }
    
    // Reply form
    $html .= '
    <div class="reply-form">
        <h3 style="color: #0c2461; margin-bottom: 1rem;">✉️ Send Reply:</h3>
        <textarea id="replyText" placeholder="Type your reply here..." style="margin-bottom: 1rem;"></textarea>
        
        <div style="display: flex; gap: 1rem; justify-content: flex-end;">
            <button onclick="closeModal()" style="padding: 1rem 2rem; background: #9e9e9e; color: white; border: none; border-radius: 10px; cursor: pointer; font-weight: 600; transition: all 0.3s;">
                Cancel
            </button>
            <button onclick="sendReply(' . $message['id'] . ')" style="padding: 1rem 2rem; background: #4caf50; color: white; border: none; border-radius: 10px; cursor: pointer; font-weight: 600; transition: all 0.3s;">
                📤 Send Reply
            </button>
        </div>
    </div>';
    
    return $html;
}

function sendReplyEmail($message, $replyText) {
    // Placeholder for email sending functionality
    // In production, integrate with PHPMailer or similar SMTP service
    
    $to = $message['email'];
    $subject = "Re: " . $message['subject'] . " - Origin Driving School";
    
    $emailBody = "
    <html>
    <head>
        <style>
            body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
            .header { background: linear-gradient(135deg, #0c2461, #1e3799); color: white; padding: 2rem; text-align: center; }
            .content { padding: 2rem; background: #f8f9fa; }
            .message { background: white; padding: 1.5rem; border-radius: 10px; margin: 1rem 0; }
            .footer { background: #333; color: white; padding: 1rem; text-align: center; font-size: 0.9rem; }
        </style>
    </head>
    <body>
        <div class='header'>
            <h1>🚗 Origin Driving School</h1>
            <p>Professional Driving Education</p>
        </div>
        
        <div class='content'>
            <p>Dear " . htmlspecialchars($message['name']) . ",</p>
            
            <p>Thank you for contacting Origin Driving School. We have received your message and here is our response:</p>
            
            <div class='message'>
                " . nl2br(htmlspecialchars($replyText)) . "
            </div>
            
            <p>If you have any further questions, please don't hesitate to contact us.</p>
            
            <p>Best regards,<br>
            <strong>Origin Driving School Team</strong></p>
            
            <hr>
            
            <p style='font-size: 0.9rem; color: #666;'><strong>Your Original Message:</strong></p>
            <div style='background: #f0f0f0; padding: 1rem; border-left: 4px solid #0c2461; margin: 1rem 0;'>
                " . nl2br(htmlspecialchars($message['message'])) . "
            </div>
        </div>
        
        <div class='footer'>
            <p>📞 +61 4 1234 5678 | ✉️ info@origindrivingschool.com</p>
            <p>123 Main Street, Sydney, NSW 2000, Australia</p>
            <p>&copy; 2025 Origin Driving School. All rights reserved.</p>
        </div>
    </body>
    </html>
    ";
    
    // Headers for HTML email
    $headers = "MIME-Version: 1.0\r\n";
    $headers .= "Content-type: text/html; charset=UTF-8\r\n";
    $headers .= "From: Origin Driving School <noreply@origindrivingschool.com>\r\n";
    $headers .= "Reply-To: info@origindrivingschool.com\r\n";
    
    // In development, we'll just log it (in production, use PHPMailer with SMTP)
    // For now, return true to indicate it would be sent
    // mail($to, $subject, $emailBody, $headers);
    
    // Log email for development
    $logFile = '../temp_emails/' . date('Y-m-d_H-i-s') . '_' . $message['id'] . '.html';
    @mkdir('../temp_emails', 0777, true);
    file_put_contents($logFile, $emailBody);
    
    return true; // Return false if email fails in production
}
?>
