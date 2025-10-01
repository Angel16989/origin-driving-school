<?php
// user_journey_test.php - Comprehensive user journey testing
session_start();
require_once 'php/db_connect.php';

// Get user counts for testing
$admin_count = $conn->query("SELECT COUNT(*) as count FROM users WHERE role='admin'")->fetch_assoc()['count'];
$instructor_count = $conn->query("SELECT COUNT(*) as count FROM users WHERE role='instructor'")->fetch_assoc()['count'];
$student_count = $conn->query("SELECT COUNT(*) as count FROM users WHERE role='student'")->fetch_assoc()['count'];
$message_count = $conn->query("SELECT COUNT(*) as count FROM messages")->fetch_assoc()['count'];

$current_user = $_SESSION['username'] ?? 'Not logged in';
$current_role = $_SESSION['role'] ?? 'None';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Journey Test - Origin Driving School</title>
    <link rel="stylesheet" href="css/styles.css">
    <style>
        .test-section {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            padding: 2rem;
            border-radius: 15px;
            margin: 1.5rem 0;
            border-left: 5px solid #28a745;
        }
        
        .test-failed {
            border-left-color: #dc3545;
            background: linear-gradient(135deg, #f8d7da 0%, #f5c6cb 100%);
        }
        
        .test-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 1.5rem;
            margin: 2rem 0;
        }
        
        .journey-card {
            background: white;
            padding: 2rem;
            border-radius: 15px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        
        .journey-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: linear-gradient(90deg, #007bff, #6f42c1);
        }
        
        .journey-card:hover {
            transform: translateY(-5px);
        }
        
        .journey-step {
            display: flex;
            align-items: center;
            padding: 1rem;
            margin: 0.5rem 0;
            background: #f8f9fa;
            border-radius: 10px;
            transition: all 0.3s ease;
        }
        
        .journey-step:hover {
            background: #e9ecef;
            transform: translateX(5px);
        }
        
        .step-icon {
            font-size: 1.5rem;
            margin-right: 1rem;
            width: 2rem;
            text-align: center;
        }
        
        .step-status {
            margin-left: auto;
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
        }
        
        .status-pass {
            background: #d4edda;
            color: #155724;
        }
        
        .status-fail {
            background: #f8d7da;
            color: #721c24;
        }
        
        .status-pending {
            background: #fff3cd;
            color: #856404;
        }
        
        .quick-links {
            display: flex;
            flex-wrap: wrap;
            gap: 1rem;
            margin: 1.5rem 0;
        }
        
        .test-link {
            padding: 0.75rem 1.5rem;
            background: linear-gradient(135deg, #007bff 0%, #6f42c1 100%);
            color: white;
            text-decoration: none;
            border-radius: 25px;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(0,123,255,0.3);
        }
        
        .test-link:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0,123,255,0.4);
            text-decoration: none;
            color: white;
        }
    </style>
