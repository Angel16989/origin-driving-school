<?php 
session_start();
require_once 'includes/security.php';

// Check if user is already logged in
if (isset($_SESSION['username'])) {
    header("Location: dashboard.php");
    exit();
}
$page_title = "Register - Origin Driving School";
$page_description = "Create your Origin Driving School account and start your driving journey";
include 'includes/header.php';
?>
    <script src="includes/verification.js" defer></script>
    
    <!-- Hero Section -->
    <section style="background: linear-gradient(135deg, var(--dashboard-blue) 0%, #40407a 100%); color: white; padding: 6rem 2rem 4rem; position: relative; overflow: hidden;">
        <div style="position: absolute; top: -50%; left: -50%; width: 200%; height: 200%; background: radial-gradient(circle, rgba(255, 215, 0, 0.1) 0%, transparent 70%); animation: containerGlow 15s ease-in-out infinite; pointer-events: none;"></div>
        
        <div style="max-width: 1200px; margin: 0 auto; text-align: center; position: relative; z-index: 2;">
            <div style="font-size: 4rem; margin-bottom: 1rem;">�</div>
            <h2 style="font-size: 2.5rem; margin-bottom: 1rem;">Create Your Account</h2>
            <p style="font-size: 1.2rem; opacity: 0.9; max-width: 600px; margin: 0 auto;">Join thousands of successful drivers at Origin Driving School</p>
        </div>
    </section>
    
    <div class="container">
        <div style="max-width: 600px; margin: 2rem auto;">
            <div style="background: white; padding: 3rem; border-radius: 20px; box-shadow: 0 15px 40px rgba(0,0,0,0.1);">
                <div style="text-align: center; margin-bottom: 2rem;">
                    <div style="font-size: 4rem; margin-bottom: 1rem;">🚗</div>
                    <h2>Join Origin Driving School</h2>
                    <p style="color: #666; margin-top: 1rem;">Create your account and start your journey to safe, confident driving</p>
                </div>
                
                <!-- Success Message -->
                <?php if (isset($_SESSION['register_success'])): ?>
                    <div style="background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%); color: #155724; padding: 2rem; border-radius: 15px; margin: 2rem 0; border-left: 5px solid #28a745; text-align: center;">
                        <div style="font-size: 3rem; margin-bottom: 1rem;">✅</div>
                        <strong>Registration Successful!</strong><br>
                        <?php echo $_SESSION['register_success']; unset($_SESSION['register_success']); ?>
                        <div style="margin-top: 2rem;">
                            <a href="login.php" class="btn btn-success">🔐 Login Now</a>
                        </div>
                    </div>
                <?php endif; ?>
                
                <?php if (isset($_SESSION['register_errors'])): ?>
                    <div style="background: linear-gradient(135deg, #f8d7da 0%, #f1b0b7 100%); color: #721c24; padding: 2rem; border-radius: 15px; margin: 2rem 0; border-left: 5px solid #dc3545; text-align: center;">
                        <div style="font-size: 3rem; margin-bottom: 1rem;">❌</div>
                        <strong>Registration Failed!</strong><br>
                        <?php 
                            foreach ($_SESSION['register_errors'] as $error) {
                                echo "<div style='margin: 0.5rem 0'>$error</div>";
                            }
                            unset($_SESSION['register_errors']); 
                        ?>
                    </div>
                <?php endif; ?>
                
                <?php if (isset($_SESSION['verification_message'])): ?>
                    <div style="background: linear-gradient(135deg, #cce5ff 0%, #b8daff 100%); color: #004085; padding: 2rem; border-radius: 15px; margin: 2rem 0; border-left: 5px solid #0056b3; text-align: center;">
                        <div style="font-size: 3rem; margin-bottom: 1rem;">🔍</div>
                        <strong>Verification Required</strong><br>
                        <?php echo $_SESSION['verification_message']; unset($_SESSION['verification_message']); ?>
                    </div>
                <?php endif; ?>
                
                <!-- Error Message -->
                <?php if (isset($_SESSION['register_error'])): ?>
                    <div style="background: linear-gradient(135deg, #f8d7da 0%, #f1b0b7 100%); color: #721c24; padding: 1.5rem; border-radius: 10px; margin: 2rem 0; border-left: 5px solid #dc3545;">
                        <strong>❌ Registration Error!</strong><br>
                        <?php echo $_SESSION['register_error']; unset($_SESSION['register_error']); ?>
                    </div>
                <?php endif; ?>
                
                <?php if (!isset($_SESSION['register_success'])): ?>
                <form action="process_register.php" method="POST" id="registerForm">
                    <?php echo Security::getCSRFField(); ?>
                    
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem; margin-bottom: 2rem;">
                        <div>
                            <label for="first_name" style="display: block; margin-bottom: 0.5rem; font-weight: 600;">👤 First Name *</label>
                            <input 
                                type="text" 
                                id="first_name" 
                                name="first_name" 
                                required 
                                style="width: 100%; padding: 1rem; border: 2px solid #e0e0e0; border-radius: 10px; font-size: 1rem; transition: all 0.3s ease;" 
                                onfocus="this.style.borderColor='var(--primary-color)'; this.style.boxShadow='0 0 0 3px rgba(0,123,255,0.1)'" 
                                onblur="this.style.borderColor='#e0e0e0'; this.style.boxShadow='none'"
                                placeholder="Enter your first name"
                                value="<?php echo isset($_SESSION['form_data']['first_name']) ? htmlspecialchars($_SESSION['form_data']['first_name']) : ''; ?>"
                            >
                        </div>
                        
                        <div>
                            <label for="last_name" style="display: block; margin-bottom: 0.5rem; font-weight: 600;">👤 Last Name *</label>
                            <input 
                                type="text" 
                                id="last_name" 
                                name="last_name" 
                                required 
                                style="width: 100%; padding: 1rem; border: 2px solid #e0e0e0; border-radius: 10px; font-size: 1rem; transition: all 0.3s ease;" 
                                onfocus="this.style.borderColor='var(--primary-color)'; this.style.boxShadow='0 0 0 3px rgba(0,123,255,0.1)'" 
                                onblur="this.style.borderColor='#e0e0e0'; this.style.boxShadow='none'"
                                placeholder="Enter your last name"
                                value="<?php echo isset($_SESSION['form_data']['last_name']) ? htmlspecialchars($_SESSION['form_data']['last_name']) : ''; ?>"
                            >
                        </div>
                    </div>
                    
                    <div style="margin-bottom: 2rem;">
                        <label for="username" style="display: block; margin-bottom: 0.5rem; font-weight: 600;">👨‍💻 Username *</label>
                        <input 
                            type="text" 
                            id="username" 
                            name="username" 
                            required 
                            style="width: 100%; padding: 1rem; border: 2px solid #e0e0e0; border-radius: 10px; font-size: 1rem; transition: all 0.3s ease;" 
                            onfocus="this.style.borderColor='var(--primary-color)'; this.style.boxShadow='0 0 0 3px rgba(0,123,255,0.1)'" 
                            onblur="this.style.borderColor='#e0e0e0'; this.style.boxShadow='none'"
                            placeholder="Choose a unique username"
                            value="<?php echo isset($_SESSION['form_data']['username']) ? htmlspecialchars($_SESSION['form_data']['username']) : ''; ?>"
                            minlength="3"
                            maxlength="50"
                        >
                        <p style="font-size: 0.9rem; color: #666; margin-top: 0.5rem;">3-50 characters, letters, numbers, and underscores only</p>
                    </div>
                    
                    <div style="margin-bottom: 2rem;">
                        <label for="email" style="display: block; margin-bottom: 0.5rem; font-weight: 600;">📧 Email Address *</label>
                        <input 
                            type="email" 
                            id="email" 
                            name="email" 
                            required 
                            style="width: 100%; padding: 1rem; border: 2px solid #e0e0e0; border-radius: 10px; font-size: 1rem; transition: all 0.3s ease;" 
                            onfocus="this.style.borderColor='var(--primary-color)'; this.style.boxShadow='0 0 0 3px rgba(0,123,255,0.1)'" 
                            onblur="this.style.borderColor='#e0e0e0'; this.style.boxShadow='none'"
                            placeholder="Enter your email address"
                            value="<?php echo isset($_SESSION['form_data']['email']) ? htmlspecialchars($_SESSION['form_data']['email']) : ''; ?>"
                        >
                        <p style="font-size: 0.9rem; color: #666; margin-top: 0.5rem;">We'll send you a verification email</p>
                    </div>
                    
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem; margin-bottom: 2rem;">
                        <div>
                            <label for="phone" style="display: block; margin-bottom: 0.5rem; font-weight: 600;">📞 Phone Number</label>
                            <input 
                                type="tel" 
                                id="phone" 
                                name="phone" 
                                style="width: 100%; padding: 1rem; border: 2px solid #e0e0e0; border-radius: 10px; font-size: 1rem; transition: all 0.3s ease;" 
                                onfocus="this.style.borderColor='var(--primary-color)'; this.style.boxShadow='0 0 0 3px rgba(0,123,255,0.1)'" 
                                onblur="this.style.borderColor='#e0e0e0'; this.style.boxShadow='none'"
                                placeholder="(555) 123-4567"
                                value="<?php echo isset($_SESSION['form_data']['phone']) ? htmlspecialchars($_SESSION['form_data']['phone']) : ''; ?>"
                            >
                        </div>
                        
                        <div>
                            <label for="date_of_birth" style="display: block; margin-bottom: 0.5rem; font-weight: 600;">🎂 Date of Birth *</label>
                            <input 
                                type="date" 
                                id="date_of_birth" 
                                name="date_of_birth" 
                                required 
                                style="width: 100%; padding: 1rem; border: 2px solid #e0e0e0; border-radius: 10px; font-size: 1rem; transition: all 0.3s ease;" 
                                onfocus="this.style.borderColor='var(--primary-color)'; this.style.boxShadow='0 0 0 3px rgba(0,123,255,0.1)'" 
                                onblur="this.style.borderColor='#e0e0e0'; this.style.boxShadow='none'"
                                value="<?php echo isset($_SESSION['form_data']['date_of_birth']) ? htmlspecialchars($_SESSION['form_data']['date_of_birth']) : ''; ?>"
                                max="<?php echo date('Y-m-d', strtotime('-13 years')); ?>"
                            >
                        </div>
                    </div>
                    
                    <div style="margin-bottom: 2rem;">
                        <label for="password" style="display: block; margin-bottom: 0.5rem; font-weight: 600;">🔐 Password *</label>
                        <input 
                            type="password" 
                            id="password" 
                            name="password" 
                            required 
                            style="width: 100%; padding: 1rem; border: 2px solid #e0e0e0; border-radius: 10px; font-size: 1rem; transition: all 0.3s ease;" 
                            onfocus="this.style.borderColor='var(--primary-color)'; this.style.boxShadow='0 0 0 3px rgba(0,123,255,0.1)'" 
                            onblur="this.style.borderColor='#e0e0e0'; this.style.boxShadow='none'"
                            minlength="8"
                            placeholder="Create a strong password"
                        >
                        <div id="passwordStrength" style="margin-top: 0.5rem; font-size: 0.9rem;"></div>
                    </div>
                    
                    <div style="margin-bottom: 2rem;">
                        <label for="confirm_password" style="display: block; margin-bottom: 0.5rem; font-weight: 600;">🔐 Confirm Password *</label>
                        <input 
                            type="password" 
                            id="confirm_password" 
                            name="confirm_password" 
                            required 
                            style="width: 100%; padding: 1rem; border: 2px solid #e0e0e0; border-radius: 10px; font-size: 1rem; transition: all 0.3s ease;" 
                            onfocus="this.style.borderColor='var(--primary-color)'; this.style.boxShadow='0 0 0 3px rgba(0,123,255,0.1)'" 
                            onblur="this.style.borderColor='#e0e0e0'; this.style.boxShadow='none'"
                            placeholder="Confirm your password"
                        >
                        <div id="matchStatus" style="margin-top: 0.5rem; font-size: 0.9rem;"></div>
                    </div>
                    
                    <div style="background: #f8f9fa; padding: 2rem; border-radius: 15px; margin-bottom: 2rem;">
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
                    
                    <div style="margin-bottom: 2rem;">
                        <label class="checkbox-label">
                            <input type="checkbox" name="terms_agreed" required>
                            <span>I agree to the <a href="terms-of-service.php" target="_blank" style="color: var(--primary-color); text-decoration: none; font-weight: 600;">Terms of Service</a> and <a href="privacy-policy.php" target="_blank" style="color: var(--primary-color); text-decoration: none; font-weight: 600;">Privacy Policy</a></span>
                        </label>
                    </div>
                    
                    <div style="margin-bottom: 2rem;">
                        <label class="checkbox-label">
                            <input type="checkbox" name="newsletter_signup">
                            <span>📧 Subscribe to our newsletter for driving tips and special offers</span>
                        </label>
                    </div>
                    
                    <button 
                        type="submit" 
                        class="btn btn-success" 
                        style="width: 100%; padding: 1rem; font-size: 1.1rem; margin-bottom: 1rem;"
                        id="submitBtn"
                        disabled
                    >
                        🚗 Create My Account
                    </button>
                </form>
                <?php endif; ?>
                
                <div style="text-align: center; margin-top: 2rem; padding-top: 2rem; border-top: 1px solid #eee;">
                    <p style="color: #666; margin-bottom: 1rem;">Already have an account?</p>
                    <a href="login.php" class="btn" style="width: 100%;">🔐 Sign In</a>
                </div>
                
                <div style="text-align: center; margin-top: 2rem;">
                    <p style="color: #666; font-size: 0.9rem;">
                        Need help? Contact us at 
                        <a href="tel:5551234374" style="color: var(--primary-color); font-weight: 600;">(555) 123-DRIVE</a>
                        or <a href="contact.php" style="color: var(--primary-color); font-weight: 600;">send us a message</a>
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
        // Clear form data from session
        <?php unset($_SESSION['form_data']); ?>
        
        const passwordInput = document.getElementById('password');
        const confirmInput = document.getElementById('confirm_password');
        const submitBtn = document.getElementById('submitBtn');
        const usernameInput = document.getElementById('username');
        
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
            
            // Check all form requirements
            checkFormValidity();
        }
        
        // Check overall form validity
        function checkFormValidity() {
            const password = passwordInput.value;
            const confirm = confirmInput.value;
            const username = usernameInput.value;
            const termsChecked = document.querySelector('input[name="terms_agreed"]').checked;
            
            const requirements = {
                length: password.length >= 8,
                upper: /[A-Z]/.test(password),
                lower: /[a-z]/.test(password),
                number: /\d/.test(password),
                special: /[!@#$%^&*(),.?":{}|<>]/.test(password),
                match: password === confirm && password.length > 0
            };
            
            const passwordValid = Object.values(requirements).every(Boolean);
            const usernameValid = username.length >= 3 && /^[a-zA-Z0-9_]+$/.test(username);
            const allValid = passwordValid && usernameValid && termsChecked;
            
            submitBtn.disabled = !allValid;
            submitBtn.style.opacity = allValid ? '1' : '0.5';
        }
        
        // Username validation
        usernameInput.addEventListener('input', function() {
            const username = this.value;
            const isValid = /^[a-zA-Z0-9_]+$/.test(username);
            
            if (username.length > 0 && !isValid) {
                this.style.borderColor = '#dc3545';
                this.nextElementSibling.style.color = '#dc3545';
                this.nextElementSibling.innerHTML = '❌ Only letters, numbers, and underscores allowed';
            } else if (username.length >= 3) {
                this.style.borderColor = '#28a745';
                this.nextElementSibling.style.color = '#28a745';
                this.nextElementSibling.innerHTML = '✅ Username looks good';
            } else {
                this.style.borderColor = '#e0e0e0';
                this.nextElementSibling.style.color = '#666';
                this.nextElementSibling.innerHTML = '3-50 characters, letters, numbers, and underscores only';
            }
            
            checkFormValidity();
        });
        
        passwordInput.addEventListener('input', checkPassword);
        confirmInput.addEventListener('input', checkPassword);
        document.querySelector('input[name="terms_agreed"]').addEventListener('change', checkFormValidity);
        
        // Form submission
        document.getElementById('registerForm')?.addEventListener('submit', function(e) {
            const password = passwordInput.value;
            const confirm = confirmInput.value;
            
            if (password !== confirm) {
                e.preventDefault();
                alert('Passwords do not match.');
                return;
            }
            
            // Show loading state
            submitBtn.innerHTML = '⏳ Creating Account...';
            submitBtn.disabled = true;
        });
        
        // Auto-focus first field
        document.getElementById('first_name').focus();
    </script>
    
<?php include 'includes/footer.php'; ?>
