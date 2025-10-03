<?php
// Create new instructor account
require_once 'php/db_connect.php';

echo "🔧 Creating New Instructor Account...<br><br>";

// New instructor credentials
$username = 'instructor_test';
$password = 'test123';
$role = 'instructor';

// Hash the password
$password_hash = password_hash($password, PASSWORD_DEFAULT);

// Check if user already exists
$check_query = "SELECT id FROM users WHERE username = '$username'";
$result = $conn->query($check_query);

if ($result->num_rows > 0) {
    echo "⚠️ User '$username' already exists. Updating password...<br>";
    $update_query = "UPDATE users SET password = '$password_hash' WHERE username = '$username'";
    if ($conn->query($update_query)) {
        echo "✅ Password updated successfully!<br>";
    } else {
        echo "❌ Error updating password: " . $conn->error . "<br>";
    }
} else {
    // Insert new instructor
    $insert_query = "INSERT INTO users (username, password, role, created_at) VALUES ('$username', '$password_hash', '$role', NOW())";
    
    if ($conn->query($insert_query)) {
        echo "✅ New instructor account created successfully!<br>";
        
        // Get the user ID
        $user_id = $conn->insert_id;
        
        // Add instructor to instructors table if it exists
        $instructor_check = $conn->query("SHOW TABLES LIKE 'instructors'");
        if ($instructor_check->num_rows > 0) {
            $instructor_insert = "INSERT INTO instructors (name, email, specialization, experience_years, rating, students_taught, bio, languages, availability) VALUES ('Test Instructor', 'test.instructor@example.com', 'Driving Lessons', 5, 4.8, 25, 'Experienced driving instructor with 5 years of teaching.', 'English', 'Monday-Friday')";
            if ($conn->query($instructor_insert)) {
                echo "✅ Instructor profile created in instructors table!<br>";
            } else {
                echo "⚠️ Note: Could not create instructor profile: " . $conn->error . "<br>";
            }
        }
    } else {
        echo "❌ Error creating account: " . $conn->error . "<br>";
    }
}

echo "<br><h3>🎯 New Instructor Credentials:</h3>";
echo "<div style='background: #f8f9fa; padding: 20px; border-radius: 10px; margin: 10px 0;'>";
echo "<p><strong>👤 Username:</strong> <code style='background: #e9ecef; padding: 5px 10px; border-radius: 5px; font-weight: bold; color: #007bff;'>$username</code></p>";
echo "<p><strong>🔐 Password:</strong> <code style='background: #e9ecef; padding: 5px 10px; border-radius: 5px; font-weight: bold; color: #28a745;'>$password</code></p>";
echo "<p><strong>👨‍🏫 Role:</strong> <code style='background: #e9ecef; padding: 5px 10px; border-radius: 5px; font-weight: bold; color: #ffc107;'>$role</code></p>";
echo "</div>";

echo "<h3>🔗 Login Steps:</h3>";
echo "<ol>";
echo "<li>Go to: <a href='login.php' style='color: #007bff; font-weight: bold;'>Login Page</a></li>";
echo "<li>Enter username: <strong>$username</strong></li>";
echo "<li>Enter password: <strong>$password</strong></li>";
echo "<li>Click Login</li>";
echo "</ol>";

echo "<h3>✅ What to Test:</h3>";
echo "<ul>";
echo "<li>🔐 <strong>Login Process:</strong> Verify successful login with new credentials</li>";
echo "<li>📱 <strong>Navigation:</strong> Test clicking between different tabs (no 404 errors)</li>";
echo "<li>👨‍🏫 <strong>Instructor Features:</strong> Check instructor-specific dashboard content</li>";
echo "<li>🧭 <strong>Path Routing:</strong> Ensure all links work correctly from instructor panel</li>";
echo "</ul>";

// Also show all instructor accounts
echo "<br><h3>📋 All Instructor Accounts:</h3>";
$all_instructors = $conn->query("SELECT username, role, created_at FROM users WHERE role = 'instructor' ORDER BY created_at DESC");
if ($all_instructors->num_rows > 0) {
    echo "<table style='border-collapse: collapse; width: 100%; margin: 10px 0;'>";
    echo "<tr style='background: #007bff; color: white;'><th style='padding: 10px; border: 1px solid #ddd;'>Username</th><th style='padding: 10px; border: 1px solid #ddd;'>Role</th><th style='padding: 10px; border: 1px solid #ddd;'>Created</th></tr>";
    while ($row = $all_instructors->fetch_assoc()) {
        echo "<tr style='background: #f8f9fa;'>";
        echo "<td style='padding: 10px; border: 1px solid #ddd; font-weight: bold;'>" . $row['username'] . "</td>";
        echo "<td style='padding: 10px; border: 1px solid #ddd;'>" . $row['role'] . "</td>";
        echo "<td style='padding: 10px; border: 1px solid #ddd;'>" . $row['created_at'] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
}

$conn->close();
?>