<?php
// setup_database.php - Complete Database Setup Script
echo "<h1>🔧 Origin Driving School - Complete Setup</h1>";

// Step 1: Test basic PHP functionality
echo "<h2>Step 1: PHP Test</h2>";
echo "<p>✅ PHP is working! Version: " . phpversion() . "</p>";

// Step 2: Test MySQL connection
echo "<h2>Step 2: MySQL Connection Test</h2>";
$servername = "localhost";
$username = "root";
$password = "";

try {
    $conn = new mysqli($servername, $username, $password);
    if ($conn->connect_error) {
        echo "<p style='color:red;'>❌ MySQL connection failed: " . $conn->connect_error . "</p>";
        echo "<p><strong>Fix:</strong> Start XAMPP and make sure MySQL is running!</p>";
        exit;
    } else {
        echo "<p style='color:green;'>✅ MySQL connection successful!</p>";
    }
} catch (Exception $e) {
    echo "<p style='color:red;'>❌ Error: " . $e->getMessage() . "</p>";
    echo "<p><strong>Solution:</strong> Install and start XAMPP</p>";
    exit;
}

// Step 3: Create database if not exists
echo "<h2>Step 3: Database Creation</h2>";
$dbname = "origin_driving_school";
$sql = "CREATE DATABASE IF NOT EXISTS $dbname";
if ($conn->query($sql) === TRUE) {
    echo "<p style='color:green;'>✅ Database '$dbname' created/verified!</p>";
} else {
    echo "<p style='color:red;'>❌ Error creating database: " . $conn->error . "</p>";
    exit;
}

// Step 4: Select database and create tables
$conn->select_db($dbname);
echo "<h2>Step 4: Creating Tables</h2>";

// Create all tables with proper structure
$tables = [
    "branches" => "CREATE TABLE IF NOT EXISTS branches (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(100),
        address VARCHAR(255)
    )",
    "users" => "CREATE TABLE IF NOT EXISTS users (
        id INT AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(50) UNIQUE,
        password VARCHAR(255),
        role ENUM('admin','student','instructor'),
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP
    )",
    "students" => "CREATE TABLE IF NOT EXISTS students (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(100),
        email VARCHAR(100),
        phone VARCHAR(20),
        license_no VARCHAR(50),
        progress VARCHAR(255),
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP
    )",
    "instructors" => "CREATE TABLE IF NOT EXISTS instructors (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(100),
        email VARCHAR(100),
        qualifications VARCHAR(255),
        schedule VARCHAR(255),
        branch_id INT,
        FOREIGN KEY (branch_id) REFERENCES branches(id)
    )",
    "bookings" => "CREATE TABLE IF NOT EXISTS bookings (
        id INT AUTO_INCREMENT PRIMARY KEY,
        student_id INT,
        instructor_id INT,
        date DATE,
        time TIME,
        status VARCHAR(50),
        FOREIGN KEY (student_id) REFERENCES students(id),
        FOREIGN KEY (instructor_id) REFERENCES instructors(id)
    )",
    "invoices" => "CREATE TABLE IF NOT EXISTS invoices (
        id INT AUTO_INCREMENT PRIMARY KEY,
        student_id INT,
        amount DECIMAL(10,2),
        status VARCHAR(50),
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (student_id) REFERENCES students(id)
    )",
    "payments" => "CREATE TABLE IF NOT EXISTS payments (
        id INT AUTO_INCREMENT PRIMARY KEY,
        invoice_id INT,
        amount DECIMAL(10,2),
        method VARCHAR(50),
        paid_at DATETIME,
        FOREIGN KEY (invoice_id) REFERENCES invoices(id)
    )",
    "messages" => "CREATE TABLE IF NOT EXISTS messages (
        id INT AUTO_INCREMENT PRIMARY KEY,
        sender_id INT,
        receiver_id INT,
        message TEXT,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (sender_id) REFERENCES users(id),
        FOREIGN KEY (receiver_id) REFERENCES users(id)
    )"
];

