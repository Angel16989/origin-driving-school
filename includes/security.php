<?php
/**
 * Security Helper Functions for Origin Driving School
 * Provides comprehensive security utilities including CSRF protection, 
 * input validation, rate limiting, and security headers
 */

class Security {
    
    /**
     * Generate CSRF token
     */
    public static function generateCSRFToken() {
        if (!isset($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf_token'];
    }
    
    /**
     * Validate CSRF token
     */
    public static function validateCSRFToken($token) {
        return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
    }
    
    /**
     * Get CSRF token input field
     */
    public static function getCSRFField() {
        $token = self::generateCSRFToken();
        return '<input type="hidden" name="csrf_token" value="' . htmlspecialchars($token) . '">';
    }
    
    /**
     * Rate limiting functionality
     */
    public static function checkRateLimit($action, $identifier, $max_attempts = 5, $time_window = 300) {
        $conn = self::getDBConnection();
        if (!$conn) return true; // Allow if DB unavailable
        
        try {
            // Create rate_limits table if it doesn't exist
            $createTable = "CREATE TABLE IF NOT EXISTS rate_limits (
                id INT AUTO_INCREMENT PRIMARY KEY,
                action VARCHAR(50) NOT NULL,
                identifier VARCHAR(255) NOT NULL,
                attempts INT DEFAULT 1,
                first_attempt TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                last_attempt TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                INDEX(action, identifier),
                INDEX(last_attempt)
            )";
            $conn->exec($createTable);
            
            // Clean old entries
            $cleanup_time = date('Y-m-d H:i:s', time() - $time_window);
            $conn->prepare("DELETE FROM rate_limits WHERE last_attempt < ?")->execute([$cleanup_time]);
            
            // Check current attempts
            $check_time = date('Y-m-d H:i:s', time() - $time_window);
            $stmt = $conn->prepare("SELECT attempts FROM rate_limits WHERE action = ? AND identifier = ? AND first_attempt > ?");
            $stmt->execute([$action, $identifier, $check_time]);
            $result = $stmt->fetch();
            
            if ($result && $result['attempts'] >= $max_attempts) {
                return false; // Rate limited
            }
            
            // Update or insert attempt
            $stmt = $conn->prepare("INSERT INTO rate_limits (action, identifier, attempts, first_attempt) VALUES (?, ?, 1, NOW()) 
                                   ON DUPLICATE KEY UPDATE attempts = attempts + 1, last_attempt = NOW()");
            $stmt->execute([$action, $identifier]);
            
            return true; // Not rate limited
            
        } catch (Exception $e) {
            error_log("Rate limiting error: " . $e->getMessage());
            return true; // Allow if error
        }
    }
    
    /**
     * Sanitize input data
     */
    public static function sanitizeInput($data, $type = 'string') {
        switch ($type) {
            case 'email':
                return filter_var(trim($data), FILTER_SANITIZE_EMAIL);
            case 'int':
                return filter_var($data, FILTER_SANITIZE_NUMBER_INT);
            case 'float':
                return filter_var($data, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
            case 'url':
                return filter_var(trim($data), FILTER_SANITIZE_URL);
            case 'html':
                return htmlspecialchars(trim($data), ENT_QUOTES, 'UTF-8');
            default:
                return filter_var(trim($data), FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
        }
    }
    
    /**
     * Validate password strength
     */
    public static function validatePassword($password) {
        $errors = [];
        
        if (strlen($password) < 8) {
            $errors[] = "Password must be at least 8 characters long";
        }
        
        if (!preg_match('/[A-Z]/', $password)) {
            $errors[] = "Password must contain at least one uppercase letter";
        }
        
        if (!preg_match('/[a-z]/', $password)) {
            $errors[] = "Password must contain at least one lowercase letter";
        }
        
        if (!preg_match('/\d/', $password)) {
            $errors[] = "Password must contain at least one number";
        }
        
        if (!preg_match('/[!@#$%^&*(),.?":{}|<>]/', $password)) {
            $errors[] = "Password must contain at least one special character";
        }
        
        // Check against common passwords
        $common_passwords = ['password', '123456789', 'qwerty123', 'admin123', 'welcome123'];
        if (in_array(strtolower($password), $common_passwords)) {
            $errors[] = "Password is too common, please choose a more secure password";
        }
        
        return $errors;
    }
    
    /**
     * Set security headers
     */
    public static function setSecurityHeaders() {
        // Prevent clickjacking
        header('X-Frame-Options: DENY');
        
        // Prevent MIME type sniffing
        header('X-Content-Type-Options: nosniff');
        
        // XSS protection
        header('X-XSS-Protection: 1; mode=block');
        
        // Referrer policy
        header('Referrer-Policy: strict-origin-when-cross-origin');
        
        // Content Security Policy
        header("Content-Security-Policy: default-src 'self'; script-src 'self' 'unsafe-inline'; style-src 'self' 'unsafe-inline'; img-src 'self' data:; font-src 'self'; connect-src 'self'");
        
        // Strict Transport Security (if HTTPS)
        if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
            header('Strict-Transport-Security: max-age=31536000; includeSubDomains');
        }
    }
    
    /**
     * Log security events
     */
    public static function logSecurityEvent($event_type, $description, $user_id = null) {
        $conn = self::getDBConnection();
        if (!$conn) return;
        
        try {
            // Create security_log table if it doesn't exist
            $createTable = "CREATE TABLE IF NOT EXISTS security_log (
                id INT AUTO_INCREMENT PRIMARY KEY,
                event_type VARCHAR(50) NOT NULL,
                description TEXT NOT NULL,
                user_id INT NULL,
                ip_address VARCHAR(45),
                user_agent TEXT,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                INDEX(event_type),
                INDEX(created_at),
                INDEX(ip_address)
            )";
            $conn->exec($createTable);
            
            $stmt = $conn->prepare("INSERT INTO security_log (event_type, description, user_id, ip_address, user_agent) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([
                $event_type,
                $description,
                $user_id,
                $_SERVER['REMOTE_ADDR'] ?? 'unknown',
                $_SERVER['HTTP_USER_AGENT'] ?? 'unknown'
            ]);
            
        } catch (Exception $e) {
            error_log("Security logging error: " . $e->getMessage());
        }
    }
    
    /**
     * Check if IP is blocked
     */
    public static function checkBlacklist($ip_address) {
        $conn = self::getDBConnection();
        if (!$conn) return false;
        
        try {
            // Create ip_blacklist table if it doesn't exist
            $createTable = "CREATE TABLE IF NOT EXISTS ip_blacklist (
                id INT AUTO_INCREMENT PRIMARY KEY,
                ip_address VARCHAR(45) NOT NULL UNIQUE,
                reason VARCHAR(255),
                blocked_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                expires_at TIMESTAMP NULL,
                INDEX(ip_address)
            )";
            $conn->exec($createTable);
            
            $stmt = $conn->prepare("SELECT id FROM ip_blacklist WHERE ip_address = ? AND (expires_at IS NULL OR expires_at > NOW())");
            $stmt->execute([$ip_address]);
            
            return $stmt->rowCount() > 0;
            
        } catch (Exception $e) {
            error_log("Blacklist check error: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Block IP address
     */
    public static function blockIP($ip_address, $reason = 'Security violation', $duration_hours = 24) {
        $conn = self::getDBConnection();
        if (!$conn) return;
        
        try {
            $expires_at = $duration_hours ? date('Y-m-d H:i:s', time() + ($duration_hours * 3600)) : null;
            
            $stmt = $conn->prepare("INSERT INTO ip_blacklist (ip_address, reason, expires_at) VALUES (?, ?, ?) 
                                   ON DUPLICATE KEY UPDATE reason = VALUES(reason), expires_at = VALUES(expires_at), blocked_at = NOW()");
            $stmt->execute([$ip_address, $reason, $expires_at]);
            
            self::logSecurityEvent('IP_BLOCKED', "IP {$ip_address} blocked: {$reason}");
            
        } catch (Exception $e) {
            error_log("IP blocking error: " . $e->getMessage());
        }
    }
    
    /**
     * Get database connection
     */
    private static function getDBConnection() {
        static $conn = null;
        
        if ($conn === null) {
            try {
                $servername = "localhost";
                $username = "root";
                $password = "";
                $dbname = "origin_driving_school";
                
                $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch(PDOException $e) {
                error_log("Database connection failed: " . $e->getMessage());
                return null;
            }
        }
        
        return $conn;
    }
    
    /**
     * Initialize security for each request
     */
    public static function initialize() {
        // Set security headers
        self::setSecurityHeaders();
        
        // Check IP blacklist
        $ip = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
        if (self::checkBlacklist($ip)) {
            http_response_code(403);
            die('Access denied. Your IP address has been blocked.');
        }
        
        // Start session securely
        if (session_status() === PHP_SESSION_NONE) {
            // Secure session configuration
            ini_set('session.cookie_httponly', 1);
            ini_set('session.cookie_secure', isset($_SERVER['HTTPS']));
            ini_set('session.use_strict_mode', 1);
            ini_set('session.cookie_samesite', 'Strict');
            
            session_start();
            
            // Regenerate session ID periodically
            if (!isset($_SESSION['last_regeneration']) || time() - $_SESSION['last_regeneration'] > 300) {
                session_regenerate_id(true);
                $_SESSION['last_regeneration'] = time();
            }
        }
    }
    
    /**
     * Validate file upload security
     */
    public static function validateFileUpload($file, $allowed_types = ['jpg', 'jpeg', 'png', 'pdf'], $max_size = 2097152) {
        $errors = [];
        
        if (!isset($file['error']) || is_array($file['error'])) {
            $errors[] = 'Invalid file upload';
        }
        
        switch ($file['error']) {
            case UPLOAD_ERR_OK:
                break;
            case UPLOAD_ERR_NO_FILE:
                $errors[] = 'No file was uploaded';
                break;
            case UPLOAD_ERR_INI_SIZE:
            case UPLOAD_ERR_FORM_SIZE:
                $errors[] = 'File is too large';
                break;
            default:
                $errors[] = 'Unknown upload error';
                break;
        }
        
        if ($file['size'] > $max_size) {
            $errors[] = 'File is too large (max 2MB)';
        }
        
        $finfo = new finfo(FILEINFO_MIME_TYPE);
        $mime_type = $finfo->file($file['tmp_name']);
        $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        
        $allowed_mime_types = [
            'jpg' => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'png' => 'image/png',
            'pdf' => 'application/pdf'
        ];
        
        if (!in_array($extension, $allowed_types) || 
            !isset($allowed_mime_types[$extension]) || 
            $allowed_mime_types[$extension] !== $mime_type) {
            $errors[] = 'File type not allowed';
        }
        
        return $errors;
    }
}

// Auto-initialize security on include
Security::initialize();
?>
