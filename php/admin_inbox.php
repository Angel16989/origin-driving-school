<?php
session_start();
require_once '../db/db_connect.php';
require_once '../includes/security.php';

// Check if user is logged in as admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

$page_title = "Admin Inbox - Origin Driving School";
$page_description = "Contact messages and inquiries";

// Get filter status
$filter = $_POST['filter'] ?? $_GET['filter'] ?? 'all';
$search = $_POST['search'] ?? $_GET['search'] ?? '';

// Build query based on filters
$query = "SELECT * FROM contact_messages WHERE 1=1";
$params = [];

if ($filter !== 'all') {
    $query .= " AND status = ?";
    $params[] = $filter;
}

if (!empty($search)) {
    $query .= " AND (name LIKE ? OR email LIKE ? OR subject LIKE ? OR message LIKE ?)";
    $searchTerm = "%{$search}%";
    $params = array_merge($params, [$searchTerm, $searchTerm, $searchTerm, $searchTerm]);
}

$query .= " ORDER BY created_at DESC";

try {
    $stmt = $conn->prepare($query);
    $stmt->execute($params);
    $messages = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Get counts for each status
    $newCount = $conn->query("SELECT COUNT(*) FROM contact_messages WHERE status = 'new'")->fetchColumn();
    $readCount = $conn->query("SELECT COUNT(*) FROM contact_messages WHERE status = 'read'")->fetchColumn();
    $repliedCount = $conn->query("SELECT COUNT(*) FROM contact_messages WHERE status = 'replied'")->fetchColumn();
    $closedCount = $conn->query("SELECT COUNT(*) FROM contact_messages WHERE status = 'closed'")->fetchColumn();
    $totalCount = $conn->query("SELECT COUNT(*) FROM contact_messages")->fetchColumn();
    
} catch (PDOException $e) {
    $error_message = "Error loading messages: " . $e->getMessage();
}

include '../includes/header.php';
?>

