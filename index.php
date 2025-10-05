<?php
// index.php - Origin Driving School - Professional Landing Page
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Origin Driving School | Professional Driving Lessons | Get Your License Fast</title>
    <meta name="description" content="Learn to drive with Origin Driving School - Premier driving instruction with certified instructors, flexible scheduling, and high pass rates. Book your lesson today!">
    <meta name="keywords" content="driving school, driving lessons, learn to drive, driving instructor, driving test, license">
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/enhanced-styles.css">
    <link rel="stylesheet" href="css/css-graphics.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .nav-link:hover { color: var(--yellow-line) !important; }
        .service-card:hover { transform: translateY(-10px); }
        .instructor-card:hover { transform: scale(1.05); }
        .cta-button { transition: all 0.3s ease; }
        .cta-button:hover { transform: translateY(-3px); box-shadow: 0 10px 30px rgba(0,0,0,0.2); }
    </style>
</head>
<body class="page-transition">
    <!-- Professional Navigation Header -->
    <nav class="main-nav" style="background: rgba(12, 36, 97, 0.95); backdrop-filter: blur(20px); padding: 1rem 0; position: fixed; top: 0; left: 0; right: 0; z-index: 1000; box-shadow: 0 4px 20px rgba(0,0,0,0.15);">
        <div style="max-width: 1200px; margin: 0 auto; display: flex; justify-content: space-between; align-items: center; padding: 0 2rem;">
            <div style="display: flex; align-items: center;">
                <div style="width: 50px; height: 50px; background: linear-gradient(135deg, var(--yellow-line), #ffed4e); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; margin-right: 1rem;">🚗</div>
                <div>
                    <h1 style="color: white; font-size: 1.5rem; margin: 0; font-weight: 800;">Origin Driving School</h1>
                    <p style="color: rgba(255,255,255,0.8); font-size: 0.9rem; margin: 0;">Professional Driving Education</p>
                </div>
            </div>
            <div style="display: flex; gap: 2rem; align-items: center;">
                <a href="about.php" class="nav-link" style="color: white; text-decoration: none; font-weight: 500; transition: color 0.3s;">About</a>
                <a href="services.php" class="nav-link" style="color: white; text-decoration: none; font-weight: 500; transition: color 0.3s;">Services</a>
                <a href="instructors.php" class="nav-link" style="color: white; text-decoration: none; font-weight: 500; transition: color 0.3s;">Instructors</a>
                <a href="gallery.php" class="nav-link" style="color: white; text-decoration: none; font-weight: 500; transition: color 0.3s;">Gallery</a>
                <a href="contact.php" class="nav-link" style="color: white; text-decoration: none; font-weight: 500; transition: color 0.3s;">Contact</a>
                <a href="login.php" class="btn cta-button" style="background: var(--yellow-line); color: var(--tire-black); font-size: 0.9rem; padding: 0.8rem 1.5rem;">Student Portal</a>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-enhanced hero-with-photo" style="background: linear-gradient(135deg, rgba(12, 36, 97, 0.85) 0%, rgba(64, 64, 122, 0.8) 100%), url('https://images.unsplash.com/photo-1503376780353-7e6692767b70?auto=format&fit=crop&w=2000&q=80'); color: white; padding: 8rem 2rem 6rem; margin-top: 80px; position: relative; overflow: hidden; background-size: cover; background-position: center;">
        <div style="position: absolute; top: -50%; left: -50%; width: 200%; height: 200%; background: radial-gradient(circle, rgba(255, 215, 0, 0.1) 0%, transparent 70%); animation: containerGlow 15s ease-in-out infinite; pointer-events: none;"></div>
        
        <div class="hero-content" style="max-width: 1200px; margin: 0 auto; text-align: center; position: relative; z-index: 2;">
            <h1 class="hero-title" style="font-size: clamp(3rem, 8vw, 5rem); font-weight: 900; margin-bottom: 1.5rem; line-height: 1.1;">
                Master the Road with <span class="gradient-text" style="color: var(--yellow-line);">Confidence</span>
            </h1>
            <p style="font-size: 1.4rem; margin-bottom: 3rem; opacity: 0.95; max-width: 600px; margin-left: auto; margin-right: auto; line-height: 1.6;">
                Join over 5,000 successful drivers who learned with Origin Driving School's certified instructors and cutting-edge training methods.
            </p>
            <div class="hero-cta" style="display: flex; justify-content: center; gap: 2rem; flex-wrap: wrap; margin-bottom: 4rem;">
                <a href="register.php" class="btn btn-pulse cta-button btn-enhanced btn-primary-enhanced" style="font-size: 1.2rem; padding: 1.5rem 3rem; background: var(--yellow-line); color: var(--tire-black);">
                    🚀 Start Learning Today
                </a>
                <a href="services.php" class="btn cta-button btn-enhanced btn-secondary-enhanced" style="font-size: 1.2rem; padding: 1.5rem 3rem; background: transparent; border: 2px solid rgba(255,255,255,0.3); color: white;">
                    📦 View Packages
                </a>
            </div>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 2rem; max-width: 800px; margin: 0 auto;">
                <div style="text-align: center;">
                    <div style="font-size: 2.5rem; font-weight: 900; color: var(--yellow-line);">98%</div>
                    <div style="opacity: 0.9;">Pass Rate</div>
                </div>
                <div style="text-align: center;">
                    <div style="font-size: 2.5rem; font-weight: 900; color: var(--yellow-line);">5000+</div>
                    <div style="opacity: 0.9;">Happy Students</div>
                </div>
                <div style="text-align: center;">
                    <div style="font-size: 2.5rem; font-weight: 900; color: var(--yellow-line);">50+</div>
                    <div style="opacity: 0.9;">Expert Instructors</div>
                </div>
                <div style="text-align: center;">
                    <div style="font-size: 2.5rem; font-weight: 900; color: var(--yellow-line);">15+</div>
                    <div style="opacity: 0.9;">Years Experience</div>
                </div>
            </div>

            <div class="hero-gallery-grid">
                <div class="media-frame">
                    <span class="media-tag">On the Road</span>
                    <img src="images/thorough streets.png" alt="Instructor guiding a student driver on the road" loading="lazy">
                    <div class="media-gallery-overlay">Expert-led road sessions across real DMV routes</div>
                </div>
                <div class="media-frame">
                    <span class="media-tag">Training Fleet</span>
                    <img src="images/dual control sedan.png" alt="Origin Driving School training vehicles ready for lessons" loading="lazy">
                    <div class="media-gallery-overlay">Modern dual-control vehicles serviced weekly</div>
                </div>
                <div class="media-frame">
                    <span class="media-tag">Classroom</span>
                    <img src="images/interactive mordern class.png" alt="Students reviewing theory materials in a bright classroom" loading="lazy">
                    <div class="media-gallery-overlay">Immersive theory classes with interactive tech</div>
                </div>
            </div>
        </div>
    </section>

    <section style="padding: 4rem 2rem; background: white;">
        <div style="max-width: 1200px; margin: 0 auto;">
            <div style="text-align: center; margin-bottom: 3rem;">
                <h2 style="font-size: 2.5rem; color: var(--dashboard-blue); margin-bottom: 1rem;">Step Inside Origin Driving School</h2>
                <p style="font-size: 1.1rem; color: #555; max-width: 720px; margin: 0 auto; line-height: 1.7;">
                    From smart simulators to real-world road sessions, our media gallery gives you a glimpse of the premium learning environment waiting for you.
                </p>
            </div>

            <div class="media-grid">
                <div class="media-frame">
                    <img src="images/instructor giving feedback.png" alt="Driving instructor coaching a student before a lesson" loading="lazy">
                    <div class="media-caption">
                        <span class="media-badge">1:1 Coaching</span>
                        Personalized in-car strategies built around your goals
                    </div>
                </div>
                <div class="media-frame">
                    <img src="images/student holding her driving lisence.png" alt="Happy graduate holding a fresh driver's license" loading="lazy">
                    <div class="media-caption">
                        <span class="media-badge">Victory Lap</span>
                        Celebrate first-time passes with our team of experts
                    </div>
                </div>
                <div class="media-frame">
                    <img src="images/dual control.png" alt="Car dashboard with dual controls ready for practice" loading="lazy">
                    <div class="media-caption">
                        <span class="media-badge">Dual Controls</span>
                        Safety-first vehicles serviced weekly and sanitized daily
                    </div>
                </div>
                <div class="media-frame">
                    <img src="images/simulation.png" alt="Bright classroom with digital driving simulations" loading="lazy">
                    <div class="media-caption">
                        <span class="media-badge">Smart Theory</span>
                        Interactive workshops, hazard perception labs & VR practice
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" style="padding: 6rem 2rem; background: white;">
        <div style="max-width: 1200px; margin: 0 auto;">
            <div style="text-align: center; margin-bottom: 4rem;">
                <h2 style="font-size: 2.5rem; color: var(--dashboard-blue); margin-bottom: 1rem;">Why Choose Origin Driving School?</h2>
                <p style="font-size: 1.2rem; color: var(--text-dark); max-width: 600px; margin: 0 auto;">
                    With over 15 years of experience and a 98% pass rate, we're the premier choice for driving education in the region.
                </p>
            </div>
            
            <div class="enhanced-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 3rem;">
                <div class="card-enhanced scroll-reveal" style="text-align: center; padding: 2rem;">
                    <div class="feature-icon" style="width: 80px; height: 80px; background: linear-gradient(135deg, var(--green-light), #26de81); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 2rem; margin: 0 auto 2rem; color: white;">✓</div>
                    <h3 style="color: var(--dashboard-blue); margin-bottom: 1rem;">Certified Instructors</h3>
                    <p style="color: var(--text-dark); line-height: 1.6;">All our instructors are fully certified with years of teaching experience and perfect safety records.</p>
                </div>
                <div class="card-enhanced scroll-reveal" style="text-align: center; padding: 2rem;">
                    <div class="feature-icon" style="width: 80px; height: 80px; background: linear-gradient(135deg, var(--blue-light), #3d4de8); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 2rem; margin: 0 auto 2rem; color: white;">📱</div>
                    <h3 style="color: var(--dashboard-blue); margin-bottom: 1rem;">Modern Technology</h3>
                    <p style="color: var(--text-dark); line-height: 1.6;">Advanced booking system, progress tracking, and digital learning materials for the best experience.</p>
                </div>
                <div class="card-enhanced scroll-reveal" style="text-align: center; padding: 2rem;">
                    <div class="feature-icon" style="width: 80px; height: 80px; background: linear-gradient(135deg, var(--orange-signal), #ff9f43); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 2rem; margin: 0 auto 2rem; color: white;">⭐</div>
                    <h3 style="color: var(--dashboard-blue); margin-bottom: 1rem;">Flexible Scheduling</h3>
                    <p style="color: var(--text-dark); line-height: 1.6;">Book lessons at your convenience with our 7-day-a-week availability and easy rescheduling.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section id="services" style="padding: 6rem 2rem; background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);">
        <div style="max-width: 1200px; margin: 0 auto;">
            <div style="text-align: center; margin-bottom: 4rem;">
                <h2 style="font-size: 2.5rem; color: var(--dashboard-blue); margin-bottom: 1rem;">Our Services</h2>
                <p style="font-size: 1.2rem; color: var(--text-dark);">Comprehensive driving education packages tailored to your needs</p>
            </div>
            
            <div class="enhanced-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(350px, 1fr)); gap: 2rem;">
                <!-- Beginner Package -->
                <div class="service-card service-package scroll-reveal glow-on-hover" style="background: white; padding: 3rem 2rem; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.1); text-align: center; transition: transform 0.3s;">
                    <div style="font-size: 3rem; margin-bottom: 1rem;">🚗</div>
                    <h3 style="color: var(--dashboard-blue); margin-bottom: 1rem;">Beginner Package</h3>
                    <div style="font-size: 3rem; font-weight: 900; color: var(--green-light); margin-bottom: 1rem;">$299</div>
                    <ul style="text-align: left; margin-bottom: 2rem; list-style: none; padding: 0;">
                        <li style="padding: 0.5rem 0; border-bottom: 1px solid #eee;">✓ 10 Professional Lessons</li>
                        <li style="padding: 0.5rem 0; border-bottom: 1px solid #eee;">✓ Theory Test Preparation</li>
                        <li style="padding: 0.5rem 0; border-bottom: 1px solid #eee;">✓ Highway Training</li>
                        <li style="padding: 0.5rem 0; border-bottom: 1px solid #eee;">✓ Parallel Parking Mastery</li>
                        <li style="padding: 0.5rem 0;">✓ Test Day Support</li>
                    </ul>
                    <a href="register.php" class="btn btn-success cta-button" style="width: 100%;">Choose This Package</a>
                </div>
                
                <!-- Premium Package -->
                <div class="service-card service-package featured scroll-reveal glow-on-hover" style="background: linear-gradient(135deg, var(--dashboard-blue), #40407a); color: white; padding: 3rem 2rem; border-radius: 20px; box-shadow: 0 15px 40px rgba(12, 36, 97, 0.3); text-align: center; transform: scale(1.05); position: relative; transition: transform 0.3s;">
                    <div style="background: var(--yellow-line); color: var(--tire-black); padding: 0.5rem 1rem; border-radius: 20px; position: absolute; top: -10px; left: 50%; transform: translateX(-50%); font-weight: 700; font-size: 0.9rem;">MOST POPULAR</div>
                    <div style="font-size: 3rem; margin-bottom: 1rem;">🏆</div>
                    <h3 style="margin-bottom: 1rem;">Premium Package</h3>
                    <div style="font-size: 3rem; font-weight: 900; color: var(--yellow-line); margin-bottom: 1rem;">$499</div>
                    <ul style="text-align: left; margin-bottom: 2rem; list-style: none; padding: 0;">
                        <li style="padding: 0.5rem 0; border-bottom: 1px solid rgba(255,255,255,0.2);">✓ 20 Professional Lessons</li>
                        <li style="padding: 0.5rem 0; border-bottom: 1px solid rgba(255,255,255,0.2);">✓ Theory + Hazard Perception</li>
                        <li style="padding: 0.5rem 0; border-bottom: 1px solid rgba(255,255,255,0.2);">✓ Advanced Maneuvers</li>
                        <li style="padding: 0.5rem 0; border-bottom: 1px solid rgba(255,255,255,0.2);">✓ Night & Weather Driving</li>
                        <li style="padding: 0.5rem 0; border-bottom: 1px solid rgba(255,255,255,0.2);">✓ Mock Test Sessions</li>
                        <li style="padding: 0.5rem 0;">✓ Pass Guarantee*</li>
                    </ul>
                    <a href="register.php" class="btn cta-button" style="background: var(--yellow-line); color: var(--tire-black); width: 100%;">Choose This Package</a>
                </div>
                
                <!-- Intensive Course -->
                <div class="service-card service-package scroll-reveal glow-on-hover" style="background: white; padding: 3rem 2rem; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.1); text-align: center; transition: transform 0.3s;">
                    <div style="font-size: 3rem; margin-bottom: 1rem;">⚡</div>
                    <h3 style="color: var(--dashboard-blue); margin-bottom: 1rem;">Intensive Course</h3>
                    <div style="font-size: 3rem; font-weight: 900; color: var(--orange-signal); margin-bottom: 1rem;">$799</div>
                    <ul style="text-align: left; margin-bottom: 2rem; list-style: none; padding: 0;">
                        <li style="padding: 0.5rem 0; border-bottom: 1px solid #eee;">✓ 5-Day Crash Course</li>
                        <li style="padding: 0.5rem 0; border-bottom: 1px solid #eee;">✓ 40 Hours of Training</li>
                        <li style="padding: 0.5rem 0; border-bottom: 1px solid #eee;">✓ Test Booking Included</li>
                        <li style="padding: 0.5rem 0; border-bottom: 1px solid #eee;">✓ One-on-One Instruction</li>
                        <li style="padding: 0.5rem 0;">✓ Fast Track License</li>
                    </ul>
                    <a href="register.php" class="btn btn-warning cta-button" style="width: 100%;">Choose This Package</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section style="padding: 6rem 2rem; background: white;">
        <div style="max-width: 1200px; margin: 0 auto;">
            <div style="text-align: center; margin-bottom: 4rem;">
                <h2 style="font-size: 2.5rem; color: var(--dashboard-blue); margin-bottom: 1rem;">What Our Students Say</h2>
                <p style="font-size: 1.2rem; color: var(--text-dark);">Real success stories from our satisfied students</p>
            </div>
            
            <div class="enhanced-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(350px, 1fr)); gap: 2rem;">
                <div class="testimonial-card scroll-reveal" style="background: linear-gradient(135deg, #f8f9fa 0%, white 100%); padding: 2rem; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
                    <div style="display: flex; margin-bottom: 1rem;">
                        <span style="color: var(--yellow-line); font-size: 1.2rem;">★★★★★</span>
                    </div>
                    <p style="font-style: italic; margin-bottom: 1.5rem; line-height: 1.6;">"Origin Driving School helped me pass my test on the first try! Michael was patient and professional. Highly recommended!"</p>
                    <div style="display: flex; align-items: center;">
                        <div style="width: 50px; height: 50px; background: var(--green-light); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; margin-right: 1rem;">👩</div>
                        <div>
                            <h4 style="margin: 0; color: var(--dashboard-blue);">Emma Johnson</h4>
                            <p style="margin: 0; font-size: 0.9rem; color: var(--text-dark);">Student - Passed March 2024</p>
                        </div>
                    </div>
                </div>
                
                <div style="background: linear-gradient(135deg, #f8f9fa 0%, white 100%); padding: 2rem; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
                    <div style="display: flex; margin-bottom: 1rem;">
                        <span style="color: var(--yellow-line); font-size: 1.2rem;">★★★★★</span>
                    </div>
                    <p style="font-style: italic; margin-bottom: 1.5rem; line-height: 1.6;">"The intensive course was perfect for my busy schedule. Passed in just one week! Amazing instructors and modern teaching methods."</p>
                    <div style="display: flex; align-items: center;">
                        <div style="width: 50px; height: 50px; background: var(--blue-light); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; margin-right: 1rem;">👨</div>
                        <div>
                            <h4 style="margin: 0; color: var(--dashboard-blue);">James Wilson</h4>
                            <p style="margin: 0; font-size: 0.9rem; color: var(--text-dark);">Student - Passed February 2024</p>
                        </div>
                    </div>
                </div>
                
                <div style="background: linear-gradient(135deg, #f8f9fa 0%, white 100%); padding: 2rem; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
                    <div style="display: flex; margin-bottom: 1rem;">
                        <span style="color: var(--yellow-line); font-size: 1.2rem;">★★★★★</span>
                    </div>
                    <p style="font-style: italic; margin-bottom: 1.5rem; line-height: 1.6;">"Sarah made learning to drive so easy and stress-free. The online booking system is fantastic. Will definitely recommend to friends!"</p>
                    <div style="display: flex; align-items: center;">
                        <div style="width: 50px; height: 50px; background: var(--orange-signal); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; margin-right: 1rem;">👩</div>
                        <div>
                            <h4 style="margin: 0; color: var(--dashboard-blue);">Lisa Chen</h4>
                            <p style="margin: 0; font-size: 0.9rem; color: var(--text-dark);">Student - Passed April 2024</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="contact" style="padding: 6rem 2rem; background: linear-gradient(135deg, var(--dashboard-blue) 0%, #40407a 100%); color: white;">
        <div style="max-width: 1200px; margin: 0 auto;">
            <div style="text-align: center; margin-bottom: 4rem;">
                <h2 style="font-size: 2.5rem; margin-bottom: 1rem;">Get In Touch</h2>
                <p style="font-size: 1.2rem; opacity: 0.9;">Ready to start your driving journey? Contact us today!</p>
            </div>
            
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 3rem;">
                <div>
                    <h3 style="margin-bottom: 2rem;">Contact Information</h3>
                    <div style="margin-bottom: 1.5rem; display: flex; align-items: center;">
                        <div style="width: 50px; height: 50px; background: var(--yellow-line); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin-right: 1rem; color: var(--tire-black);">📍</div>
                        <div>
                            <h4 style="margin: 0;">Address</h4>
                            <p style="margin: 0; opacity: 0.8;">123 Driving School Lane, City, ST 12345</p>
                        </div>
                    </div>
                    <div style="margin-bottom: 1.5rem; display: flex; align-items: center;">
                        <div style="width: 50px; height: 50px; background: var(--yellow-line); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin-right: 1rem; color: var(--tire-black);">📞</div>
                        <div>
                            <h4 style="margin: 0;">Phone</h4>
                            <p style="margin: 0; opacity: 0.8;">(555) 123-DRIVE</p>
                        </div>
                    </div>
                    <div style="margin-bottom: 1.5rem; display: flex; align-items: center;">
                        <div style="width: 50px; height: 50px; background: var(--yellow-line); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin-right: 1rem; color: var(--tire-black);">📧</div>
                        <div>
                            <h4 style="margin: 0;">Email</h4>
                            <p style="margin: 0; opacity: 0.8;">info@origindrivingschool.com</p>
                        </div>
                    </div>
                </div>
                
                <div>
                    <h3 style="margin-bottom: 2rem;">Operating Hours</h3>
                    <div style="background: rgba(255,255,255,0.1); padding: 2rem; border-radius: 20px;">
                        <div style="margin-bottom: 1rem; display: flex; justify-content: space-between;">
                            <span>Monday - Friday:</span>
                            <span>8:00 AM - 8:00 PM</span>
                        </div>
                        <div style="margin-bottom: 1rem; display: flex; justify-content: space-between;">
                            <span>Saturday:</span>
                            <span>9:00 AM - 6:00 PM</span>
                        </div>
                        <div style="display: flex; justify-content: space-between;">
                            <span>Sunday:</span>
                            <span>10:00 AM - 4:00 PM</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <div style="text-align: center; margin-top: 4rem;">
                <a href="register.php" class="btn cta-button" style="background: var(--yellow-line); color: var(--tire-black); font-size: 1.2rem; padding: 1.5rem 3rem; margin: 0.5rem;">Start Learning Today</a>
                <a href="login.php" class="btn cta-button" style="background: transparent; border: 2px solid rgba(255,255,255,0.3); color: white; font-size: 1.2rem; padding: 1.5rem 3rem; margin: 0.5rem;">Student Login</a>
            </div>
        </div>
    </section>

    <!-- Group Members Section (DWIN309 Requirement) -->
    <section id="team" style="background: white; padding: 4rem 2rem;">
        <div style="max-width: 1200px; margin: 0 auto;">
            <h2 style="text-align: center; font-size: 2.5rem; margin-bottom: 1rem; color: var(--dashboard-blue);">👥 Development Team</h2>
            <p style="text-align: center; color: #666; margin-bottom: 3rem; font-size: 1.1rem;">Meet the team behind Origin Driving School Management System</p>
            
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 2rem; margin-bottom: 3rem;">
                <!-- Member 1 -->
                <div style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); padding: 2rem; border-radius: 15px; text-align: center; box-shadow: 0 5px 20px rgba(0,0,0,0.1);">
                    <div style="width: 80px; height: 80px; background: linear-gradient(135deg, var(--dashboard-blue), #40407a); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 2rem; margin: 0 auto 1rem; color: white;">�‍💻</div>
                    <h3 style="margin-bottom: 0.5rem; color: var(--dashboard-blue);">Ms Isha Shrestha</h3>
                    <p style="color: #666; margin-bottom: 0.5rem; font-size: 0.9rem;"><strong>Student ID:</strong> K241002</p>
                    <div style="background: white; padding: 1rem; border-radius: 10px; margin-top: 1rem;">
                        <p style="margin: 0; font-weight: 600; color: var(--dashboard-blue); margin-bottom: 0.5rem;">Implemented:</p>
                        <ul style="text-align: left; color: #666; font-size: 0.9rem; line-height: 1.6;">
                            <li>Student Management Module</li>
                            <li>User Registration & Authentication</li>
                            <li>Database Design & Setup</li>
                            <li>Frontend UI/UX Design</li>
                        </ul>
                    </div>
                </div>

                <!-- Member 2 -->
                <div style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); padding: 2rem; border-radius: 15px; text-align: center; box-shadow: 0 5px 20px rgba(0,0,0,0.1);">
                    <div style="width: 80px; height: 80px; background: linear-gradient(135deg, var(--dashboard-blue), #40407a); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 2rem; margin: 0 auto 1rem; color: white;">👨‍💻</div>
                    <h3 style="margin-bottom: 0.5rem; color: var(--dashboard-blue);">Mr Rojan Shrestha</h3>
                    <p style="color: #666; margin-bottom: 0.5rem; font-size: 0.9rem;"><strong>Student ID:</strong> K240867</p>
                    <div style="background: white; padding: 1rem; border-radius: 10px; margin-top: 1rem;">
                        <p style="margin: 0; font-weight: 600; color: var(--dashboard-blue); margin-bottom: 0.5rem;">Implemented:</p>
                        <ul style="text-align: left; color: #666; font-size: 0.9rem; line-height: 1.6;">
                            <li>Instructor Management System</li>
                            <li>Scheduling & Booking Module</li>
                            <li>Backend PHP Logic</li>
                            <li>Security Implementation</li>
                        </ul>
                    </div>
                </div>

                <!-- Member 3 -->
                <div style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); padding: 2rem; border-radius: 15px; text-align: center; box-shadow: 0 5px 20px rgba(0,0,0,0.1);">
                    <div style="width: 80px; height: 80px; background: linear-gradient(135deg, var(--dashboard-blue), #40407a); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 2rem; margin: 0 auto 1rem; color: white;">👨‍💻</div>
                    <h3 style="margin-bottom: 0.5rem; color: var(--dashboard-blue);">Mr Rasik Tiwari</h3>
                    <p style="color: #666; margin-bottom: 0.5rem; font-size: 0.9rem;"><strong>Student ID:</strong> K240750</p>
                    <div style="background: white; padding: 1rem; border-radius: 10px; margin-top: 1rem;">
                        <p style="margin: 0; font-weight: 600; color: var(--dashboard-blue); margin-bottom: 0.5rem;">Implemented:</p>
                        <ul style="text-align: left; color: #666; font-size: 0.9rem; line-height: 1.6;">
                            <li>Financial Management Module</li>
                            <li>Reports & Analytics System</li>
                            <li>Communication Features</li>
                            <li>Testing & Documentation</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer (DWIN309 Compliant) -->
    <footer style="background: var(--road-dark); color: white; padding: 3rem 2rem 2rem; text-align: center;">
        <div style="max-width: 1200px; margin: 0 auto;">
            <div style="display: flex; justify-content: center; align-items: center; margin-bottom: 2rem;">
                <div style="width: 60px; height: 60px; background: linear-gradient(135deg, var(--yellow-line), #ffed4e); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 2rem; margin-right: 1rem;">🚗</div>
                <div>
                    <h3 style="margin: 0; font-size: 1.5rem;">Origin Driving School</h3>
                    <p style="margin: 0; opacity: 0.8;">Professional Driving Education</p>
                </div>
            </div>
            
            <!-- DWIN309 Required Footer Text -->
            <div style="background: rgba(255,255,255,0.1); padding: 1.5rem; border-radius: 10px; margin-bottom: 2rem;">
                <p style="margin: 0; font-size: 1rem; line-height: 1.6;">
                    This website was created by <strong>Ms Isha Shrestha (K241002), Mr Rojan Shrestha (K240867), and Mr Rasik Tiwari (K240750)</strong> for the final assessment of <strong>DWIN309</strong> at <strong>Kent Institute Australia</strong>.
                </p>
            </div>
            
            <div style="border-top: 1px solid rgba(255,255,255,0.2); padding-top: 2rem; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
                <p style="margin: 0; opacity: 0.8;">&copy; 2025 Origin Driving School. All rights reserved.</p>
                <div style="display: flex; gap: 2rem;">
                    <a href="privacy-policy.php" style="color: rgba(255,255,255,0.8); text-decoration: none;">Privacy Policy</a>
                    <a href="terms-of-service.php" style="color: rgba(255,255,255,0.8); text-decoration: none;">Terms of Service</a>
                    <a href="contact.php" style="color: rgba(255,255,255,0.8); text-decoration: none;">Contact</a>
                </div>
            </div>
        </div>
    </footer>

    <script>
        // Smooth scrolling for navigation links - Only for same-page anchors on index page
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                const href = this.getAttribute('href');
                // Only handle anchor links that exist on this page
                if (href.startsWith('#') && href.length > 1) {
                    const target = document.querySelector(href);
                    if (target && target.offsetParent !== null) { // Check if element exists and is visible
                        e.preventDefault();
                        target.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }
                }
                // Let normal page navigation work for .php links
            });
        });

        // Add scroll effect to navigation
        window.addEventListener('scroll', function() {
            const nav = document.querySelector('.main-nav');
            if (window.scrollY > 100) {
                nav.style.background = 'rgba(12, 36, 97, 0.98)';
            } else {
                nav.style.background = 'rgba(12, 36, 97, 0.95)';
            }
        });
        
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
    </script>
</body>
</html>
