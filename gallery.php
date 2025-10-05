<?php
session_start();
$page_title = "Gallery - Origin Driving School";
$page_description = "View our facilities, vehicles, success stories, and happy students at Origin Driving School.";
include 'includes/header.php';
?>

<link rel="stylesheet" href="css/enhanced-styles.css">
<link rel="stylesheet" href="css/css-graphics.css">

<style>
.gallery-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
    gap: 2rem;
    margin: 3rem 0;
}

.gallery-item {
    position: relative;
    height: 300px;
    border-radius: 20px;
    overflow: hidden;
    cursor: pointer;
    transition: all 0.4s ease;
}

.gallery-item:hover {
    transform: scale(1.05);
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
}

.gallery-item img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.6s ease;
}

.gallery-item:hover img {
    transform: scale(1.2);
}

.gallery-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(135deg, rgba(12, 36, 97, 0.9), rgba(255, 215, 0, 0.8));
    display: flex;
    align-items: center;
    justify-content: center;
    flex-direction: column;
    opacity: 0;
    transition: opacity 0.4s ease;
    padding: 2rem;
    text-align: center;
}

.gallery-item:hover .gallery-overlay {
    opacity: 1;
}

.gallery-category {
    margin: 4rem 0;
}

.lightbox {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.95);
    z-index: 10000;
    align-items: center;
    justify-content: center;
}

.lightbox.active {
    display: flex;
}

.lightbox-content {
    max-width: 90%;
    max-height: 90%;
    border-radius: 10px;
}
</style>

<!-- Hero Section -->
<section class="hero-enhanced" style="padding: 6rem 2rem 4rem; text-align: center; color: white;">
    <div class="hero-content" style="max-width: 800px; margin: 0 auto;">
        <div style="font-size: 4rem; margin-bottom: 1rem;" class="floating">📸</div>
        <h1 class="hero-title" style="font-size: 3rem; margin-bottom: 1rem;">Our Gallery</h1>
        <p class="hero-subtitle" style="font-size: 1.3rem; opacity: 0.9;">
            Explore our state-of-the-art facilities, modern vehicles, professional instructors, and happy students achieving their driving goals
        </p>
        <div class="section-divider"></div>
    </div>
</section>

