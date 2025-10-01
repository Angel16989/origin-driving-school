<?php 
session_start();
require_once 'includes/security.php';
$page_title = "Contact Us - Origin Driving School";
$page_description = "Contact Origin Driving School - Get in touch with us for driving lessons, inquiries, and support.";
include 'includes/header.php';
?>
    <!-- Hero Section -->
    <section style="background: linear-gradient(135deg, var(--dashboard-blue) 0%, #40407a 100%); color: white; padding: 6rem 2rem 4rem; position: relative; overflow: hidden;">
        <div style="position: absolute; top: -50%; left: -50%; width: 200%; height: 200%; background: radial-gradient(circle, rgba(255, 215, 0, 0.1) 0%, transparent 70%); animation: containerGlow 15s ease-in-out infinite; pointer-events: none;"></div>
        
        <div style="max-width: 1200px; margin: 0 auto; text-align: center; position: relative; z-index: 2;">
            <div style="font-size: 4rem; margin-bottom: 1rem;">📞</div>
            <h2 style="font-size: 2.5rem; margin-bottom: 1rem;">We'd Love to Hear From You!</h2>
            <p style="font-size: 1.2rem; opacity: 0.9; max-width: 600px; margin: 0 auto;">Whether you have questions about our courses, want to schedule a lesson, or need support, our friendly team is ready to help you succeed.</p>
        </div>
    </section>
    
    <div class="container">
        <!-- Success/Error Messages -->
        <?php if (isset($_SESSION['contact_success'])): ?>
            <div style="background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%); color: #155724; padding: 1.5rem; border-radius: 10px; margin: 2rem 0; border-left: 5px solid #28a745; box-shadow: 0 5px 15px rgba(40, 167, 69, 0.2);">
                <strong>✅ Success!</strong> <?php echo $_SESSION['contact_success']; unset($_SESSION['contact_success']); ?>
            </div>
        <?php endif; ?>
        
        <?php if (isset($_SESSION['contact_error'])): ?>
            <div style="background: linear-gradient(135deg, #f8d7da 0%, #f1b0b7 100%); color: #721c24; padding: 1.5rem; border-radius: 10px; margin: 2rem 0; border-left: 5px solid #dc3545; box-shadow: 0 5px 15px rgba(220, 53, 69, 0.2);">
                <strong>❌ Error!</strong> <?php echo $_SESSION['contact_error']; unset($_SESSION['contact_error']); ?>
            </div>
        <?php endif; ?>
        
        <!-- Hero Section -->
        <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 4rem 2rem; border-radius: 20px; text-align: center; margin: 2rem 0;">
            <div style="font-size: 4rem; margin-bottom: 1rem;">📞</div>
            <h2 style="font-size: 2.5rem; margin-bottom: 1rem;">We'd Love to Hear From You!</h2>
            <p style="font-size: 1.2rem; opacity: 0.9; max-width: 600px; margin: 0 auto;">Whether you have questions about our courses, want to schedule a lesson, or need support, our friendly team is ready to help you succeed.</p>
        </div>
        
        <!-- Contact Information -->
        <section style="margin: 4rem 0;">
            <h2 style="text-align: center; margin-bottom: 3rem;">📍 Get In Touch</h2>
            
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(350px, 1fr)); gap: 2rem;">
                <!-- Phone -->
                <div style="background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%); padding: 2rem; border-radius: 15px; text-align: center; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
                    <div style="font-size: 3rem; margin-bottom: 1rem;">📞</div>
                    <h3>Phone Us</h3>
                    <p style="font-size: 1.5rem; color: var(--primary-color); font-weight: 600; margin: 1rem 0;">(555) 123-DRIVE</p>
                    <p>Call us during business hours for immediate assistance. Our phone lines are staffed by knowledgeable team members who can answer questions and schedule lessons.</p>
                    <div style="margin-top: 1rem;">
                        <a href="tel:5551234374" class="btn btn-success">📞 Call Now</a>
                    </div>
                </div>
                
                <!-- Email -->
                <div style="background: linear-gradient(135deg, #e8f5e8 0%, #c8e6c9 100%); padding: 2rem; border-radius: 15px; text-align: center; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
                    <div style="font-size: 3rem; margin-bottom: 1rem;">📧</div>
                    <h3>Email Us</h3>
                    <p style="font-size: 1.2rem; color: var(--success-color); font-weight: 600; margin: 1rem 0;">info@origindrivingschool.com</p>
                    <p>Send us an email for detailed inquiries, documentation requests, or non-urgent matters. We typically respond within 24 hours during business days.</p>
                    <div style="margin-top: 1rem;">
                        <a href="mailto:info@origindrivingschool.com" class="btn btn-success">📧 Send Email</a>
                    </div>
                </div>
                
                <!-- Address -->
                <div style="background: linear-gradient(135deg, #fff3e0 0%, #ffe0b2 100%); padding: 2rem; border-radius: 15px; text-align: center; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
                    <div style="font-size: 3rem; margin-bottom: 1rem;">📍</div>
                    <h3>Visit Us</h3>
                    <p style="color: var(--warning-color); font-weight: 600; margin: 1rem 0;">123 Driving Lane<br>Education City, EC 12345</p>
                    <p>Visit our office for in-person consultations, documentation, or to meet with our instructors. Free parking is available for all visitors.</p>
                    <div style="margin-top: 1rem;">
                        <a href="#" class="btn btn-warning">🗺️ Get Directions</a>
                    </div>
                </div>
                
                <!-- Emergency -->
                <div style="background: linear-gradient(135deg, #ffebee 0%, #ffcdd2 100%); padding: 2rem; border-radius: 15px; text-align: center; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
                    <div style="font-size: 3rem; margin-bottom: 1rem;">🚨</div>
                    <h3>Emergency Contact</h3>
                    <p style="font-size: 1.3rem; color: var(--danger-color); font-weight: 600; margin: 1rem 0;">(555) 911-HELP</p>
                    <p>For driving lesson emergencies or urgent safety concerns only. This line is monitored 24/7 for critical situations during scheduled lessons.</p>
                    <div style="margin-top: 1rem;">
                        <a href="tel:5559114357" class="btn btn-danger">🚨 Emergency Line</a>
                    </div>
                </div>
            </div>
        </section>
        
        <!-- Business Hours -->
        <section style="margin: 4rem 0;">
            <h2 style="text-align: center; margin-bottom: 3rem;">🕐 Business Hours</h2>
            
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(400px, 1fr)); gap: 2rem;">
                <div style="background: white; padding: 2rem; border-radius: 15px; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
                    <h3>📞 Office Hours</h3>
                    <div style="margin: 1rem 0;">
                        <div style="display: flex; justify-content: space-between; padding: 0.5rem 0; border-bottom: 1px solid #eee;">
                            <span>Monday - Friday:</span>
                            <span style="font-weight: 600;">8:00 AM - 8:00 PM</span>
                        </div>
                        <div style="display: flex; justify-content: space-between; padding: 0.5rem 0; border-bottom: 1px solid #eee;">
                            <span>Saturday:</span>
                            <span style="font-weight: 600;">9:00 AM - 6:00 PM</span>
                        </div>
                        <div style="display: flex; justify-content: space-between; padding: 0.5rem 0; border-bottom: 1px solid #eee;">
                            <span>Sunday:</span>
                            <span style="font-weight: 600;">10:00 AM - 4:00 PM</span>
                        </div>
                        <div style="display: flex; justify-content: space-between; padding: 0.5rem 0;">
                            <span>Holidays:</span>
                            <span style="font-weight: 600;">Closed</span>
                        </div>
                    </div>
                    <p style="color: var(--info-color); margin-top: 1rem;">📧 Email responses within 24 hours during business days</p>
                </div>
                
                <div style="background: white; padding: 2rem; border-radius: 15px; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
                    <h3>🚗 Lesson Hours</h3>
                    <div style="margin: 1rem 0;">
                        <div style="display: flex; justify-content: space-between; padding: 0.5rem 0; border-bottom: 1px solid #eee;">
                            <span>Monday - Friday:</span>
                            <span style="font-weight: 600;">7:00 AM - 9:00 PM</span>
                        </div>
                        <div style="display: flex; justify-content: space-between; padding: 0.5rem 0; border-bottom: 1px solid #eee;">
                            <span>Saturday:</span>
                            <span style="font-weight: 600;">8:00 AM - 7:00 PM</span>
                        </div>
                        <div style="display: flex; justify-content: space-between; padding: 0.5rem 0; border-bottom: 1px solid #eee;">
                            <span>Sunday:</span>
                            <span style="font-weight: 600;">9:00 AM - 5:00 PM</span>
                        </div>
                        <div style="display: flex; justify-content: space-between; padding: 0.5rem 0;">
                            <span>Holidays:</span>
                            <span style="font-weight: 600;">Limited Hours</span>
                        </div>
                    </div>
                    <p style="color: var(--success-color); margin-top: 1rem;">🌟 Extended hours for your convenience</p>
                </div>
            </div>
        </section>
        
        <!-- Contact Form -->
        <section style="margin: 4rem 0;">
            <h2 style="text-align: center; margin-bottom: 3rem;">📝 Send Us a Message</h2>
            
            <div style="max-width: 800px; margin: 0 auto;">
                <form action="process_contact.php" method="POST" style="background: white; padding: 3rem; border-radius: 20px; box-shadow: 0 15px 40px rgba(0,0,0,0.1);">
                    <?php echo Security::getCSRFField(); ?>
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem; margin-bottom: 2rem;">
                        <div>
                            <label for="name" style="display: block; margin-bottom: 0.5rem; font-weight: 600;">👤 Full Name *</label>
                            <input type="text" id="name" name="name" required style="width: 100%; padding: 1rem; border: 2px solid #e0e0e0; border-radius: 10px; font-size: 1rem; transition: border-color 0.3s ease;" onfocus="this.style.borderColor='var(--primary-color)'" onblur="this.style.borderColor='#e0e0e0'">
                        </div>
                        
                        <div>
                            <label for="email" style="display: block; margin-bottom: 0.5rem; font-weight: 600;">📧 Email Address *</label>
                            <input type="email" id="email" name="email" required style="width: 100%; padding: 1rem; border: 2px solid #e0e0e0; border-radius: 10px; font-size: 1rem; transition: border-color 0.3s ease;" onfocus="this.style.borderColor='var(--primary-color)'" onblur="this.style.borderColor='#e0e0e0'">
                        </div>
                    </div>
                    
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem; margin-bottom: 2rem;">
                        <div>
                            <label for="phone" style="display: block; margin-bottom: 0.5rem; font-weight: 600;">📞 Phone Number</label>
                            <input type="tel" id="phone" name="phone" style="width: 100%; padding: 1rem; border: 2px solid #e0e0e0; border-radius: 10px; font-size: 1rem; transition: border-color 0.3s ease;" onfocus="this.style.borderColor='var(--primary-color)'" onblur="this.style.borderColor='#e0e0e0'">
                        </div>
                        
                        <div>
                            <label for="subject" style="display: block; margin-bottom: 0.5rem; font-weight: 600;">📋 Subject *</label>
                            <select id="subject" name="subject" required style="width: 100%; padding: 1rem; border: 2px solid #e0e0e0; border-radius: 10px; font-size: 1rem; background: white; transition: border-color 0.3s ease;" onfocus="this.style.borderColor='var(--primary-color)'" onblur="this.style.borderColor='#e0e0e0'">
                                <option value="">Select a topic...</option>
                                <option value="lesson-inquiry">🚗 Lesson Inquiry</option>
                                <option value="pricing">💰 Pricing Information</option>
                                <option value="scheduling">📅 Scheduling</option>
                                <option value="support">🛟 Customer Support</option>
                                <option value="feedback">💭 Feedback</option>
                                <option value="other">❓ Other</option>
                            </select>
                        </div>
                    </div>
                    
                    <div style="margin-bottom: 2rem;">
                        <label for="message" style="display: block; margin-bottom: 0.5rem; font-weight: 600;">💬 Your Message *</label>
                        <textarea id="message" name="message" rows="6" required style="width: 100%; padding: 1rem; border: 2px solid #e0e0e0; border-radius: 10px; font-size: 1rem; resize: vertical; font-family: inherit; transition: border-color 0.3s ease;" onfocus="this.style.borderColor='var(--primary-color)'" onblur="this.style.borderColor='#e0e0e0'" placeholder="Tell us how we can help you..."></textarea>
                    </div>
                    
                    <div style="margin-bottom: 2rem;">
                        <label style="display: flex; align-items: center; cursor: pointer;">
                            <input type="checkbox" name="newsletter" style="margin-right: 1rem; transform: scale(1.2);">
                            <span>📧 Subscribe to our newsletter for driving tips and updates</span>
                        </label>
                    </div>
                    
                    <div style="text-align: center;">
                        <button type="submit" class="btn btn-success" style="padding: 1rem 3rem; font-size: 1.1rem;">📤 Send Message</button>
                    </div>
                    
                    <p style="text-align: center; margin-top: 2rem; color: #666; font-size: 0.9rem;">
                        We respect your privacy. Your information will never be shared with third parties.<br>
                        <a href="privacy-policy.php" style="color: var(--primary-color);">View our Privacy Policy</a>
                    </p>
                </form>
            </div>
        </section>
        
        <!-- FAQ -->
        <section style="margin: 4rem 0;">
            <h2 style="text-align: center; margin-bottom: 3rem;">❓ Frequently Asked Questions</h2>
            
            <div style="max-width: 800px; margin: 0 auto;">
                <div style="background: white; border-radius: 15px; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
                    <details style="border-bottom: 1px solid #eee;">
                        <summary style="padding: 2rem; cursor: pointer; font-weight: 600; background: #f8f9fa; transition: background-color 0.3s ease;" onmouseover="this.style.backgroundColor='#e9ecef'" onmouseout="this.style.backgroundColor='#f8f9fa'">📞 How do I schedule my first lesson?</summary>
                        <div style="padding: 2rem; background: white;">
                            <p>You can schedule your first lesson by calling us at (555) 123-DRIVE, using our online booking system after creating an account, or visiting our office. We recommend calling first to discuss your specific needs and find the best instructor match.</p>
                        </div>
                    </details>
                    
                    <details style="border-bottom: 1px solid #eee;">
                        <summary style="padding: 2rem; cursor: pointer; font-weight: 600; background: #f8f9fa; transition: background-color 0.3s ease;" onmouseover="this.style.backgroundColor='#e9ecef'" onmouseout="this.style.backgroundColor='#f8f9fa'">💰 What are your rates and payment options?</summary>
                        <div style="padding: 2rem; background: white;">
                            <p>Our rates vary by package type. Individual lessons start at $45/hour, with package deals offering better value. We accept cash, check, credit cards, and offer payment plans. Contact us for detailed pricing information tailored to your needs.</p>
                        </div>
                    </details>
                    
                    <details style="border-bottom: 1px solid #eee;">
                        <summary style="padding: 2rem; cursor: pointer; font-weight: 600; background: #f8f9fa; transition: background-color 0.3s ease;" onmouseover="this.style.backgroundColor='#e9ecef'" onmouseout="this.style.backgroundColor='#f8f9fa'">🚗 Do you provide vehicles for the driving test?</summary>
                        <div style="padding: 2rem; background: white;">
                            <p>Yes! We provide insured vehicles for driving tests at most DMV locations. This service is available to our students who have completed our training program. Additional fees may apply depending on the test location.</p>
                        </div>
                    </details>
                    
                    <details style="border-bottom: 1px solid #eee;">
                        <summary style="padding: 2rem; cursor: pointer; font-weight: 600; background: #f8f9fa; transition: background-color 0.3s ease;" onmouseover="this.style.backgroundColor='#e9ecef'" onmouseout="this.style.backgroundColor='#f8f9fa'">📅 What is your cancellation policy?</summary>
                        <div style="padding: 2rem; background: white;">
                            <p>We require 24-hour notice for lesson cancellations to avoid charges. Emergency cancellations are handled case-by-case. We understand that schedules change and work with our students to reschedule when needed.</p>
                        </div>
                    </details>
                    
                    <details style="border-bottom: 1px solid #eee;">
                        <summary style="padding: 2rem; cursor: pointer; font-weight: 600; background: #f8f9fa; transition: background-color 0.3s ease;" onmouseover="this.style.backgroundColor='#e9ecef'" onmouseout="this.style.backgroundColor='#f8f9fa'">🆔 What documents do I need to bring?</summary>
                        <div style="padding: 2rem; background: white;">
                            <p>Bring a valid learner's permit or driver's license, proof of insurance (if using your own vehicle), and any required parental consent forms if under 18. We'll provide a complete checklist when you schedule your first lesson.</p>
                        </div>
                    </details>
                    
                    <details>
                        <summary style="padding: 2rem; cursor: pointer; font-weight: 600; background: #f8f9fa; transition: background-color 0.3s ease;" onmouseover="this.style.backgroundColor='#e9ecef'" onmouseout="this.style.backgroundColor='#f8f9fa'">⏰ How long does it take to get my license?</summary>
                        <div style="padding: 2rem; background: white;">
                            <p>Most students complete their training in 4-8 weeks with 1-2 lessons per week. Timeline depends on your starting skill level, practice frequency, and individual learning pace. We work with you to create a personalized schedule that fits your timeline and goals.</p>
                        </div>
                    </details>
                </div>
            </div>
        </section>
        
        <!-- Social Media & Online Presence -->
        <section style="margin: 4rem 0;">
            <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 3rem 2rem; border-radius: 20px; text-align: center;">
                <h2 style="margin-bottom: 2rem;">🌐 Connect With Us Online</h2>
                <p style="font-size: 1.2rem; margin-bottom: 2rem; opacity: 0.9;">Follow us on social media for driving tips, success stories, and updates!</p>
                
                <div style="display: flex; justify-content: center; gap: 2rem; flex-wrap: wrap; margin: 2rem 0;">
                    <a href="#" style="background: rgba(255,255,255,0.2); padding: 1rem 2rem; border-radius: 15px; text-decoration: none; color: white; display: flex; align-items: center; gap: 0.5rem; transition: transform 0.3s ease;" onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='translateY(0)'">
                        <span style="font-size: 1.5rem;">📘</span>
                        <span>Facebook</span>
                    </a>
                    <a href="#" style="background: rgba(255,255,255,0.2); padding: 1rem 2rem; border-radius: 15px; text-decoration: none; color: white; display: flex; align-items: center; gap: 0.5rem; transition: transform 0.3s ease;" onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='translateY(0)'">
                        <span style="font-size: 1.5rem;">📸</span>
                        <span>Instagram</span>
                    </a>
                    <a href="#" style="background: rgba(255,255,255,0.2); padding: 1rem 2rem; border-radius: 15px; text-decoration: none; color: white; display: flex; align-items: center; gap: 0.5rem; transition: transform 0.3s ease;" onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='translateY(0)'">
                        <span style="font-size: 1.5rem;">🐦</span>
                        <span>Twitter</span>
                    </a>
                    <a href="#" style="background: rgba(255,255,255,0.2); padding: 1rem 2rem; border-radius: 15px; text-decoration: none; color: white; display: flex; align-items: center; gap: 0.5rem; transition: transform 0.3s ease;" onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='translateY(0)'">
                        <span style="font-size: 1.5rem;">📺</span>
                        <span>YouTube</span>
                    </a>
                </div>
                
                <p style="margin-top: 2rem;">📧 Or sign up for our email newsletter for exclusive tips and offers!</p>
            </div>
        </section>
        
        <!-- Call to Action -->
        <div style="text-align: center; margin: 4rem 0;">
            <h2 style="margin-bottom: 2rem;">🚀 Ready to Get Started?</h2>
            <p style="font-size: 1.2rem; margin-bottom: 2rem;">Don't wait - start your driving journey today with Origin Driving School!</p>
            <div>
                <a href="register.php" class="btn btn-success" style="margin: 0.5rem;">📝 Register Now</a>
                <a href="tel:5551234374" class="btn" style="margin: 0.5rem;">📞 Call Us</a>
                <a href="index.php#services" class="btn" style="margin: 0.5rem;">💰 View Packages</a>
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
        // Auto-resize textarea
        document.getElementById('message').addEventListener('input', function() {
            this.style.height = 'auto';
            this.style.height = (this.scrollHeight) + 'px';
        });
        
        // Form validation
        document.querySelector('form').addEventListener('submit', function(e) {
            const email = document.getElementById('email').value;
            const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            
            if (!emailPattern.test(email)) {
                e.preventDefault();
                alert('Please enter a valid email address.');
                document.getElementById('email').focus();
            }
        });
    </script>
    
<?php include 'includes/footer.php'; ?>
