<?php
// my_students.php - Instructor's Students Management
session_start();
require_once 'db_connect.php';
require_once 'role_nav.php';

checkRoleAccess(['instructor'], $_SESSION['role']);

$user_id = $_SESSION['user_id'];

// Get instructor ID
$stmt = $conn->prepare("SELECT i.id FROM instructors i JOIN users u ON u.username = i.email WHERE u.id = ?");
$stmt->bind_param('i', $user_id);
$stmt->execute();
$instructor_result = $stmt->get_result();
$instructor = $instructor_result->fetch_assoc();

if (!$instructor) {
    header('Location: ../dashboard.php?error=instructor_not_found');
    exit;
}

$instructor_id = $instructor['id'];

// Get students assigned to this instructor
$students_query = $conn->prepare("
    SELECT DISTINCT s.*, COUNT(b.id) as total_lessons,
           COUNT(CASE WHEN b.status = 'Completed' THEN 1 END) as completed_lessons,
           COUNT(CASE WHEN b.status = 'Pending' THEN 1 END) as pending_lessons,
           MAX(b.date) as last_lesson_date
    FROM students s 
    LEFT JOIN bookings b ON s.id = b.student_id AND b.instructor_id = ?
    WHERE s.id IN (SELECT DISTINCT student_id FROM bookings WHERE instructor_id = ?)
    GROUP BY s.id
    ORDER BY last_lesson_date DESC
");
$students_query->bind_param('ii', $instructor_id, $instructor_id);
$students_query->execute();
$students = $students_query->get_result();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Students - Origin Driving School</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body class="page-transition">
    <header>
        <h1>👥 My Students</h1>
        <p>Track and manage your assigned students' progress</p>
    </header>
    
    <?php renderNavigation($_SESSION['role']); ?>
    
    <div class="container">
        <h2>🎓 Student Management Dashboard</h2>
        
        <?php if ($students->num_rows > 0): ?>
        <div class="stats-grid">
            <?php 
            $total_students = $students->num_rows;
            $total_lessons = 0;
            $completed_lessons = 0;
            $pending_lessons = 0;
            
            // Reset pointer to calculate stats
            $students->data_seek(0);
            while($stats_row = $students->fetch_assoc()) {
                $total_lessons += $stats_row['total_lessons'];
                $completed_lessons += $stats_row['completed_lessons'];
                $pending_lessons += $stats_row['pending_lessons'];
            }
            $students->data_seek(0); // Reset for main display
            ?>
            <div class="stat-card instructor-card">
                <div class="stat-number"><?php echo $total_students; ?></div>
                <div class="stat-label">My Students</div>
            </div>
            <div class="stat-card instructor-card">
                <div class="stat-number"><?php echo $total_lessons; ?></div>
                <div class="stat-label">Total Lessons</div>
            </div>
            <div class="stat-card instructor-card">
                <div class="stat-number"><?php echo $completed_lessons; ?></div>
                <div class="stat-label">Completed</div>
            </div>
            <div class="stat-card instructor-card">
                <div class="stat-number"><?php echo $pending_lessons; ?></div>
                <div class="stat-label">Pending</div>
            </div>
        </div>
        
        <h3>📋 Student Details</h3>
        <table class="table">
            <thead>
                <tr>
                    <th>🎓 Student Name</th>
                    <th>📧 Contact</th>
                    <th>📊 Progress</th>
                    <th>📅 Lessons</th>
                    <th>✅ Completed</th>
                    <th>⏳ Pending</th>
                    <th>📆 Last Lesson</th>
                    <th>🎯 Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while($student = $students->fetch_assoc()): ?>
                <tr>
                    <td>
                        <strong><?php echo htmlspecialchars($student['name']); ?></strong><br>
                        <small>License: <?php echo htmlspecialchars($student['license_no']); ?></small>
                    </td>
                    <td>
                        <div><?php echo htmlspecialchars($student['email']); ?></div>
                        <div><?php echo htmlspecialchars($student['phone']); ?></div>
                    </td>
                    <td>
                        <span class="status-badge <?php 
                            $progress = strtolower($student['progress']);
                            if (strpos($progress, 'beginner') !== false) echo 'warning';
                            elseif (strpos($progress, 'intermediate') !== false) echo 'info';
                            elseif (strpos($progress, 'advanced') !== false) echo 'success';
                            else echo 'info';
                        ?>">
                            <?php echo htmlspecialchars($student['progress']); ?>
                        </span>
                    </td>
                    <td class="text-center">
                        <div class="stat-number" style="font-size: 1.5rem; margin: 0;">
                            <?php echo $student['total_lessons']; ?>
                        </div>
                    </td>
                    <td class="text-center">
                        <span class="status-badge success">
                            <?php echo $student['completed_lessons']; ?>
                        </span>
                    </td>
                    <td class="text-center">
                        <span class="status-badge warning">
                            <?php echo $student['pending_lessons']; ?>
                        </span>
                    </td>
                    <td>
                        <?php if ($student['last_lesson_date']): ?>
                            <?php echo date('M j, Y', strtotime($student['last_lesson_date'])); ?>
                        <?php else: ?>
                            <span class="status-badge info">No lessons yet</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <div style="display: flex; flex-direction: column; gap: 0.5rem;">
                            <a href="student_progress.php?id=<?php echo $student['id']; ?>" class="btn" style="padding: 0.5rem 1rem; font-size: 0.8rem;">
                                📊 View Progress
                            </a>
                            <a href="schedule_lesson.php?student_id=<?php echo $student['id']; ?>" class="btn btn-success" style="padding: 0.5rem 1rem; font-size: 0.8rem;">
                                📅 Schedule Lesson
                            </a>
                        </div>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        
        <?php else: ?>
        <div style="text-align: center; padding: 4rem; background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border-radius: 20px; margin: 2rem 0;">
            <div style="font-size: 4rem; margin-bottom: 1rem;">🎓</div>
            <h3>No Students Assigned Yet</h3>
            <p>Students will appear here once they book lessons with you. Check back later or contact the admin for student assignments.</p>
            <a href="../dashboard.php" class="btn" style="margin-top: 1rem;">🏠 Back to Dashboard</a>
        </div>
        <?php endif; ?>
        
        <!-- Quick Actions -->
        <div style="background: linear-gradient(135deg, var(--orange-signal) 0%, #ff9f43 100%); color: white; padding: 2rem; border-radius: 20px; margin: 2rem 0; text-align: center;">
            <h3>🚀 Instructor Tools</h3>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem; margin-top: 1.5rem;">
                <a href="my_schedule.php" class="btn" style="background: rgba(255,255,255,0.2); border: 2px solid rgba(255,255,255,0.3);">
                    📅 My Schedule
                </a>
                <a href="instructor_messages.php" class="btn" style="background: rgba(255,255,255,0.2); border: 2px solid rgba(255,255,255,0.3);">
                    💬 Messages
                </a>
                <a href="../dashboard.php" class="btn" style="background: rgba(255,255,255,0.2); border: 2px solid rgba(255,255,255,0.3);">
                    🏠 Dashboard
                </a>
            </div>
        </div>
    </div>
    
    <footer>&copy; 2025 Origin Driving School - Instructor Portal</footer>
</body>
</html>
