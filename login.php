<?php
// login.php - User Login
session_start();
require_once 'php/db_connect.php';

$msg = '';
$msg_type = '';

// Handle logout message
if (isset($_GET['logout']) && $_GET['logout'] === 'success') {
    $msg = '✅ You have been successfully logged out.';
    $msg_type = 'success';
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    
    if (empty($username) || empty($password)) {
        $msg = '⚠️ Please enter both username and password.';
        $msg_type = 'error';
    } else {
        $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($row = $result->fetch_assoc()) {
            if (password_verify($password, $row['password'])) {
                $_SESSION['user_id'] = $row['id'];
                $_SESSION['role'] = $row['role'];
                $_SESSION['username'] = $row['username'];
                
                // Redirect to dashboard with success
                header('Location: dashboard.php?login=success');
                exit;
            } else {
                $msg = '❌ Invalid password. Please try again.';
                $msg_type = 'error';
            }
        } else {
            $msg = '❌ User not found. Please check your username.';
            $msg_type = 'error';
        }
    }
}
$page_title = "Login - Origin Driving School";
$page_description = "Access your driving school dashboard";
include 'includes/header.php';
?>
    
    <!-- Hero Section -->
    <section style="background: linear-gradient(135deg, var(--dashboard-blue) 0%, #40407a 100%); color: white; padding: 6rem 2rem 4rem; position: relative; overflow: hidden;">
        <div style="position: absolute; top: -50%; left: -50%; width: 200%; height: 200%; background: radial-gradient(circle, rgba(255, 215, 0, 0.1) 0%, transparent 70%); animation: containerGlow 15s ease-in-out infinite; pointer-events: none;"></div>
        
        <div style="max-width: 1200px; margin: 0 auto; text-align: center; position: relative; z-index: 2;">
            <div style="font-size: 4rem; margin-bottom: 1rem;">🔐</div>
            <h2 style="font-size: 2.5rem; margin-bottom: 1rem;">Student Login</h2>
            <p style="font-size: 1.2rem; opacity: 0.9; max-width: 600px; margin: 0 auto;">Access your driving school dashboard</p>
        </div>
    </section>
    
    <div class="container">
        <?php if ($msg): ?>
        <div class="message <?php echo $msg_type; ?>" style="margin-bottom: 2rem;">
            <?php echo htmlspecialchars($msg); ?>
        </div>
        <?php endif; ?>
        
        <div style="max-width: 500px; margin: 0 auto;">
            <h2 style="text-align: center; margin-bottom: 2rem; color: var(--dashboard-blue);">
                Welcome Back
            </h2>
            
            <form method="post" style="background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%); padding: 3rem 2rem; border-radius: 20px; box-shadow: 0 15px 50px rgba(0,0,0,0.15);">
                <div class="form-group floating-label">
                    <input type="text" name="username" id="username" required placeholder=" " value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username']) : ''; ?>">
                    <label for="username">👤 Username</label>
                </div>
                
                <div class="form-group floating-label">
                    <input type="password" name="password" id="password" required placeholder=" ">
                    <label for="password">🔒 Password</label>
                </div>
                
                <div style="margin-bottom: 2rem;">
                    <label style="display: flex; align-items: center; cursor: pointer;">
                        <input type="checkbox" name="remember" style="margin-right: 0.5rem;">
                        <span>Remember me for 30 days</span>
                    </label>
                </div>
                
                <button type="submit" class="btn btn-pulse" style="width: 100%; font-size: 1.1rem; padding: 1rem;">
                    🚗 Login to Dashboard
                </button>
            </form>
            
            <!-- Action Links -->
            <div style="text-align: center; margin-top: 2rem; padding-top: 2rem; border-top: 1px solid #e0e0e0;">
                <div style="margin-bottom: 1.5rem;">
                    <a href="forgot-password.php" style="color: #007bff; text-decoration: none; font-weight: 600; display: inline-block; padding: 0.5rem 1rem; background: #f8f9fa; border-radius: 25px; transition: all 0.3s ease;" onmouseover="this.style.background='#e9ecef'" onmouseout="this.style.background='#f8f9fa'">
                        🔑 Forgot Password?
                    </a>
                </div>
                
                <div>
                    <p style="margin-bottom: 1rem; color: #666;">Don't have an account?</p>
                    <a href="register.php" class="btn" style="background: transparent; border: 2px solid var(--dashboard-blue); color: var(--dashboard-blue); display: inline-block; padding: 0.8rem 2rem; border-radius: 25px; text-decoration: none; font-weight: 600; transition: all 0.3s ease;" onmouseover="this.style.background='var(--dashboard-blue)'; this.style.color='white'" onmouseout="this.style.background='transparent'; this.style.color='var(--dashboard-blue)'">
                        📝 Register as Student
                    </a>
                </div>
            </div>
            
            <!-- Demo Accounts Info -->
            <div style="background: linear-gradient(135deg, #e8f4fd 0%, #d1ecf1 100%); padding: 2rem; border-radius: 15px; margin-top: 2rem; text-align: center;">
                <h3 style="color: var(--dashboard-blue); margin-bottom: 1rem;">🎯 Demo Accounts</h3>
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 1rem;">
                    <div>
                        <strong>Admin:</strong><br>
                        <code>admin</code> / <code>admin123</code>
                    </div>
                    <div>
                        <strong>Instructor:</strong><br>
                        <code>instructor</code> / <code>instructor123</code>
                    </div>
                    <div>
                        <strong>Student:</strong><br>
                        <code>student</code> / <code>student123</code>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
<?php include 'includes/footer.php'; ?>
