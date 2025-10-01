<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - Origin Driving School</title>
    <link rel="stylesheet" href="css/styles.css">
    <meta name="description" content="Reset your Origin Driving School account password">
</head>
<body class="page-transition">
    <header>
        <h1>🔐 Reset Password</h1>
        <p>Create a new secure password for your account</p>
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
    </nav>
    
    <div class="container">
        <div style="max-width: 500px; margin: 2rem auto;">
            <div style="background: white; padding: 3rem; border-radius: 20px; box-shadow: 0 15px 40px rgba(0,0,0,0.1);">
                <?php
                session_start();
                require_once 'includes/security.php';
                
                // Database connection
                $servername = "localhost";
                $username = "root";
                $password = "";
                $dbname = "driving_school";
                
                $valid_token = false;
                $expired = false;
                $user_email = '';
                
                try {
                    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
                    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    
                    if (isset($_GET['token']) && !empty($_GET['token'])) {
                        $token = $_GET['token'];
                        
                        // Validate token
                        $stmt = $conn->prepare("SELECT pr.*, u.email FROM password_resets pr JOIN users u ON pr.user_id = u.id WHERE pr.token = ? AND pr.used = FALSE");
                        $stmt->execute([$token]);
                        $reset_data = $stmt->fetch(PDO::FETCH_ASSOC);
                        
                        if ($reset_data) {
                            if (strtotime($reset_data['expires_at']) > time()) {
                                $valid_token = true;
                                $user_email = $reset_data['email'];
                            } else {
                                $expired = true;
                            }
                        }
                    }
                } catch(PDOException $e) {
                    // Handle error silently
                }
                ?>
                
                <?php if (!isset($_GET['token']) || empty($_GET['token'])): ?>
                    <!-- No token provided -->
                    <div style="text-align: center;">
                        <div style="font-size: 4rem; margin-bottom: 1rem;">❌</div>
                        <h2 style="color: #dc3545;">Invalid Reset Link</h2>
                        <p style="color: #666; margin: 2rem 0;">The password reset link is missing or invalid. Please request a new password reset.</p>
                        <a href="forgot-password.php" class="btn btn-success">🔑 Request New Reset</a>
                    </div>
                
                <?php elseif ($expired): ?>
                    <!-- Token expired -->
                    <div style="text-align: center;">
                        <div style="font-size: 4rem; margin-bottom: 1rem;">⏰</div>
                        <h2 style="color: #dc3545;">Link Expired</h2>
                        <p style="color: #666; margin: 2rem 0;">This password reset link has expired. For security reasons, reset links are only valid for 30 minutes.</p>
                        <a href="forgot-password.php" class="btn btn-success">🔑 Request New Reset</a>
                    </div>
                
                <?php elseif (!$valid_token): ?>
                    <!-- Invalid token -->
                    <div style="text-align: center;">
                        <div style="font-size: 4rem; margin-bottom: 1rem;">🚫</div>
                        <h2 style="color: #dc3545;">Invalid or Used Link</h2>
                        <p style="color: #666; margin: 2rem 0;">This password reset link is invalid or has already been used. Each reset link can only be used once.</p>
                        <a href="forgot-password.php" class="btn btn-success">🔑 Request New Reset</a>
                    </div>
                
                <?php else: ?>
                    <!-- Valid token - show reset form -->
                    <div style="text-align: center; margin-bottom: 2rem;">
                        <div style="font-size: 4rem; margin-bottom: 1rem;">🔒</div>
                        <h2>Create New Password</h2>
                        <p style="color: #666; margin-top: 1rem;">Enter a strong new password for <strong><?php echo htmlspecialchars($user_email); ?></strong></p>
                    </div>
                    
                    <!-- Success/Error Messages -->
                    <?php if (isset($_SESSION['reset_success'])): ?>
                        <div style="background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%); color: #155724; padding: 1.5rem; border-radius: 10px; margin: 2rem 0; border-left: 5px solid #28a745; text-align: center;">
                            <strong>✅ Success!</strong><br>
                            <?php echo $_SESSION['reset_success']; unset($_SESSION['reset_success']); ?>
                            <div style="margin-top: 1rem;">
                                <a href="login.php" class="btn btn-success">🔐 Login Now</a>
                            </div>
                        </div>
                    <?php endif; ?>
                    
                    <?php if (isset($_SESSION['reset_error'])): ?>
                        <div style="background: linear-gradient(135deg, #f8d7da 0%, #f1b0b7 100%); color: #721c24; padding: 1.5rem; border-radius: 10px; margin: 2rem 0; border-left: 5px solid #dc3545; text-align: center;">
                            <strong>❌ Error!</strong><br>
                            <?php echo $_SESSION['reset_error']; unset($_SESSION['reset_error']); ?>
                        </div>
                    <?php endif; ?>
                    
                    <?php if (!isset($_SESSION['reset_success'])): ?>
                    <form action="process_reset_password.php" method="POST" id="resetForm">
                        <?php echo Security::getCSRFField(); ?>
                        <input type="hidden" name="token" value="<?php echo htmlspecialchars($_GET['token']); ?>">
                        
                        <div style="margin-bottom: 2rem;">
                            <label for="password" style="display: block; margin-bottom: 0.5rem; font-weight: 600;">🔐 New Password</label>
                            <input 
                                type="password" 
                                id="password" 
                                name="password" 
                                required 
                                style="width: 100%; padding: 1rem; border: 2px solid #e0e0e0; border-radius: 10px; font-size: 1rem; transition: all 0.3s ease;" 
                                onfocus="this.style.borderColor='var(--primary-color)'; this.style.boxShadow='0 0 0 3px rgba(0,123,255,0.1)'" 
                                onblur="this.style.borderColor='#e0e0e0'; this.style.boxShadow='none'"
                                minlength="8"
                                placeholder="Enter your new password"
                            >
                            <div id="passwordStrength" style="margin-top: 0.5rem; font-size: 0.9rem;"></div>
                        </div>
                        
                        <div style="margin-bottom: 2rem;">
                            <label for="confirm_password" style="display: block; margin-bottom: 0.5rem; font-weight: 600;">🔐 Confirm Password</label>
                            <input 
                                type="password" 
                                id="confirm_password" 
                                name="confirm_password" 
                                required 
                                style="width: 100%; padding: 1rem; border: 2px solid #e0e0e0; border-radius: 10px; font-size: 1rem; transition: all 0.3s ease;" 
                                onfocus="this.style.borderColor='var(--primary-color)'; this.style.boxShadow='0 0 0 3px rgba(0,123,255,0.1)'" 
                                onblur="this.style.borderColor='#e0e0e0'; this.style.boxShadow='none'"
                                placeholder="Confirm your new password"
                            >
                            <div id="matchStatus" style="margin-top: 0.5rem; font-size: 0.9rem;"></div>
                        </div>
                        
                        <button 
                            type="submit" 
                            class="btn btn-success" 
                            style="width: 100%; padding: 1rem; font-size: 1.1rem; margin-bottom: 1rem;"
                            id="submitBtn"
                            disabled
                        >
                            🔒 Update Password
                        </button>
                    </form>
                    <?php endif; ?>
                    
                    <div style="background: #f8f9fa; padding: 2rem; border-radius: 15px; margin-top: 2rem;">
                        <h3 style="margin-bottom: 1rem;">🛡️ Password Requirements</h3>
                        <ul id="passwordRequirements" style="color: #666; font-size: 0.9rem; line-height: 1.6; list-style: none; padding: 0;">
                            <li id="req-length">❌ At least 8 characters long</li>
                            <li id="req-upper">❌ At least one uppercase letter (A-Z)</li>
                            <li id="req-lower">❌ At least one lowercase letter (a-z)</li>
                            <li id="req-number">❌ At least one number (0-9)</li>
                            <li id="req-special">❌ At least one special character (!@#$%^&*)</li>
                            <li id="req-match">❌ Passwords must match</li>
                        </ul>
                    </div>
                <?php endif; ?>
                
                <div style="text-align: center; margin-top: 2rem; padding-top: 2rem; border-top: 1px solid #eee;">
                    <div style="margin: 1rem 0;">
                        <a href="login.php" class="btn" style="margin: 0.5rem;">🔐 Back to Login</a>
                        <a href="contact.php" class="btn" style="margin: 0.5rem;">📞 Need Help?</a>
                    </div>
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
        const passwordInput = document.getElementById('password');
        const confirmInput = document.getElementById('confirm_password');
        const submitBtn = document.getElementById('submitBtn');
        
        if (passwordInput && confirmInput) {
            // Password strength and validation
            function checkPassword() {
                const password = passwordInput.value;
                const confirm = confirmInput.value;
                
                // Check requirements
                const requirements = {
                    length: password.length >= 8,
                    upper: /[A-Z]/.test(password),
                    lower: /[a-z]/.test(password),
                    number: /\d/.test(password),
                    special: /[!@#$%^&*(),.?":{}|<>]/.test(password),
                    match: password === confirm && password.length > 0
                };
                
                // Update requirement indicators
                Object.keys(requirements).forEach(req => {
                    const element = document.getElementById(`req-${req}`);
                    if (element) {
                        if (requirements[req]) {
                            element.innerHTML = element.innerHTML.replace('❌', '✅');
                            element.style.color = '#28a745';
                        } else {
                            element.innerHTML = element.innerHTML.replace('✅', '❌');
                            element.style.color = '#666';
                        }
                    }
                });
                
                // Password strength indicator
                const strengthElement = document.getElementById('passwordStrength');
                if (password.length > 0) {
                    const score = Object.values(requirements).slice(0, 5).filter(Boolean).length;
                    const colors = ['#dc3545', '#fd7e14', '#ffc107', '#20c997', '#28a745'];
                    const labels = ['Very Weak', 'Weak', 'Fair', 'Good', 'Strong'];
                    
                    strengthElement.innerHTML = `Strength: <span style="color: ${colors[score - 1] || colors[0]}; font-weight: 600;">${labels[score - 1] || labels[0]}</span>`;
                } else {
                    strengthElement.innerHTML = '';
                }
                
                // Match status
                const matchElement = document.getElementById('matchStatus');
                if (confirm.length > 0) {
                    if (requirements.match) {
                        matchElement.innerHTML = '<span style="color: #28a745;">✅ Passwords match</span>';
                    } else {
                        matchElement.innerHTML = '<span style="color: #dc3545;">❌ Passwords do not match</span>';
                    }
                } else {
                    matchElement.innerHTML = '';
                }
                
                // Enable/disable submit button
                const allValid = Object.values(requirements).every(Boolean);
                if (submitBtn) {
                    submitBtn.disabled = !allValid;
                    submitBtn.style.opacity = allValid ? '1' : '0.5';
                }
            }
            
            passwordInput.addEventListener('input', checkPassword);
            confirmInput.addEventListener('input', checkPassword);
            
            // Form submission
            document.getElementById('resetForm')?.addEventListener('submit', function(e) {
                const password = passwordInput.value;
                const confirm = confirmInput.value;
                
                if (password !== confirm) {
                    e.preventDefault();
                    alert('Passwords do not match.');
                    return;
                }
                
                if (password.length < 8) {
                    e.preventDefault();
                    alert('Password must be at least 8 characters long.');
                    return;
                }
                
                // Show loading state
                submitBtn.innerHTML = '⏳ Updating...';
                submitBtn.disabled = true;
            });
            
            // Auto-focus first field
            passwordInput.focus();
        }
    </script>
</body>
</html>