foreach ($tables as $name => $sql) {
    if ($conn->query($sql) === TRUE) {
        echo "<p style='color:green;'>✅ Table '$name' created!</p>";
    } else {
        echo "<p style='color:red;'>❌ Error creating table '$name': " . $conn->error . "</p>";
    }
}

// Step 5: Insert sample data with CORRECT password hashes
echo "<h2>Step 5: Inserting Sample Data</h2>";

// Create proper password hash for "password"
$password_hash = password_hash('password', PASSWORD_DEFAULT);

$sample_data = [
    "branches" => "INSERT IGNORE INTO branches (id, name, address) VALUES 
        (1, 'Central', '123 Main St'), 
        (2, 'North', '456 North Rd')",
    
    "users" => "INSERT IGNORE INTO users (id, username, password, role) VALUES 
        (1, 'admin', '$password_hash', 'admin'),
        (2, 'student1', '$password_hash', 'student'),
        (3, 'instructor1', '$password_hash', 'instructor')",
    
    "students" => "INSERT IGNORE INTO students (id, name, email, phone, license_no, progress) VALUES 
        (1, 'John Doe', 'john@example.com', '1234567890', 'A1234567', 'Theory Complete'),
        (2, 'Jane Smith', 'jane@example.com', '0987654321', 'B7654321', 'Practical Scheduled')",
    
    "instructors" => "INSERT IGNORE INTO instructors (id, name, email, qualifications, schedule, branch_id) VALUES 
        (1, 'Mike Brown', 'mike@driving.com', 'Certified Instructor', 'Mon-Fri 9am-5pm', 1),
        (2, 'Sara Lee', 'sara@driving.com', 'Senior Instructor', 'Tue-Thu 10am-4pm', 2)",
    
    "bookings" => "INSERT IGNORE INTO bookings (id, student_id, instructor_id, date, time, status) VALUES 
        (1, 1, 1, '2025-09-20', '10:00:00', 'Confirmed'),
        (2, 2, 2, '2025-09-21', '11:00:00', 'Pending')",
    
    "invoices" => "INSERT IGNORE INTO invoices (id, student_id, amount, status) VALUES 
        (1, 1, 100.00, 'Paid'),
        (2, 2, 150.00, 'Unpaid')",
    
    "payments" => "INSERT IGNORE INTO payments (id, invoice_id, amount, method, paid_at) VALUES 
        (1, 1, 100.00, 'Cash', '2025-09-15 09:00:00')",
    
    "messages" => "INSERT IGNORE INTO messages (id, sender_id, receiver_id, message) VALUES 
        (1, 2, 3, 'Hello Instructor, when is my next lesson?'),
        (2, 3, 2, 'Your next lesson is on 2025-09-21 at 11:00.')"
];

foreach ($sample_data as $table => $sql) {
    if ($conn->query($sql) === TRUE) {
        echo "<p style='color:green;'>✅ Sample data inserted into '$table'!</p>";
    } else {
        echo "<p style='color:orange;'>⚠️ $table: " . $conn->error . " (might already exist)</p>";
    }
}

echo "<h2>🎉 Setup Complete!</h2>";
echo "<div style='background:#d4edda;padding:20px;border-radius:10px;margin:20px 0;'>";
echo "<h3>✅ System is now fully functional!</h3>";
echo "<p><strong>Login credentials:</strong></p>";
echo "<ul>";
echo "<li>Admin: <code>admin</code> / <code>password</code></li>";
echo "<li>Student: <code>student1</code> / <code>password</code></li>";  
echo "<li>Instructor: <code>instructor1</code> / <code>password</code></li>";
echo "</ul>";
echo "<p><a href='index.php' style='background:#28a745;color:white;padding:15px 25px;text-decoration:none;border-radius:5px;font-weight:bold;'>🚀 GO TO WEBSITE</a></p>";
echo "</div>";

$conn->close();
?>
<style>
body { 
    font-family: Arial, sans-serif; 
    max-width: 1000px; 
    margin: 20px auto; 
    padding: 20px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: #333;
}
h1, h2 { color: #2c3e50; }
p { margin: 10px 0; }
</style>
