<?php
session_start();
$page_title = "Our Services - Origin Driving School";
$page_description = "Explore our comprehensive driving education services - from beginner lessons to advanced training.";
include 'includes/header.php';
?>

<link rel="stylesheet" href="css/enhanced-styles.css">

<style>
/* Desktop-Specific Services Page Styles */
@media screen and (min-width: 1024px) {
    .services-hero {
        padding: 8rem 2rem 6rem !important;
    }
    
    .services-hero h2 {
        font-size: 4.5rem !important;
    }
    
    .services-hero p {
        font-size: 1.8rem !important;
    }
    
    .services-section {
        padding: 5rem 2rem !important;
    }
    
    .services-grid {
        grid-template-columns: repeat(auto-fit, minmax(450px, 1fr)) !important;
        gap: 4rem !important;
    }
    
    .service-card {
        padding: 3rem !important;
        font-size: 1.3rem !important;
        min-height: 400px !important;
    }
    
    .service-card h3 {
        font-size: 2.2rem !important;
    }
    
    .price-tag {
        font-size: 1.6rem !important;
    }
    
    .service-card ul li {
        font-size: 1.1rem !important;
        margin: 8px 0 !important;
    }
}
</style>

    <!-- Hero Section -->
    <section class="services-hero hero-with-photo" style="background: linear-gradient(135deg, rgba(12, 36, 97, 0.82) 0%, rgba(64, 64, 122, 0.78) 100%), url('https://images.unsplash.com/photo-1529429617124-aee318cd0b08?auto=format&fit=crop&w=2000&q=80'); color: white; padding: 6rem 2rem 4rem; position: relative; overflow: hidden; background-size: cover; background-position: center;">
        <div style="position: absolute; top: -50%; left: -50%; width: 200%; height: 200%; background: radial-gradient(circle, rgba(255, 215, 0, 0.1) 0%, transparent 70%); animation: containerGlow 15s ease-in-out infinite; pointer-events: none;"></div>
        
        <div style="max-width: 1200px; margin: 0 auto; text-align: center; position: relative; z-index: 2;">
            <div style="font-size: 4rem; margin-bottom: 1rem;">🎯</div>
            <h2 style="font-size: 2.5rem; margin-bottom: 1rem;">Comprehensive Driving Education</h2>
            <p style="font-size: 1.2rem; opacity: 0.9; max-width: 600px; margin: 0 auto;">From your first lesson to advanced defensive driving, we offer complete training programs designed to make you a confident, skilled driver.</p>
        </div>
    </section>

    <div class="container">
        <section style="margin: 4rem 0;">
            <h2 style="text-align: center; margin-bottom: 1rem; color: var(--dashboard-blue);">What Our Lessons Look Like</h2>
            <p style="text-align: center; max-width: 760px; margin: 0 auto 3rem; color: #555; font-size: 1.1rem;">
                These Unsplash-powered snapshots showcase the energy of our in-person and on-road coaching. Swap them with your own photos anytime to personalize the experience.
            </p>
            <div class="media-grid">
                <div class="media-frame">
                    <img src="images/thorough streets.png" alt="Instructor guiding student through city streets" loading="lazy">
                    <div class="media-caption">
                        <span class="media-badge">City Skills</span>
                        Handling busy intersections and roundabouts with confidence
                    </div>
                </div>
                <div class="media-frame">
                    <img src="images/checking mirror.png" alt="Student checking mirrors before maneuver" loading="lazy">
                    <div class="media-caption">
                        <span class="media-badge">Awareness</span>
                        Building habits around mirrors, indicators, and planning ahead
                    </div>
                </div>
                <div class="media-frame">
                    <img src="images/pedal advice.png" alt="Close-up of instructor providing pedal feedback" loading="lazy">
                    <div class="media-caption">
                        <span class="media-badge">Precision</span>
                        Smooth acceleration and braking with gentle instructor cues
                    </div>
                </div>
            </div>
        </section>

        <!-- Services Overview -->
        <section class="services-section" style="margin: 4rem 0;">
            <h2 style="text-align: center; margin-bottom: 3rem; color: var(--dashboard-blue);">🚗 Our Driving Services</h2>
            
            <div class="services-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(350px, 1fr)); gap: 2rem;">

                <!-- Beginner Lessons -->
                <div class="service-card" style="background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%); padding: 2rem; border-radius: 15px; text-align: center; box-shadow: 0 10px 30px rgba(0,0,0,0.1); position: relative;">
                    <div style="font-size: 3rem; margin-bottom: 1rem;">🔰</div>
                    <h3 style="color: var(--dashboard-blue); margin-bottom: 1rem;">Beginner Lessons</h3>
                    <p style="color: #666; margin-bottom: 1.5rem; line-height: 1.6;">
                        Perfect for first-time drivers. Learn the basics of vehicle control, traffic rules, and road safety with our patient, certified instructors.
                    </p>
                    <ul style="text-align: left; color: #555; margin-bottom: 2rem;">
                        <li>✓ Vehicle familiarization</li>
                        <li>✓ Basic controls & safety</li>
                        <li>✓ Traffic rules & signs</li>
                        <li>✓ Parking techniques</li>
                        <li>✓ Road test preparation</li>
                    </ul>
                    <div class="price-tag" style="background: var(--dashboard-blue); color: white; padding: 1rem; border-radius: 10px; font-weight: bold; margin-bottom: 1rem;">
                        $75 per lesson
                    </div>
                    <a href="book_lesson.php" style="background: #28a745; color: white; padding: 0.8rem 2rem; border-radius: 25px; text-decoration: none; font-weight: 500;">Book Now</a>
                </div>

                <!-- Intermediate Training -->
                <div class="service-card" style="background: linear-gradient(135deg, #e8f5e8 0%, #c8e6c9 100%); padding: 2rem; border-radius: 15px; text-align: center; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
                    <div style="font-size: 3rem; margin-bottom: 1rem;">⚡</div>
                    <h3 style="color: var(--dashboard-blue); margin-bottom: 1rem;">Intermediate Training</h3>
                    <p style="color: #666; margin-bottom: 1.5rem; line-height: 1.6;">
                        Build confidence with city driving, highway navigation, and challenging traffic situations. Perfect for building real-world skills.
                    </p>
                    <ul style="text-align: left; color: #555; margin-bottom: 2rem;">
                        <li>✓ City & highway driving</li>
                        <li>✓ Complex intersections</li>
                        <li>✓ Merge & lane changes</li>
                        <li>✓ Weather conditions</li>
                        <li>✓ Confidence building</li>
                    </ul>
                    <div class="price-tag" style="background: var(--dashboard-blue); color: white; padding: 1rem; border-radius: 10px; font-weight: bold; margin-bottom: 1rem;">
                        $85 per lesson
                    </div>
                    <a href="book_lesson.php" style="background: #28a745; color: white; padding: 0.8rem 2rem; border-radius: 25px; text-decoration: none; font-weight: 500;">Book Now</a>
                </div>

                <!-- Advanced & Defensive -->
                <div class="service-card" style="background: linear-gradient(135deg, #fff3e0 0%, #ffcc80 100%); padding: 2rem; border-radius: 15px; text-align: center; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
                    <div style="font-size: 3rem; margin-bottom: 1rem;">🛡️</div>
                    <h3 style="color: var(--dashboard-blue); margin-bottom: 1rem;">Advanced & Defensive</h3>
                    <p style="color: #666; margin-bottom: 1.5rem; line-height: 1.6;">
                        Master advanced techniques and defensive driving strategies. Ideal for experienced drivers wanting to enhance their skills.
                    </p>
                    <ul style="text-align: left; color: #555; margin-bottom: 2rem;">
                        <li>✓ Defensive driving techniques</li>
                        <li>✓ Emergency maneuvers</li>
                        <li>✓ Night & adverse weather</li>
                        <li>✓ Advanced parking</li>
                        <li>✓ Accident avoidance</li>
                    </ul>
                    <div class="price-tag" style="background: var(--dashboard-blue); color: white; padding: 1rem; border-radius: 10px; font-weight: bold; margin-bottom: 1rem;">
                        $95 per lesson
                    </div>
                    <a href="book_lesson.php" style="background: #28a745; color: white; padding: 0.8rem 2rem; border-radius: 25px; text-decoration: none; font-weight: 500;">Book Now</a>
                </div>

                <!-- Road Test Prep -->
                <div class="service-card" style="background: linear-gradient(135deg, #f3e5f5 0%, #e1bee7 100%); padding: 2rem; border-radius: 15px; text-align: center; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
                    <div style="font-size: 3rem; margin-bottom: 1rem;">🎯</div>
                    <h3 style="color: var(--dashboard-blue); margin-bottom: 1rem;">Road Test Preparation</h3>
                    <p style="color: #666; margin-bottom: 1.5rem; line-height: 1.6;">
                        Intensive preparation for your driving test. We'll ensure you're confident and ready to pass on your first attempt.
                    </p>
                    <ul style="text-align: left; color: #555; margin-bottom: 2rem;">
                        <li>✓ Test route practice</li>
                        <li>✓ Common mistake prevention</li>
                        <li>✓ Parallel parking mastery</li>
                        <li>✓ Pre-test mock exams</li>
                        <li>✓ Confidence building</li>
                    </ul>
                    <div class="price-tag" style="background: var(--dashboard-blue); color: white; padding: 1rem; border-radius: 10px; font-weight: bold; margin-bottom: 1rem;">
                        $90 per lesson
                    </div>
                    <a href="book_lesson.php" style="background: #28a745; color: white; padding: 0.8rem 2rem; border-radius: 25px; text-decoration: none; font-weight: 500;">Book Now</a>
                </div>

                <!-- Package Deals -->
                <div class="service-card" style="background: linear-gradient(135deg, #fce4ec 0%, #f8bbd9 100%); padding: 2rem; border-radius: 15px; text-align: center; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
                    <div style="font-size: 3rem; margin-bottom: 1rem;">📦</div>
                    <h3 style="color: var(--dashboard-blue); margin-bottom: 1rem;">Package Deals</h3>
                    <p style="color: #666; margin-bottom: 1.5rem; line-height: 1.6;">
                        Save money with our comprehensive packages. Multiple lessons at discounted rates for committed learners.
                    </p>
                    <ul style="text-align: left; color: #555; margin-bottom: 2rem;">
                        <li>✓ 5-lesson package: 10% off</li>
                        <li>✓ 10-lesson package: 15% off</li>
                        <li>✓ 20-lesson package: 20% off</li>
                        <li>✓ Flexible scheduling</li>
                        <li>✓ Progress tracking</li>
                    </ul>
                    <div class="price-tag" style="background: var(--dashboard-blue); color: white; padding: 1rem; border-radius: 10px; font-weight: bold; margin-bottom: 1rem;">
                        From $340 (5-pack)
                    </div>
                    <a href="book_lesson.php" style="background: #28a745; color: white; padding: 0.8rem 2rem; border-radius: 25px; text-decoration: none; font-weight: 500;">Book Package</a>
                </div>

                <!-- Refresher Courses -->
                <div class="service-card" style="background: linear-gradient(135deg, #e0f2f1 0%, #b2dfdb 100%); padding: 2rem; border-radius: 15px; text-align: center; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
                    <div style="font-size: 3rem; margin-bottom: 1rem;">🔄</div>
                    <h3 style="color: var(--dashboard-blue); margin-bottom: 1rem;">Refresher Courses</h3>
                    <p style="color: #666; margin-bottom: 1.5rem; line-height: 1.6;">
                        Perfect for drivers returning to the road after a break or those wanting to update their skills with current best practices.
                    </p>
                    <ul style="text-align: left; color: #555; margin-bottom: 2rem;">
                        <li>✓ Skill assessment</li>
                        <li>✓ Updated traffic laws</li>
                        <li>✓ Confidence restoration</li>
                        <li>✓ Modern vehicle features</li>
                        <li>✓ Personalized focus areas</li>
                    </ul>
                    <div class="price-tag" style="background: var(--dashboard-blue); color: white; padding: 1rem; border-radius: 10px; font-weight: bold; margin-bottom: 1rem;">
                        $80 per lesson
                    </div>
                    <a href="book_lesson.php" style="background: #28a745; color: white; padding: 0.8rem 2rem; border-radius: 25px; text-decoration: none; font-weight: 500;">Book Now</a>
                </div>
            </div>
        </section>

        <!-- Why Choose Our Services -->
        <section style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 4rem 2rem; border-radius: 20px; text-align: center; margin: 4rem 0;">
            <h2 style="margin-bottom: 2rem;">Why Choose Our Driving Services?</h2>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 2rem; max-width: 1000px; margin: 0 auto;">
                <div>
                    <div style="font-size: 2.5rem; margin-bottom: 1rem;">👨‍🏫</div>
                    <h4>Certified Instructors</h4>
                    <p style="opacity: 0.9;">All our instructors are professionally certified and experienced in modern driving techniques.</p>
                </div>
                <div>
                    <div style="font-size: 2.5rem; margin-bottom: 1rem;">🚗</div>
                    <h4>Modern Vehicles</h4>
                    <p style="opacity: 0.9;">Learn in safe, well-maintained vehicles equipped with the latest safety features.</p>
                </div>
                <div>
                    <div style="font-size: 2.5rem; margin-bottom: 1rem;">📅</div>
                    <h4>Flexible Scheduling</h4>
                    <p style="opacity: 0.9;">Book lessons at your convenience with our flexible scheduling system.</p>
                </div>
                <div>
                    <div style="font-size: 2.5rem; margin-bottom: 1rem;">💯</div>
                    <h4>High Success Rate</h4>
                    <p style="opacity: 0.9;">95% of our students pass their road test on the first attempt.</p>
                </div>
            </div>
        </section>

        <!-- Call to Action -->
        <section style="text-align: center; margin: 4rem 0;">
            <h2 style="color: var(--dashboard-blue); margin-bottom: 2rem;">Ready to Start Your Driving Journey?</h2>
            <p style="font-size: 1.2rem; color: #666; margin-bottom: 2rem; max-width: 600px; margin-left: auto; margin-right: auto;">
                Contact us today to discuss your learning goals and find the perfect service package for your needs.
            </p>
            <div style="display: flex; justify-content: center; gap: 2rem; flex-wrap: wrap;">
                <a href="book_lesson.php" style="background: var(--dashboard-blue); color: white; padding: 1rem 2rem; border-radius: 25px; text-decoration: none; font-weight: bold; font-size: 1.1rem;">
                    📅 Book a Lesson
                </a>
                <a href="contact.php" style="background: #28a745; color: white; padding: 1rem 2rem; border-radius: 25px; text-decoration: none; font-weight: bold; font-size: 1.1rem;">
                    💬 Contact Us
                </a>
            </div>
        </section>
    </div>

<?php include 'includes/footer.php'; ?>
