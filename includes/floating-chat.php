<!-- floating-chat.php - Facebook-style Floating Chat Messenger -->
<?php
// Detect if we're in a subfolder to adjust API paths
$chat_current_dir = dirname($_SERVER['PHP_SELF']);
$chat_in_subfolder = (strpos($chat_current_dir, '/php') !== false || strpos($chat_current_dir, '\php') !== false);
$chat_api_prefix = $chat_in_subfolder ? '../php/' : 'php/';
?>
<style>
    /* Floating Chat Button */
    .chat-float-button {
        position: fixed;
        bottom: 30px;
        right: 30px;
        width: 60px;
        height: 60px;
        background: linear-gradient(135deg, #0084ff, #00a8ff);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        box-shadow: 0 4px 20px rgba(0, 132, 255, 0.4);
        z-index: 9998;
        transition: all 0.3s ease;
        animation: pulse-chat 2s infinite;
    }
    
    .chat-float-button:hover {
        transform: scale(1.1);
        box-shadow: 0 6px 30px rgba(0, 132, 255, 0.6);
    }
    
    .chat-float-button .icon {
        color: white;
        font-size: 28px;
    }
    
    .chat-notification-badge {
        position: absolute;
        top: -5px;
        right: -5px;
        background: #ff4444;
        color: white;
        border-radius: 50%;
        width: 24px;
        height: 24px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
        font-weight: bold;
        border: 3px solid white;
    }
    
    @keyframes pulse-chat {
        0%, 100% { box-shadow: 0 4px 20px rgba(0, 132, 255, 0.4); }
        50% { box-shadow: 0 4px 30px rgba(0, 132, 255, 0.7); }
    }
    
    /* Chat Window */
    .chat-window {
        position: fixed;
        bottom: 100px;
        right: 30px;
        width: 380px;
        height: 550px;
        background: white;
        border-radius: 20px;
        box-shadow: 0 10px 50px rgba(0, 0, 0, 0.3);
        display: none;
        flex-direction: column;
        z-index: 9999;
        overflow: hidden;
        animation: slideUp 0.3s ease;
    }
    
    .chat-window.active {
        display: flex;
    }
    
    @keyframes slideUp {
        from {
            transform: translateY(20px);
            opacity: 0;
        }
        to {
            transform: translateY(0);
            opacity: 1;
        }
    }
    
    /* Chat Header */
    .chat-header {
        background: linear-gradient(135deg, #0084ff, #00a8ff);
        color: white;
        padding: 15px 20px;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    
    .chat-header h3 {
        margin: 0;
        font-size: 18px;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    
    .chat-header .close-btn {
        background: rgba(255, 255, 255, 0.2);
        border: none;
        color: white;
        width: 30px;
        height: 30px;
        border-radius: 50%;
        cursor: pointer;
        font-size: 20px;
        transition: all 0.2s;
    }
    
    .chat-header .close-btn:hover {
        background: rgba(255, 255, 255, 0.3);
    }
    
    /* Chat Users List */
    .chat-users-list {
        flex: 1;
        overflow-y: auto;
        background: #f8f9fa;
    }
    
    .chat-user-item {
        display: flex;
        align-items: center;
        padding: 15px;
        border-bottom: 1px solid #e0e0e0;
        cursor: pointer;
        transition: background 0.2s;
    }
    
    .chat-user-item:hover {
        background: white;
    }
    
    .chat-user-avatar {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        background: linear-gradient(135deg, #667eea, #764ba2);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: bold;
        font-size: 18px;
        margin-right: 15px;
        position: relative;
    }
    
    .online-indicator {
        position: absolute;
        bottom: 2px;
        right: 2px;
        width: 12px;
        height: 12px;
        background: #4CAF50;
        border: 2px solid white;
        border-radius: 50%;
    }
    
    .chat-user-info {
        flex: 1;
    }
    
    .chat-user-name {
        font-weight: 600;
        color: #333;
        margin-bottom: 3px;
    }
    
    .chat-user-role {
        font-size: 12px;
        color: #888;
        background: #e3f2fd;
        padding: 2px 8px;
        border-radius: 10px;
        display: inline-block;
    }
    
    /* Chat Messages View */
    .chat-messages-view {
        display: none;
        flex-direction: column;
        height: 100%;
    }
    
    .chat-messages-view.active {
        display: flex;
    }
    
    .chat-messages-header {
        background: white;
        padding: 15px;
        border-bottom: 2px solid #f0f0f0;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    
    .back-btn {
        background: #f0f0f0;
        border: none;
        padding: 8px 12px;
        border-radius: 8px;
        cursor: pointer;
        font-size: 18px;
    }
    
    .chat-messages-container {
        flex: 1;
        overflow-y: auto;
        padding: 20px;
        background: #f8f9fa;
    }
    
    .message-bubble {
        margin-bottom: 15px;
        display: flex;
        gap: 10px;
    }
    
    .message-bubble.sent {
        flex-direction: row-reverse;
    }
    
    .message-content {
        max-width: 70%;
        padding: 12px 16px;
        border-radius: 18px;
        background: white;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    }
    
    .message-bubble.sent .message-content {
        background: linear-gradient(135deg, #0084ff, #00a8ff);
        color: white;
    }
    
    .message-time {
        font-size: 11px;
        color: #888;
        margin-top: 5px;
    }
    
    /* Chat Input */
    .chat-input-container {
        padding: 15px;
        background: white;
        border-top: 2px solid #f0f0f0;
        display: flex;
        gap: 10px;
        align-items: center;
    }
    
    .chat-input {
        flex: 1;
        padding: 12px 16px;
        border: 2px solid #e0e0e0;
        border-radius: 25px;
        outline: none;
        font-size: 14px;
    }
    
    .chat-input:focus {
        border-color: #0084ff;
    }
    
    .send-btn {
        width: 45px;
        height: 45px;
        border-radius: 50%;
        background: linear-gradient(135deg, #0084ff, #00a8ff);
        border: none;
        color: white;
        font-size: 20px;
        cursor: pointer;
        transition: transform 0.2s;
    }
    
    .send-btn:hover {
        transform: scale(1.1);
    }
    
    .empty-state {
        text-align: center;
        padding: 40px 20px;
        color: #888;
    }
    
    .empty-state-icon {
        font-size: 60px;
        margin-bottom: 15px;
        opacity: 0.3;
    }
</style>

<!-- Floating Chat Button -->
<div class="chat-float-button" onclick="toggleChat()">
    <span class="icon">💬</span>
    <span class="chat-notification-badge" id="chatBadge" style="display: none;">3</span>
</div>

<!-- Chat Window -->
<div class="chat-window" id="chatWindow">
    <!-- Chat Header -->
    <div class="chat-header">
        <h3>
            <span>💬</span>
            <span>Messages</span>
        </h3>
        <button class="close-btn" onclick="toggleChat()">×</button>
    </div>
    
    <!-- Users List View -->
    <div class="chat-users-list" id="usersList">
        <?php
        // Get current user
        $current_user_id = $_SESSION['user_id'] ?? 0;
        $current_role = $_SESSION['role'] ?? '';
        
        // Fetch other users based on role
        if ($current_role === 'student') {
            // Students see instructors
            $users_query = "SELECT u.id, u.username, u.role, i.name 
                           FROM users u 
                           LEFT JOIN instructors i ON u.username = i.email 
                           WHERE u.role = 'instructor' AND u.id != $current_user_id 
                           ORDER BY i.name LIMIT 10";
        } elseif ($current_role === 'instructor') {
            // Instructors see students
            $users_query = "SELECT u.id, u.username, u.role, s.name 
                           FROM users u 
                           LEFT JOIN students s ON u.username = s.email 
                           WHERE u.role = 'student' AND u.id != $current_user_id 
                           ORDER BY s.name LIMIT 10";
        } else {
            // Admin sees everyone
            $users_query = "SELECT u.id, u.username, u.role, 
                           COALESCE(s.name, i.name, u.username) as name 
                           FROM users u 
                           LEFT JOIN students s ON u.username = s.email 
                           LEFT JOIN instructors i ON u.username = i.email 
                           WHERE u.id != $current_user_id 
                           ORDER BY u.role, name LIMIT 20";
        }
        
        $users_result = $conn->query($users_query);
        
        if ($users_result && $users_result->num_rows > 0):
            while ($user = $users_result->fetch_assoc()):
                $user_initial = strtoupper(substr($user['name'] ?? $user['username'], 0, 1));
                $role_label = ucfirst($user['role']);
        ?>
        <div class="chat-user-item" onclick="openChat(<?php echo $user['id']; ?>, '<?php echo htmlspecialchars($user['name'] ?? $user['username']); ?>')">
            <div class="chat-user-avatar">
                <?php echo $user_initial; ?>
                <div class="online-indicator"></div>
            </div>
            <div class="chat-user-info">
                <div class="chat-user-name"><?php echo htmlspecialchars($user['name'] ?? $user['username']); ?></div>
                <span class="chat-user-role"><?php echo $role_label; ?></span>
            </div>
        </div>
        <?php 
            endwhile;
        else:
        ?>
        <div class="empty-state">
            <div class="empty-state-icon">👥</div>
            <p>No users available to chat</p>
        </div>
        <?php endif; ?>
    </div>
    
    <!-- Messages View -->
    <div class="chat-messages-view" id="messagesView">
        <div class="chat-messages-header">
            <button class="back-btn" onclick="backToUsersList()">←</button>
            <div class="chat-user-avatar" style="width: 40px; height: 40px; margin: 0;">
                <span id="chatUserInitial">?</span>
            </div>
            <div style="flex: 1;">
                <div class="chat-user-name" id="chatUserName">User Name</div>
            </div>
        </div>
        
        <div class="chat-messages-container" id="messagesContainer">
            <!-- Messages will be loaded here -->
        </div>
        
        <div class="chat-input-container">
            <input type="text" class="chat-input" id="messageInput" placeholder="Type a message..." onkeypress="if(event.key==='Enter') sendMessage()">
            <button class="send-btn" onclick="sendMessage()">➤</button>
        </div>
    </div>
</div>

<script>
const CHAT_API_PREFIX = '<?php echo $chat_api_prefix; ?>';
let currentChatUserId = null;
let currentChatUserName = '';

function toggleChat() {
    const chatWindow = document.getElementById('chatWindow');
    chatWindow.classList.toggle('active');
    
    // Hide notification badge when opened
    if (chatWindow.classList.contains('active')) {
        document.getElementById('chatBadge').style.display = 'none';
    }
}

function openChat(userId, userName) {
    currentChatUserId = userId;
    currentChatUserName = userName;
    
    // Update header
    document.getElementById('chatUserName').textContent = userName;
    document.getElementById('chatUserInitial').textContent = userName.charAt(0).toUpperCase();
    
    // Switch to messages view
    document.getElementById('usersList').style.display = 'none';
    document.getElementById('messagesView').classList.add('active');
    
    // Load messages
    loadMessages(userId);
}

function backToUsersList() {
    document.getElementById('usersList').style.display = 'block';
    document.getElementById('messagesView').classList.remove('active');
    currentChatUserId = null;
}

function loadMessages(userId) {
    // Fetch messages from server
    fetch(`${CHAT_API_PREFIX}get_messages.php?user_id=${userId}`)
        .then(response => response.json())
        .then(messages => {
            const container = document.getElementById('messagesContainer');
            container.innerHTML = '';
            
            if (messages.length === 0) {
                container.innerHTML = '<div class="empty-state"><div class="empty-state-icon">💬</div><p>No messages yet. Start the conversation!</p></div>';
            } else {
                messages.forEach(msg => {
                    const messageDiv = document.createElement('div');
                    messageDiv.className = `message-bubble ${msg.is_sent ? 'sent' : 'received'}`;
                    messageDiv.innerHTML = `
                        <div class="message-content">
                            <div>${msg.message}</div>
                            <div class="message-time">${msg.time}</div>
                        </div>
                    `;
                    container.appendChild(messageDiv);
                });
                container.scrollTop = container.scrollHeight;
            }
        })
        .catch(error => {
            console.error('Error loading messages:', error);
        });
}

function sendMessage() {
    const input = document.getElementById('messageInput');
    const message = input.value.trim();
    
    if (!message || !currentChatUserId) return;
    
    // Send message to server
    fetch(`${CHAT_API_PREFIX}send_message.php`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `to_user_id=${currentChatUserId}&message=${encodeURIComponent(message)}`
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            input.value = '';
            loadMessages(currentChatUserId);
        }
    })
    .catch(error => {
        console.error('Error sending message:', error);
    });
}

// Auto-refresh messages every 5 seconds when chat is open
setInterval(() => {
    if (currentChatUserId) {
        loadMessages(currentChatUserId);
    }
}, 5000);
</script>
