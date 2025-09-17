<?php
// php/my_schedule.php - Instructor Schedule Management
session_start();
require_once 'db_connect.php';
require_once 'role_nav.php';

checkRoleAccess(['instructor'], $_SESSION['role']);

$user_id = $_SESSION['user_id'];

// Get instructor info
$stmt = $conn->prepare("SELECT i.* FROM instructors i JOIN users u ON u.username = i.email WHERE u.id = ?");
$stmt->bind_param('i', $user_id);
$stmt->execute();
$instructor_result = $stmt->get_result();
$instructor = $instructor_result->fetch_assoc();

if (!$instructor) {
    // Create instructor record if doesn't exist
    $stmt = $conn->prepare("SELECT username FROM users WHERE id = ?");
    $stmt->bind_param('i', $user_id);
    $stmt->execute();
    $user_result = $stmt->get_result();
    $user = $user_result->fetch_assoc();
    
    $stmt = $conn->prepare("INSERT INTO instructors (name, email, qualifications, schedule, branch_id) VALUES (?, ?, 'Instructor', 'Mon-Fri 9am-5pm', 1)");
    $name = ucfirst($user['username']);
    $stmt->bind_param('ss', $name, $user['username']);
    $stmt->execute();
    
    header('Location: my_schedule.php');
    exit;
}

$instructor_id = $instructor['id'];

// Handle status updates
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_status'])) {
    $booking_id = $_POST['booking_id'];
    $new_status = $_POST['new_status'];
    
    $stmt = $conn->prepare("UPDATE bookings SET status = ? WHERE id = ? AND instructor_id = ?");
    $stmt->bind_param('sii', $new_status, $booking_id, $instructor_id);
    $stmt->execute();
    
    $success_msg = "Booking status updated successfully!";
}

