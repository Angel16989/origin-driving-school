<?php
// book_lesson.php - Student Booking Interface
session_start();
require_once 'php/db_connect.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'student') {
    header('Location: login.php');
    exit;
}

$user_id = $_SESSION['user_id'];
$success_msg = '';
$error_msg = '';

// Get student ID
$stmt = $conn->prepare("SELECT s.id FROM students s JOIN users u ON u.username = s.email WHERE u.id = ?");
$stmt->bind_param('i', $user_id);
$stmt->execute();
$student_result = $stmt->get_result();
$student = $student_result->fetch_assoc();

if (!$student) {
    $error_msg = "Student profile not found. Please complete your profile first.";
} else {
    $student_id = $student['id'];
}

// Handle booking submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['create_booking']) && $student) {
    $instructor_id = intval($_POST['instructor_id']);
    $date = $_POST['date'];
    $time = $_POST['time'];
    $lesson_type = $_POST['lesson_type'];
    $duration = intval($_POST['duration']);
    
    // Validate date is not in the past
    if (strtotime($date) < strtotime(date('Y-m-d'))) {
        $error_msg = "Cannot book lessons in the past!";
    } else {
        // Check for instructor availability (double-booking prevention)
        $check_stmt = $conn->prepare("SELECT id FROM bookings WHERE instructor_id = ? AND date = ? AND time = ? AND status != 'Cancelled'");
        $check_stmt->bind_param('iss', $instructor_id, $date, $time);
        $check_stmt->execute();
        $check_stmt->store_result();
        
        if ($check_stmt->num_rows > 0) {
            $error_msg = "⚠️ This time slot is already booked! Please choose another time.";
        } else {
            // Calculate cost based on lesson type and duration
            $cost_per_hour = 50.00;
            if ($lesson_type === 'Highway Driving') $cost_per_hour = 65.00;
            if ($lesson_type === 'Test Preparation') $cost_per_hour = 75.00;
            $total_cost = $cost_per_hour * ($duration / 60);
            
            // Create booking
            $insert_stmt = $conn->prepare("INSERT INTO bookings (student_id, instructor_id, date, time, status) VALUES (?, ?, ?, ?, 'Pending')");
            $insert_stmt->bind_param('iiss', $student_id, $instructor_id, $date, $time);
            
            if ($insert_stmt->execute()) {
                $booking_id = $conn->insert_id;
                
                // Create invoice
                $invoice_stmt = $conn->prepare("INSERT INTO invoices (student_id, amount, status, due_date) VALUES (?, ?, 'Unpaid', DATE_ADD(?, INTERVAL 7 DAY))");
                $invoice_stmt->bind_param('ids', $student_id, $total_cost, $date);
                $invoice_stmt->execute();
                
                $success_msg = "✅ Booking request submitted successfully! Cost: $" . number_format($total_cost, 2) . ". You'll receive confirmation soon.";
            } else {
                $error_msg = "❌ Error creating booking. Please try again.";
            }
        }
    }
}

// Fetch all active instructors
$instructors_query = "SELECT * FROM instructors WHERE status = 'Active' ORDER BY name ASC";
$instructors = $conn->query($instructors_query);

