<?php
// fix_empty_charts.php - Add data for instructor performance and student enrollment
require_once 'php/db_connect.php';

echo "🔧 Fixing Empty Charts - Adding Instructor & Student Data...\n\n";

// First, let's check what we have
echo "📊 Current Data Check:\n";
echo "======================\n";

$instructor_bookings = $conn->query("SELECT i.name, COUNT(b.id) as lessons FROM instructors i LEFT JOIN bookings b ON i.id = b.instructor_id GROUP BY i.id, i.name");
echo "Instructor Lessons:\n";
while ($row = $instructor_bookings->fetch_assoc()) {
    echo "- {$row['name']}: {$row['lessons']} lessons\n";
}

$monthly_students = $conn->query("SELECT DATE_FORMAT(created_at, '%Y-%m') as month, COUNT(*) as count FROM students WHERE created_at >= DATE_SUB(NOW(), INTERVAL 12 MONTH) GROUP BY month ORDER BY month");
echo "\nMonthly Student Enrollments:\n";
while ($row = $monthly_students->fetch_assoc()) {
    echo "- {$row['month']}: {$row['count']} students\n";
}

echo "\n🚀 Adding More Instructor Bookings...\n";
echo "=====================================\n";

// Add lots more bookings for instructors to make the chart meaningful
$instructor_lessons = [
    // Mike Brown (ID: 1) - Chief Instructor - Should have most lessons
    [1, '2025-09-01', '09:00:00', 'Completed'],
    [1, '2025-09-01', '11:00:00', 'Completed'],
    [1, '2025-09-02', '10:00:00', 'Completed'],
    [1, '2025-09-02', '14:00:00', 'Completed'],
    [1, '2025-09-03', '09:00:00', 'Completed'],
    [1, '2025-09-03', '15:00:00', 'Completed'],
    [1, '2025-09-04', '10:00:00', 'Completed'],
    [1, '2025-09-05', '11:00:00', 'Completed'],
    [1, '2025-09-05', '16:00:00', 'Completed'],
    [1, '2025-09-06', '09:00:00', 'Completed'],
    [1, '2025-09-08', '10:00:00', 'Completed'],
    [1, '2025-09-08', '14:00:00', 'Completed'],
    [1, '2025-09-09', '11:00:00', 'Completed'],
    [1, '2025-09-10', '15:00:00', 'Completed'],
    [1, '2025-09-11', '09:00:00', 'Completed'],
    [1, '2025-09-12', '10:00:00', 'Completed'],
    [1, '2025-09-12', '14:00:00', 'Completed'],
    [1, '2025-09-13', '11:00:00', 'Completed'],
    [1, '2025-09-15', '16:00:00', 'Completed'],
    [1, '2025-09-16', '09:00:00', 'Completed'],
    [1, '2025-08-20', '10:00:00', 'Completed'],
    [1, '2025-08-21', '11:00:00', 'Completed'],
    [1, '2025-08-22', '14:00:00', 'Completed'],
    [1, '2025-08-23', '15:00:00', 'Completed'],
    [1, '2025-08-25', '09:00:00', 'Completed'],
    [1, '2025-08-26', '10:00:00', 'Completed'],
    [1, '2025-08-27', '11:00:00', 'Completed'],
    [1, '2025-08-28', '14:00:00', 'Completed'],
    [1, '2025-08-29', '16:00:00', 'Completed'],
    [1, '2025-08-30', '09:00:00', 'Completed'],
    
    // Sara Lee (ID: 2) - Teen Specialist - Moderate lessons
    [2, '2025-09-02', '10:00:00', 'Completed'],
    [2, '2025-09-02', '15:00:00', 'Completed'],
    [2, '2025-09-04', '11:00:00', 'Completed'],
    [2, '2025-09-05', '14:00:00', 'Completed'],
    [2, '2025-09-06', '10:00:00', 'Completed'],
    [2, '2025-09-09', '16:00:00', 'Completed'],
    [2, '2025-09-10', '11:00:00', 'Completed'],
    [2, '2025-09-11', '14:00:00', 'Completed'],
    [2, '2025-09-12', '15:00:00', 'Completed'],
    [2, '2025-09-13', '10:00:00', 'Completed'],
    [2, '2025-09-16', '11:00:00', 'Completed'],
    [2, '2025-08-22', '14:00:00', 'Completed'],
    [2, '2025-08-23', '15:00:00', 'Completed'],
    [2, '2025-08-25', '10:00:00', 'Completed'],
    [2, '2025-08-26', '11:00:00', 'Completed'],
    [2, '2025-08-27', '14:00:00', 'Completed'],
    [2, '2025-08-28', '16:00:00', 'Completed'],
    [2, '2025-08-29', '10:00:00', 'Completed'],
];

