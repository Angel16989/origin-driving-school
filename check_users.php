<?php
// check_users.php - Check all user accounts
require_once 'php/db_connect.php';

echo "=== ALL USER ACCOUNTS IN DATABASE ===\n\n";

$result = $conn->query("SELECT id, username, role FROM users ORDER BY role, username");

echo str_pad("ID", 5) . str_pad("USERNAME", 25) . "ROLE\n";
echo str_repeat("-", 60) . "\n";

while ($user = $result->fetch_assoc()) {
    echo str_pad($user['id'], 5) . 
         str_pad($user['username'], 25) . 
         $user['role'] . "\n";
}

echo "\n=== TEST CREDENTIALS ===\n\n";
echo "ADMIN ACCOUNTS:\n";
$admins = $conn->query("SELECT username FROM users WHERE role = 'admin'");
while ($admin = $admins->fetch_assoc()) {
    echo "  Username: {$admin['username']}\n";
    echo "  Password: Test@1234\n\n";
}

echo "INSTRUCTOR ACCOUNTS:\n";
$instructors = $conn->query("SELECT username FROM users WHERE role = 'instructor' LIMIT 3");
while ($instructor = $instructors->fetch_assoc()) {
    echo "  Username: {$instructor['username']}\n";
    echo "  Password: Test@1234\n\n";
}

echo "STUDENT ACCOUNTS:\n";
$students = $conn->query("SELECT username FROM users WHERE role = 'student' LIMIT 3");
while ($student = $students->fetch_assoc()) {
    echo "  Username: {$student['username']}\n";
    echo "  Password: Test@1234\n\n";
}

$conn->close();
?>
