<?php
// check_status.php - Honest System Status Check
echo "<h1>🔍 HONEST System Status Check</h1>";
echo "<p><em>Let's see what's ACTUALLY working...</em></p>";

$status = [];
$overall_working = true;

// Test 1: Basic PHP
echo "<h2>1. PHP Environment</h2>";
if (function_exists('phpversion')) {
    echo "<p style='color:green;'>✅ PHP is working (Version: " . phpversion() . ")</p>";
    $status['php'] = true;
} else {
    echo "<p style='color:red;'>❌ PHP not working</p>";
    $status['php'] = false;
    $overall_working = false;
}

// Test 2: MySQL Extension
echo "<h2>2. MySQL Extension</h2>";
if (extension_loaded('mysqli')) {
    echo "<p style='color:green;'>✅ MySQLi extension loaded</p>";
    $status['mysqli'] = true;
} else {
    echo "<p style='color:red;'>❌ MySQLi extension not loaded</p>";
    $status['mysqli'] = false;
    $overall_working = false;
}

// Test 3: Database Connection
echo "<h2>3. Database Connection</h2>";
try {
    $conn = new mysqli('localhost', 'root', '', 'origin_driving_school');
    if ($conn->connect_error) {
        echo "<p style='color:red;'>❌ Cannot connect to database: " . $conn->connect_error . "</p>";
        echo "<p><strong>Action needed:</strong> Run setup_database.php first!</p>";
        $status['database'] = false;
        $overall_working = false;
    } else {
        echo "<p style='color:green;'>✅ Database connection successful</p>";
        $status['database'] = true;
    }
} catch (Exception $e) {
    echo "<p style='color:red;'>❌ Database error: " . $e->getMessage() . "</p>";
    $status['database'] = false;
    $overall_working = false;
}

// Test 4: Tables exist
if ($status['database']) {
    echo "<h2>4. Database Tables</h2>";
    $required_tables = ['users', 'students', 'instructors', 'bookings', 'invoices', 'payments', 'messages', 'branches'];
    $tables_ok = true;
    
    foreach ($required_tables as $table) {
        $result = $conn->query("SHOW TABLES LIKE '$table'");
        if ($result && $result->num_rows > 0) {
            echo "<p style='color:green;'>✅ Table '$table' exists</p>";
        } else {
            echo "<p style='color:red;'>❌ Table '$table' missing</p>";
            $tables_ok = false;
            $overall_working = false;
        }
    }
    $status['tables'] = $tables_ok;
}

// Test 5: Sample Data
if ($status['database'] && $status['tables']) {
    echo "<h2>5. Sample Data</h2>";
    $result = $conn->query("SELECT COUNT(*) as count FROM users");
    if ($result) {
        $row = $result->fetch_assoc();
        if ($row['count'] > 0) {
            echo "<p style='color:green;'>✅ Users table has " . $row['count'] . " records</p>";
            $status['data'] = true;
        } else {
            echo "<p style='color:red;'>❌ No users found in database</p>";
            $status['data'] = false;
            $overall_working = false;
        }
    }
}

// Test 6: Login Test
if ($overall_working) {
    echo "<h2>6. Login System Test</h2>";
    $result = $conn->query("SELECT username FROM users WHERE username = 'admin'");
    if ($result && $result->num_rows > 0) {
        echo "<p style='color:green;'>✅ Admin user exists</p>";
        echo "<p><strong>Try logging in:</strong> admin / password</p>";
        $status['login'] = true;
    } else {
        echo "<p style='color:red;'>❌ Admin user not found</p>";
        $status['login'] = false;
        $overall_working = false;
    }
}

// Overall Status
echo "<h2>🏁 OVERALL STATUS</h2>";
if ($overall_working) {
    echo "<div style='background:#d4edda;padding:20px;border-radius:10px;border:2px solid #28a745;'>";
    echo "<h3 style='color:#155724;'>🎉 SYSTEM IS FUNCTIONAL!</h3>";
    echo "<p>Everything is working properly. You can now use the system.</p>";
    echo "<p><a href='index.php' style='background:#28a745;color:white;padding:15px 25px;text-decoration:none;border-radius:5px;font-weight:bold;'>🚀 ACCESS WEBSITE</a></p>";
    echo "</div>";
} else {
    echo "<div style='background:#f8d7da;padding:20px;border-radius:10px;border:2px solid #dc3545;'>";
    echo "<h3 style='color:#721c24;'>❌ SYSTEM NOT FUNCTIONAL</h3>";
    echo "<p>Issues found that need to be fixed:</p>";
    echo "<ol>";
    if (!$status['php']) echo "<li>PHP not working - Install XAMPP</li>";
    if (!$status['mysqli']) echo "<li>MySQL extension missing - Check XAMPP installation</li>";
    if (!$status['database']) echo "<li>Database connection failed - Start MySQL in XAMPP</li>";
    if (!$status['tables']) echo "<li>Database tables missing - Run setup_database.php</li>";
    if (!$status['data']) echo "<li>No sample data - Run setup_database.php</li>";
    if (!$status['login']) echo "<li>Login system not ready - Run setup_database.php</li>";
    echo "</ol>";
    echo "<p><a href='setup_database.php' style='background:#dc3545;color:white;padding:15px 25px;text-decoration:none;border-radius:5px;font-weight:bold;'>🔧 RUN SETUP</a></p>";
    echo "</div>";
}

// File Check
echo "<h2>7. File Structure Check</h2>";
$required_files = [
    'index.php' => 'Homepage',
    'login.php' => 'Login page', 
    'dashboard.php' => 'Dashboard',
    'php/db_connect.php' => 'Database connection',
    'css/styles.css' => 'Styles',
    'js/scripts.js' => 'JavaScript'
];

foreach ($required_files as $file => $description) {
    if (file_exists($file)) {
        echo "<p style='color:green;'>✅ $description ($file)</p>";
    } else {
        echo "<p style='color:red;'>❌ Missing: $description ($file)</p>";
    }
}

if (isset($conn)) $conn->close();
?>

<style>
body { 
    font-family: Arial, sans-serif; 
    max-width: 1000px; 
    margin: 20px auto; 
    padding: 20px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    min-height: 100vh;
}
h1, h2, h3 { color: #2c3e50; }
p { margin: 8px 0; }
ol li { margin: 5px 0; }
</style>
