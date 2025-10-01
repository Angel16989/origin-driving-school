<?php
// setup_dummy_users.php - Add dummy users and students for testing
require_once 'php/db_connect.php';

$dummy_users = [
    [
        'username' => 'indianuser1',
        'email' => 'indian1@example.com',
        'password' => 'Test@1234',
        'full_name' => 'Priya Sharma',
        'phone' => '555-1001',
        'role' => 'student'
    ],
    [
        'username' => 'nepaliuser1',
        'email' => 'nepali1@example.com',
        'password' => 'Test@1234',
        'full_name' => 'Suman Thapa',
        'phone' => '555-1002',
        'role' => 'student'
    ],
    [
        'username' => 'whiteuser1',
        'email' => 'white1@example.com',
        'password' => 'Test@1234',
        'full_name' => 'Mike Johnson',
        'phone' => '555-1003',
        'role' => 'student'
    ],
    [
        'username' => 'instructor1',
        'email' => 'instructor1@example.com',
        'password' => 'Test@1234',
        'full_name' => 'Rajesh Patel',
        'phone' => '555-1004',
        'role' => 'instructor'
    ],
    [
        'username' => 'instructor2',
        'email' => 'instructor2@example.com',
        'password' => 'Test@1234',
        'full_name' => 'Anita Gurung',
        'phone' => '555-1005',
        'role' => 'instructor'
    ]
];

foreach ($dummy_users as $user) {
    $hashed_password = password_hash($user['password'], PASSWORD_DEFAULT);
    $stmt = $conn->prepare("INSERT INTO users (username, password, role, created_at) VALUES (?, ?, ?, NOW())");
    $stmt->bind_param("sss", $user['username'], $hashed_password, $user['role']);
    if ($stmt->execute()) {
        $user_id = $conn->insert_id;
        if ($user['role'] === 'student') {
            $stmt2 = $conn->prepare("INSERT INTO students (name, email, phone, progress, created_at) VALUES (?, ?, ?, 'Getting Started', NOW())");
            $stmt2->bind_param("sss", $user['full_name'], $user['email'], $user['phone']);
            $stmt2->execute();
            $stmt2->close();
        }
        echo "✅ Added user: {$user['username']} ({$user['role']})\n";
    } else {
        echo "❌ Error adding user: {$user['username']} - " . $conn->error . "\n";
    }
    $stmt->close();
}

echo "\n🎉 Dummy users and students added!\n";
?>
