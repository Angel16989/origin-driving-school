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
    Security::logSecurityEvent('CSRF_FAILURE', 'Invalid CSRF token in forgot password form');
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
    Security::logSecurityEvent('DATABASE_ERROR', 'Forgot password database connection failed');
    $_SESSION['reset_error'] = "Database connection failed. Please try again later.";
    header("Location: forgot-password.php");
    exit();
}

// Enhanced rate limiting - use Security class instead
$ip_address = $_SERVER['REMOTE_ADDR'];
if (!Security::checkRateLimit('password_reset', $ip_address, 3, 300)) {
    Security::logSecurityEvent('RATE_LIMIT_EXCEEDED', 'Password reset rate limit exceeded');
    $_SESSION['reset_error'] = "Too many reset attempts. Please wait 5 minutes before trying again.";
    header("Location: forgot-password.php");
    exit();
}

// Check if form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = Security::sanitizeInput($_POST['email'], 'email');
    
    // Validate email
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        Security::logSecurityEvent('INVALID_EMAIL', 'Invalid email in password reset: ' . ($_POST['email'] ?? 'empty'));
        $_SESSION['reset_error'] = "Please enter a valid email address.";
        header("Location: forgot-password.php");
        exit();
    }
    
    // Check if email exists in database
    $checkUser = $conn->prepare("SELECT id, username, email FROM users WHERE email = ?");
    $checkUser->execute([$email]);
    $user = $checkUser->fetch(PDO::FETCH_ASSOC);
    
    if ($user) {
        Security::logSecurityEvent('PASSWORD_RESET_REQUESTED', "Password reset requested for user: {$user['username']}", $user['id']);
        
        // Generate secure reset token
        $reset_token = bin2hex(random_bytes(32));
        $expires_at = date('Y-m-d H:i:s', strtotime('+30 minutes'));
        
        // Create password_resets table if it doesn't exist
        try {
            $createResetTable = "CREATE TABLE IF NOT EXISTS password_resets (
                id INT AUTO_INCREMENT PRIMARY KEY,
                user_id INT NOT NULL,
                email VARCHAR(255) NOT NULL,
                token VARCHAR(255) NOT NULL UNIQUE,
                expires_at TIMESTAMP NOT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                used BOOLEAN DEFAULT FALSE,
                FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
                INDEX(token),
                INDEX(expires_at)
            )";
            $conn->exec($createResetTable);
        } catch(PDOException $e) {
            // Table might already exist
        }
        
        // Delete any existing reset tokens for this user
        $deleteOld = $conn->prepare("DELETE FROM password_resets WHERE user_id = ?");
        $deleteOld->execute([$user['id']]);
        
        // Insert new reset token
        $insertToken = $conn->prepare("INSERT INTO password_resets (user_id, email, token, expires_at) VALUES (?, ?, ?, ?)");
        $insertToken->execute([$user['id'], $email, $reset_token, $expires_at]);
        
        // Simulate sending email (in a real app, you would send actual email)
        $reset_link = "http://localhost/Groupprojectdevelopingweb/reset-password.php?token=" . $reset_token;
        
        // For demonstration purposes, we'll log the reset link
        // In production, you would send this via email
        error_log("Password Reset Link for {$email}: {$reset_link}");
        
        $_SESSION['reset_success'] = "If an account with that email exists, you will receive a password reset link within a few minutes. Please check your email and spam folder.";
        
        // Create a temporary file to simulate email for development
        $email_content = "
        Password Reset Request for Origin Driving School
        
        Hello {$user['username']},
        
        You requested a password reset for your account. Click the link below to reset your password:
        
        {$reset_link}
        
        This link will expire in 30 minutes.
        
        If you didn't request this reset, please ignore this email.
        
        Best regards,
        Origin Driving School Team
        ";
        
        file_put_contents('temp_emails/reset_' . $user['id'] . '_' . time() . '.txt', $email_content);
        
    } else {
        Security::logSecurityEvent('PASSWORD_RESET_UNKNOWN_EMAIL', "Password reset attempted for unknown email: {$email}");
        // Don't reveal if email exists or not for security
        $_SESSION['reset_success'] = "If an account with that email exists, you will receive a password reset link within a few minutes. Please check your email and spam folder.";
    }
    
    // Clean up expired reset tokens
    $cleanup_resets = $conn->prepare("DELETE FROM password_resets WHERE expires_at < NOW()");
    $cleanup_resets->execute();

header("Location: forgot-password.php");
exit();
?>
