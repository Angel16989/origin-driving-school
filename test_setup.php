<?php
// test_setup.php - Test database connection and setup
echo "<h1>Origin Driving School - Setup Test</h1>";

// Test database connection
try {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "origin_driving_school";
    
    $conn = new mysqli($servername, $username, $password, $dbname);
    
    if ($conn->connect_error) {
        echo "<p style='color:red;'>❌ Database connection failed: " . $conn->connect_error . "</p>";
        echo "<p><strong>Please:</strong></p>";
        echo "<ul>";
        echo "<li>1. Start XAMPP and ensure MySQL is running</li>";
        echo "<li>2. Create database 'origin_driving_school' in phpMyAdmin</li>";
        echo "<li>3. Import db/database.sql into the database</li>";
        echo "</ul>";
        exit;
    } else {
        echo "<p style='color:green;'>✅ Database connection successful!</p>";
    }
    
    // Test tables exist
    $tables = ['users', 'students', 'instructors', 'bookings', 'invoices', 'payments', 'messages', 'branches'];
    echo "<h3>Testing Tables:</h3>";
    foreach($tables as $table) {
        $result = $conn->query("SHOW TABLES LIKE '$table'");
        if($result->num_rows > 0) {
            echo "<p style='color:green;'>✅ Table '$table' exists</p>";
        } else {
            echo "<p style='color:red;'>❌ Table '$table' missing</p>";
        }
    }
    
    // Test sample data
    echo "<h3>Testing Sample Data:</h3>";
    $result = $conn->query("SELECT COUNT(*) as count FROM users");
    $row = $result->fetch_assoc();
    echo "<p>Users: " . $row['count'] . "</p>";
    
    $result = $conn->query("SELECT COUNT(*) as count FROM students");
    $row = $result->fetch_assoc();
    echo "<p>Students: " . $row['count'] . "</p>";
    
    $result = $conn->query("SELECT COUNT(*) as count FROM instructors");
    $row = $result->fetch_assoc();
    echo "<p>Instructors: " . $row['count'] . "</p>";
    
    // Test login credentials
    echo "<h3>Testing Login Credentials:</h3>";
    $result = $conn->query("SELECT username, role FROM users");
    while($row = $result->fetch_assoc()) {
        echo "<p>✅ " . $row['username'] . " (" . $row['role'] . ") - Password: 'password'</p>";
    }
    
    echo "<h3>✅ Setup Complete!</h3>";
    echo "<p><a href='index.php' style='background:#007bff;color:white;padding:10px 20px;text-decoration:none;border-radius:5px;'>Go to Homepage</a></p>";
    
} catch(Exception $e) {
    echo "<p style='color:red;'>❌ Error: " . $e->getMessage() . "</p>";
}
?>
<style>
body { font-family: Arial, sans-serif; max-width: 800px; margin: 50px auto; padding: 20px; }
</style>