foreach ($instructor_lessons as $lesson) {
    $instructor_id = $lesson[0];
    $date = $lesson[1];
    $time = $lesson[2]; 
    $status = $lesson[3];
    $student_id = rand(10, 29); // Random student from our dummy data
    
    $stmt = $conn->prepare("INSERT INTO bookings (student_id, instructor_id, date, time, status) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param('iisss', $student_id, $instructor_id, $date, $time, $status);
    $stmt->execute();
    
    echo "✅ Added lesson: Instructor {$instructor_id} on {$date} {$time} - {$status}\n";
}

echo "\n👥 Adding More Student Enrollments...\n";
echo "======================================\n";

// Add more students across different months to fill the enrollment trend chart
$monthly_enrollments = [
    // November 2024
    ['Alex Johnson', 'alex.johnson@email.com', '0412345678', 'DL112233', 'Registered', '2024-11-05 10:00:00'],
    ['Sophie Chen', 'sophie.chen@email.com', '0412345679', 'DL112234', 'Theory Completed', '2024-11-12 14:30:00'],
    ['Marcus Williams', 'marcus.w@email.com', '0412345680', 'DL112235', 'Practical Started', '2024-11-18 09:15:00'],
    ['Isabella Rodriguez', 'isabella.r@email.com', '0412345681', 'DL112236', 'Licensed', '2024-11-25 11:45:00'],
    
    // December 2024
    ['Ethan Thompson', 'ethan.t@email.com', '0412345682', 'DL112237', 'Theory Completed', '2024-12-03 13:20:00'],
    ['Olivia Davis', 'olivia.d@email.com', '0412345683', 'DL112238', 'Practical Started', '2024-12-08 15:10:00'],
    ['Logan Martinez', 'logan.m@email.com', '0412345684', 'DL112239', 'Test Ready', '2024-12-15 10:30:00'],
    ['Ava Anderson', 'ava.a@email.com', '0412345685', 'DL112240', 'Licensed', '2024-12-22 16:00:00'],
    ['Noah Taylor', 'noah.t@email.com', '0412345686', 'DL112241', 'Registered', '2024-12-28 09:45:00'],
    
    // January 2025
    ['Emma Wilson', 'emma.w@email.com', '0412345687', 'DL112242', 'Theory Completed', '2025-01-05 11:00:00'],
    ['Liam Moore', 'liam.m@email.com', '0412345688', 'DL112243', 'Practical Started', '2025-01-10 14:15:00'],
    ['Mia Jackson', 'mia.j@email.com', '0412345689', 'DL112244', 'Licensed', '2025-01-15 10:45:00'],
    ['Lucas White', 'lucas.w@email.com', '0412345690', 'DL112245', 'Test Ready', '2025-01-22 16:30:00'],
    ['Charlotte Harris', 'charlotte.h@email.com', '0412345691', 'DL112246', 'Registered', '2025-01-28 13:00:00'],
    
    // February 2025
    ['Alexander Clark', 'alex.c@email.com', '0412345692', 'DL112247', 'Theory Completed', '2025-02-02 09:30:00'],
    ['Amelia Lewis', 'amelia.l@email.com', '0412345693', 'DL112248', 'Practical Started', '2025-02-08 15:20:00'],
    ['Benjamin Lee', 'benjamin.l@email.com', '0412345694', 'DL112249', 'Licensed', '2025-02-15 11:15:00'],
    ['Harper Walker', 'harper.w@email.com', '0412345695', 'DL112250', 'Test Ready', '2025-02-22 14:45:00'],
    
    // March 2025
    ['James Hall', 'james.h@email.com', '0412345696', 'DL112251', 'Registered', '2025-03-01 10:00:00'],
    ['Evelyn Allen', 'evelyn.a@email.com', '0412345697', 'DL112252', 'Theory Completed', '2025-03-08 16:10:00'],
    ['Henry Young', 'henry.y@email.com', '0412345698', 'DL112253', 'Practical Started', '2025-03-15 13:30:00'],
    ['Abigail King', 'abigail.k@email.com', '0412345699', 'DL112254', 'Licensed', '2025-03-22 09:50:00'],
    ['Sebastian Wright', 'sebastian.w@email.com', '0412345700', 'DL112255', 'Test Ready', '2025-03-28 15:40:00'],
    
    // April 2025
    ['Madison Lopez', 'madison.l@email.com', '0412345701', 'DL112256', 'Registered', '2025-04-03 11:20:00'],
    ['Owen Hill', 'owen.h@email.com', '0412345702', 'DL112257', 'Theory Completed', '2025-04-10 14:00:00'],
    ['Scarlett Scott', 'scarlett.s@email.com', '0412345703', 'DL112258', 'Practical Started', '2025-04-18 10:15:00'],
    ['Jack Green', 'jack.g@email.com', '0412345704', 'DL112259', 'Licensed', '2025-04-25 16:25:00'],
    
    // May 2025
    ['Grace Adams', 'grace.a@email.com', '0412345705', 'DL112260', 'Test Ready', '2025-05-02 09:40:00'],
    ['Carter Baker', 'carter.b@email.com', '0412345706', 'DL112261', 'Registered', '2025-05-09 13:55:00'],
    ['Lily Nelson', 'lily.n@email.com', '0412345707', 'DL112262', 'Theory Completed', '2025-05-16 15:10:00'],
    ['Wyatt Carter', 'wyatt.c@email.com', '0412345708', 'DL112263', 'Practical Started', '2025-05-23 11:35:00'],
    ['Zoe Mitchell', 'zoe.m@email.com', '0412345709', 'DL112264', 'Licensed', '2025-05-30 14:20:00'],
    
    // June 2025 - Summer enrollment boost
    ['Leo Perez', 'leo.p@email.com', '0412345710', 'DL112265', 'Registered', '2025-06-02 10:30:00'],
    ['Stella Roberts', 'stella.r@email.com', '0412345711', 'DL112266', 'Theory Completed', '2025-06-05 16:45:00'],
    ['Julian Turner', 'julian.t@email.com', '0412345712', 'DL112267', 'Practical Started', '2025-06-10 09:20:00'],
    ['Aurora Phillips', 'aurora.p@email.com', '0412345713', 'DL112268', 'Test Ready', '2025-06-15 13:15:00'],
    ['Grayson Campbell', 'grayson.c@email.com', '0412345714', 'DL112269', 'Licensed', '2025-06-20 15:30:00'],
    ['Violet Parker', 'violet.p@email.com', '0412345715', 'DL112270', 'Registered', '2025-06-25 11:50:00'],
    
    // Current month data (October 2025) - we already added some, add more
    ['Mason Evans', 'mason.e@email.com', '0412345716', 'DL112271', 'Registered', '2025-10-01 14:00:00'],
    ['Hazel Edwards', 'hazel.e@email.com', '0412345717', 'DL112272', 'Theory Completed', '2025-10-02 10:30:00'],
];

foreach ($monthly_enrollments as $student) {
    $name = $student[0];
    $email = $student[1];
    $phone = $student[2];
    $license_no = $student[3];
    $progress = $student[4];
    $created_at = $student[5];
    
    $stmt = $conn->prepare("INSERT INTO students (name, email, phone, license_no, progress, created_at) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param('ssssss', $name, $email, $phone, $license_no, $progress, $created_at);
    $stmt->execute();
    
    echo "✅ Added student: {$name} - {$progress} ({$created_at})\n";
}

// Final verification
echo "\n📊 UPDATED DATA SUMMARY:\n";
echo "==========================\n";

$total_students = $conn->query("SELECT COUNT(*) as count FROM students")->fetch_assoc()['count'];
$total_bookings = $conn->query("SELECT COUNT(*) as count FROM bookings")->fetch_assoc()['count'];

echo "👥 Total Students: {$total_students}\n";
echo "📅 Total Bookings: {$total_bookings}\n";

// Updated instructor performance
echo "\n👨‍🏫 Updated Instructor Performance:\n";
$instructor_stats = $conn->query("SELECT i.name, COUNT(b.id) as lessons FROM instructors i LEFT JOIN bookings b ON i.id = b.instructor_id GROUP BY i.id, i.name ORDER BY lessons DESC");
while ($row = $instructor_stats->fetch_assoc()) {
    echo "- {$row['name']}: {$row['lessons']} lessons\n";
}

// Updated monthly enrollments
echo "\n📈 Updated Monthly Enrollments (Last 12 months):\n";
$monthly_stats = $conn->query("SELECT DATE_FORMAT(created_at, '%Y-%m') as month, COUNT(*) as count FROM students WHERE created_at >= DATE_SUB(NOW(), INTERVAL 12 MONTH) GROUP BY month ORDER BY month");
while ($row = $monthly_stats->fetch_assoc()) {
    echo "- {$row['month']}: {$row['count']} students\n";
}

echo "\n🎉 Charts should now be filled with meaningful data!\n";
echo "📊 Refresh your analytics page to see the results!\n";

$conn->close();
?>