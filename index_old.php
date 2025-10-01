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
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
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
                <a href="#about" class="nav-link" style="color: white; text-decoration: none; font-weight: 500; transition: color 0.3s;">About</a>
                <a href="#services" class="nav-link" style="color: white; text-decoration: none; font-weight: 500; transition: color 0.3s;">Services</a>
                <a href="#instructors" class="nav-link" style="color: white; text-decoration: none; font-weight: 500; transition: color 0.3s;">Instructors</a>
                <a href="#contact" class="nav-link" style="color: white; text-decoration: none; font-weight: 500; transition: color 0.3s;">Contact</a>
                <a href="login.php" class="btn" style="background: var(--yellow-line); color: var(--tire-black); font-size: 0.9rem; padding: 0.8rem 1.5rem;">Student Portal</a>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section style="background: linear-gradient(135deg, var(--dashboard-blue) 0%, #40407a 100%); color: white; padding: 8rem 2rem 6rem; margin-top: 80px; position: relative; overflow: hidden;">
        <!-- Background Animation -->
        <div style="position: absolute; top: -50%; left: -50%; width: 200%; height: 200%; background: radial-gradient(circle, rgba(255, 215, 0, 0.1) 0%, transparent 70%); animation: containerGlow 15s ease-in-out infinite; pointer-events: none;"></div>
        
        <div style="max-width: 1200px; margin: 0 auto; text-align: center; position: relative; z-index: 2;">
            <h1 style="font-size: clamp(3rem, 8vw, 5rem); font-weight: 900; margin-bottom: 1.5rem; line-height: 1.1;">
                Master the Road with <span style="color: var(--yellow-line);">Confidence</span>
            </h1>
            <p style="font-size: 1.4rem; margin-bottom: 3rem; opacity: 0.95; max-width: 600px; margin-left: auto; margin-right: auto; line-height: 1.6;">
                Join over 5,000 successful drivers who learned with Origin Driving School's certified instructors and cutting-edge training methods.
            </p>
            <div style="display: flex; justify-content: center; gap: 2rem; flex-wrap: wrap;">
                <a href="register.php" class="btn btn-pulse" style="font-size: 1.2rem; padding: 1.5rem 3rem; background: var(--yellow-line); color: var(--tire-black);">
                    Start Learning Today
                </a>
                <a href="#services" class="btn" style="font-size: 1.2rem; padding: 1.5rem 3rem; background: transparent; border: 2px solid rgba(255,255,255,0.3); color: white;">
                    View Packages
                </a>
            </div>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 2rem; margin-top: 4rem; max-width: 800px; margin-left: auto; margin-right: auto;">
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
        </div>
    </section>
    
    <div class="container">
        <!-- Hero Section with Car Theme -->
        <div style="text-align: center; margin-bottom: 4rem; padding: 3rem; background: linear-gradient(135deg, var(--dashboard-blue) 0%, #40407a 100%); color: white; border-radius: 25px; position: relative; overflow: hidden;">
            <div style="position: absolute; top: -50%; left: -50%; width: 200%; height: 200%; background: radial-gradient(circle, rgba(255, 215, 0, 0.1) 0%, transparent 70%); animation: containerGlow 10s ease-in-out infinite; pointer-events: none;"></div>
            
            <h2 style="font-size: 3rem; margin-bottom: 1rem; position: relative; z-index: 2;">
                🎯 Master the Road with Confidence!
            </h2>
            <p style="font-size: 1.4rem; margin-bottom: 2rem; opacity: 0.9; position: relative; z-index: 2;">
                Experience premium driving education with state-of-the-art management technology
            </p>
            
            <div style="display: flex; justify-content: center; gap: 2rem; margin-top: 2rem; position: relative; z-index: 2;">
                <a href="login.php" class="btn btn-pulse" style="font-size: 1.3rem; padding: 1.2rem 3rem;">
                    🚗 Start Your Journey
                </a>
                <a href="register.php" class="btn" style="font-size: 1.3rem; padding: 1.2rem 3rem; background: rgba(255,255,255,0.2); border: 2px solid rgba(255,255,255,0.3);">
                    📝 Join Our School
                </a>
            </div>
        </div>

        <!-- Feature Cards with Automotive Design -->
        <h2 style="text-align: center; margin-bottom: 3rem; color: var(--dashboard-blue); font-size: 2.5rem;">
            🏆 Premium Driving School Features
        </h2>
        
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 2.5rem; margin: 3rem 0;">
            <!-- Student Management -->
            <div class="stat-card student-card" style="text-align: center; padding: 3rem 2rem; cursor: default;">
                <div style="font-size: 4rem; margin-bottom: 1rem;">👥</div>
                <h3 style="color: white; margin-bottom: 1rem; font-size: 1.5rem;">Student Management</h3>
                <p style="color: rgba(255,255,255,0.9); line-height: 1.6;">
                    Complete student profile management with progress tracking, lesson history, and digital licensing integration.
                </p>
                <div style="margin-top: 2rem;">
                    <span class="status-badge success" style="margin: 0.2rem;">✅ Progress Tracking</span>
                    <span class="status-badge success" style="margin: 0.2rem;">✅ Digital Profiles</span>
                    <span class="status-badge success" style="margin: 0.2rem;">✅ License Management</span>
                </div>
            </div>
            
            <!-- Instructor Management -->
            <div class="stat-card instructor-card" style="text-align: center; padding: 3rem 2rem; cursor: default;">
                <div style="font-size: 4rem; margin-bottom: 1rem;">👨‍🏫</div>
                <h3 style="color: white; margin-bottom: 1rem; font-size: 1.5rem;">Expert Instructors</h3>
                <p style="color: rgba(255,255,255,0.9); line-height: 1.6;">
                    Certified professional instructors with advanced scheduling systems and performance analytics.
                </p>
                <div style="margin-top: 2rem;">
                    <span class="status-badge warning" style="margin: 0.2rem;">🎓 Certified Pros</span>
                    <span class="status-badge warning" style="margin: 0.2rem;">📅 Smart Scheduling</span>
                    <span class="status-badge warning" style="margin: 0.2rem;">📊 Performance Metrics</span>
                </div>
            </div>
            
            <!-- Smart Booking -->
            <div class="stat-card admin-card" style="text-align: center; padding: 3rem 2rem; cursor: default;">
                <div style="font-size: 4rem; margin-bottom: 1rem;">📅</div>
                <h3 style="color: white; margin-bottom: 1rem; font-size: 1.5rem;">Smart Booking System</h3>
                <p style="color: rgba(255,255,255,0.9); line-height: 1.6;">
                    Advanced booking engine with calendar integration, conflict detection, and automated confirmations.
                </p>
                <div style="margin-top: 2rem;">
                    <span class="status-badge danger" style="margin: 0.2rem;">🚫 No Double-booking</span>
                    <span class="status-badge danger" style="margin: 0.2rem;">📱 Mobile Ready</span>
                    <span class="status-badge danger" style="margin: 0.2rem;">⚡ Instant Confirm</span>
                </div>
            </div>
            
            <!-- Financial Management -->
            <div class="stat-card" style="background: linear-gradient(135deg, var(--yellow-line) 0%, #ffed4e 100%); color: var(--tire-black); text-align: center; padding: 3rem 2rem; cursor: default;">
                <div style="font-size: 4rem; margin-bottom: 1rem;">💰</div>
                <h3 style="color: var(--tire-black); margin-bottom: 1rem; font-size: 1.5rem;">Financial Hub</h3>
                <p style="color: rgba(30, 39, 46, 0.8); line-height: 1.6;">
                    Complete invoice management, payment processing, and comprehensive financial reporting dashboard.
                </p>
                <div style="margin-top: 2rem;">
                    <span style="background: var(--tire-black); color: var(--yellow-line); padding: 0.5rem 1rem; border-radius: 20px; margin: 0.2rem; display: inline-block; font-size: 0.8rem;">💳 Payment Processing</span>
                    <span style="background: var(--tire-black); color: var(--yellow-line); padding: 0.5rem 1rem; border-radius: 20px; margin: 0.2rem; display: inline-block; font-size: 0.8rem;">📊 Financial Reports</span>
                    <span style="background: var(--tire-black); color: var(--yellow-line); padding: 0.5rem 1rem; border-radius: 20px; margin: 0.2rem; display: inline-block; font-size: 0.8rem;">📧 Auto Invoicing</span>
                </div>
            </div>
        </div>

        <!-- Road-themed Technology Section -->
        <div style="background: linear-gradient(135deg, var(--road-dark) 0%, var(--tire-black) 100%); color: white; padding: 4rem 2rem; border-radius: 25px; margin: 4rem 0; text-align: center; position: relative; overflow: hidden;">
            <!-- Animated road lines -->
            <div style="position: absolute; top: 0; left: 0; right: 0; height: 4px; background: repeating-linear-gradient(90deg, var(--yellow-line) 0px, var(--yellow-line) 30px, transparent 30px, transparent 60px); animation: roadLine 3s linear infinite;"></div>
            
            <h3 style="font-size: 2.5rem; margin-bottom: 2rem;">🛣️ Built for the Modern Road</h3>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 2rem; margin: 3rem 0;">
                <div style="padding: 2rem; background: rgba(255,255,255,0.1); border-radius: 15px; backdrop-filter: blur(10px);">
                    <div style="font-size: 3rem; margin-bottom: 1rem;">⚡</div>
                    <h4>Lightning Fast</h4>
                    <p>Optimized performance with instant loading and real-time updates</p>
                </div>
                <div style="padding: 2rem; background: rgba(255,255,255,0.1); border-radius: 15px; backdrop-filter: blur(10px);">
                    <div style="font-size: 3rem; margin-bottom: 1rem;">�</div>
                    <h4>Secure & Safe</h4>
                    <p>Enterprise-grade security protecting all student and instructor data</p>
                </div>
                <div style="padding: 2rem; background: rgba(255,255,255,0.1); border-radius: 15px; backdrop-filter: blur(10px);">
                    <div style="font-size: 3rem; margin-bottom: 1rem;">📱</div>
                    <h4>Mobile Ready</h4>
                    <p>Responsive design works perfectly on phones, tablets, and desktops</p>
                </div>
            </div>
        </div>

        <!-- Call to Action with Dashboard Preview -->
        <div style="text-align: center; padding: 3rem; background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border-radius: 25px; margin: 3rem 0;">
            <h3 style="font-size: 2rem; color: var(--dashboard-blue); margin-bottom: 1rem;">
                🚀 Ready to Hit the Road?
            </h3>
            <p style="font-size: 1.2rem; color: var(--text-dark); margin-bottom: 2rem;">
                Join thousands of satisfied students who've mastered driving with Origin Driving School
            </p>
            
            <div style="display: flex; justify-content: center; gap: 2rem; flex-wrap: wrap;">
                <a href="register.php" class="btn btn-success" style="font-size: 1.2rem; padding: 1.2rem 3rem;">
                    🎓 Enroll as Student
                </a>
                <a href="login.php" class="btn" style="font-size: 1.2rem; padding: 1.2rem 3rem;">
                    🔑 Access Dashboard
                </a>
                <a href="test_setup.php" class="btn btn-warning" style="font-size: 1.2rem; padding: 1.2rem 3rem;">
                    � Test System
                </a>
            </div>
        </div>
        
        <!-- Statistics Dashboard -->
        <div style="background: linear-gradient(135deg, var(--blue-light) 0%, #3d4de8 100%); color: white; padding: 3rem; border-radius: 25px; margin: 3rem 0; text-align: center;">
            <h3 style="font-size: 2rem; margin-bottom: 2rem;">🏆 Our Success Story</h3>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 2rem;">
                <div>
                    <div style="font-size: 3rem; font-weight: 900; margin-bottom: 0.5rem;">5000+</div>
                    <div>Successful Students</div>
                </div>
                <div>
                    <div style="font-size: 3rem; font-weight: 900; margin-bottom: 0.5rem;">98%</div>
                    <div>Pass Rate</div>
                </div>
                <div>
                    <div style="font-size: 3rem; font-weight: 900; margin-bottom: 0.5rem;">50+</div>
                    <div>Expert Instructors</div>
                </div>
                <div>
                    <div style="font-size: 3rem; font-weight: 900; margin-bottom: 0.5rem;">15+</div>
                    <div>Years Experience</div>
                </div>
            </div>
        </div>
    </div>
    <footer>
        &copy; 2025 Origin Driving School
    </footer>
</body>
</html>
