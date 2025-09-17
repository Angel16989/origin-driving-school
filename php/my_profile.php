<?php
// php/my_profile.php - Student Profile Management
session_start();
require_once 'db_connect.php';
require_once 'role_nav.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'student') {
    header('Location: ../login.php');
    exit;
}

$user_id = $_SESSION['user_id'];

// Get student info
$stmt = $conn->prepare("SELECT s.* FROM students s JOIN users u ON u.username = s.email WHERE u.id = ?");
$stmt->bind_param('i', $user_id);
$stmt->execute();
$student_result = $stmt->get_result();
$student = $student_result->fetch_assoc();

if (!$student) {
    // Create student record if doesn't exist
    $stmt = $conn->prepare("SELECT username FROM users WHERE id = ?");
    $stmt->bind_param('i', $user_id);
    $stmt->execute();
    $user_result = $stmt->get_result();
    $user = $user_result->fetch_assoc();
    
    $stmt = $conn->prepare("INSERT INTO students (name, email, progress) VALUES (?, ?, 'Profile Setup Required')");
    $name = ucfirst($user['username']);
    $stmt->bind_param('ss', $name, $user['username']);
    $stmt->execute();
    
    header('Location: my_profile.php');
    exit;
}

// Handle profile updates
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_profile'])) {
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $license_no = $_POST['license_no'];
    
    $stmt = $conn->prepare("UPDATE students SET name=?, phone=?, license_no=? WHERE id=?");
    $stmt->bind_param('sssi', $name, $phone, $license_no, $student['id']);
    $stmt->execute();
    
    $success_msg = "Profile updated successfully!";
    // Refresh student data
    $stmt = $conn->prepare("SELECT * FROM students WHERE id = ?");
    $stmt->bind_param('i', $student['id']);
    $stmt->execute();
    $student_result = $stmt->get_result();
    $student = $student_result->fetch_assoc();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Profile - Origin Driving School</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body class="page-transition">
    <header>
        <h1>👤 My Profile</h1>
        <p>Manage your personal information</p>
    </header>
    
    <?php renderNavigation($_SESSION['role']); ?>
    
    <div class="container">
        <?php if (isset($success_msg)): ?>
        <div class="message success"><?php echo $success_msg; ?></div>
        <?php endif; ?>
        
        <div style="display: grid; grid-template-columns: 1fr 2fr; gap: 2rem; margin-bottom: 2rem;">
            <div class="stat-card student-card">
                <div class="stat-number"><?php echo strlen($student['progress'] ?? ''); ?></div>
                <div class="stat-label">Progress Level</div>
            </div>
            <div style="background: white; padding: 2rem; border-radius: 15px; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
                <h3>Quick Stats</h3>
                <p><strong>Current Status:</strong> <?php echo $student['progress'] ?? 'Not Set'; ?></p>
                <p><strong>Member Since:</strong> <?php echo date('M Y', strtotime($student['created_at'])); ?></p>
                <p><strong>License Progress:</strong> <?php echo $student['license_no'] ? 'License on file' : 'No license number'; ?></p>
            </div>
        </div>

        <h2>Update Profile Information</h2>
        <form method="post" class="profile-form">
            <div class="form-group floating-label">
                <input type="text" name="name" value="<?php echo htmlspecialchars($student['name'] ?? ''); ?>" placeholder=" " required>
                <label>Full Name</label>
            </div>
            
            <div class="form-group floating-label">
                <input type="email" value="<?php echo htmlspecialchars($student['email'] ?? ''); ?>" readonly style="background: #f8f9fa;">
                <label>Email (Cannot be changed)</label>
            </div>
            
            <div class="form-group floating-label">
                <input type="tel" name="phone" value="<?php echo htmlspecialchars($student['phone'] ?? ''); ?>" placeholder=" ">
                <label>Phone Number</label>
            </div>
            
            <div class="form-group floating-label">
                <input type="text" name="license_no" value="<?php echo htmlspecialchars($student['license_no'] ?? ''); ?>" placeholder=" ">
                <label>License Number (if any)</label>
            </div>
            
            <button type="submit" name="update_profile" class="btn btn-pulse">💾 Update Profile</button>
        </form>
    </div>
    
    <footer>&copy; 2025 Origin Driving School - Student Portal</footer>
    
    <style>
    .profile-form {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        padding: 2rem;
        border-radius: 15px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    }
    </style>
</body>
</html>
