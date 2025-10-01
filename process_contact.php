<?php
session_start();
require_once 'includes/security.php';

// Check if form was submitted
if ($_SERVER["REQUEST_METHOD"] != "POST") {
    $_SESSION['contact_error'] = "Invalid request method.";
    header("Location: contact.php");
    exit();
}

// Validate CSRF token
if (!Security::validateCSRFToken($_POST['csrf_token'] ?? '')) {
    Security::logSecurityEvent('CSRF_FAILURE', 'Invalid CSRF token in contact form');
    $_SESSION['contact_error'] = "Security validation failed. Please try again.";
    header("Location: contact.php");
    exit();
}

// Rate limiting - max 3 contact form submissions per 10 minutes per IP
$ip_address = $_SERVER['REMOTE_ADDR'];
if (!Security::checkRateLimit('contact_form', $ip_address, 3, 600)) {
    Security::logSecurityEvent('RATE_LIMIT_EXCEEDED', 'Contact form rate limit exceeded', null);
    $_SESSION['contact_error'] = "Too many contact form submissions. Please wait 10 minutes before trying again.";
    header("Location: contact.php");
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
    Security::logSecurityEvent('DATABASE_ERROR', 'Contact form database connection failed');
    $_SESSION['contact_error'] = "System error. Please try again later or call us directly.";
    header("Location: contact.php");
    exit();
}

    // Get form data with proper sanitization
    $name = Security::sanitizeInput($_POST['name'], 'html');
    $email = Security::sanitizeInput($_POST['email'], 'email');
    $phone = Security::sanitizeInput($_POST['phone'], 'string');
    $subject = Security::sanitizeInput($_POST['subject'], 'html');
    $message = Security::sanitizeInput($_POST['message'], 'html');
    $newsletter = isset($_POST['newsletter']) ? 1 : 0;
    
    // Validate required fields
    $errors = array();
    
    if (empty($name)) {
        $errors[] = "Name is required.";
    }
    
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Valid email is required.";
    }
    
    if (empty($subject)) {
        $errors[] = "Subject is required.";
    }
    
    if (empty($message)) {
        $errors[] = "Message is required.";
    }
    
    // If no errors, process the form
    if (empty($errors)) {
        try {
            // Create contact_messages table if it doesn't exist
            $createTable = "CREATE TABLE IF NOT EXISTS contact_messages (
                id INT AUTO_INCREMENT PRIMARY KEY,
                name VARCHAR(255) NOT NULL,
                email VARCHAR(255) NOT NULL,
                phone VARCHAR(50),
                subject VARCHAR(255) NOT NULL,
                message TEXT NOT NULL,
                newsletter_signup BOOLEAN DEFAULT FALSE,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                status ENUM('new', 'read', 'replied', 'closed') DEFAULT 'new'
            )";
            $conn->exec($createTable);
            
            // Insert the message
            $stmt = $conn->prepare("INSERT INTO contact_messages (name, email, phone, subject, message, newsletter_signup) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->execute([$name, $email, $phone, $subject, $message, $newsletter]);
            
            // If newsletter signup, add to newsletter list
            if ($newsletter) {
                $checkNewsletter = $conn->prepare("SELECT id FROM newsletter_subscribers WHERE email = ?");
                $checkNewsletter->execute([$email]);
                
                if ($checkNewsletter->rowCount() == 0) {
                    // Create newsletter table if it doesn't exist
                    $createNewsletterTable = "CREATE TABLE IF NOT EXISTS newsletter_subscribers (
                        id INT AUTO_INCREMENT PRIMARY KEY,
                        email VARCHAR(255) UNIQUE NOT NULL,
                        name VARCHAR(255),
                        subscribed_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                        status ENUM('active', 'unsubscribed') DEFAULT 'active'
                    )";
                    $conn->exec($createNewsletterTable);
                    
                    // Add to newsletter
                    $newsletterStmt = $conn->prepare("INSERT INTO newsletter_subscribers (email, name) VALUES (?, ?)");
                    $newsletterStmt->execute([$email, $name]);
                }
            }
            
            $_SESSION['contact_success'] = "Thank you for your message! We'll get back to you within 24 hours.";
            Security::logSecurityEvent('CONTACT_FORM_SUCCESS', "Contact form submitted by {$email}");
            
        } catch(PDOException $e) {
            Security::logSecurityEvent('DATABASE_ERROR', 'Contact form submission failed: ' . $e->getMessage());
            $_SESSION['contact_error'] = "There was an error sending your message. Please try again or call us directly.";
        }
    } else {
        Security::logSecurityEvent('FORM_VALIDATION_FAILED', 'Contact form validation failed: ' . implode(', ', $errors));
        $_SESSION['contact_error'] = implode(" ", $errors);
    }

// Redirect back to contact page
header("Location: contact.php");
exit();
?>
