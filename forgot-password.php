<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password - Origin Driving School</title>
    <link rel="stylesheet" href="css/styles.css">
    <meta name="description" content="Reset your Origin Driving School account password">
</head>
<body class="page-transition">
    <?php 
    session_start();
    require_once 'includes/security.php';
    ?>
    <header>
        <h1>🔐 Forgot Password</h1>
        <p>Reset your account password securely</p>
    </header>
    
    <nav class="role-nav">
        <a href="index.php" class="nav-item">
            <span class="nav-icon">🏠</span>
            <span class="nav-label">Home</span>
        </a>
        <a href="login.php" class="nav-item">
            <span class="nav-icon">🔐</span>
            <span class="nav-label">Login</span>
        </a>
        <a href="register.php" class="nav-item">
            <span class="nav-icon">📝</span>
            <span class="nav-label">Register</span>
        </a>
    </nav>
    
    <div class="container">
        <div style="max-width: 500px; margin: 2rem auto;">
            <div style="background: white; padding: 3rem; border-radius: 20px; box-shadow: 0 15px 40px rgba(0,0,0,0.1);">
                <div style="text-align: center; margin-bottom: 2rem;">
                    <div style="font-size: 4rem; margin-bottom: 1rem;">🔑</div>
                    <h2>Reset Your Password</h2>
                    <p style="color: #666; margin-top: 1rem;">Enter your email address and we'll send you a secure link to reset your password.</p>
                </div>
                
                <!-- Success Message -->
                <?php if (isset($_SESSION['reset_success'])): ?>
                    <div style="background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%); color: #155724; padding: 1.5rem; border-radius: 10px; margin: 2rem 0; border-left: 5px solid #28a745; text-align: center;">
                        <strong>✅ Email Sent!</strong><br>
                        <?php echo $_SESSION['reset_success']; unset($_SESSION['reset_success']); ?>
                    </div>
                <?php endif; ?>
                
                <!-- Error Message -->
                <?php if (isset($_SESSION['reset_error'])): ?>
                    <div style="background: linear-gradient(135deg, #f8d7da 0%, #f1b0b7 100%); color: #721c24; padding: 1.5rem; border-radius: 10px; margin: 2rem 0; border-left: 5px solid #dc3545; text-align: center;">
                        <strong>❌ Error!</strong><br>
                        <?php echo $_SESSION['reset_error']; unset($_SESSION['reset_error']); ?>
                    </div>
                <?php endif; ?>
                
                <form action="process_forgot_password.php" method="POST" id="forgotForm">
                    <?php echo Security::getCSRFField(); ?>
                    <div style="margin-bottom: 2rem;">
                        <label for="email" style="display: block; margin-bottom: 0.5rem; font-weight: 600;">📧 Email Address</label>
                        <input 
                            type="email" 
                            id="email" 
                            name="email" 
                            required 
                            style="width: 100%; padding: 1rem; border: 2px solid #e0e0e0; border-radius: 10px; font-size: 1rem; transition: all 0.3s ease;" 
                            onfocus="this.style.borderColor='var(--primary-color)'; this.style.boxShadow='0 0 0 3px rgba(0,123,255,0.1)'" 
                            onblur="this.style.borderColor='#e0e0e0'; this.style.boxShadow='none'"
                            placeholder="Enter your registered email address"
                        >
                    </div>
                    
                    <button 
                        type="submit" 
                        class="btn btn-success" 
                        style="width: 100%; padding: 1rem; font-size: 1.1rem; margin-bottom: 1rem;"
                    >
                        🔑 Send Reset Link
                    </button>
                </form>
                
                <div style="text-align: center; margin-top: 2rem;">
                    <p style="color: #666; margin-bottom: 1rem;">Remember your password?</p>
                    <a href="login.php" class="btn" style="margin: 0.5rem;">🔐 Back to Login</a>
                </div>
                
                <div style="background: #f8f9fa; padding: 2rem; border-radius: 15px; margin-top: 2rem;">
                    <h3 style="margin-bottom: 1rem;">🛡️ Security Information</h3>
                    <ul style="color: #666; font-size: 0.9rem; line-height: 1.6;">
                        <li>📧 Reset link will be sent to your registered email</li>
                        <li>⏰ Link expires in 30 minutes for security</li>
                        <li>🔐 You can only request a reset every 5 minutes</li>
                        <li>🛟 Contact support if you don't receive the email</li>
                        <li>🚫 Suspicious activity is monitored and blocked</li>
                    </ul>
                </div>
                
                <div style="text-align: center; margin-top: 2rem; padding-top: 2rem; border-top: 1px solid #eee;">
                    <h4>Need Help?</h4>
                    <div style="margin: 1rem 0;">
                        <a href="contact.php" class="btn" style="margin: 0.5rem;">📞 Contact Support</a>
                        <a href="register.php" class="btn" style="margin: 0.5rem;">📝 Create Account</a>
                    </div>
                    <p style="color: #666; font-size: 0.9rem; margin-top: 1rem;">
                        For immediate assistance, call us at 
                        <a href="tel:5551234374" style="color: var(--primary-color); font-weight: 600;">(555) 123-DRIVE</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
    
    <footer>
        <p>&copy; 2025 Origin Driving School. All rights reserved.</p>
        <div style="margin: 1rem 0;">
            <a href="privacy-policy.php" style="color: #ccc; margin: 0 1rem;">Privacy Policy</a>
            <a href="terms-of-service.php" style="color: #ccc; margin: 0 1rem;">Terms of Service</a>
            <a href="contact.php" style="color: #ccc; margin: 0 1rem;">Contact</a>
        </div>
    </footer>
    
    <script>
        // Form validation and loading state
        document.getElementById('forgotForm').addEventListener('submit', function(e) {
            const email = document.getElementById('email').value;
            const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            const button = this.querySelector('button[type="submit"]');
            
            if (!emailPattern.test(email)) {
                e.preventDefault();
                alert('Please enter a valid email address.');
                document.getElementById('email').focus();
                return;
            }
            
            // Show loading state
            button.innerHTML = '⏳ Sending...';
            button.disabled = true;
            
            // Re-enable after 3 seconds if form doesn't submit (fallback)
            setTimeout(() => {
                button.innerHTML = '🔑 Send Reset Link';
                button.disabled = false;
            }, 3000);
        });
        
        // Auto-focus email field
        document.getElementById('email').focus();
    </script>
</body>
</html>
