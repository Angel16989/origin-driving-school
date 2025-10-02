<?php
// debug_admin_login.php - Debug admin login issue
require_once 'php/db_connect.php';

echo "<h1>🔍 Admin Login Debugger</h1>";

// Check if admin user exists
$result = $conn->query("SELECT id, username, password, role, created_at FROM users WHERE username = 'admin'");

if ($result->num_rows === 0) {
    echo "<div style='background: #f8d7da; padding: 20px; border-radius: 10px; margin: 20px;'>";
    echo "<h2>❌ Admin User Does NOT Exist</h2>";
    echo "<p>Let's create it now...</p>";
    
    // Create admin
    $password = 'Test@1234';
    $hashed = password_hash($password, PASSWORD_DEFAULT);
    
    $stmt = $conn->prepare("INSERT INTO users (username, password, role, created_at) VALUES ('admin', ?, 'admin', NOW())");
    $stmt->bind_param("s", $hashed);
    
    if ($stmt->execute()) {
        echo "<div style='background: #d4edda; padding: 15px; margin-top: 15px; border-radius: 5px;'>";
        echo "<h3>✅ Admin Created!</h3>";
        echo "<p><strong>Username:</strong> admin</p>";
        echo "<p><strong>Password:</strong> Test@1234</p>";
        echo "</div>";
        
        // Retrieve the newly created admin
        $result = $conn->query("SELECT id, username, password, role, created_at FROM users WHERE username = 'admin'");
    } else {
        echo "<p style='color: red;'>Error: " . $conn->error . "</p>";
        exit;
    }
    
    echo "</div>";
}

// Get admin details
$admin = $result->fetch_assoc();

echo "<div style='background: #e3f2fd; padding: 20px; border-radius: 10px; margin: 20px;'>";
echo "<h2>✅ Admin User Found</h2>";
echo "<table style='width: 100%; background: white; border-radius: 5px;'>";
echo "<tr><td style='padding: 10px; font-weight: bold;'>ID:</td><td style='padding: 10px;'>{$admin['id']}</td></tr>";
echo "<tr><td style='padding: 10px; font-weight: bold;'>Username:</td><td style='padding: 10px;'>{$admin['username']}</td></tr>";
echo "<tr><td style='padding: 10px; font-weight: bold;'>Role:</td><td style='padding: 10px;'>{$admin['role']}</td></tr>";
echo "<tr><td style='padding: 10px; font-weight: bold;'>Created:</td><td style='padding: 10px;'>{$admin['created_at']}</td></tr>";
echo "<tr><td style='padding: 10px; font-weight: bold;'>Password Hash:</td><td style='padding: 10px; font-family: monospace; font-size: 0.8em;'>" . substr($admin['password'], 0, 50) . "...</td></tr>";
echo "</table>";
echo "</div>";

// Test password verification
echo "<div style='background: #fff8e1; padding: 20px; border-radius: 10px; margin: 20px;'>";
echo "<h2>🧪 Password Verification Test</h2>";

$test_password = 'Test@1234';
$stored_hash = $admin['password'];

echo "<p><strong>Testing password:</strong> <code>$test_password</code></p>";
echo "<p><strong>Against stored hash:</strong> <code style='font-size: 0.8em;'>" . substr($stored_hash, 0, 60) . "...</code></p>";

if (password_verify($test_password, $stored_hash)) {
    echo "<div style='background: #d4edda; padding: 15px; border-radius: 5px; margin: 10px 0;'>";
    echo "<h3 style='color: #155724;'>✅ PASSWORD VERIFICATION SUCCESSFUL!</h3>";
    echo "<p>The password 'Test@1234' matches the stored hash.</p>";
    echo "<p><strong>This means login SHOULD work!</strong></p>";
    echo "</div>";
} else {
    echo "<div style='background: #f8d7da; padding: 15px; border-radius: 5px; margin: 10px 0;'>";
    echo "<h3 style='color: #721c24;'>❌ PASSWORD VERIFICATION FAILED!</h3>";
    echo "<p>The password 'Test@1234' does NOT match the stored hash.</p>";
    echo "<p><strong>Let's reset the password...</strong></p>";
    
    // Reset password
    $new_hash = password_hash($test_password, PASSWORD_DEFAULT);
    $update = $conn->prepare("UPDATE users SET password = ? WHERE username = 'admin'");
    $update->bind_param("s", $new_hash);
    
    if ($update->execute()) {
        echo "<div style='background: #d4edda; padding: 10px; border-radius: 5px; margin-top: 10px;'>";
        echo "<p>✅ Password reset successfully! Try logging in now.</p>";
        echo "</div>";
    }
    echo "</div>";
}

