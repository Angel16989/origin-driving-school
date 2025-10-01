<?php
session_start();

// Simple contact form processor
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = htmlspecialchars($_POST['name'] ?? '');
    $email = htmlspecialchars($_POST['email'] ?? '');
    $phone = htmlspecialchars($_POST['phone'] ?? '');
    $subject = htmlspecialchars($_POST['subject'] ?? '');
    $message = htmlspecialchars($_POST['message'] ?? '');

    // Basic validation
    if (empty($name) || empty($email) || empty($message)) {
        $_SESSION['contact_error'] = 'Please fill in all required fields.';
        header('Location: contact.php');
        exit;
    }

    // In a real application, you would send an email here
    // For now, just set a success message
    $_SESSION['contact_success'] = 'Thank you for your message! We will get back to you soon.';

    header('Location: contact.php');
    exit;
}

// If not POST, redirect back
header('Location: contact.php');
exit;
?>