<style>
    .inbox-container {
        max-width: 1400px;
        margin: 2rem auto;
        padding: 0 2rem;
    }
    
    .inbox-header {
        background: linear-gradient(135deg, #0c2461 0%, #1e3799 100%);
        color: white;
        padding: 2rem;
        border-radius: 15px;
        margin-bottom: 2rem;
        box-shadow: 0 10px 30px rgba(0,0,0,0.2);
    }
    
    .inbox-stats {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1rem;
        margin-bottom: 2rem;
    }
    
    .stat-card {
        background: white;
        padding: 1.5rem;
        border-radius: 12px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.1);
        text-align: center;
        transition: all 0.3s;
        cursor: pointer;
    }
    
    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 30px rgba(0,0,0,0.15);
    }
    
    .stat-card.active {
        background: linear-gradient(135deg, #ffc107 0%, #ffb300 100%);
        color: white;
    }
    
    .stat-number {
        font-size: 2.5rem;
        font-weight: 800;
        margin-bottom: 0.5rem;
    }
    
    .stat-label {
        font-size: 0.95rem;
        opacity: 0.8;
    }
    
    .inbox-filters {
        background: white;
        padding: 1.5rem;
        border-radius: 12px;
        margin-bottom: 2rem;
        box-shadow: 0 5px 20px rgba(0,0,0,0.1);
    }
    
    .search-box {
        display: flex;
        gap: 1rem;
        align-items: center;
    }
    
    .search-box input {
        flex: 1;
        padding: 1rem;
        border: 2px solid #e0e0e0;
        border-radius: 10px;
        font-size: 1rem;
        transition: all 0.3s;
    }
    
    .search-box input:focus {
        border-color: var(--primary-color);
        outline: none;
        box-shadow: 0 0 0 3px rgba(12, 36, 97, 0.1);
    }
    
    .messages-list {
        background: white;
        border-radius: 12px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.1);
        overflow: hidden;
    }
    
    .message-item {
        padding: 1.5rem;
        border-bottom: 1px solid #f0f0f0;
        transition: all 0.3s;
        cursor: pointer;
        position: relative;
    }
    
    .message-item:hover {
        background: #f8f9fa;
    }
    
    .message-item.unread {
        background: #e3f2fd;
        border-left: 4px solid #2196f3;
    }
    
    .message-header {
        display: flex;
        justify-content: space-between;
        align-items: start;
        margin-bottom: 0.5rem;
    }
    
    .message-sender {
        font-weight: 700;
        font-size: 1.1rem;
        color: #0c2461;
    }
    
    .message-email {
        color: #666;
        font-size: 0.9rem;
    }
    
    .message-time {
        color: #999;
        font-size: 0.85rem;
    }
    
    .message-subject {
        font-weight: 600;
        margin: 0.5rem 0;
        color: #333;
    }
    
    .message-preview {
        color: #666;
        font-size: 0.95rem;
        line-height: 1.5;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    
    .message-footer {
        display: flex;
        gap: 1rem;
        margin-top: 1rem;
        align-items: center;
    }
    
    .status-badge {
        display: inline-block;
        padding: 0.3rem 0.8rem;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 600;
    }
    
    .status-new {
        background: #e3f2fd;
        color: #1976d2;
    }
    
    .status-read {
        background: #fff3e0;
        color: #f57c00;
    }
    
    .status-replied {
        background: #e8f5e9;
        color: #388e3c;
    }
    
    .status-closed {
        background: #f5f5f5;
        color: #757575;
    }
    
    .action-buttons {
        display: flex;
        gap: 0.5rem;
    }
    
    .btn-sm {
        padding: 0.5rem 1rem;
        font-size: 0.85rem;
        border-radius: 8px;
        border: none;
        cursor: pointer;
        transition: all 0.3s;
        font-weight: 600;
    }
    
    .btn-view {
        background: #2196f3;
        color: white;
    }
    
    .btn-view:hover {
        background: #1976d2;
        transform: translateY(-2px);
    }
    
    .btn-reply {
        background: #4caf50;
        color: white;
    }
    
    .btn-reply:hover {
        background: #388e3c;
        transform: translateY(-2px);
    }
    
    .btn-close {
        background: #f44336;
        color: white;
    }
    
    .btn-close:hover {
        background: #d32f2f;
        transform: translateY(-2px);
    }
    
    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
        color: #999;
    }
    
    .empty-state svg {
        font-size: 5rem;
        margin-bottom: 1rem;
    }
    
    /* Modal Styles */
    .modal {
        display: none;
        position: fixed;
        z-index: 9999;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background: rgba(0,0,0,0.7);
        backdrop-filter: blur(5px);
    }
    
    .modal.active {
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .modal-content {
        background: white;
        padding: 2rem;
        border-radius: 15px;
        max-width: 800px;
        width: 90%;
        max-height: 90vh;
        overflow-y: auto;
        box-shadow: 0 20px 60px rgba(0,0,0,0.3);
        animation: slideIn 0.3s ease-out;
    }
    
    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateY(-50px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .modal-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
        padding-bottom: 1rem;
        border-bottom: 2px solid #f0f0f0;
    }
    
    .modal-close {
        background: none;
        border: none;
        font-size: 2rem;
        cursor: pointer;
        color: #999;
        transition: color 0.3s;
    }
    
    .modal-close:hover {
        color: #333;
    }
    
    .message-details {
        margin-bottom: 2rem;
    }
    
    .detail-row {
        margin-bottom: 1rem;
        display: flex;
        gap: 1rem;
    }
    
    .detail-label {
        font-weight: 700;
        color: #0c2461;
        min-width: 100px;
    }
    
    .detail-value {
        color: #666;
    }
    
    .message-body {
        background: #f8f9fa;
        padding: 1.5rem;
        border-radius: 10px;
        margin: 1.5rem 0;
        line-height: 1.8;
    }
    
    .reply-form {
        margin-top: 2rem;
        padding-top: 2rem;
        border-top: 2px solid #f0f0f0;
    }
    
    .reply-form textarea {
        width: 100%;
        padding: 1rem;
        border: 2px solid #e0e0e0;
        border-radius: 10px;
        font-size: 1rem;
        font-family: inherit;
        resize: vertical;
        min-height: 150px;
    }
    
    .reply-form textarea:focus {
        border-color: var(--primary-color);
        outline: none;
        box-shadow: 0 0 0 3px rgba(12, 36, 97, 0.1);
    }
</style>

<div class="inbox-container">
    <!-- Header -->
    <div class="inbox-header">
        <h1 style="margin: 0 0 0.5rem 0; font-size: 2.5rem;">📬 Admin Inbox</h1>
        <p style="margin: 0; opacity: 0.9; font-size: 1.1rem;">Manage contact form submissions and customer inquiries</p>
    </div>
    
    <!-- Statistics Cards -->
    <div class="inbox-stats">
        <form method="GET" style="display: contents;">
            <button type="submit" name="filter" value="all" class="stat-card <?php echo $filter === 'all' ? 'active' : ''; ?>" style="border: none; width: 100%;">
                <div class="stat-number"><?php echo $totalCount; ?></div>
                <div class="stat-label">📊 Total Messages</div>
            </button>
            
            <button type="submit" name="filter" value="new" class="stat-card <?php echo $filter === 'new' ? 'active' : ''; ?>" style="border: none; width: 100%;">
                <div class="stat-number"><?php echo $newCount; ?></div>
                <div class="stat-label">🆕 New</div>
            </button>
            
            <button type="submit" name="filter" value="read" class="stat-card <?php echo $filter === 'read' ? 'active' : ''; ?>" style="border: none; width: 100%;">
                <div class="stat-number"><?php echo $readCount; ?></div>
                <div class="stat-label">👀 Read</div>
            </button>
            
            <button type="submit" name="filter" value="replied" class="stat-card <?php echo $filter === 'replied' ? 'active' : ''; ?>" style="border: none; width: 100%;">
                <div class="stat-number"><?php echo $repliedCount; ?></div>
                <div class="stat-label">✅ Replied</div>
            </button>
            
            <button type="submit" name="filter" value="closed" class="stat-card <?php echo $filter === 'closed' ? 'active' : ''; ?>" style="border: none; width: 100%;">
                <div class="stat-number"><?php echo $closedCount; ?></div>
                <div class="stat-label">🔒 Closed</div>
            </button>
        </form>
    </div>
    
    <!-- Search and Filters -->
    <div class="inbox-filters">
        <form method="GET" class="search-box">
            <input type="hidden" name="filter" value="<?php echo htmlspecialchars($filter); ?>">
            <input type="text" name="search" placeholder="🔍 Search by name, email, subject, or message..." value="<?php echo htmlspecialchars($search); ?>">
            <button type="submit" class="btn btn-primary" style="padding: 1rem 2rem;">Search</button>
            <?php if (!empty($search)): ?>
                <a href="?filter=<?php echo $filter; ?>" class="btn btn-secondary" style="padding: 1rem 2rem;">Clear</a>
            <?php endif; ?>
        </form>
    </div>
    
    <!-- Messages List -->
    <div class="messages-list">
        <?php if (empty($messages)): ?>
            <div class="empty-state">
                <div style="font-size: 5rem; margin-bottom: 1rem;">📭</div>
                <h3>No messages found</h3>
                <p>There are no messages matching your criteria.</p>
            </div>
        <?php else: ?>
            <?php foreach ($messages as $msg): ?>
                <div class="message-item <?php echo $msg['status'] === 'new' ? 'unread' : ''; ?>" onclick="viewMessage(<?php echo $msg['id']; ?>)">
                    <div class="message-header">
                        <div>
                            <div class="message-sender">
                                <?php echo htmlspecialchars($msg['name']); ?>
                                <?php if ($msg['newsletter_signup']): ?>
                                    <span style="color: #4caf50; font-size: 0.9rem;">📧</span>
                                <?php endif; ?>
                            </div>
                            <div class="message-email"><?php echo htmlspecialchars($msg['email']); ?></div>
                        </div>
                        <div class="message-time">
                            <?php 
                            $time = new DateTime($msg['created_at']);
                            echo $time->format('M d, Y g:i A');
                            ?>
                        </div>
                    </div>
                    
                    <div class="message-subject">
                        📋 <?php echo htmlspecialchars($msg['subject']); ?>
                    </div>
                    
                    <div class="message-preview">
                        <?php echo htmlspecialchars(substr($msg['message'], 0, 200)); ?>...
                    </div>
                    
                    <div class="message-footer">
                        <span class="status-badge status-<?php echo $msg['status']; ?>">
                            <?php echo ucfirst($msg['status']); ?>
                        </span>
                        
                        <?php if (!empty($msg['phone'])): ?>
                            <span style="color: #666; font-size: 0.9rem;">📞 <?php echo htmlspecialchars($msg['phone']); ?></span>
                        <?php endif; ?>
                        
                        <div class="action-buttons" style="margin-left: auto;">
                            <button class="btn-sm btn-view" onclick="event.stopPropagation(); viewMessage(<?php echo $msg['id']; ?>)">
                                👁️ View
                            </button>
                            <button class="btn-sm btn-reply" onclick="event.stopPropagation(); replyMessage(<?php echo $msg['id']; ?>)">
                                ✉️ Reply
                            </button>
                            <?php if ($msg['status'] !== 'closed'): ?>
                                <button class="btn-sm btn-close" onclick="event.stopPropagation(); closeMessage(<?php echo $msg['id']; ?>)">
                                    🔒 Close
                                </button>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

<!-- Message View Modal -->
<div id="messageModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h2>📨 Message Details</h2>
            <button class="modal-close" onclick="closeModal()">&times;</button>
        </div>
        <div id="modalBody">
            <!-- Content will be loaded dynamically -->
        </div>
    </div>
</div>

<script>
function viewMessage(id) {
    // Mark as read and load message details
    fetch('inbox_actions.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `action=view&id=${id}`
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            document.getElementById('modalBody').innerHTML = data.html;
            document.getElementById('messageModal').classList.add('active');
            
            // Update status in list
            location.reload();
        }
    })
    .catch(error => console.error('Error:', error));
}

function replyMessage(id) {
    viewMessage(id);
    // Focus will be set to reply textarea by the loaded content
}

function closeMessage(id) {
    if (confirm('Are you sure you want to close this message?')) {
        fetch('inbox_actions.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `action=close&id=${id}`
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('Error closing message');
            }
        })
        .catch(error => console.error('Error:', error));
    }
}

function sendReply(messageId) {
    const replyText = document.getElementById('replyText').value;
    
    if (!replyText.trim()) {
        alert('Please enter a reply message');
        return;
    }
    
    fetch('inbox_actions.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `action=reply&id=${messageId}&reply=${encodeURIComponent(replyText)}`
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('✅ Reply sent successfully!');
            closeModal();
            location.reload();
        } else {
            alert('❌ Error sending reply: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('❌ Error sending reply');
    });
}

function closeModal() {
    document.getElementById('messageModal').classList.remove('active');
}

// Close modal when clicking outside
document.getElementById('messageModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeModal();
    }
});

// Close modal with Escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeModal();
    }
});
</script>

<?php include '../includes/footer.php'; ?>
