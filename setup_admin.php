<?php
// setup_admin.php - Create admin account for testing
require_once 'php/db_connect.php';

echo "<h1>Admin Account Setup</h1>";

// Check if admin already exists
$check = $conn->query("SELECT id FROM users WHERE role = 'admin' LIMIT 1");

if ($check->num_rows > 0) {
    echo "<p style='color: orange;'>⚠️ Admin account already exists!</p>";
    
    // Show existing admin accounts
    $admins = $conn->query("SELECT username, created_at FROM users WHERE role = 'admin'");
    echo "<h2>Existing Admin Accounts:</h2><ul>";
    while ($admin = $admins->fetch_assoc()) {
        echo "<li><strong>Username:</strong> {$admin['username']} | <strong>Password:</strong> Test@1234</li>";
    }
    echo "</ul>";
} else {
    // Create admin account
    $username = 'admin';
    $password = 'Test@1234';
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $role = 'admin';
    
    $stmt = $conn->prepare("INSERT INTO users (username, password, role, created_at) VALUES (?, ?, ?, NOW())");
    $stmt->bind_param("sss", $username, $hashed_password, $role);
    
    if ($stmt->execute()) {
        echo "<div style='background: #d4edda; padding: 20px; border-radius: 10px; border-left: 5px solid #28a745;'>";
        echo "<h2 style='color: #155724;'>✅ Admin Account Created Successfully!</h2>";
        echo "<p><strong>Username:</strong> admin</p>";
        echo "<p><strong>Password:</strong> Test@1234</p>";
        echo "<p><strong>Role:</strong> Administrator</p>";
        echo "<p><a href='login.php' style='background: #28a745; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;'>Go to Login</a></p>";
        echo "</div>";
    } else {
        echo "<p style='color: red;'>❌ Error creating admin account: " . $conn->error . "</p>";
    }
    $stmt->close();
}

// Display all user accounts for reference
echo "<h2>📋 All User Accounts in System:</h2>";
echo "<table border='1' cellpadding='10' style='border-collapse: collapse; width: 100%;'>";
echo "<tr style='background: #f8f9fa;'><th>ID</th><th>Username</th><th>Role</th><th>Password</th><th>Created</th></tr>";

$all_users = $conn->query("SELECT id, username, role, created_at FROM users ORDER BY role, username");
while ($user = $all_users->fetch_assoc()) {
    $bg_color = '';
    switch($user['role']) {
        case 'admin': $bg_color = '#fff3cd'; break;
        case 'instructor': $bg_color = '#d1ecf1'; break;
        case 'student': $bg_color = '#d4edda'; break;
    }
    echo "<tr style='background: $bg_color;'>";
    echo "<td>{$user['id']}</td>";
    echo "<td><strong>{$user['username']}</strong></td>";
    echo "<td>{$user['role']}</td>";
    echo "<td>Test@1234</td>";
    echo "<td>" . date('M j, Y', strtotime($user['created_at'])) . "</td>";
    echo "</tr>";
}
echo "</table>";

$conn->close();
?>

<style>
    body {
        font-family: Arial, sans-serif;
        max-width: 1200px;
        margin: 20px auto;
        padding: 20px;
        background: #f8f9fa;
    }
    h1 {
        color: #0c2461;
        border-bottom: 3px solid #FFD700;
        padding-bottom: 10px;
    }
</style>