echo "</div>";

// Manual login test
echo "<div style='background: #e8f5e8; padding: 20px; border-radius: 10px; margin: 20px;'>";
echo "<h2>🔐 Manual Login Test</h2>";
echo "<form method='POST' style='background: white; padding: 20px; border-radius: 10px;'>";
echo "<p><label><strong>Username:</strong><br><input type='text' name='test_username' value='admin' style='width: 300px; padding: 8px; margin-top: 5px; border: 2px solid #ddd; border-radius: 5px;'></label></p>";
echo "<p><label><strong>Password:</strong><br><input type='text' name='test_password' value='Test@1234' style='width: 300px; padding: 8px; margin-top: 5px; border: 2px solid #ddd; border-radius: 5px;'></label></p>";
echo "<p><button type='submit' name='test_login' style='background: #28a745; color: white; padding: 10px 30px; border: none; border-radius: 5px; cursor: pointer; font-size: 1em;'>🧪 Test Login</button></p>";
echo "</form>";

if (isset($_POST['test_login'])) {
    $test_user = $_POST['test_username'];
    $test_pass = $_POST['test_password'];
    
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param('s', $test_user);
    $stmt->execute();
    $test_result = $stmt->get_result();
    
    if ($test_row = $test_result->fetch_assoc()) {
        if (password_verify($test_pass, $test_row['password'])) {
            echo "<div style='background: #d4edda; padding: 15px; border-radius: 5px; margin-top: 15px;'>";
            echo "<h3 style='color: #155724;'>✅ LOGIN TEST SUCCESSFUL!</h3>";
            echo "<p>Username: <strong>{$test_user}</strong></p>";
            echo "<p>Password: <strong>{$test_pass}</strong></p>";
            echo "<p>Role: <strong>{$test_row['role']}</strong></p>";
            echo "<p style='margin-top: 15px;'><a href='login.php' style='background: #28a745; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;'>Go to Real Login Page</a></p>";
            echo "</div>";
        } else {
            echo "<div style='background: #f8d7da; padding: 15px; border-radius: 5px; margin-top: 15px;'>";
            echo "<h3 style='color: #721c24;'>❌ LOGIN TEST FAILED - Password Incorrect</h3>";
            echo "</div>";
        }
    } else {
        echo "<div style='background: #f8d7da; padding: 15px; border-radius: 5px; margin-top: 15px;'>";
        echo "<h3 style='color: #721c24;'>❌ LOGIN TEST FAILED - User Not Found</h3>";
        echo "</div>";
    }
}

echo "</div>";

// Show all users
echo "<div style='background: white; padding: 20px; border-radius: 10px; margin: 20px;'>";
echo "<h2>👥 All Users in Database</h2>";
echo "<table style='width: 100%; border-collapse: collapse;'>";
echo "<tr style='background: #0c2461; color: white;'>";
echo "<th style='padding: 10px; text-align: left;'>ID</th>";
echo "<th style='padding: 10px; text-align: left;'>Username</th>";
echo "<th style='padding: 10px; text-align: left;'>Role</th>";
echo "<th style='padding: 10px; text-align: left;'>Test Password</th>";
echo "</tr>";

$all = $conn->query("SELECT id, username, role FROM users ORDER BY role, username");
$i = 0;
while ($user = $all->fetch_assoc()) {
    $bg = $i % 2 == 0 ? '#f8f9fa' : 'white';
    echo "<tr style='background: $bg;'>";
    echo "<td style='padding: 10px; border-bottom: 1px solid #dee2e6;'>{$user['id']}</td>";
    echo "<td style='padding: 10px; border-bottom: 1px solid #dee2e6;'><strong>{$user['username']}</strong></td>";
    echo "<td style='padding: 10px; border-bottom: 1px solid #dee2e6;'>{$user['role']}</td>";
    echo "<td style='padding: 10px; border-bottom: 1px solid #dee2e6;'><code>Test@1234</code></td>";
    echo "</tr>";
    $i++;
}
echo "</table>";
echo "</div>";

$conn->close();
?>

<style>
    body {
        font-family: Arial, sans-serif;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        margin: 0;
        padding: 20px;
        min-height: 100vh;
    }
    h1 {
        color: white;
        text-align: center;
        text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
    }
    code {
        background: #f4f4f4;
        padding: 2px 6px;
        border-radius: 3px;
        font-family: 'Courier New', monospace;
    }
</style>