// Get instructor's bookings for the next 30 days
$bookings = $conn->query("SELECT b.*, s.name as student_name, s.phone, s.email 
                         FROM bookings b 
                         JOIN students s ON b.student_id = s.id 
                         WHERE b.instructor_id = $instructor_id 
                         AND b.date >= CURDATE() 
                         AND b.date <= DATE_ADD(CURDATE(), INTERVAL 30 DAY)
                         ORDER BY b.date ASC, b.time ASC");

// Get today's schedule
$today_bookings = $conn->query("SELECT b.*, s.name as student_name, s.phone 
                               FROM bookings b 
                               JOIN students s ON b.student_id = s.id 
                               WHERE b.instructor_id = $instructor_id 
                               AND b.date = CURDATE()
                               ORDER BY b.time ASC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Schedule - Origin Driving School</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body class="page-transition">
    <header>
        <h1>📅 My Teaching Schedule</h1>
        <p>Welcome back, <?php echo htmlspecialchars($instructor['name']); ?></p>
    </header>
    
    <?php renderNavigation($_SESSION['role']); ?>
    
    <div class="container">
        <?php if (isset($success_msg)): ?>
        <div class="message success"><?php echo $success_msg; ?></div>
        <?php endif; ?>
        
        <!-- Instructor Stats -->
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1.5rem; margin: 2rem 0;">
            <?php
            $total_lessons = $bookings->num_rows;
            $today_lessons = $today_bookings->num_rows;
            $pending_lessons = 0;
            
            $bookings->data_seek(0);
            while($booking = $bookings->fetch_assoc()) {
                if ($booking['status'] === 'Pending') $pending_lessons++;
            }
            ?>
            
            <div class="stat-card instructor-card">
                <div class="stat-number"><?php echo $today_lessons; ?></div>
                <div class="stat-label">Today's Lessons</div>
            </div>
            <div class="stat-card instructor-card">
                <div class="stat-number"><?php echo $total_lessons; ?></div>
                <div class="stat-label">Next 30 Days</div>
            </div>
            <div class="stat-card instructor-card">
                <div class="stat-number"><?php echo $pending_lessons; ?></div>
                <div class="stat-label">Pending Approval</div>
            </div>
            <div class="stat-card instructor-card">
                <div class="stat-number"><?php echo strlen($instructor['qualifications']); ?></div>
                <div class="stat-label">Experience Level</div>
            </div>
        </div>

        <!-- Today's Schedule -->
        <h2>🎯 Today's Schedule - <?php echo date('F j, Y'); ?></h2>
        <div style="background: linear-gradient(135deg, #fff5cd 0%, #fff3cd 100%); padding: 2rem; border-radius: 15px; margin-bottom: 2rem; border-left: 5px solid #f39c12;">
            <?php if ($today_bookings->num_rows > 0): ?>
                <div style="display: grid; gap: 1rem;">
                    <?php 
                    $today_bookings->data_seek(0);
                    while($booking = $today_bookings->fetch_assoc()): ?>
                    <div style="background: white; padding: 1.5rem; border-radius: 10px; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 4px 15px rgba(0,0,0,0.1);">
                        <div>
                            <div style="font-size: 1.2rem; font-weight: 600; color: #2c3e50;">
                                <?php echo date('g:i A', strtotime($booking['time'])); ?> - <?php echo $booking['student_name']; ?>
                            </div>
                            <div style="color: #6c757d; margin-top: 0.5rem;">
                                📞 <?php echo $booking['phone']; ?> | Status: <?php echo $booking['status']; ?>
                            </div>
                        </div>
                        <div style="text-align: right;">
                            <div style="padding: 0.5rem 1rem; background: #f39c12; color: white; border-radius: 20px; font-weight: 600;">
                                Today
                            </div>
                        </div>
                    </div>
                    <?php endwhile; ?>
                </div>
            <?php else: ?>
                <div style="text-align: center; color: #856404; font-size: 1.2rem;">
                    🌟 No lessons scheduled for today - Enjoy your free time!
                </div>
            <?php endif; ?>
        </div>

        <!-- Upcoming Schedule -->
        <h2>📋 Upcoming Lessons (Next 30 Days)</h2>
        <div class="table-container">
            <table class="table">
                <thead>
                    <tr>
                        <th>Date & Time</th>
                        <th>Student</th>
                        <th>Contact</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $bookings->data_seek(0);
                    while($booking = $bookings->fetch_assoc()): 
                        $status_class = '';
                        $status_icon = '';
                        switch($booking['status']) {
                            case 'Confirmed':
                                $status_class = 'info';
                                $status_icon = '✅';
                                break;
                            case 'Pending':
                                $status_class = 'warning';
                                $status_icon = '⏳';
                                break;
                            case 'Completed':
                                $status_class = 'success';
                                $status_icon = '🎓';
                                break;
                        }
                    ?>
                    <tr>
                        <td>
                            <div style="font-weight: 600;"><?php echo date('M j, Y', strtotime($booking['date'])); ?></div>
                            <div style="color: #6c757d;"><?php echo date('g:i A', strtotime($booking['time'])); ?></div>
                        </td>
                        <td>
                            <div style="display: flex; align-items: center;">
                                <div style="width: 40px; height: 40px; background: linear-gradient(135deg, #f39c12, #e67e22); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-weight: bold; margin-right: 1rem;">
                                    <?php echo strtoupper(substr($booking['student_name'], 0, 2)); ?>
                                </div>
                                <div>
                                    <div style="font-weight: 600;"><?php echo $booking['student_name']; ?></div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div>📞 <?php echo $booking['phone']; ?></div>
                            <div style="font-size: 0.9em; color: #6c757d;">✉️ <?php echo $booking['email']; ?></div>
                        </td>
                        <td>
                            <span class="status-badge <?php echo $status_class; ?>">
                                <?php echo $status_icon . ' ' . $booking['status']; ?>
                            </span>
                        </td>
                        <td>
                            <form method="post" style="display: inline;">
                                <input type="hidden" name="booking_id" value="<?php echo $booking['id']; ?>">
                                <?php if ($booking['status'] === 'Pending'): ?>
                                    <button type="submit" name="update_status" value="Confirmed" class="btn" style="padding: 0.5rem 1rem; font-size: 0.9rem; background: #27ae60;">
                                        ✅ Confirm
                                    </button>
                                <?php elseif ($booking['status'] === 'Confirmed'): ?>
                                    <button type="submit" name="update_status" value="Completed" class="btn" style="padding: 0.5rem 1rem; font-size: 0.9rem; background: #3498db;">
                                        🎓 Mark Complete
                                    </button>
                                <?php else: ?>
                                    <span style="color: #27ae60; font-weight: 600;">✓ Done</span>
                                <?php endif; ?>
                            </form>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                    
                    <?php if ($bookings->num_rows === 0): ?>
                    <tr>
                        <td colspan="5" style="text-align: center; padding: 3rem; color: #6c757d;">
                            <div style="font-size: 3rem; margin-bottom: 1rem;">📅</div>
                            <div style="font-size: 1.2rem; font-weight: 600; margin-bottom: 0.5rem;">No upcoming lessons</div>
                            <div>Students will book lessons and they'll appear here!</div>
                        </td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
    
    <footer>&copy; 2025 Origin Driving School - Instructor Portal</footer>
</body>
</html>
