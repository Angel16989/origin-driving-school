<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Our Services - Origin Driving School</title>
    <link rel="stylesheet" href="css/modern.css">
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar">
        <div class="nav-container">
            <a href="about.php" class="nav-logo">
                <div class="nav-logo-icon">🚗</div>
                <span>Origin Driving</span>
            </a>

            <ul class="nav-menu" id="navMenu">
                <li><a href="about.php" class="nav-link">Home</a></li>
                <li><a href="services.php" class="nav-link active">Services</a></li>
                <li><a href="instructors.php" class="nav-link">Instructors</a></li>
                <li><a href="contact.php" class="nav-link">Contact</a></li>
                <li><a href="login.php" class="nav-button">Student Portal</a></li>
            </ul>

            <button class="nav-toggle" onclick="toggleMobileMenu()">☰</button>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero">
        <div class="container">
            <div class="hero-content">
                <div class="hero-badge">💼 OUR SERVICES</div>
                <h1 class="hero-title">Comprehensive Driving Programs</h1>
                <p class="hero-subtitle">From beginner lessons to advanced training, we offer a complete range of driving instruction services tailored to your needs.</p>
            </div>
        </div>
    </section>

    <!-- Services Grid -->
    <section class="section">
        <div class="container">
            <div class="grid grid-2">
                <!-- Beginner's Course -->
                <div class="card">
                    <div class="card-icon">🎓</div>
                    <h3 class="card-title">Beginner's Course</h3>
                    <p class="card-text">Perfect for first-time learners. Our comprehensive beginner's program covers all the basics from vehicle controls to road rules, building a strong foundation for safe driving.</p>
                    <ul style="margin: var(--spacing-md) 0; color: var(--gray); line-height: 2;">
                        <li>✓ Vehicle familiarization and controls</li>
                        <li>✓ Basic maneuvers and parking</li>
                        <li>✓ Traffic rules and road signs</li>
                        <li>✓ 15 hours of behind-the-wheel training</li>
                        <li>✓ Classroom instruction included</li>
                    </ul>
                    <p style="color: var(--secondary-blue); font-weight: 700; font-size: var(--font-size-xl);">Starting at $599</p>
                    <a href="login.php" class="btn btn-primary">Book Now</a>
                </div>

                <!-- Intermediate Course -->
                <div class="card">
                    <div class="card-icon">🛣️</div>
                    <h3 class="card-title">Intermediate Course</h3>
                    <p class="card-text">For students with some driving experience looking to build confidence and refine their skills on various road types and traffic conditions.</p>
                    <ul style="margin: var(--spacing-md) 0; color: var(--gray); line-height: 2;">
                        <li>✓ Highway driving techniques</li>
                        <li>✓ Complex intersection navigation</li>
                        <li>✓ Defensive driving strategies</li>
                        <li>✓ Weather condition handling</li>
                        <li>✓ 10 hours of practical training</li>
                    </ul>
                    <p style="color: var(--secondary-blue); font-weight: 700; font-size: var(--font-size-xl);">Starting at $449</p>
                    <a href="login.php" class="btn btn-primary">Book Now</a>
                </div>

                <!-- Refresher Course -->
                <div class="card">
                    <div class="card-icon">🔄</div>
                    <h3 class="card-title">Refresher Course</h3>
                    <p class="card-text">Haven't driven in a while? Our refresher course helps you regain confidence and update your driving skills with current road rules and techniques.</p>
                    <ul style="margin: var(--spacing-md) 0; color: var(--gray); line-height: 2;">
                        <li>✓ Skills assessment and personalized plan</li>
                        <li>✓ Modern traffic pattern review</li>
                        <li>✓ Confidence-building exercises</li>
                        <li>✓ Flexible scheduling</li>
                        <li>✓ 5-10 hours based on needs</li>
                    </ul>
                    <p style="color: var(--secondary-blue); font-weight: 700; font-size: var(--font-size-xl);">Starting at $299</p>
                    <a href="login.php" class="btn btn-primary">Book Now</a>
                </div>

                <!-- Teen Driver Education -->
                <div class="card">
                    <div class="card-icon">👦</div>
                    <h3 class="card-title">Teen Driver Education</h3>
                    <p class="card-text">Specialized program for teen drivers combining classroom learning with behind-the-wheel training, designed to meet state requirements.</p>
                    <ul style="margin: var(--spacing-md) 0; color: var(--gray); line-height: 2;">
                        <li>✓ 30 hours classroom instruction</li>
                        <li>✓ 15 hours behind-the-wheel training</li>
                        <li>✓ Parent involvement sessions</li>
                        <li>✓ Risk awareness education</li>
                        <li>✓ State-approved curriculum</li>
                    </ul>
                    <p style="color: var(--secondary-blue); font-weight: 700; font-size: var(--font-size-xl);">Starting at $699</p>
                    <a href="login.php" class="btn btn-primary">Book Now</a>
                </div>

                <!-- International Students -->
                <div class="card">
                    <div class="card-icon">🌍</div>
                    <h3 class="card-title">International Students</h3>
                    <p class="card-text">Tailored for international students adjusting to local driving laws and customs. We help you transition smoothly to driving in your new country.</p>
                    <ul style="margin: var(--spacing-md) 0; color: var(--gray); line-height: 2;">
                        <li>✓ Local driving laws and customs</li>
                        <li>✓ License conversion assistance</li>
                        <li>✓ Cultural driving differences</li>
                        <li>✓ Flexible scheduling</li>
                        <li>✓ Multilingual instruction available</li>
                    </ul>
                    <p style="color: var(--secondary-blue); font-weight: 700; font-size: var(--font-size-xl);">Starting at $499</p>
                    <a href="login.php" class="btn btn-primary">Book Now</a>
                </div>

                <!-- Road Test Preparation -->
                <div class="card">
                    <div class="card-icon">📝</div>
                    <h3 class="card-title">Road Test Preparation</h3>
                    <p class="card-text">Focused preparation for your driving test. We'll help you polish your skills and build the confidence you need to pass on your first attempt.</p>
                    <ul style="margin: var(--spacing-md) 0; color: var(--gray); line-height: 2;">
                        <li>✓ Test route familiarization</li>
                        <li>✓ Common error correction</li>
                        <li>✓ Mock test sessions</li>
                        <li>✓ Last-minute tips and strategies</li>
                        <li>✓ Test day vehicle rental available</li>
                    </ul>
                    <p style="color: var(--secondary-blue); font-weight: 700; font-size: var(--font-size-xl);">Starting at $199</p>
                    <a href="login.php" class="btn btn-primary">Book Now</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Additional Features -->
    <section class="section" style="background: var(--white);">
        <div class="container">
            <div class="section-header">
                <span class="section-badge">⭐ What's Included</span>
                <h2 class="section-title">Every Course Includes</h2>
            </div>

            <div class="grid grid-4">
                <div class="card">
                    <div style="font-size: 3rem; text-align: center; margin-bottom: var(--spacing-sm);">🚗</div>
                    <h4 style="text-align: center; margin-bottom: var(--spacing-sm);">Modern Vehicles</h4>
                    <p style="text-align: center; color: var(--gray);">Well-maintained, safe vehicles with dual controls</p>
                </div>

                <div class="card">
                    <div style="font-size: 3rem; text-align: center; margin-bottom: var(--spacing-sm);">👨‍🏫</div>
                    <h4 style="text-align: center; margin-bottom: var(--spacing-sm);">Certified Instructors</h4>
                    <p style="text-align: center; color: var(--gray);">Experienced, patient, professional instructors</p>
                </div>

                <div class="card">
                    <div style="font-size: 3rem; text-align: center; margin-bottom: var(--spacing-sm);">📱</div>
                    <h4 style="text-align: center; margin-bottom: var(--spacing-sm);">Online Portal</h4>
                    <p style="text-align: center; color: var(--gray);">Track progress and manage bookings online</p>
                </div>

                <div class="card">
                    <div style="font-size: 3rem; text-align: center; margin-bottom: var(--spacing-sm);">📚</div>
                    <h4 style="text-align: center; margin-bottom: var(--spacing-sm);">Learning Materials</h4>
                    <p style="text-align: center; color: var(--gray);">Comprehensive study guides and resources</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="section" style="background: linear-gradient(135deg, var(--primary-blue), var(--secondary-blue)); color: var(--white);">
        <div class="container text-center">
            <h2 style="color: var(--white); font-size: var(--font-size-4xl); margin-bottom: var(--spacing-md);">Ready to Get Started?</h2>
            <p style="color: var(--white); font-size: var(--font-size-lg); opacity: 0.95; margin-bottom: var(--spacing-xl);">Choose the course that's right for you and begin your journey to becoming a confident, safe driver.</p>
            <div style="display: flex; gap: var(--spacing-md); justify-content: center; flex-wrap: wrap;">
                <a href="login.php" class="btn btn-primary btn-lg">📝 Enroll Now</a>
                <a href="contact.php" class="btn btn-secondary btn-lg">📞 Ask Questions</a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <h3>Origin Driving School</h3>
                    <p>Building confident, safe drivers since 2010.</p>
                    <p style="margin-top: var(--spacing-md);">📞 (555) 123-4567<br>📧 info@origindriving.com</p>
                </div>

                <div class="footer-section">
                    <h3>Quick Links</h3>
                    <ul>
                        <li><a href="about.php">Home</a></li>
                        <li><a href="services.php">Services</a></li>
                        <li><a href="instructors.php">Instructors</a></li>
                        <li><a href="contact.php">Contact</a></li>
                    </ul>
                </div>

                <div class="footer-section">
                    <h3>Services</h3>
                    <ul>
                        <li><a href="services.php">Beginner's Course</a></li>
                        <li><a href="services.php">Refresher Lessons</a></li>
                        <li><a href="services.php">Road Test Prep</a></li>
                        <li><a href="services.php">International Students</a></li>
                    </ul>
                </div>

                <div class="footer-section">
                    <h3>Office Hours</h3>
                    <p>Monday - Friday: 8:00 AM - 6:00 PM<br>
                    Saturday: 9:00 AM - 4:00 PM<br>
                    Sunday: Closed</p>
                </div>
            </div>

            <div class="footer-bottom">
                <p>&copy; 2024 Origin Driving School. All rights reserved. | Team: Ms Isha Shrestha (K241002), Mr Rojan Shrestha (K240867), Mr Rasik Tiwari (K240750)</p>
            </div>
        </div>
    </footer>

    <script>
        function toggleMobileMenu() {
            const navMenu = document.getElementById('navMenu');
            navMenu.classList.toggle('active');
        }

        document.addEventListener('click', function(event) {
            const navMenu = document.getElementById('navMenu');
            const navToggle = document.querySelector('.nav-toggle');

            if (!navMenu.contains(event.target) && !navToggle.contains(event.target)) {
                navMenu.classList.remove('active');
            }
        });
    </script>
</body>
</html>