<?php
// process_register.php - User Registration Processing
session_start();
require_once 'includes/security.php';
require_once 'php/db_connect.php';

// Initialize Security
Security::initialize();

// Set security headers
Security::setSecurityHeaders();

// Check request method
if ($_SERVER["REQUEST_METHOD"] != "POST") {
    $_SESSION['register_error'] = "Invalid request method.";
    header("Location: register.php");
    exit();
}

// Validate CSRF token
if (!Security::validateCSRFToken($_POST['csrf_token'] ?? '')) {
    Security::logSecurityEvent('CSRF_FAILURE', 'Invalid CSRF token in registration form');
    $_SESSION['register_error'] = "Security validation failed. Please try again.";
    header("Location: register.php");
    exit();
}

// Check rate limiting
if (!Security::checkRateLimit('register', 5, 300)) { // 5 attempts per 5 minutes
    Security::logSecurityEvent('RATE_LIMIT_EXCEEDED', 'Registration rate limit exceeded');
    $_SESSION['register_error'] = "Too many registration attempts. Please try again later.";
    header("Location: register.php");
    exit();
}

// Sanitize and validate input

$username = Security::sanitizeInput($_POST['username'] ?? '');
$email = Security::sanitizeInput($_POST['email'] ?? '');
$phone = Security::sanitizeInput($_POST['phone'] ?? '');
$first_name = Security::sanitizeInput($_POST['first_name'] ?? '');
$last_name = Security::sanitizeInput($_POST['last_name'] ?? '');
$full_name = trim($first_name . ' ' . $last_name);
$password = $_POST['password'] ?? '';
$confirm_password = $_POST['confirm_password'] ?? '';

// Validation
$errors = [];

// Username validation
if (empty($username)) {
    $errors[] = "Username is required.";
} elseif (strlen($username) < 3) {
    $errors[] = "Username must be at least 3 characters long.";
} elseif (!preg_match('/^[a-zA-Z0-9_]+$/', $username)) {
    $errors[] = "Username can only contain letters, numbers, and underscores.";
}

// Email validation
if (empty($email)) {
    $errors[] = "Email is required.";
} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = "Please enter a valid email address.";
}

// Phone validation
if (empty($phone)) {
    $errors[] = "Phone number is required.";
} elseif (!preg_match('/^[\+]?[0-9\-\(\)\s]{10,}$/', $phone)) {
    $errors[] = "Please enter a valid phone number.";
}

// Full name validation
if (empty($full_name)) {
    $errors[] = "Full name is required.";
} elseif (strlen($full_name) < 2) {
    $errors[] = "Full name must be at least 2 characters long.";
}

// Password validation
if (empty($password)) {
    $errors[] = "Password is required.";
} else {
    $password_validation = Security::validatePassword($password);
    if (!empty($password_validation)) {
        $errors = array_merge($errors, $password_validation);
    }
}

// Confirm password validation
if ($password !== $confirm_password) {
    $errors[] = "Passwords do not match.";
}

// Check for existing username and email
try {
    $stmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $existing_user = $result->fetch_assoc();
        $errors[] = "Username already exists.";
    }
    $stmt->close();
} catch (Exception $e) {
    Security::logSecurityEvent('DATABASE_ERROR', 'Registration check failed: ' . $e->getMessage());
    $errors[] = "Database error occurred. Please try again.";
}

// If there are errors, return to registration with errors
if (!empty($errors)) {
    $_SESSION['register_errors'] = $errors;
    $_SESSION['register_data'] = [
        'username' => $username,
        'email' => $email,
        'phone' => $phone,
        'full_name' => $full_name
    ];
    header("Location: register.php");
    exit();
}

// Hash password
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

try {
    // Start transaction
    $conn->autocommit(false);
    
    // Insert into users table
    $stmt = $conn->prepare("INSERT INTO users (username, password, role, created_at) VALUES (?, ?, 'student', NOW())");
    $stmt->bind_param("ss", $username, $hashed_password);
    
    if (!$stmt->execute()) {
        throw new Exception("Failed to create user account");
    }
    
    $user_id = $conn->insert_id;
    $stmt->close();
    
    // Insert into students table
    $stmt = $conn->prepare("INSERT INTO students (name, email, phone, progress, created_at) VALUES (?, ?, ?, 'Getting Started', NOW())");
    $stmt->bind_param("sss", $full_name, $email, $phone);
    
    if (!$stmt->execute()) {
        throw new Exception("Failed to create student profile");
    }
    
    $stmt->close();
    
    // Commit transaction
    $conn->commit();
    $conn->autocommit(true);
    
    // Log successful registration
    Security::logSecurityEvent('USER_REGISTERED', "New user registered: $username", $user_id);
    
    // Set session variables for auto-login
    $_SESSION['user_id'] = $user_id;
    $_SESSION['username'] = $username;
    $_SESSION['role'] = 'student';
    $_SESSION['email'] = $email;
    $_SESSION['full_name'] = $full_name;
    
    // Set verification and success messages
    $_SESSION['verification_message'] = "✅ Your account details have been verified!";
    $_SESSION['register_success'] = "Welcome to Origin Driving School! 🎉
        <br><br>
        ✅ Username verified: {$username}
        <br>
        ✅ Account type: Student
        <br>
        ✅ Registration complete
        <br><br>
        You can now log in to access your dashboard!";

    // Log successful registration
    Security::logSecurityEvent('REGISTRATION_SUCCESS', "New student account created: {$username}");

    // Redirect to dashboard
    header("Location: login.php?registration=success");
    exit();
    
} catch (Exception $e) {
    // Rollback transaction
    $conn->rollback();
    $conn->autocommit(true);
    
    Security::logSecurityEvent('REGISTRATION_ERROR', 'Registration failed: ' . $e->getMessage());
    $_SESSION['register_error'] = "Registration failed. Please try again.";
    
    // Preserve form data
    $_SESSION['register_data'] = [
        'username' => $username,
        'email' => $email,
        'phone' => $phone,
        'full_name' => $full_name
    ];
    
    header("Location: register.php");
    exit();
}
?>