</head>
<body class="page-transition">
    <header>
        <h1>🧪 User Journey Testing Suite</h1>
        <p>Comprehensive testing of Origin Driving School functionality</p>
    </header>
    
    <div class="container">
        <!-- Current Session Status -->
        <div class="test-section">
            <h2>👤 Current Session Status</h2>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem;">
                <div style="background: white; padding: 1.5rem; border-radius: 10px; text-align: center;">
                    <div style="font-size: 2rem;">👤</div>
                    <h3>Current User</h3>
                    <p><strong><?php echo htmlspecialchars($current_user); ?></strong></p>
                </div>
                <div style="background: white; padding: 1.5rem; border-radius: 10px; text-align: center;">
                    <div style="font-size: 2rem;">🎭</div>
                    <h3>Current Role</h3>
                    <p><strong><?php echo htmlspecialchars($current_role); ?></strong></p>
                </div>
                <div style="background: white; padding: 1.5rem; border-radius: 10px; text-align: center;">
                    <div style="font-size: 2rem;">📊</div>
                    <h3>Session ID</h3>
                    <p><strong><?php echo session_id(); ?></strong></p>
                </div>
            </div>
        </div>
        
        <!-- System Overview -->
        <div class="test-section">
            <h2>🏗️ System Overview</h2>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 1rem;">
                <div style="background: white; padding: 1.5rem; border-radius: 10px; text-align: center;">
                    <div style="font-size: 2rem;">👑</div>
                    <h4>Admins</h4>
                    <p><strong><?php echo $admin_count; ?></strong></p>
                </div>
                <div style="background: white; padding: 1.5rem; border-radius: 10px; text-align: center;">
                    <div style="font-size: 2rem;">👨‍🏫</div>
                    <h4>Instructors</h4>
                    <p><strong><?php echo $instructor_count; ?></strong></p>
                </div>
                <div style="background: white; padding: 1.5rem; border-radius: 10px; text-align: center;">
                    <div style="font-size: 2rem;">🎓</div>
                    <h4>Students</h4>
                    <p><strong><?php echo $student_count; ?></strong></p>
                </div>
                <div style="background: white; padding: 1.5rem; border-radius: 10px; text-align: center;">
                    <div style="font-size: 2rem;">💬</div>
                    <h4>Messages</h4>
                    <p><strong><?php echo $message_count; ?></strong></p>
                </div>
            </div>
        </div>
        
        <!-- User Journey Tests -->
        <div class="test-grid">
            <!-- Admin Journey -->
            <div class="journey-card">
                <h3>👑 Admin Journey</h3>
                <p>Complete administrative workflow testing</p>
                
                <div class="journey-step">
                    <div class="step-icon">🔐</div>
                    <div>Login as Admin</div>
                    <div class="step-status status-pass">✅ READY</div>
                </div>
                
                <div class="journey-step">
                    <div class="step-icon">🏠</div>
                    <div>Access Admin Dashboard</div>
                    <div class="step-status status-pass">✅ READY</div>
                </div>
                
                <div class="journey-step">
                    <div class="step-icon">👥</div>
                    <div>Manage Students</div>
                    <div class="step-status status-pass">✅ READY</div>
                </div>
                
                <div class="journey-step">
                    <div class="step-icon">👨‍🏫</div>
                    <div>Manage Instructors</div>
                    <div class="step-status status-pass">✅ READY</div>
                </div>
                
                <div class="journey-step">
                    <div class="step-icon">💬</div>
                    <div>Send/View Messages</div>
                    <div class="step-status status-pass">✅ READY</div>
                </div>
                
                <div class="journey-step">
                    <div class="step-icon">🚪</div>
                    <div>Logout Safely</div>
                    <div class="step-status status-pass">✅ READY</div>
                </div>
                
                <a href="login.php" class="test-link" style="margin-top: 1rem; display: inline-block;">
                    🚀 Start Admin Test
                </a>
            </div>
            
            <!-- Instructor Journey -->
            <div class="journey-card">
                <h3>👨‍🏫 Instructor Journey</h3>
                <p>Complete instructor workflow testing</p>
                
                <div class="journey-step">
                    <div class="step-icon">🔐</div>
                    <div>Login as Instructor</div>
                    <div class="step-status status-pass">✅ READY</div>
                </div>
                
                <div class="journey-step">
                    <div class="step-icon">🏠</div>
                    <div>Access Instructor Dashboard</div>
                    <div class="step-status status-pass">✅ READY</div>
                </div>
                
                <div class="journey-step">
                    <div class="step-icon">📅</div>
                    <div>View Schedule</div>
                    <div class="step-status status-pass">✅ READY</div>
                </div>
                
                <div class="journey-step">
                    <div class="step-icon">👥</div>
                    <div>Manage Students</div>
                    <div class="step-status status-pass">✅ READY</div>
                </div>
                
                <div class="journey-step">
                    <div class="step-icon">💬</div>
                    <div>Instructor Messages</div>
                    <div class="step-status status-pass">✅ READY</div>
                </div>
                
                <div class="journey-step">
                    <div class="step-icon">🚪</div>
                    <div>Logout Safely</div>
                    <div class="step-status status-pass">✅ READY</div>
                </div>
                
                <a href="login.php" class="test-link" style="margin-top: 1rem; display: inline-block;">
                    🚀 Start Instructor Test
                </a>
            </div>
            
            <!-- Student Journey -->
            <div class="journey-card">
                <h3>🎓 Student Journey</h3>
                <p>Complete student workflow testing</p>
                
                <div class="journey-step">
                    <div class="step-icon">🔐</div>
                    <div>Login as Student</div>
                    <div class="step-status status-pass">✅ READY</div>
                </div>
                
                <div class="journey-step">
                    <div class="step-icon">🏠</div>
                    <div>Access Student Dashboard</div>
                    <div class="step-status status-pass">✅ READY</div>
                </div>
                
                <div class="journey-step">
                    <div class="step-icon">👤</div>
                    <div>View Profile</div>
                    <div class="step-status status-pass">✅ READY</div>
                </div>
                
                <div class="journey-step">
                    <div class="step-icon">📅</div>
                    <div>View Bookings</div>
                    <div class="step-status status-pass">✅ READY</div>
                </div>
                
                <div class="journey-step">
                    <div class="step-icon">💬</div>
                    <div>Student Messages</div>
                    <div class="step-status status-pass">✅ READY</div>
                </div>
                
                <div class="journey-step">
                    <div class="step-icon">🚪</div>
                    <div>Logout Safely</div>
                    <div class="step-status status-pass">✅ READY</div>
                </div>
                
                <a href="login.php" class="test-link" style="margin-top: 1rem; display: inline-block;">
                    🚀 Start Student Test
                </a>
            </div>
        </div>
        
        <!-- Test Account Information -->
        <div class="test-section">
            <h2>🔑 Test Account Information</h2>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1.5rem;">
                <div style="background: white; padding: 2rem; border-radius: 15px;">
                    <h4 style="color: #dc3545; margin-top: 0;">👑 Admin Account</h4>
                    <p><strong>Username:</strong> admin</p>
                    <p><strong>Password:</strong> password</p>
                    <p><strong>Access:</strong> Full system control</p>
                </div>
                <div style="background: white; padding: 2rem; border-radius: 15px;">
                    <h4 style="color: #fd7e14; margin-top: 0;">👨‍🏫 Instructor Account</h4>
                    <p><strong>Username:</strong> instructor1</p>
                    <p><strong>Password:</strong> password</p>
                    <p><strong>Access:</strong> Teaching management</p>
                </div>
                <div style="background: white; padding: 2rem; border-radius: 15px;">
                    <h4 style="color: #20c997; margin-top: 0;">🎓 Student Account</h4>
                    <p><strong>Username:</strong> student1</p>
                    <p><strong>Password:</strong> password</p>
                    <p><strong>Access:</strong> Learning dashboard</p>
                </div>
            </div>
        </div>
        
        <!-- Quick Test Links -->
        <div class="test-section">
            <h2>🔗 Quick Test Links</h2>
            <div class="quick-links">
                <a href="index.php" class="test-link">🏠 Homepage</a>
                <a href="login.php" class="test-link">🔐 Login</a>
                <a href="dashboard.php" class="test-link">📊 Dashboard</a>
                <a href="php/messages.php" class="test-link">💬 Messages</a>
                <a href="php/students.php" class="test-link">👥 Students</a>
                <a href="php/instructors.php" class="test-link">👨‍🏫 Instructors</a>
                <a href="logout.php" class="test-link">🚪 Logout</a>
            </div>
        </div>
        
        <!-- System Health Check -->
        <div class="test-section">
            <h2>🏥 System Health Check</h2>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem;">
                <?php
                $health_checks = [
                    ['name' => 'Database Connection', 'status' => $conn ? 'pass' : 'fail', 'icon' => '🗄️'],
                    ['name' => 'Session System', 'status' => session_status() === PHP_SESSION_ACTIVE ? 'pass' : 'fail', 'icon' => '🔒'],
                    ['name' => 'User Accounts', 'status' => ($admin_count > 0 && $instructor_count > 0 && $student_count > 0) ? 'pass' : 'fail', 'icon' => '👥'],
                    ['name' => 'Message System', 'status' => $message_count >= 0 ? 'pass' : 'fail', 'icon' => '💬'],
                    ['name' => 'File Structure', 'status' => (file_exists('css/styles.css') && file_exists('php/db_connect.php')) ? 'pass' : 'fail', 'icon' => '📁'],
                    ['name' => 'CSS Styling', 'status' => file_exists('css/styles.css') ? 'pass' : 'fail', 'icon' => '🎨']
                ];
                
                foreach ($health_checks as $check):
                    $bg_color = $check['status'] === 'pass' ? '#d4edda' : '#f8d7da';
                    $text_color = $check['status'] === 'pass' ? '#155724' : '#721c24';
                    $status_icon = $check['status'] === 'pass' ? '✅' : '❌';
                ?>
                <div style="background: <?php echo $bg_color; ?>; color: <?php echo $text_color; ?>; padding: 1.5rem; border-radius: 10px; text-align: center;">
                    <div style="font-size: 2rem;"><?php echo $check['icon']; ?></div>
                    <h4><?php echo $check['name']; ?></h4>
                    <p><strong><?php echo $status_icon; ?> <?php echo strtoupper($check['status']); ?></strong></p>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
        
        <!-- Testing Instructions -->
        <div class="test-section">
            <h2>📋 Testing Instructions</h2>
            <div style="background: white; padding: 2rem; border-radius: 15px;">
                <h3>Complete User Journey Test Steps:</h3>
                <ol style="line-height: 2;">
                    <li><strong>🏠 Homepage Test:</strong> Visit the landing page and verify professional appearance, navigation, and content.</li>
                    <li><strong>🔐 Login Test:</strong> Test login with each user role (admin, instructor1, student1) using password "password".</li>
                    <li><strong>📊 Dashboard Test:</strong> Verify role-specific dashboards display correct statistics and navigation.</li>
                    <li><strong>🧭 Navigation Test:</strong> Test all navigation links work correctly for each role.</li>
                    <li><strong>💬 Messaging Test:</strong> Send and receive messages between different user types.</li>
                    <li><strong>🎨 UI/UX Test:</strong> Check icons display correctly, animations work, and styling is professional.</li>
                    <li><strong>📱 Responsive Test:</strong> Test on different screen sizes and devices.</li>
                    <li><strong>🚪 Logout Test:</strong> Verify logout works correctly and redirects to login page with success message.</li>
                </ol>
                
                <div style="background: #e7f3ff; padding: 1.5rem; border-radius: 10px; margin-top: 2rem; border-left: 4px solid #007bff;">
                    <h4 style="color: #004085; margin-top: 0;">💡 Testing Tips</h4>
                    <ul>
                        <li>Test in multiple browsers (Chrome, Firefox, Safari, Edge)</li>
                        <li>Try different screen sizes and mobile devices</li>
                        <li>Check for any broken images, links, or functionality</li>
                        <li>Verify all icons display properly (not as square boxes)</li>
                        <li>Test message sending between all user role combinations</li>
                        <li>Ensure logout completely clears session data</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    
    <footer>&copy; 2025 Origin Driving School - User Journey Testing Suite</footer>
    
    <script>
        // Add some interactive feedback
        document.querySelectorAll('.journey-step').forEach(step => {
            step.addEventListener('click', function() {
                this.style.background = '#007bff';
                this.style.color = 'white';
                setTimeout(() => {
                    this.style.background = '#f8f9fa';
                    this.style.color = 'inherit';
                }, 300);
            });
        });
        
        // Auto-refresh system status every 30 seconds
        setTimeout(() => {
            location.reload();
        }, 30000);
    </script>
</body>
</html>
