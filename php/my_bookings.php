<?php
// php/my_bookings.php - Student's Personal Bookings
session_start();
require_once 'db_connect.php';
require_once 'role_nav.php';

checkRoleAccess(['student'], $_SESSION['role']);

$user_id = $_SESSION['user_id'];

// Get student ID
$stmt = $conn->prepare("SELECT s.id FROM students s JOIN users u ON u.username = s.email WHERE u.id = ?");
$stmt->bind_param('i', $user_id);
$stmt->execute();
$student_result = $stmt->get_result();
$student = $student_result->fetch_assoc();

if (!$student) {
    header('Location: my_profile.php');
    exit;
}

$student_id = $student['id'];

// Handle new booking request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['request_booking'])) {
    $instructor_id = $_POST['instructor_id'];
    $date = $_POST['date'];
    $time = $_POST['time'];
    
    // Check for conflicts
    $stmt = $conn->prepare("SELECT id FROM bookings WHERE instructor_id=? AND date=? AND time=?");
    $stmt->bind_param('iss', $instructor_id, $date, $time);
    $stmt->execute();
    $stmt->store_result();
    
    if ($stmt->num_rows > 0) {
        $error_msg = "That time slot is already booked. Please choose another time.";
    } else {
        $stmt = $conn->prepare("INSERT INTO bookings (student_id, instructor_id, date, time, status) VALUES (?, ?, ?, ?, 'Pending')");
        $stmt->bind_param('iiss', $student_id, $instructor_id, $date, $time);
        $stmt->execute();
        
        // Create invoice
        $stmt = $conn->prepare("INSERT INTO invoices (student_id, amount, status) VALUES (?, 75.00, 'Unpaid')");
        $stmt->bind_param('i', $student_id);
        $stmt->execute();
        
        $success_msg = "Booking request submitted! You'll receive confirmation soon.";
    }
}

