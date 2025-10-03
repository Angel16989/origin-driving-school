<?php
session_start();
$page_title = "Features & Benefits - Origin Driving School";
$page_description = "Discover all the amazing features and benefits that make Origin Driving School the best choice for your driving education.";
include 'includes/header.php';
?>

<link rel="stylesheet" href="css/enhanced-styles.css">
<link rel="stylesheet" href="css/css-graphics.css">

<style>
.feature-showcase {
    position: relative;
    margin: 3rem 0;
    padding: 4rem 2rem;
    border-radius: 25px;
    overflow: hidden;
}

.feature-icon-large {
    font-size: 5rem;
    margin-bottom: 1.5rem;
    display: inline-block;
    animation: float 4s ease-in-out infinite;
}

.comparison-table {
    width: 100%;
    border-collapse: collapse;
    margin: 2rem 0;
    background: white;
    border-radius: 15px;
    overflow: hidden;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
}

.comparison-table th {
    background: linear-gradient(135deg, #0c2461, #40407a);
    color: white;
    padding: 1.5rem;
    text-align: left;
}

.comparison-table td {
    padding: 1.5rem;
    border-bottom: 1px solid #e0e0e0;
}

.comparison-table tr:hover {
    background: #f8f9fa;
}

.check-mark {
    color: #28a745;
    font-size: 1.5rem;
}

.cross-mark {
    color: #dc3545;
    font-size: 1.5rem;
}
</style>

<!-- Hero Section -->
<section class="hero-enhanced hero-with-photo" style="padding: 6rem 2rem 4rem; text-align: center; color: white; background: linear-gradient(135deg, rgba(12, 36, 97, 0.85), rgba(64, 64, 122, 0.78)), url('https://images.unsplash.com/photo-1525609004556-c46c7d6cf023?auto=format&fit=crop&w=2000&q=80'); background-size: cover; background-position: center;">
    <div class="hero-content" style="max-width: 900px; margin: 0 auto;">
        <div class="feature-icon-large">🌟</div>
        <h1 class="hero-title" style="font-size: 3rem; margin-bottom: 1rem;">
            Why <span class="gradient-text">Origin Driving School</span> Stands Out
        </h1>
        <p class="hero-subtitle" style="font-size: 1.3rem; opacity: 0.9; line-height: 1.6;">
            Discover the comprehensive features and benefits that make us the premier choice for driving education. From cutting-edge technology to personalized instruction, we've thought of everything.
        </p>
        <div class="section-divider"></div>
    </div>
</section>

<div class="container">

    <section class="scroll-reveal" style="margin: 4rem 0;">
        <div style="text-align: center; margin-bottom: 3rem;">
            <h2 style="text-align: center; color: var(--dashboard-blue); font-size: 2.5rem; margin-bottom: 1rem;">
                📸 A Look Inside Our Advantage
            </h2>
            <p style="text-align: center; color: #666; font-size: 1.2rem; max-width: 780px; margin: 0 auto;">
                We captured real training moments using free, high-resolution images from Unsplash so you can visualize the Origin experience from day one.
            </p>
        </div>

        <div class="media-grid">
            <div class="media-frame">
                <img src="https://source.unsplash.com/1000x750/?driving,instructor" alt="Instructor explaining dashboard features to student" loading="lazy">
                <div class="media-caption">
                    <span class="media-badge">Coaching</span>
                    Patient guidance inside the vehicle before every session
                </div>
            </div>
            <div class="media-frame">
                <img src="https://source.unsplash.com/1000x750/?driving-simulator,training" alt="Student practicing driving scenario on a simulator" loading="lazy">
                <div class="media-caption">
                    <span class="media-badge">Sim Labs</span>
                    Hazard perception training with immersive simulations
                </div>
            </div>
            <div class="media-frame">
                <img src="https://source.unsplash.com/1000x750/?car,night-driving" alt="Car driving safely along city streets at night" loading="lazy">
                <div class="media-caption">
                    <span class="media-badge">Night Flights</span>
                    Safe-night modules preparing you for low-light conditions
                </div>
            </div>
        </div>
    </section>

    <!-- Technology Features -->
    <section class="scroll-reveal" style="margin: 4rem 0;">
        <h2 style="text-align: center; color: var(--dashboard-blue); font-size: 2.5rem; margin-bottom: 1rem;">
            🚀 Advanced Technology
        </h2>
        <p style="text-align: center; color: #666; font-size: 1.2rem; margin-bottom: 3rem;">
            State-of-the-art technology for the best learning experience
        </p>
        
        <div class="enhanced-grid">
            <div class="card-enhanced glass-card">
                <div class="feature-icon" style="background: linear-gradient(135deg, #667eea, #764ba2);">
                    💻
                </div>
                <h3 style="color: var(--dashboard-blue); margin-bottom: 1rem;">Smart Booking System</h3>
                <p style="color: #666; line-height: 1.6;">
                    Book, reschedule, or cancel lessons 24/7 through our intelligent online platform. Receive instant confirmations and automatic reminders.
                </p>
                <ul style="color: #555; margin-top: 1rem;">
                    <li>✓ Real-time availability</li>
                    <li>✓ Instant confirmations</li>
                    <li>✓ SMS & email reminders</li>
                    <li>✓ Easy rescheduling</li>
                </ul>
            </div>
            
            <div class="card-enhanced glass-card">
                <div class="feature-icon" style="background: linear-gradient(135deg, #28a745, #20c997);">
                    📊
                </div>
                <h3 style="color: var(--dashboard-blue); margin-bottom: 1rem;">Progress Tracking</h3>
                <p style="color: #666; line-height: 1.6;">
                    Monitor your learning journey with detailed progress reports, skill assessments, and personalized recommendations from your instructor.
                </p>
                <ul style="color: #555; margin-top: 1rem;">
                    <li>✓ Skill assessment reports</li>
                    <li>✓ Visual progress charts</li>
                    <li>✓ Instructor feedback</li>
                    <li>✓ Goal tracking</li>
                </ul>
            </div>
            
            <div class="card-enhanced glass-card">
                <div class="feature-icon" style="background: linear-gradient(135deg, #007bff, #6f42c1);">
                    📱
                </div>
                <h3 style="color: var(--dashboard-blue); margin-bottom: 1rem;">Mobile Learning App</h3>
                <p style="color: #666; line-height: 1.6;">
                    Study theory materials, practice tests, and road signs on the go. Access your dashboard anytime, anywhere from your smartphone.
                </p>
                <ul style="color: #555; margin-top: 1rem;">
                    <li>✓ Theory study materials</li>
                    <li>✓ Practice tests</li>
                    <li>✓ Road sign quizzes</li>
                    <li>✓ Video tutorials</li>
                </ul>
            </div>
        </div>
    </section>

    <!-- Vehicle Features -->
    <section class="feature-showcase scroll-reveal" style="background: linear-gradient(135deg, #e3f2fd, #bbdefb);">
        <h2 style="text-align: center; color: var(--dashboard-blue); font-size: 2.5rem; margin-bottom: 3rem;">
            🚗 Premium Training Vehicles
        </h2>
        <div class="media-strip">
            <div class="media-frame">
                <img src="https://source.unsplash.com/800x600/?driving-school,fleet" alt="Row of Origin Driving School vehicles parked outside the academy" loading="lazy">
                <div class="media-gallery-overlay">Fleet inspected weekly with detailed safety checklists</div>
            </div>
            <div class="media-frame">
                <img src="https://source.unsplash.com/800x600/?car-interior,modern" alt="Interior of a modern training vehicle highlighting dashboard" loading="lazy">
                <div class="media-gallery-overlay">Touchscreen dashboards and reverse cameras for modern familiarity</div>
            </div>
            <div class="media-frame">
                <img src="https://source.unsplash.com/800x600/?car-service,maintenance" alt="Technician performing maintenance on a vehicle" loading="lazy">
                <div class="media-gallery-overlay">Certified technicians keep every car in peak condition</div>
            </div>
        </div>
        
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 2rem;">
            <div style="background: white; padding: 2rem; border-radius: 15px; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
                <div style="font-size: 3rem; text-align: center; margin-bottom: 1rem;">🛡️</div>
                <h4 style="color: var(--dashboard-blue);">Safety First</h4>
                <ul style="color: #666;">
                    <li>Dual brake controls</li>
                    <li>Adjustable mirrors</li>
                    <li>Advanced airbag systems</li>
                    <li>Anti-lock braking (ABS)</li>
                    <li>Electronic stability control</li>
                </ul>
            </div>
            
            <div style="background: white; padding: 2rem; border-radius: 15px; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
                <div style="font-size: 3rem; text-align: center; margin-bottom: 1rem;">✨</div>
                <h4 style="color: var(--dashboard-blue);">Modern Comfort</h4>
                <ul style="color: #666;">
                    <li>Climate control A/C</li>
                    <li>Power steering</li>
                    <li>Automatic transmission</li>
                    <li>Bluetooth connectivity</li>
                    <li>Backup cameras</li>
                </ul>
            </div>
            
            <div style="background: white; padding: 2rem; border-radius: 15px; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
                <div style="font-size: 3rem; text-align: center; margin-bottom: 1rem;">🔧</div>
                <h4 style="color: var(--dashboard-blue);">Well Maintained</h4>
                <ul style="color: #666;">
                    <li>Regular service intervals</li>
                    <li>Weekly safety inspections</li>
                    <li>Professional detailing</li>
                    <li>Latest model vehicles</li>
                    <li>Comprehensive insurance</li>
                </ul>
            </div>
        </div>
    </section>

    <!-- Instructor Excellence -->
    <section class="scroll-reveal" style="margin: 4rem 0;">
        <h2 style="text-align: center; color: var(--dashboard-blue); font-size: 2.5rem; margin-bottom: 1rem;">
            👨‍🏫 Expert Instructors
        </h2>
        <p style="text-align: center; color: #666; font-size: 1.2rem; margin-bottom: 3rem;">
            Learn from the best - Our instructors are the heart of our success
        </p>
        
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 2rem;">
            <div class="card-enhanced" style="text-align: center; padding: 2rem;">
                <div class="stat-number" style="color: var(--yellow-line);">100%</div>
                <h4 style="color: var(--dashboard-blue);">Certified Professionals</h4>
                <p style="color: #666;">All instructors hold valid certifications and teaching licenses</p>
            </div>
            
            <div class="card-enhanced" style="text-align: center; padding: 2rem;">
                <div class="stat-number" style="color: var(--yellow-line);">10+</div>
                <h4 style="color: var(--dashboard-blue);">Years Experience</h4>
                <p style="color: #666;">Average experience per instructor in driver education</p>
            </div>
            
            <div class="card-enhanced" style="text-align: center; padding: 2rem;">
                <div class="stat-number" style="color: var(--yellow-line);">4.9/5</div>
                <h4 style="color: var(--dashboard-blue);">Student Rating</h4>
                <p style="color: #666;">Based on thousands of verified student reviews</p>
            </div>
            
            <div class="card-enhanced" style="text-align: center; padding: 2rem;">
                <div class="stat-number" style="color: var(--yellow-line);">500+</div>
                <h4 style="color: var(--dashboard-blue);">Students Taught</h4>
                <p style="color: #666;">Average number of successful students per instructor</p>
            </div>
        </div>
    </section>

    <!-- Comparison Table -->
    <section class="scroll-reveal" style="margin: 4rem 0;">
        <h2 style="text-align: center; color: var(--dashboard-blue); font-size: 2.5rem; margin-bottom: 1rem;">
            ⚖️ How We Compare
        </h2>
        <p style="text-align: center; color: #666; font-size: 1.2rem; margin-bottom: 3rem;">
            See why students choose Origin Driving School over competitors
        </p>
        
        <div style="overflow-x: auto;">
            <table class="comparison-table">
                <thead>
                    <tr>
                        <th>Feature</th>
                        <th style="text-align: center;">Origin Driving School</th>
                        <th style="text-align: center;">Typical Competitor</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><strong>Online Booking System</strong></td>
                        <td style="text-align: center;"><span class="check-mark">✓</span></td>
                        <td style="text-align: center;"><span class="cross-mark">✗</span></td>
                    </tr>
                    <tr>
                        <td><strong>Modern Vehicle Fleet (< 3 years)</strong></td>
                        <td style="text-align: center;"><span class="check-mark">✓</span></td>
                        <td style="text-align: center;"><span class="cross-mark">✗</span></td>
                    </tr>
                    <tr>
                        <td><strong>Progress Tracking Dashboard</strong></td>
                        <td style="text-align: center;"><span class="check-mark">✓</span></td>
                        <td style="text-align: center;"><span class="cross-mark">✗</span></td>
                    </tr>
                    <tr>
                        <td><strong>Mobile Learning App</strong></td>
                        <td style="text-align: center;"><span class="check-mark">✓</span></td>
                        <td style="text-align: center;"><span class="cross-mark">✗</span></td>
                    </tr>
                    <tr>
                        <td><strong>Flexible Scheduling (7 days/week)</strong></td>
                        <td style="text-align: center;"><span class="check-mark">✓</span></td>
                        <td style="text-align: center;">Limited</td>
                    </tr>
                    <tr>
                        <td><strong>Pass Guarantee Program</strong></td>
                        <td style="text-align: center;"><span class="check-mark">✓</span></td>
                        <td style="text-align: center;"><span class="cross-mark">✗</span></td>
                    </tr>
                    <tr>
                        <td><strong>Instructor Choice Option</strong></td>
                        <td style="text-align: center;"><span class="check-mark">✓</span></td>
                        <td style="text-align: center;"><span class="cross-mark">✗</span></td>
                    </tr>
                    <tr>
                        <td><strong>Free Theory Materials</strong></td>
                        <td style="text-align: center;"><span class="check-mark">✓</span></td>
                        <td style="text-align: center;">Extra Cost</td>
                    </tr>
                    <tr>
                        <td><strong>Test Day Vehicle Rental</strong></td>
                        <td style="text-align: center;"><span class="check-mark">✓</span></td>
                        <td style="text-align: center;">Extra Cost</td>
                    </tr>
                    <tr>
                        <td><strong>Money-Back Satisfaction Guarantee</strong></td>
                        <td style="text-align: center;"><span class="check-mark">✓</span></td>
                        <td style="text-align: center;"><span class="cross-mark">✗</span></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </section>

    <!-- Learning Environment -->
    <section class="feature-showcase scroll-reveal" style="background: linear-gradient(135deg, #fff3e0, #ffe0b2);">
        <h2 style="text-align: center; color: var(--dashboard-blue); font-size: 2.5rem; margin-bottom: 3rem;">
            🎓 Superior Learning Environment
        </h2>
        
        <div class="enhanced-grid">
            <div style="text-align: center;">
                <div style="font-size: 4rem; margin-bottom: 1rem;">📚</div>
                <h3 style="color: var(--dashboard-blue); margin-bottom: 1rem;">Comprehensive Curriculum</h3>
                <p style="color: #666; line-height: 1.6;">
                    Our structured curriculum covers everything from basic vehicle control to advanced defensive driving techniques, ensuring you're prepared for all road conditions.
                </p>
            </div>
            
            <div style="text-align: center;">
                <div style="font-size: 4rem; margin-bottom: 1rem;">🏫</div>
                <h3 style="color: var(--dashboard-blue); margin-bottom: 1rem;">Modern Classrooms</h3>
                <p style="color: #666; line-height: 1.6;">
                    Comfortable, well-equipped learning spaces with interactive displays, simulators, and comfortable seating for optimal theory instruction.
                </p>
            </div>
            
            <div style="text-align: center;">
                <div style="font-size: 4rem; margin-bottom: 1rem;">👥</div>
                <h3 style="color: var(--dashboard-blue); margin-bottom: 1rem;">Small Class Sizes</h3>
                <p style="color: #666; line-height: 1.6;">
                    Maximum 8 students per theory class ensures personalized attention and plenty of opportunity for questions and discussion.
                </p>
            </div>
        </div>
    </section>

    <!-- Additional Benefits -->
    <section class="scroll-reveal" style="margin: 4rem 0;">
        <h2 style="text-align: center; color: var(--dashboard-blue); font-size: 2.5rem; margin-bottom: 3rem;">
            🎁 Extra Benefits
        </h2>
        
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 1.5rem;">
            <div class="testimonial-card">
                <h4 style="color: var(--dashboard-blue); margin-bottom: 0.5rem;">🎯 Flexible Payment Plans</h4>
                <p style="color: #666;">Interest-free payment plans available for all packages over $300</p>
            </div>
            
            <div class="testimonial-card">
                <h4 style="color: var(--dashboard-blue); margin-bottom: 0.5rem;">🔄 Free Rescheduling</h4>
                <p style="color: #666;">Reschedule lessons up to 24 hours in advance at no charge</p>
            </div>
            
            <div class="testimonial-card">
                <h4 style="color: var(--dashboard-blue); margin-bottom: 0.5rem;">📖 Study Materials Included</h4>
                <p style="color: #666;">Comprehensive theory books, online resources, and practice tests</p>
            </div>
            
            <div class="testimonial-card">
                <h4 style="color: var(--dashboard-blue); margin-bottom: 0.5rem;">🎁 Referral Rewards</h4>
                <p style="color: #666;">Get $50 credit for each friend you refer who enrolls</p>
            </div>
            
            <div class="testimonial-card">
                <h4 style="color: var(--dashboard-blue); margin-bottom: 0.5rem;">🏆 Performance Bonuses</h4>
                <p style="color: #666;">Free extra lessons for students who pass on first attempt</p>
            </div>
            
            <div class="testimonial-card">
                <h4 style="color: var(--dashboard-blue); margin-bottom: 0.5rem;">🅿️ Free Parking</h4>
                <p style="color: #666;">Complimentary parking for all students and visitors</p>
            </div>
        </div>
    </section>

    <!-- Call to Action -->
    <section class="scroll-reveal" style="background: linear-gradient(135deg, #0c2461, #40407a); color: white; padding: 4rem 2rem; border-radius: 25px; text-align: center; margin: 4rem 0;">
        <h2 style="font-size: 2.5rem; margin-bottom: 1rem;">🌟 Experience the Origin Difference</h2>
        <p style="font-size: 1.2rem; opacity: 0.9; margin-bottom: 2rem; max-width: 700px; margin-left: auto; margin-right: auto;">
            Join thousands of satisfied students who chose Origin Driving School and achieved their driving goals with confidence. Your journey to becoming a skilled, safe driver starts here.
        </p>
        <div style="display: flex; justify-content: center; gap: 2rem; flex-wrap: wrap;">
            <a href="register.php" class="btn-enhanced btn-primary-enhanced">
                🚀 Start Your Journey Today
            </a>
            <a href="contact.php" class="btn-enhanced btn-secondary-enhanced" style="background: transparent; border: 2px solid white;">
                💬 Schedule a Free Consultation
            </a>
        </div>
        
        <div style="margin-top: 3rem; padding-top: 2rem; border-top: 1px solid rgba(255,255,255,0.2);">
            <p style="opacity: 0.8; margin-bottom: 1rem;">📞 Call us now: (555) 123-DRIVE</p>
            <p style="opacity: 0.8;">✉️ Email: info@origindrivingschool.com</p>
        </div>
    </section>

</div>

<?php include 'includes/footer.php'; ?>
