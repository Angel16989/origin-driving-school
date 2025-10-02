<?php
// dashboard.php - Role-based Dashboard
session_start();
require_once 'php/db_connect.php';
require_once 'php/role_nav.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$user_role = $_SESSION['role'];
$user_id = $_SESSION['user_id'];

// Get role-specific statistics
$stats = [];

if ($user_role === 'admin') {
    // Admin statistics
    $res = $conn->query('SELECT COUNT(*) AS cnt FROM students');
    $stats['students'] = $res->fetch_assoc()['cnt'];
    $res = $conn->query('SELECT COUNT(*) AS cnt FROM instructors');
    $stats['instructors'] = $res->fetch_assoc()['cnt'];
    $res = $conn->query('SELECT COUNT(*) AS cnt FROM bookings');
    $stats['bookings'] = $res->fetch_assoc()['cnt'];
    $res = $conn->query('SELECT SUM(amount) AS total FROM invoices WHERE status = "Paid"');
    $row = $res->fetch_assoc();
    $stats['revenue'] = $row['total'] ? $row['total'] : 0.00;
    
} elseif ($user_role === 'instructor') {
    // Instructor statistics
    $stmt = $conn->prepare("SELECT i.id FROM instructors i JOIN users u ON u.username = i.email WHERE u.id = ?");
    $stmt->bind_param('i', $user_id);
    $stmt->execute();
    $instructor_result = $stmt->get_result();
    $instructor = $instructor_result->fetch_assoc();
    
    if ($instructor) {
        $instructor_id = $instructor['id'];
        $res = $conn->query("SELECT COUNT(*) AS cnt FROM bookings WHERE instructor_id = $instructor_id");
        $stats['total_lessons'] = $res->fetch_assoc()['cnt'];
        $res = $conn->query("SELECT COUNT(*) AS cnt FROM bookings WHERE instructor_id = $instructor_id AND date = CURDATE()");
        $stats['today_lessons'] = $res->fetch_assoc()['cnt'];
        $res = $conn->query("SELECT COUNT(*) AS cnt FROM bookings WHERE instructor_id = $instructor_id AND status = 'Pending'");
        $stats['pending_lessons'] = $res->fetch_assoc()['cnt'];
        $res = $conn->query("SELECT COUNT(*) AS cnt FROM bookings WHERE instructor_id = $instructor_id AND status = 'Completed'");
        $stats['completed_lessons'] = $res->fetch_assoc()['cnt'];
    }
    
} elseif ($user_role === 'student') {
    // Student statistics
    $stmt = $conn->prepare("SELECT s.id FROM students s JOIN users u ON u.username = s.email WHERE u.id = ?");
    $stmt->bind_param('i', $user_id);
    $stmt->execute();
    $student_result = $stmt->get_result();
    $student = $student_result->fetch_assoc();
    
    if ($student) {
        $student_id = $student['id'];
        $res = $conn->query("SELECT COUNT(*) AS cnt FROM bookings WHERE student_id = $student_id");
        $stats['total_lessons'] = $res->fetch_assoc()['cnt'];
        $res = $conn->query("SELECT COUNT(*) AS cnt FROM bookings WHERE student_id = $student_id AND status = 'Completed'");
        $stats['completed_lessons'] = $res->fetch_assoc()['cnt'];
        $res = $conn->query("SELECT COUNT(*) AS cnt FROM invoices WHERE student_id = $student_id AND status = 'Unpaid'");
        $stats['unpaid_invoices'] = $res->fetch_assoc()['cnt'];
        $res = $conn->query("SELECT COUNT(*) AS cnt FROM bookings WHERE student_id = $student_id AND date >= CURDATE() AND status = 'Confirmed'");
        $stats['upcoming_lessons'] = $res->fetch_assoc()['cnt'];
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - Origin Driving School</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body class="page-transition">
    <header>
        <h1><?php 
            switch($user_role) {
                case 'admin': echo '🔧 Admin Dashboard'; break;
                case 'instructor': echo '👨‍🏫 Instructor Dashboard'; break;
                case 'student': echo '🎓 Student Dashboard'; break;
            }
        ?></h1>
        <p><?php 
            switch($user_role) {
                case 'admin': echo 'Complete system management and oversight'; break;
                case 'instructor': echo 'Manage your teaching schedule and students'; break;
                case 'student': echo 'Track your driving lessons and progress'; break;
            }
        ?></p>
    </header>
    
    <?php renderNavigation($user_role); ?>
    
    <div class="container">
        <h2>📊 Dashboard Overview</h2>
        
        <?php if ($user_role === 'admin'): ?>
        <!-- Admin Dashboard -->
        <div class="stats-grid">
            <div class="stat-card admin-card">
                <div class="stat-number"><?php echo $stats['students']; ?></div>
                <div class="stat-label">Total Students</div>
            </div>
            <div class="stat-card admin-card">
                <div class="stat-number"><?php echo $stats['instructors']; ?></div>
                <div class="stat-label">Total Instructors</div>
            </div>
            <div class="stat-card admin-card">
                <div class="stat-number"><?php echo $stats['bookings']; ?></div>
                <div class="stat-label">Total Bookings</div>
            </div>
            <div class="stat-card admin-card">
                <div class="stat-number">$<?php echo number_format($stats['revenue'],0); ?></div>
                <div class="stat-label">Total Revenue</div>
            </div>
        </div>
        <h3>🚀 Admin Quick Actions</h3>
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem; margin-top: 2rem;">
            <a href="php/students.php" class="btn">👥 Manage Students</a>
            <a href="php/instructors.php" class="btn">👨‍🏫 Manage Instructors</a>
            <a href="php/bookings.php" class="btn">📅 View All Bookings</a>
            <a href="php/invoices.php" class="btn btn-success">💰 Financial Overview</a>
            <a href="php/analytics.php" class="btn" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">📊 Advanced Analytics</a>
            <a href="php/messages.php" class="btn">💬 System Messages</a>
        </div>
        
        <?php elseif ($user_role === 'instructor'): ?>
        <!-- Instructor Dashboard -->
        <div class="stats-grid">
            <div class="stat-card instructor-card">
                <div class="stat-number"><?php echo $stats['today_lessons'] ?? 0; ?></div>
                <div class="stat-label">Today's Lessons</div>
            </div>
            <div class="stat-card instructor-card">
                <div class="stat-number"><?php echo $stats['total_lessons'] ?? 0; ?></div>
                <div class="stat-label">Total Lessons</div>
            </div>
            <div class="stat-card instructor-card">
                <div class="stat-number"><?php echo $stats['pending_lessons'] ?? 0; ?></div>
                <div class="stat-label">Pending Approval</div>
            </div>
            <div class="stat-card instructor-card">
                <div class="stat-number"><?php echo $stats['completed_lessons'] ?? 0; ?></div>
                <div class="stat-label">Completed Lessons</div>
            </div>
        </div>
        <h3>🎯 Instructor Quick Actions</h3>
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem; margin-top: 2rem;">
            <a href="php/my_schedule.php" class="btn btn-pulse">📅 View My Schedule</a>
            <a href="php/my_students.php" class="btn">👥 My Students</a>
            <a href="php/instructor_messages.php" class="btn">� Messages</a>
        </div>
        
        <?php elseif ($user_role === 'student'): ?>
        <!-- Student Dashboard -->
        <div class="stats-grid">
            <div class="stat-card student-card">
                <div class="stat-number"><?php echo $stats['total_lessons'] ?? 0; ?></div>
                <div class="stat-label">Total Lessons</div>
            </div>
            <div class="stat-card student-card">
                <div class="stat-number"><?php echo $stats['completed_lessons'] ?? 0; ?></div>
                <div class="stat-label">Completed</div>
            </div>
            <div class="stat-card student-card">
                <div class="stat-number"><?php echo $stats['upcoming_lessons'] ?? 0; ?></div>
                <div class="stat-label">Upcoming</div>
            </div>
            <div class="stat-card student-card">
                <div class="stat-number"><?php echo $stats['unpaid_invoices'] ?? 0; ?></div>
                <div class="stat-label">Unpaid Bills</div>
            </div>
        </div>
        <h3>🚗 Student Quick Actions</h3>
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem; margin-top: 2rem;">
            <a href="book_lesson.php" class="btn btn-pulse">📅 Book New Lesson</a>
            <a href="php/my_bookings.php" class="btn">📋 My Bookings</a>
            <a href="php/my_profile.php" class="btn">👤 Update Profile</a>
            <a href="php/my_invoices.php" class="btn">💳 View Payments</a>
            <a href="php/student_messages.php" class="btn">💬 Messages</a>
        </div>
        <?php endif; ?>
        
        <!-- Role-specific welcome message -->
        <div style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); padding: 2rem; border-radius: 15px; margin-top: 3rem; text-align: center;">
            <?php if ($user_role === 'admin'): ?>
                <h3>🎯 Admin Control Center</h3>
                <p>You have full access to manage students, instructors, bookings, and financial records. Monitor system performance and ensure smooth operations.</p>
            <?php elseif ($user_role === 'instructor'): ?>
                <h3>👨‍🏫 Welcome, Instructor!</h3>
                <p>Manage your teaching schedule, approve student bookings, and track lesson progress. Your expertise helps students become safe drivers!</p>
            <?php elseif ($user_role === 'student'): ?>
                <h3>🎓 Welcome to Your Learning Journey!</h3>
                <p>Book driving lessons, track your progress, and manage payments. We're here to help you become a confident and safe driver!</p>
            <?php endif; ?>
        </div>
    </div>
    <footer>&copy; 2025 Origin Driving School - <?php echo ucfirst($user_role); ?> Portal</footer>
</body>
</html>