// Get student's bookings
$bookings = $conn->query("SELECT b.*, i.name as instructor_name, i.qualifications FROM bookings b 
                         JOIN instructors i ON b.instructor_id = i.id 
                         WHERE b.student_id = $student_id 
                         ORDER BY b.date DESC, b.time DESC");

// Get available instructors
$instructors = $conn->query("SELECT * FROM instructors ORDER BY name");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Lessons - Origin Driving School</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body class="page-transition">
    <header>
        <h1>📅 My Driving Lessons</h1>
        <p>Book lessons and track your progress</p>
    </header>
    
    <?php renderNavigation($_SESSION['role']); ?>
    
    <div class="container">
        <?php if (isset($success_msg)): ?>
        <div class="message success"><?php echo $success_msg; ?></div>
        <?php endif; ?>
        
        <?php if (isset($error_msg)): ?>
        <div class="message error"><?php echo $error_msg; ?></div>
        <?php endif; ?>
        
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1.5rem; margin: 2rem 0;">
            <?php
            $total_lessons = $bookings->num_rows;
            $completed_lessons = 0;
            $upcoming_lessons = 0;
            
            // Count lesson types
            $bookings->data_seek(0);
            while($booking = $bookings->fetch_assoc()) {
                if ($booking['status'] === 'Completed') $completed_lessons++;
                if ($booking['status'] === 'Confirmed' && $booking['date'] >= date('Y-m-d')) $upcoming_lessons++;
            }
            ?>
            
            <div class="stat-card student-card">
                <div class="stat-number"><?php echo $total_lessons; ?></div>
                <div class="stat-label">Total Lessons</div>
            </div>
            <div class="stat-card student-card">
                <div class="stat-number"><?php echo $completed_lessons; ?></div>
                <div class="stat-label">Completed</div>
            </div>
            <div class="stat-card student-card">
                <div class="stat-number"><?php echo $upcoming_lessons; ?></div>
                <div class="stat-label">Upcoming</div>
            </div>
        </div>

        <h2>📝 Request New Lesson</h2>
        <form method="post" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); padding: 2rem; border-radius: 15px; margin-bottom: 2rem;">
            <div style="display: grid; grid-template-columns: 1fr 1fr 1fr 1fr auto; gap: 1rem; align-items: end;">
                <div class="form-group">
                    <label>Choose Instructor</label>
                    <select name="instructor_id" required>
                        <option value="">Select Instructor</option>
                        <?php 
                        $instructors->data_seek(0);
                        while($instructor = $instructors->fetch_assoc()): ?>
                        <option value="<?php echo $instructor['id']; ?>">
                            <?php echo $instructor['name']; ?> - <?php echo $instructor['qualifications']; ?>
                        </option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label>Date</label>
                    <input type="date" name="date" min="<?php echo date('Y-m-d', strtotime('+1 day')); ?>" required>
                </div>
                <div class="form-group">
                    <label>Time</label>
                    <select name="time" required>
                        <option value="">Select Time</option>
                        <option value="09:00:00">9:00 AM</option>
                        <option value="10:00:00">10:00 AM</option>
                        <option value="11:00:00">11:00 AM</option>
                        <option value="14:00:00">2:00 PM</option>
                        <option value="15:00:00">3:00 PM</option>
                        <option value="16:00:00">4:00 PM</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Cost</label>
                    <input type="text" value="$75.00" readonly style="background: #e9ecef;">
                </div>
                <button type="submit" name="request_booking" class="btn">📅 Book Lesson</button>
            </div>
        </form>

        <h2>📋 My Lesson History</h2>
        <div class="table-container">
            <table class="table">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Instructor</th>
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
                            case 'Completed':
                                $status_class = 'success';
                                $status_icon = '✅';
                                break;
                            case 'Confirmed':
                                $status_class = 'info';
                                $status_icon = '📅';
                                break;
                            case 'Pending':
                                $status_class = 'warning';
                                $status_icon = '⏳';
                                break;
                            default:
                                $status_icon = '❓';
                        }
                    ?>
                    <tr>
                        <td><strong><?php echo date('M j, Y', strtotime($booking['date'])); ?></strong></td>
                        <td><?php echo date('g:i A', strtotime($booking['time'])); ?></td>
                        <td>
                            <div style="display: flex; align-items: center;">
                                <div style="width: 40px; height: 40px; background: linear-gradient(135deg, #667eea, #764ba2); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-weight: bold; margin-right: 1rem;">
                                    <?php echo strtoupper(substr($booking['instructor_name'], 0, 2)); ?>
                                </div>
                                <div>
                                    <div style="font-weight: 600;"><?php echo $booking['instructor_name']; ?></div>
                                    <div style="font-size: 0.9em; color: #6c757d;"><?php echo $booking['qualifications']; ?></div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="status-badge <?php echo $status_class; ?>">
                                <?php echo $status_icon . ' ' . $booking['status']; ?>
                            </span>
                        </td>
                        <td>
                            <?php if ($booking['status'] === 'Pending'): ?>
                                <small style="color: #6c757d;">Awaiting confirmation</small>
                            <?php elseif ($booking['status'] === 'Confirmed'): ?>
                                <small style="color: #28a745;">Ready for lesson</small>
                            <?php else: ?>
                                <small style="color: #6c757d;">Lesson completed</small>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                    
                    <?php if ($bookings->num_rows === 0): ?>
                    <tr>
                        <td colspan="5" style="text-align: center; padding: 3rem; color: #6c757d;">
                            <div style="font-size: 3rem; margin-bottom: 1rem;">📅</div>
                            <div style="font-size: 1.2rem; font-weight: 600; margin-bottom: 0.5rem;">No lessons booked yet</div>
                            <div>Book your first lesson using the form above!</div>
                        </td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
    
    <footer>&copy; 2025 Origin Driving School - Student Portal</footer>
    
    <style>
    .status-badge {
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-weight: 600;
        font-size: 0.9rem;
    }
    .status-badge.success { background: #d4edda; color: #155724; }
    .status-badge.info { background: #d1ecf1; color: #0c5460; }
    .status-badge.warning { background: #fff3cd; color: #856404; }
    </style>
</body>
</html>