<div class="container">
    
    <!-- Success Stories Category -->
    <div class="gallery-category scroll-reveal">
        <h2 style="text-align: center; color: var(--dashboard-blue); margin-bottom: 1rem; font-size: 2.5rem;">
            🏆 Success Stories
        </h2>
        <p style="text-align: center; color: #666; margin-bottom: 3rem; font-size: 1.2rem;">
            Celebrating our students' achievements and milestones
        </p>
        
        <div class="gallery-grid">
            <div class="gallery-item image-wrapper">
                <img class="image-enhanced" src="images/student holding her driving lisence.png" alt="Student holding her driving license outside the testing center" loading="lazy">
                <div class="gallery-overlay">
                    <h3 style="color: white; font-size: 1.5rem; margin-bottom: 1rem;">First Time Pass!</h3>
                    <p style="color: white;">Emma celebrating her successful driving test on the first attempt</p>
                </div>
            </div>
            <div class="gallery-item image-wrapper">
                <img class="image-enhanced" src="images/happy graduate high fiving teacher.png" alt="Happy graduate high-fiving their instructor after a successful driving test" loading="lazy">
                <div class="gallery-overlay">
                    <h3 style="color: white; font-size: 1.5rem; margin-bottom: 1rem;">New Driver!</h3>
                    <p style="color: white;">James with his new license after completing our intensive course</p>
                </div>
            </div>
            <div class="gallery-item image-wrapper">
                <img class="image-enhanced" src="images/victory photo.png" alt="Student driver taking a victory photo next to their training vehicle" loading="lazy">
                <div class="gallery-overlay">
                    <h3 style="color: white; font-size: 1.5rem; margin-bottom: 1rem;">Perfect Score!</h3>
                    <p style="color: white;">Sarah achieved a perfect score on her driving examination</p>
                </div>
            </div>
            <div class="gallery-item image-wrapper">
                <img class="image-enhanced" src="images/group of graduete celebrating certificates outside scgool.png" alt="Group of graduates celebrating with certificates outside Origin Driving School" loading="lazy">
                <div class="gallery-overlay">
                    <h3 style="color: white; font-size: 1.5rem; margin-bottom: 1rem;">Celebration Day</h3>
                    <p style="color: white;">Families and instructors cheering our new licensed drivers</p>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Our Vehicles Category -->
    <div class="gallery-category scroll-reveal">
        <h2 style="text-align: center; color: var(--dashboard-blue); margin-bottom: 1rem; font-size: 2.5rem;">
            🚙 Our Modern Fleet
        </h2>
        <p style="text-align: center; color: #666; margin-bottom: 3rem; font-size: 1.2rem;">
            Well-maintained, safe vehicles equipped with dual controls and latest safety features
        </p>
        
        <div class="gallery-grid">
            <div class="gallery-item image-wrapper">
                <img class="image-enhanced" src="images/dual control sedan.png" alt="Dual-control sedan in Origin Driving School fleet" loading="lazy">
                <div class="gallery-overlay">
                    <h3 style="color: white; font-size: 1.5rem; margin-bottom: 1rem;">Sedan Training Vehicle</h3>
                    <p style="color: white;">Automatic transmission, dual controls, perfect for beginners</p>
                </div>
            </div>
            <div class="gallery-item image-wrapper">
                <img class="image-enhanced" src="images/suv training.png" alt="SUV training vehicle ready for highway practice" loading="lazy">
                <div class="gallery-overlay">
                    <h3 style="color: white; font-size: 1.5rem; margin-bottom: 1rem;">SUV Training Vehicle</h3>
                    <p style="color: white;">Spacious, comfortable, ideal for highway driving practice</p>
                </div>
            </div>
            <div class="gallery-item image-wrapper">
                <img class="image-enhanced" src="images/hatchback traning.png" alt="Compact hatchback used for precision parking lessons" loading="lazy">
                <div class="gallery-overlay">
                    <h3 style="color: white; font-size: 1.5rem; margin-bottom: 1rem;">Compact Car</h3>
                    <p style="color: white;">Perfect for city driving and parking practice</p>
                </div>
            </div>
            <div class="gallery-item image-wrapper">
                <img class="image-enhanced" src="images/dual control.png" alt="Interior of Origin Driving School vehicle featuring dual controls" loading="lazy">
                <div class="gallery-overlay">
                    <h3 style="color: white; font-size: 1.5rem; margin-bottom: 1rem;">Dual Control Interior</h3>
                    <p style="color: white;">Clean, sanitized interiors with instructor override pedals</p>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Facilities Category -->
    <div class="gallery-category scroll-reveal">
        <h2 style="text-align: center; color: var(--dashboard-blue); margin-bottom: 1rem; font-size: 2.5rem;">
            🏢 Our Facilities
        </h2>
        <p style="text-align: center; color: #666; margin-bottom: 3rem; font-size: 1.2rem;">
            Modern, comfortable learning environment with state-of-the-art amenities
        </p>
        
        <div class="gallery-grid">
            <div class="gallery-item image-wrapper">
                <img class="image-enhanced" src="images/interactive mordern class.png" alt="Modern classroom with interactive displays at Origin Driving School" loading="lazy">
                <div class="gallery-overlay">
                    <h3 style="color: white; font-size: 1.5rem; margin-bottom: 1rem;">Modern Classroom</h3>
                    <p style="color: white;">Interactive learning environment with latest teaching technology</p>
                </div>
            </div>
            <div class="gallery-item image-wrapper">
                <img class="image-enhanced" src="images/outdoor lot cones laid.png" alt="Outdoor practice lot with cones laid out for maneuver training" loading="lazy">
                <div class="gallery-overlay">
                    <h3 style="color: white; font-size: 1.5rem; margin-bottom: 1rem;">Practice Area</h3>
                    <p style="color: white;">Safe, controlled environment for parking and maneuvering practice</p>
                </div>
            </div>
            <div class="gallery-item image-wrapper">
                <img class="image-enhanced" src="images/simulation.png" alt="Students completing theory simulations in digital lab" loading="lazy">
                <div class="gallery-overlay">
                    <h3 style="color: white; font-size: 1.5rem; margin-bottom: 1rem;">Computer Lab</h3>
                    <p style="color: white;">Theory test preparation with interactive simulations</p>
                </div>
            </div>
            <div class="gallery-item image-wrapper">
                <img class="image-enhanced" src="images/studey materials together.png" alt="Student lounge with comfortable seating and study materials" loading="lazy">
                <div class="gallery-overlay">
                    <h3 style="color: white; font-size: 1.5rem; margin-bottom: 1rem;">Student Lounge</h3>
                    <p style="color: white;">Relax before lessons in our bright and comfortable lounge</p>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Instructors in Action Category -->
    <div class="gallery-category scroll-reveal">
        <h2 style="text-align: center; color: var(--dashboard-blue); margin-bottom: 1rem; font-size: 2.5rem;">
            👨‍🏫 Instructors in Action
        </h2>
        <p style="text-align: center; color: #666; margin-bottom: 3rem; font-size: 1.2rem;">
            Our professional instructors providing personalized, patient instruction
        </p>
        
        <div class="gallery-grid">
            <div class="gallery-item image-wrapper">
                <img class="image-enhanced" src="images/instructor giving feedback.png" alt="Driving instructor giving feedback to student inside vehicle" loading="lazy">
                <div class="gallery-overlay">
                    <h3 style="color: white; font-size: 1.5rem; margin-bottom: 1rem;">One-on-One Instruction</h3>
                    <p style="color: white;">Personalized teaching approach tailored to each student</p>
                </div>
            </div>
            <div class="gallery-item image-wrapper">
                <img class="image-enhanced" src="images/high speed lessons.png" alt="Instructor guiding student during high-speed highway session" loading="lazy">
                <div class="gallery-overlay">
                    <h3 style="color: white; font-size: 1.5rem; margin-bottom: 1rem;">Highway Training</h3>
                    <p style="color: white;">Building confidence for high-speed driving situations</p>
                </div>
            </div>
            <div class="gallery-item image-wrapper">
                <img class="image-enhanced" src="images/instructor_1.png" alt="Student practicing precise parking with instructor guidance" loading="lazy">
                <div class="gallery-overlay">
                    <h3 style="color: white; font-size: 1.5rem; margin-bottom: 1rem;">Parking Practice</h3>
                    <p style="color: white;">Mastering parallel parking and tight space maneuvering</p>
                </div>
            </div>
            <div class="gallery-item image-wrapper">
                <img class="image-enhanced" src="images/hazard preception traning.png" alt="Instructor leading simulator-based hazard perception training" loading="lazy">
                <div class="gallery-overlay">
                    <h3 style="color: white; font-size: 1.5rem; margin-bottom: 1rem;">Simulator Coaching</h3>
                    <p style="color: white;">Hazard perception workshops with VR and simulators</p>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Student Life Category -->
    <div class="gallery-category scroll-reveal">
        <h2 style="text-align: center; color: var(--dashboard-blue); margin-bottom: 1rem; font-size: 2.5rem;">
            📚 Student Life
        </h2>
        <p style="text-align: center; color: #666; margin-bottom: 3rem; font-size: 1.2rem;">
            A glimpse into the learning experience at Origin Driving School
        </p>
        
        <div class="gallery-grid">
            <div class="gallery-item image-wrapper">
                <img class="image-enhanced" src="images/student wkeing tgorugh driving theory material together.png" alt="Students working through driving theory materials together" loading="lazy">
                <div class="gallery-overlay">
                    <h3 style="color: white; font-size: 1.5rem; margin-bottom: 1rem;">Theory Classes</h3>
                    <p style="color: white;">Comprehensive road rules and safety education</p>
                </div>
            </div>
            <div class="gallery-item image-wrapper">
                <img class="image-enhanced" src="images/wokrshop at original driving school.png" alt="Learners collaborating during a workshop at Origin Driving School" loading="lazy">
                <div class="gallery-overlay">
                    <h3 style="color: white; font-size: 1.5rem; margin-bottom: 1rem;">Student Community</h3>
                    <p style="color: white;">Supportive learning environment and peer connections</p>
                </div>
            </div>
            <div class="gallery-item image-wrapper">
                <img class="image-enhanced" src="images/celebrating of certificates.png" alt="Graduates celebrating with certificates at Origin Driving School" loading="lazy">
                <div class="gallery-overlay">
                    <h3 style="color: white; font-size: 1.5rem; margin-bottom: 1rem;">Graduation Day</h3>
                    <p style="color: white;">Celebrating successful completion of our programs</p>
                </div>
            </div>
            <div class="gallery-item image-wrapper">
                <img class="image-enhanced" src="images/mentor checking on tablet.png" alt="Mentor checking in with student progress on tablet" loading="lazy">
                <div class="gallery-overlay">
                    <h3 style="color: white; font-size: 1.5rem; margin-bottom: 1rem;">Progress Sessions</h3>
                    <p style="color: white;">Weekly coaching huddles and milestone reviews</p>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Call to Action -->
    <div class="scroll-reveal" style="background: linear-gradient(135deg, #0c2461, #40407a); color: white; padding: 4rem 2rem; border-radius: 25px; text-align: center; margin: 4rem 0;">
        <h2 class="gradient-text" style="font-size: 2.5rem; margin-bottom: 1rem;">Ready to Join Our Success Stories?</h2>
        <p style="font-size: 1.2rem; opacity: 0.9; margin-bottom: 2rem;">
            Experience world-class driving education in our modern facilities with our professional team
        </p>
        <div style="display: flex; justify-content: center; gap: 2rem; flex-wrap: wrap;">
            <a href="register.php" class="btn-enhanced btn-primary-enhanced">
                🚀 Enroll Now
            </a>
            <a href="contact.php" class="btn-enhanced btn-secondary-enhanced" style="background: transparent; border: 2px solid white;">
                📞 Schedule Tour
            </a>
        </div>
    </div>
    
    <!-- Image Upload Information -->
    <div class="glass-card" style="margin: 4rem 0; text-align: center;">
        <h3 style="color: var(--dashboard-blue); margin-bottom: 1rem;">📸 Curated Unsplash Collection</h3>
        <p style="color: #666; line-height: 1.6;">
            Every gallery tile now uses high-resolution photography sourced via Unsplash's free license. Swap any image with your own media at any time:
        </p>
        <ul style="list-style: none; padding: 0; color: #666; margin: 1rem 0;">
            <li>✓ Replace with real students & instructors (with signed photo releases)</li>
            <li>✓ Showcase your branded vehicles and training spaces</li>
            <li>✓ Highlight success stories with license-day photos</li>
            <li>✓ Add BTS clips, reels, or panoramic facility tours</li>
        </ul>
        <p style="color: #999; font-size: 0.9rem; margin-top: 1rem;">
            Refer to images/README.md for detailed image specifications and download attributions
        </p>
    </div>
    
</div>

<!-- Lightbox for Full Screen View -->
<div class="lightbox" id="lightbox" onclick="this.classList.remove('active')">
    <img src="" alt="Gallery Image" class="lightbox-content" id="lightbox-img">
</div>

<script>
// Scroll reveal animation
const observerOptions = {
    threshold: 0.1,
    rootMargin: '0px 0px -50px 0px'
};

const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.classList.add('revealed');
        }
    });
}, observerOptions);

document.querySelectorAll('.scroll-reveal').forEach(el => {
    observer.observe(el);
});

// Gallery click handlers
document.querySelectorAll('.gallery-item').forEach(item => {
    item.addEventListener('click', function() {
        // In production, this would show the full-size image
        console.log('Gallery item clicked');
    });
});
</script>

<?php include 'includes/footer.php'; ?>
