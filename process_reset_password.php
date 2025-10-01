<?php
session_start();
require_once 'includes/security.php';

// Check request method
if ($_SERVER["REQUEST_METHOD"] != "POST") {
    $_SESSION['reset_error'] = "Invalid request method.";
    header("Location: forgot-password.php");
    exit();
}

// Validate CSRF token
if (!Security::validateCSRFToken($_POST['csrf_token'] ?? '')) {
    Security::logSecurityEvent('CSRF_FAILURE', 'Invalid CSRF token in password reset form');
    $_SESSION['reset_error'] = "Security validation failed. Please try again.";
    header("Location: forgot-password.php");
    exit();
}

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "driving_school";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    Security::logSecurityEvent('DATABASE_ERROR', 'Password reset database connection failed');
    $_SESSION['reset_error'] = "Database connection failed. Please try again later.";
    header("Location: reset-password.php" . (isset($_POST['token']) ? "?token=" . $_POST['token'] : ""));
    exit();
}

    $token = Security::sanitizeInput($_POST['token'], 'string');
    $new_password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    
    // Validate inputs
    $errors = array();
    
    if (empty($token)) {
        $errors[] = "Invalid reset token.";
    }
    
    if (empty($new_password)) {
        $errors[] = "Password is required.";
    }
    
    // Use Security class for password validation
    $password_errors = Security::validatePassword($new_password);
    if (!empty($password_errors)) {
        $errors = array_merge($errors, $password_errors);
    }
    
    if ($new_password !== $confirm_password) {
        $errors[] = "Passwords do not match.";
    }
    
    if (!empty($errors)) {
        Security::logSecurityEvent('PASSWORD_RESET_VALIDATION_FAILED', 'Password reset validation failed: ' . implode(', ', $errors));
        $_SESSION['reset_error'] = implode(" ", $errors);
        header("Location: reset-password.php?token=" . urlencode($token));
        exit();
    }
    
    // Validate token and check if it's still valid
    $stmt = $conn->prepare("SELECT pr.*, u.id as user_id, u.username FROM password_resets pr JOIN users u ON pr.user_id = u.id WHERE pr.token = ? AND pr.used = FALSE AND pr.expires_at > NOW()");
    $stmt->execute([$token]);
    $reset_data = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$reset_data) {
        Security::logSecurityEvent('INVALID_RESET_TOKEN', 'Invalid or expired reset token used: ' . $token);
        $_SESSION['reset_error'] = "Invalid or expired reset token.";
        header("Location: reset-password.php?token=" . urlencode($token));
        exit();
    }
    
    try {
        // Start transaction
        $conn->beginTransaction();
        
        // Hash the new password
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
        
        // Update user's password
        $updatePassword = $conn->prepare("UPDATE users SET password = ? WHERE id = ?");
        $updatePassword->execute([$hashed_password, $reset_data['user_id']]);
        
        // Mark the reset token as used
        $markUsed = $conn->prepare("UPDATE password_resets SET used = TRUE WHERE id = ?");
        $markUsed->execute([$reset_data['id']]);
        
        // Log password change
        try {
            $createLogTable = "CREATE TABLE IF NOT EXISTS password_change_log (
                id INT AUTO_INCREMENT PRIMARY KEY,
                user_id INT NOT NULL,
                change_method ENUM('reset', 'profile_update', 'admin_reset') DEFAULT 'reset',
                ip_address VARCHAR(45),
                user_agent TEXT,
                changed_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
            )";
            $conn->exec($createLogTable);
            
            $logChange = $conn->prepare("INSERT INTO password_change_log (user_id, change_method, ip_address, user_agent) VALUES (?, 'reset', ?, ?)");
            $logChange->execute([$reset_data['user_id'], $_SERVER['REMOTE_ADDR'], $_SERVER['HTTP_USER_AGENT']]);
        } catch(PDOException $e) {
            // Log creation failed, but don't fail the reset
        }
        
        // Delete all other reset tokens for this user
        $deleteOtherTokens = $conn->prepare("DELETE FROM password_resets WHERE user_id = ? AND id != ?");
        $deleteOtherTokens->execute([$reset_data['user_id'], $reset_data['id']]);
        
        // Commit transaction
        $conn->commit();
        
        Security::logSecurityEvent('PASSWORD_RESET_SUCCESS', "Password successfully reset for user: {$reset_data['username']}", $reset_data['user_id']);
        $_SESSION['reset_success'] = "Your password has been successfully updated! You can now log in with your new password.";
        
        // For development - log the successful reset
        error_log("Password successfully reset for user: " . $reset_data['username']);
        
    } catch(PDOException $e) {
        // Rollback transaction
        $conn->rollback();
        Security::logSecurityEvent('PASSWORD_RESET_DB_ERROR', 'Password reset database error: ' . $e->getMessage(), $reset_data['user_id']);
        $_SESSION['reset_error'] = "Failed to update password. Please try again.";
        error_log("Password reset failed: " . $e->getMessage());
    }

// Redirect back to reset page
$redirect_token = isset($token) ? $token : (isset($_POST['token']) ? $_POST['token'] : '');
header("Location: reset-password.php?token=" . urlencode($redirect_token));
exit();
?>
