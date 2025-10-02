<?php
// create_admin_direct.php - Directly create admin account
require_once 'php/db_connect.php';

echo "<h1>🔧 Direct Admin Account Creation</h1>";

// First, check if admin exists
$check = $conn->query("SELECT id, username FROM users WHERE username = 'admin'");

if ($check && $check->num_rows > 0) {
    echo "<div style='background: #fff3cd; padding: 20px; border-radius: 10px; margin: 20px; border-left: 5px solid #ffc107;'>";
    echo "<h2>⚠️ Admin Account Already Exists!</h2>";
    echo "<p>An admin account is already in the database.</p>";
    
    // Let's update the password to make sure it's Test@1234
    $new_password = 'Test@1234';
    $hashed = password_hash($new_password, PASSWORD_DEFAULT);
    
    $update = $conn->prepare("UPDATE users SET password = ? WHERE username = 'admin'");
    $update->bind_param("s", $hashed);
    
    if ($update->execute()) {
        echo "<div style='background: #d4edda; padding: 15px; border-radius: 5px; margin-top: 10px;'>";
        echo "<h3 style='color: #155724;'>✅ Password Reset Successful!</h3>";
        echo "<p><strong>Username:</strong> admin</p>";
        echo "<p><strong>Password:</strong> Test@1234</p>";
        echo "<p>Try logging in now!</p>";
        echo "</div>";
    }
    echo "</div>";
    
} else {
    // Create new admin account
    $username = 'admin';
    $password = 'Test@1234';
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $role = 'admin';
    
    $stmt = $conn->prepare("INSERT INTO users (username, password, role, created_at) VALUES (?, ?, ?, NOW())");
    $stmt->bind_param("sss", $username, $hashed_password, $role);
    
    if ($stmt->execute()) {
        echo "<div style='background: #d4edda; padding: 20px; border-radius: 10px; margin: 20px; border-left: 5px solid #28a745;'>";
        echo "<h2 style='color: #155724;'>✅ Admin Account Created Successfully!</h2>";
        echo "<div style='background: white; padding: 15px; border-radius: 5px; margin: 15px 0;'>";
        echo "<p style='font-size: 1.2em; margin: 10px 0;'><strong>Username:</strong> <code style='background: #f8f9fa; padding: 5px 10px; border-radius: 3px;'>admin</code></p>";
        echo "<p style='font-size: 1.2em; margin: 10px 0;'><strong>Password:</strong> <code style='background: #f8f9fa; padding: 5px 10px; border-radius: 3px;'>Test@1234</code></p>";
        echo "<p style='font-size: 1.2em; margin: 10px 0;'><strong>Role:</strong> <code style='background: #f8f9fa; padding: 5px 10px; border-radius: 3px;'>Administrator</code></p>";
        echo "</div>";
        echo "<p><a href='login.php' style='background: #28a745; color: white; padding: 12px 24px; text-decoration: none; border-radius: 5px; display: inline-block; margin-top: 10px;'>🔐 Go to Login Page</a></p>";
        echo "</div>";
    } else {
        echo "<div style='background: #f8d7da; padding: 20px; border-radius: 10px; margin: 20px; border-left: 5px solid #dc3545;'>";
        echo "<h2 style='color: #721c24;'>❌ Error Creating Admin</h2>";
        echo "<p>Error: " . $conn->error . "</p>";
        echo "</div>";
    }
}

// Show all current users
echo "<div style='margin: 20px; padding: 20px; background: #f8f9fa; border-radius: 10px;'>";
echo "<h2>📋 All Users in Database:</h2>";
echo "<table style='width: 100%; border-collapse: collapse; background: white;'>";
echo "<tr style='background: #0c2461; color: white;'>";
echo "<th style='padding: 10px; text-align: left;'>ID</th>";
echo "<th style='padding: 10px; text-align: left;'>Username</th>";
echo "<th style='padding: 10px; text-align: left;'>Role</th>";
echo "<th style='padding: 10px; text-align: left;'>Password</th>";
echo "</tr>";

$all_users = $conn->query("SELECT id, username, role FROM users ORDER BY role, username");
$row_color = true;
while ($user = $all_users->fetch_assoc()) {
    $bg = $row_color ? '#ffffff' : '#f8f9fa';
    echo "<tr style='background: $bg;'>";
    echo "<td style='padding: 10px; border-bottom: 1px solid #dee2e6;'>{$user['id']}</td>";
    echo "<td style='padding: 10px; border-bottom: 1px solid #dee2e6;'><strong>{$user['username']}</strong></td>";
    echo "<td style='padding: 10px; border-bottom: 1px solid #dee2e6;'><span style='background: #e3f2fd; padding: 3px 8px; border-radius: 3px;'>{$user['role']}</span></td>";
    echo "<td style='padding: 10px; border-bottom: 1px solid #dee2e6;'><code>Test@1234</code></td>";
    echo "</tr>";
    $row_color = !$row_color;
}
echo "</table>";
echo "</div>";

// Test the admin login
echo "<div style='margin: 20px; padding: 20px; background: #e7f3ff; border-radius: 10px; border-left: 5px solid #2196F3;'>";
echo "<h2>🧪 Test Admin Login:</h2>";
echo "<ol style='line-height: 2;'>";
echo "<li>Go to: <a href='login.php' target='_blank'>http://localhost/Groupprojectdevelopingweb/login.php</a></li>";
echo "<li>Enter Username: <strong>admin</strong></li>";
echo "<li>Enter Password: <strong>Test@1234</strong></li>";
echo "<li>Click Login</li>";
echo "</ol>";
echo "</div>";

$conn->close();
?>

<style>
    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        margin: 0;
        padding: 20px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        min-height: 100vh;
    }
    h1 {
        color: white;
        text-align: center;
        text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
    }
</style>