$page_title = "Book a Lesson - Origin Driving School";
$page_description = "Book your driving lesson with our professional instructors";
include 'includes/header.php';
?>

    <style>
        .booking-container {
            max-width: 900px;
            margin: 6rem auto 2rem;
            padding: 2rem;
        }
        .booking-form {
            background: white;
            padding: 3rem;
            border-radius: 20px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.1);
        }
        .form-group {
            margin-bottom: 1.5rem;
        }
        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 600;
            color: var(--dashboard-blue);
        }
        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 0.8rem;
            border: 2px solid #e0e0e0;
            border-radius: 10px;
            font-size: 1rem;
            transition: border-color 0.3s;
        }
        .form-group input:focus,
        .form-group select:focus {
            outline: none;
            border-color: var(--dashboard-blue);
        }
        .instructor-card {
            border: 2px solid #e0e0e0;
            padding: 1rem;
            margin-bottom: 1rem;
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.3s;
        }
        .instructor-card:hover {
            border-color: var(--dashboard-blue);
            background: #f8f9fa;
        }
        .instructor-card.selected {
            border-color: var(--dashboard-blue);
            background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%);
        }
        .time-slot {
            display: inline-block;
            padding: 0.5rem 1rem;
            margin: 0.5rem;
            border: 2px solid #e0e0e0;
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.3s;
        }
        .time-slot:hover {
            border-color: var(--dashboard-blue);
            background: #f8f9fa;
        }
        .time-slot.selected {
            border-color: var(--dashboard-blue);
            background: var(--dashboard-blue);
            color: white;
        }
        .cost-preview {
            background: linear-gradient(135deg, #fff8e1 0%, #ffe082 50%);
            padding: 1.5rem;
            border-radius: 10px;
            margin: 1.5rem 0;
            text-align: center;
        }
        .cost-preview h3 {
            margin: 0;
            color: var(--dashboard-blue);
        }
    </style>

    <div class="booking-container">
        <h1 style="text-align: center; color: var(--dashboard-blue); margin-bottom: 2rem;">📅 Book Your Driving Lesson</h1>
        
        <?php if ($success_msg): ?>
            <div style="background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%); color: #155724; padding: 1.5rem; border-radius: 10px; margin-bottom: 2rem; border-left: 5px solid #28a745;">
                <strong><?php echo $success_msg; ?></strong>
                <div style="margin-top: 1rem;">
                    <a href="php/my_bookings.php" class="btn btn-success">View My Bookings</a>
                    <a href="dashboard.php" class="btn" style="margin-left: 1rem;">Back to Dashboard</a>
                </div>
            </div>
        <?php endif; ?>
        
        <?php if ($error_msg): ?>
            <div style="background: linear-gradient(135deg, #f8d7da 0%, #f1b0b7 100%); color: #721c24; padding: 1.5rem; border-radius: 10px; margin-bottom: 2rem; border-left: 5px solid #dc3545;">
                <strong>❌ Error:</strong> <?php echo $error_msg; ?>
            </div>
        <?php endif; ?>
        
        <?php if ($student): ?>
        <form method="POST" class="booking-form" id="bookingForm">
            <!-- Step 1: Choose Instructor -->
            <div class="form-section">
                <h2 style="color: var(--dashboard-blue); margin-bottom: 1.5rem;">👨‍🏫 Step 1: Choose Your Instructor</h2>
                
                <div id="instructorsList">
                    <?php while ($instructor = $instructors->fetch_assoc()): ?>
                        <label class="instructor-card">
                            <input type="radio" name="instructor_id" value="<?php echo $instructor['id']; ?>" required style="display: none;" onchange="selectInstructor(this)">
                            <div style="display: flex; align-items: center; gap: 1rem;">
                                <div style="width: 60px; height: 60px; background: linear-gradient(135deg, var(--dashboard-blue), #40407a); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-size: 1.5rem;">
                                    <?php echo substr($instructor['name'], 0, 1); ?>
                                </div>
                                <div style="flex: 1;">
                                    <h3 style="margin: 0; color: var(--dashboard-blue);"><?php echo htmlspecialchars($instructor['name']); ?></h3>
                                    <p style="margin: 0.5rem 0; color: #666;">
                                        <strong>Specialty:</strong> <?php echo htmlspecialchars($instructor['specialty']); ?><br>
                                        <strong>Experience:</strong> <?php echo htmlspecialchars($instructor['experience']); ?>
                                    </p>
                                </div>
                                <div style="text-align: right;">
                                    <span style="font-size: 2rem;">⭐</span>
                                    <div style="color: var(--dashboard-blue); font-weight: 600;">Select</div>
                                </div>
                            </div>
                        </label>
                    <?php endwhile; ?>
                </div>
            </div>
            
            <hr style="margin: 2rem 0; border: none; border-top: 2px dashed #e0e0e0;">
            
            <!-- Step 2: Choose Date & Time -->
            <div class="form-section">
                <h2 style="color: var(--dashboard-blue); margin-bottom: 1.5rem;">📅 Step 2: Choose Date & Time</h2>
                
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                    <div class="form-group">
                        <label for="date">Date *</label>
                        <input type="date" id="date" name="date" required min="<?php echo date('Y-m-d'); ?>" max="<?php echo date('Y-m-d', strtotime('+90 days')); ?>" onchange="updateCost()">
                        <small style="color: #666;">Choose a date within the next 90 days</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="time">Time *</label>
                        <select id="time" name="time" required onchange="updateCost()">
                            <option value="">Select time...</option>
                            <option value="08:00">08:00 AM</option>
                            <option value="09:00">09:00 AM</option>
                            <option value="10:00">10:00 AM</option>
                            <option value="11:00">11:00 AM</option>
                            <option value="12:00">12:00 PM</option>
                            <option value="13:00">01:00 PM</option>
                            <option value="14:00">02:00 PM</option>
                            <option value="15:00">03:00 PM</option>
                            <option value="16:00">04:00 PM</option>
                            <option value="17:00">05:00 PM</option>
                        </select>
                    </div>
                </div>
            </div>
            
            <hr style="margin: 2rem 0; border: none; border-top: 2px dashed #e0e0e0;">
            
            <!-- Step 3: Lesson Details -->
            <div class="form-section">
                <h2 style="color: var(--dashboard-blue); margin-bottom: 1.5rem;">🚗 Step 3: Lesson Details</h2>
                
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                    <div class="form-group">
                        <label for="lesson_type">Lesson Type *</label>
                        <select id="lesson_type" name="lesson_type" required onchange="updateCost()">
                            <option value="">Select type...</option>
                            <option value="Basic Driving" data-cost="50">Basic Driving - $50/hr</option>
                            <option value="Highway Driving" data-cost="65">Highway Driving - $65/hr</option>
                            <option value="Test Preparation" data-cost="75">Test Preparation - $75/hr</option>
                            <option value="Parking Practice" data-cost="50">Parking Practice - $50/hr</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="duration">Duration *</label>
                        <select id="duration" name="duration" required onchange="updateCost()">
                            <option value="">Select duration...</option>
                            <option value="60">1 Hour</option>
                            <option value="90">1.5 Hours</option>
                            <option value="120">2 Hours</option>
                        </select>
                    </div>
                </div>
            </div>
            
            <!-- Cost Preview -->
            <div class="cost-preview" id="costPreview" style="display: none;">
                <h3>Estimated Cost: $<span id="costAmount">0.00</span></h3>
                <p style="margin: 0.5rem 0 0; color: #666;">Payment will be due within 7 days of the lesson</p>
            </div>
            
            <div style="text-align: center; margin-top: 2rem;">
                <button type="submit" name="create_booking" class="btn btn-success" style="font-size: 1.2rem; padding: 1rem 3rem;">
                    📅 Submit Booking Request
                </button>
                <a href="dashboard.php" class="btn" style="margin-left: 1rem;">Cancel</a>
            </div>
        </form>
        <?php else: ?>
            <div style="text-align: center; padding: 3rem; background: #f8f9fa; border-radius: 20px;">
                <h2>⚠️ Profile Incomplete</h2>
                <p>Please complete your student profile before booking lessons.</p>
                <a href="php/my_profile.php" class="btn btn-success">Complete Profile</a>
            </div>
        <?php endif; ?>
    </div>

    <script>
        function selectInstructor(radio) {
            // Remove selected class from all cards
            document.querySelectorAll('.instructor-card').forEach(card => {
                card.classList.remove('selected');
            });
            // Add selected class to clicked card
            radio.closest('.instructor-card').classList.add('selected');
            updateCost();
        }
        
        function updateCost() {
            const lessonType = document.getElementById('lesson_type');
            const duration = document.getElementById('duration');
            const costPreview = document.getElementById('costPreview');
            const costAmount = document.getElementById('costAmount');
            
            if (lessonType.value && duration.value) {
                const costPerHour = parseFloat(lessonType.options[lessonType.selectedIndex].getAttribute('data-cost'));
                const hours = parseInt(duration.value) / 60;
                const total = costPerHour * hours;
                
                costAmount.textContent = total.toFixed(2);
                costPreview.style.display = 'block';
            } else {
                costPreview.style.display = 'none';
            }
        }
        
        // Form validation
        document.getElementById('bookingForm').addEventListener('submit', function(e) {
            const instructor = document.querySelector('input[name="instructor_id"]:checked');
            if (!instructor) {
                e.preventDefault();
                alert('Please select an instructor!');
                return false;
            }
        });
    </script>

<?php include 'includes/footer.php'; ?>
