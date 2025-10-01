<?php 
session_start();
require_once 'includes/security.php';
require_once 'php/db_connect.php';

// Get real-time instructor data from database
$instructors = [];
$instructor_stats = [
    'total_instructors' => 0,
    'avg_experience' => 0,
    'total_students_taught' => 0,
    'avg_rating' => 0
];

try {
    // Get all instructors with their data
    $query = "SELECT * FROM instructors ORDER BY experience_years DESC, rating DESC";
    $result = $conn->query($query);
    
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $instructors[] = $row;
        }
        
        // Calculate stats
        $instructor_stats['total_instructors'] = count($instructors);
        if (count($instructors) > 0) {
            $instructor_stats['total_students_taught'] = array_sum(array_column($instructors, 'students_taught'));
            $instructor_stats['avg_experience'] = round(array_sum(array_column($instructors, 'experience_years')) / count($instructors), 1);
            $instructor_stats['avg_rating'] = round(array_sum(array_column($instructors, 'rating')) / count($instructors), 1);
        }
    }
} catch (Exception $e) {
    error_log("Error fetching instructors: " . $e->getMessage());
}

// Set page-specific variables for header
$page_title = "Our Expert Instructors - Origin Driving School";
$page_description = "Meet our team of certified, experienced driving instructors at Origin Driving School";

// Include consistent header
include 'includes/header.php';
?>
    
    <!-- Hero Section with Particle Effect -->
    <section style="background: linear-gradient(135deg, var(--dashboard-blue) 0%, #40407a 100%); color: white; padding: 8rem 2rem 5rem; position: relative; overflow: hidden;">
        <div style="position: absolute; top: -50%; left: -50%; width: 200%; height: 200%; background: radial-gradient(circle, rgba(255, 215, 0, 0.1) 0%, transparent 70%); animation: containerGlow 15s ease-in-out infinite; pointer-events: none;"></div>
        
        <!-- Floating Icons Animation -->
        <div style="position: absolute; inset: 0; overflow: hidden; opacity: 0.1;">
            <div style="position: absolute; top: 20%; left: 10%; animation: float 6s ease-in-out infinite;">🚗</div>
            <div style="position: absolute; top: 60%; right: 15%; animation: float 8s ease-in-out infinite; animation-delay: 1s;">👨‍🏫</div>
            <div style="position: absolute; bottom: 30%; left: 20%; animation: float 7s ease-in-out infinite; animation-delay: 2s;">🎓</div>
            <div style="position: absolute; top: 40%; right: 25%; animation: float 9s ease-in-out infinite; animation-delay: 3s;">⭐</div>
        </div>
        
        <div style="max-width: 1200px; margin: 0 auto; text-align: center; position: relative; z-index: 2;">
            <div style="display: inline-block; background: rgba(255, 215, 0, 0.2); padding: 1rem 2rem; border-radius: 50px; border: 2px solid var(--yellow-line); margin-bottom: 2rem;">
                <span style="font-size: 1.5rem; margin-right: 0.5rem;">👨‍🏫</span>
                <span style="font-weight: 600; color: var(--yellow-line);">MEET OUR EXPERTS</span>
            </div>
            
            <h1 style="font-size: clamp(3rem, 8vw, 5rem); font-weight: 900; margin-bottom: 1.5rem; line-height: 1.1; text-shadow: 2px 2px 4px rgba(0,0,0,0.2);">
                World-Class <span style="color: var(--yellow-line); position: relative;">Instructors<span style="position: absolute; bottom: -10px; left: 0; right: 0; height: 4px; background: var(--yellow-line); border-radius: 2px;"></span></span>
            </h1>
            
            <p style="font-size: 1.3rem; margin-bottom: 3rem; opacity: 0.95; max-width: 800px; margin-left: auto; margin-right: auto; line-height: 1.8;">
                Our elite team of certified instructors brings decades of combined experience, unmatched patience, and proven teaching methods to transform nervous beginners into confident, safe drivers.
            </p>
            
            <div style="display: inline-flex; align-items: center; gap: 1rem; background: rgba(40, 167, 69, 0.9); padding: 1rem 2rem; border-radius: 50px; box-shadow: 0 8px 25px rgba(40, 167, 69, 0.3);">
                <span style="width: 12px; height: 12px; background: #28a745; border-radius: 50%; animation: pulse 2s ease-in-out infinite; box-shadow: 0 0 0 0 rgba(40, 167, 69, 0.7);"></span>
                <span style="font-weight: 600; font-size: 1.1rem;">🔄 Real-Time Data from Database</span>
            </div>
        </div>
    </section>

    <!-- Stats Dashboard - Floating Above Content -->
    <div style="max-width: 1400px; margin: -5rem auto 0; padding: 0 2rem; position: relative; z-index: 100;">
        <div style="background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%); padding: 3rem; border-radius: 25px; box-shadow: 0 25px 80px rgba(0,0,0,0.12); border: 1px solid rgba(255,215,0,0.3);">
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 2.5rem;">
                <!-- Stat 1 -->
                <div style="text-align: center; position: relative;">
                    <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); width: 90px; height: 90px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1.5rem; box-shadow: 0 15px 35px rgba(102, 126, 234, 0.3); position: relative;">
                        <span style="font-size: 2.5rem;">👥</span>
                        <div style="position: absolute; inset: -5px; border: 3px solid var(--yellow-line); border-radius: 50%; opacity: 0.3;"></div>
                    </div>
                    <div style="font-size: 3.5rem; font-weight: 900; color: #667eea; margin-bottom: 0.5rem; font-family: 'Inter', sans-serif;"><?php echo $instructor_stats['total_instructors']; ?></div>
                    <h3 style="margin: 0; color: #333; font-size: 1.1rem; font-weight: 600;">Certified Instructors</h3>
                    <p style="margin: 0.5rem 0 0 0; color: #888; font-size: 0.9rem;">Expert teachers ready</p>
                </div>
                
                <!-- Stat 2 -->
                <div style="text-align: center; position: relative;">
                    <div style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); width: 90px; height: 90px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1.5rem; box-shadow: 0 15px 35px rgba(245, 87, 108, 0.3); position: relative;">
                        <span style="font-size: 2.5rem;">📅</span>
                        <div style="position: absolute; inset: -5px; border: 3px solid var(--yellow-line); border-radius: 50%; opacity: 0.3;"></div>
                    </div>
                    <div style="font-size: 3.5rem; font-weight: 900; color: #f5576c; margin-bottom: 0.5rem; font-family: 'Inter', sans-serif;"><?php echo array_sum(array_column($instructors, 'experience_years')); ?>+</div>
                    <h3 style="margin: 0; color: #333; font-size: 1.1rem; font-weight: 600;">Combined Experience</h3>
                    <p style="margin: 0.5rem 0 0 0; color: #888; font-size: 0.9rem;">Years of expertise</p>
                </div>
                
                <!-- Stat 3 -->
                <div style="text-align: center; position: relative;">
                    <div style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); width: 90px; height: 90px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1.5rem; box-shadow: 0 15px 35px rgba(79, 172, 254, 0.3); position: relative;">
                        <span style="font-size: 2.5rem;">⭐</span>
                        <div style="position: absolute; inset: -5px; border: 3px solid var(--yellow-line); border-radius: 50%; opacity: 0.3;"></div>
                    </div>
                    <div style="font-size: 3.5rem; font-weight: 900; color: #4facfe; margin-bottom: 0.5rem; font-family: 'Inter', sans-serif;"><?php echo $instructor_stats['avg_rating']; ?><span style="font-size: 2rem;">⭐</span></div>
                    <h3 style="margin: 0; color: #333; font-size: 1.1rem; font-weight: 600;">Average Rating</h3>
                    <p style="margin: 0.5rem 0 0 0; color: #888; font-size: 0.9rem;">Student satisfaction</p>
                </div>
                
                <!-- Stat 4 -->
                <div style="text-align: center; position: relative;">
                    <div style="background: linear-gradient(135deg, #fa709a 0%, #fee140 100%); width: 90px; height: 90px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1.5rem; box-shadow: 0 15px 35px rgba(250, 112, 154, 0.3); position: relative;">
                        <span style="font-size: 2.5rem;">🎓</span>
                        <div style="position: absolute; inset: -5px; border: 3px solid var(--yellow-line); border-radius: 50%; opacity: 0.3;"></div>
                    </div>
                    <div style="font-size: 3.5rem; font-weight: 900; color: #fa709a; margin-bottom: 0.5rem; font-family: 'Inter', sans-serif;"><?php echo number_format($instructor_stats['total_students_taught']); ?>+</div>
                    <h3 style="margin: 0; color: #333; font-size: 1.1rem; font-weight: 600;">Students Taught</h3>
                    <p style="margin: 0.5rem 0 0 0; color: #888; font-size: 0.9rem;">Success stories</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Page Content -->
    <div style="max-width: 1400px; margin: 0 auto; padding: 5rem 2rem 2rem;">
        
        <!-- Section Header with Animation -->
        <div style="text-align: center; margin-bottom: 5rem;">
            <div style="display: inline-block; background: linear-gradient(135deg, var(--dashboard-blue), #667eea); padding: 0.5rem 1.5rem; border-radius: 50px; margin-bottom: 1.5rem;">
                <span style="color: white; font-weight: 600; font-size: 0.9rem; letter-spacing: 2px;">OUR TEAM</span>
            </div>
            <h2 style="font-size: clamp(2.5rem, 5vw, 4rem); color: var(--dashboard-blue); margin-bottom: 1rem; font-weight: 900;">
                🏆 Meet Your <span style="color: var(--yellow-line);">Future Instructor</span>
            </h2>
            <p style="font-size: 1.2rem; color: #666; max-width: 700px; margin: 0 auto; line-height: 1.8;">
                Each instructor is handpicked, certified, and dedicated to your success. Browse our elite team and find the perfect match for your learning style.
            </p>
        </div>

        <!-- Dynamic Instructors Grid from Database -->
        <section style="margin: 4rem 0;">
            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(380px, 1fr)); gap: 3rem; margin-bottom: 5rem;">
                
                <?php 
                if (count($instructors) > 0):
                    $gradient_colors = [
                        ['#667eea', '#764ba2'],
                        ['#f093fb', '#f5576c'],
                        ['#4facfe', '#00f2fe'],
                        ['#43e97b', '#38f9d7'],
                        ['#fa709a', '#fee140'],
                        ['#30cfd0', '#330867'],
                        ['#a8edea', '#fed6e3'],
                        ['#ff9a9e', '#fecfef'],
                        ['#ffecd2', '#fcb69f'],
                        ['#ff6e7f', '#bfe9ff'],
                        ['#e0c3fc', '#8ec5fc'],
                        ['#f6d365', '#fda085']
                    ];
                    
                    foreach ($instructors as $index => $instructor):
                        $gradient = $gradient_colors[$index % count($gradient_colors)];
                        $emoji_options = ['👨‍🏫', '👩‍🏫', '👨‍💼', '👩‍💼', '👨‍🎓', '👩‍🎓'];
                        $emoji = $emoji_options[$index % count($emoji_options)];
                        
                        // Generate star rating display
                        $rating = floatval($instructor['rating']);
                        $full_stars = floor($rating);
                        $half_star = ($rating - $full_stars) >= 0.5;
                        $stars_html = str_repeat('⭐', $full_stars);
                        if ($half_star) $stars_html .= '⭐';
                ?>
                
                <!-- Instructor Card: <?php echo htmlspecialchars($instructor['name']); ?> -->
                <div class="instructor-card" style="background: white; border-radius: 25px; overflow: hidden; box-shadow: 0 15px 50px rgba(0,0,0,0.08); transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275); position: relative; border: 2px solid transparent;" 
                     onmouseover="this.style.transform='translateY(-15px) scale(1.02)'; this.style.boxShadow='0 25px 70px rgba(0,0,0,0.15)'; this.style.borderColor='var(--yellow-line)';" 
                     onmouseout="this.style.transform='translateY(0) scale(1)'; this.style.boxShadow='0 15px 50px rgba(0,0,0,0.08)'; this.style.borderColor='transparent';">
                    
                    <!-- Card Header with Gradient -->
                    <div style="background: linear-gradient(135deg, <?php echo $gradient[0]; ?> 0%, <?php echo $gradient[1]; ?> 100%); padding: 2.5rem 2rem; text-align: center; position: relative; overflow: hidden;">
                        <div style="position: absolute; top: -50%; right: -50%; width: 200%; height: 200%; background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%); animation: pulse 8s ease-in-out infinite;"></div>
                        
                        <!-- Instructor Avatar -->
                        <div style="width: 110px; height: 110px; background: rgba(255,255,255,0.25); backdrop-filter: blur(10px); border-radius: 50%; margin: 0 auto 1.5rem; display: flex; align-items: center; justify-content: center; font-size: 3.5rem; color: white; border: 4px solid rgba(255,255,255,0.4); box-shadow: 0 10px 30px rgba(0,0,0,0.2); position: relative; z-index: 2;">
                            <?php echo $emoji; ?>
                        </div>
                        
                        <h3 style="color: white; margin: 0 0 0.5rem 0; font-size: 1.6rem; font-weight: 700; position: relative; z-index: 2;">
                            <?php echo htmlspecialchars($instructor['name']); ?>
                        </h3>
                        <p style="color: rgba(255,255,255,0.95); margin: 0; font-size: 1rem; font-weight: 500; position: relative; z-index: 2;">
                            <?php echo htmlspecialchars($instructor['specialization']); ?>
                        </p>
                    </div>
                    
                    <!-- Card Body -->
                    <div style="padding: 2rem;">
                        <!-- Tags/Badges -->
                        <div style="display: flex; flex-wrap: wrap; gap: 0.5rem; margin-bottom: 1.5rem;">
                            <span style="background: linear-gradient(135deg, #667eea, #764ba2); color: white; padding: 0.4rem 1rem; border-radius: 20px; font-size: 0.85rem; font-weight: 600; box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);">
                                📅 <?php echo $instructor['experience_years']; ?> Years
                            </span>
                            <span style="background: linear-gradient(135deg, #f093fb, #f5576c); color: white; padding: 0.4rem 1rem; border-radius: 20px; font-size: 0.85rem; font-weight: 600; box-shadow: 0 4px 15px rgba(240, 147, 251, 0.3);">
                                <?php echo $stars_html; ?> <?php echo $instructor['rating']; ?>
                            </span>
                            <?php if (!empty($instructor['certifications'])): ?>
                            <span style="background: linear-gradient(135deg, #43e97b, #38f9d7); color: white; padding: 0.4rem 1rem; border-radius: 20px; font-size: 0.85rem; font-weight: 600; box-shadow: 0 4px 15px rgba(67, 233, 123, 0.3);">
                                ✓ Certified
                            </span>
                            <?php endif; ?>
                        </div>
                        
                        <!-- Bio -->
                        <p style="color: #555; line-height: 1.7; margin-bottom: 1.5rem; font-size: 0.95rem;">
                            <?php echo htmlspecialchars($instructor['bio']); ?>
                        </p>
                        
                        <!-- Stats Grid -->
                        <div style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); padding: 1.5rem; border-radius: 15px; margin-bottom: 1.5rem;">
                            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                                <div>
                                    <div style="font-size: 1.8rem; font-weight: 900; color: #667eea; margin-bottom: 0.2rem;">
                                        <?php echo number_format($instructor['students_taught']); ?>
                                    </div>
                                    <div style="font-size: 0.8rem; color: #666; font-weight: 600;">Students Taught</div>
                                </div>
                                <div>
                                    <div style="font-size: 1.8rem; font-weight: 900; color: #f5576c; margin-bottom: 0.2rem;">
                                        <?php echo $instructor['experience_years']; ?>+
                                    </div>
                                    <div style="font-size: 0.8rem; color: #666; font-weight: 600;">Years Experience</div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Languages & Availability -->
                        <div style="border-top: 2px solid #f0f0f0; padding-top: 1.5rem;">
                            <div style="margin-bottom: 1rem;">
                                <span style="font-weight: 700; color: #333; font-size: 0.9rem;">🗣️ Languages:</span>
                                <span style="color: #666; font-size: 0.9rem; margin-left: 0.5rem;">
                                    <?php echo htmlspecialchars($instructor['languages']); ?>
                                </span>
                            </div>
                            <div style="margin-bottom: 1.5rem;">
                                <span style="font-weight: 700; color: #333; font-size: 0.9rem;">📅 Available:</span>
                                <span style="color: #666; font-size: 0.9rem; margin-left: 0.5rem;">
                                    <?php echo htmlspecialchars($instructor['availability']); ?>
                                </span>
                            </div>
                            
                            <!-- CTA Button -->
                            <button style="width: 100%; background: linear-gradient(135deg, var(--dashboard-blue), #667eea); color: white; border: none; padding: 1rem; border-radius: 12px; font-weight: 700; font-size: 1rem; cursor: pointer; transition: all 0.3s ease; box-shadow: 0 8px 25px rgba(12, 36, 97, 0.2);"
                                    onmouseover="this.style.transform='translateY(-3px)'; this.style.boxShadow='0 12px 35px rgba(12, 36, 97, 0.3)';"
                                    onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 8px 25px rgba(12, 36, 97, 0.2)';"
                                    onclick="window.location.href='login.php';">
                                📅 Book with <?php echo explode(' ', $instructor['name'])[0]; ?>
                            </button>
                        </div>
                    </div>
                </div>
                
                <?php 
                    endforeach;
                else:
                ?>
                
                <!-- No Instructors Found -->
                <div style="grid-column: 1/-1; text-align: center; padding: 4rem 2rem; background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border-radius: 20px;">
                    <div style="font-size: 4rem; margin-bottom: 1rem;">👨‍🏫</div>
                    <h3 style="color: #333; margin-bottom: 1rem;">No Instructors Available</h3>
                    <p style="color: #666;">Please check back later or contact us for more information.</p>
                </div>
                
                <?php endif; ?>
            </div>
        </section>
        
        <!-- Premium CTA Section -->
        <section style="background: linear-gradient(135deg, var(--dashboard-blue) 0%, #667eea 100%); border-radius: 30px; padding: 5rem 3rem; text-align: center; margin: 5rem 0; position: relative; overflow: hidden; box-shadow: 0 30px 80px rgba(12, 36, 97, 0.3);">
            <div style="position: absolute; top: -50%; left: -50%; width: 200%; height: 200%; background: radial-gradient(circle, rgba(255, 215, 0, 0.1) 0%, transparent 70%); animation: containerGlow 15s ease-in-out infinite; pointer-events: none;"></div>
            
            <div style="position: relative; z-index: 2;">
                <div style="font-size: 5rem; margin-bottom: 2rem; animation: float 3s ease-in-out infinite;">🚗</div>
                <h2 style="font-size: clamp(2.5rem, 5vw, 4rem); color: white; margin-bottom: 1.5rem; font-weight: 900;">
                    Ready to <span style="color: var(--yellow-line);">Start Your Journey?</span>
                </h2>
                <p style="font-size: 1.3rem; color: rgba(255,255,255,0.95); margin-bottom: 3rem; max-width: 700px; margin-left: auto; margin-right: auto; line-height: 1.8;">
                    Join thousands of satisfied students who have mastered the road with Origin Driving School's expert instructors. Your perfect instructor is waiting!
                </p>
                
                <div style="display: flex; justify-content: center; gap: 1.5rem; flex-wrap: wrap;">
                    <a href="register.php" style="background: var(--yellow-line); color: var(--tire-black); padding: 1.5rem 3rem; border-radius: 50px; text-decoration: none; font-weight: 700; font-size: 1.2rem; transition: all 0.3s ease; box-shadow: 0 10px 30px rgba(255, 215, 0, 0.4); display: inline-flex; align-items: center; gap: 0.5rem;"
                       onmouseover="this.style.transform='translateY(-5px)'; this.style.boxShadow='0 15px 40px rgba(255, 215, 0, 0.5)';"
                       onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 10px 30px rgba(255, 215, 0, 0.4)';">
                        <span>🚗</span> Enroll Now
                    </a>
                    <a href="index.php#contact" style="background: rgba(255,255,255,0.2); backdrop-filter: blur(10px); color: white; padding: 1.5rem 3rem; border-radius: 50px; text-decoration: none; font-weight: 700; font-size: 1.2rem; transition: all 0.3s ease; border: 2px solid rgba(255,255,255,0.3); display: inline-flex; align-items: center; gap: 0.5rem;"
                       onmouseover="this.style.background='rgba(255,255,255,0.3)'; this.style.borderColor='rgba(255,255,255,0.5)';"
                       onmouseout="this.style.background='rgba(255,255,255,0.2)'; this.style.borderColor='rgba(255,255,255,0.3)';">
                        <span>📞</span> Contact Us
                    </a>
                </div>
            </div>
        </section>
    </div>
    
    <!-- Custom Animations -->
    <style>
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }
        
        @keyframes pulse {
            0%, 100% { box-shadow: 0 0 0 0 rgba(40, 167, 69, 0.7); }
            50% { box-shadow: 0 0 0 15px rgba(40, 167, 69, 0); }
        }
        
        @keyframes containerGlow {
            0%, 100% { transform: rotate(0deg) scale(1); }
            50% { transform: rotate(180deg) scale(1.1); }
        }
    </style>
    
<?php include 'includes/footer.php'; ?>
                        <div style="width: 120px; height: 120px; background: rgba(255,255,255,0.2); border-radius: 50%; margin: 0 auto 1rem auto; display: flex; align-items: center; justify-content: center; font-size: 3.5rem; color: white; border: 4px solid rgba(255,255,255,0.3);">👨‍💼</div>
                        <h3 style="color: white; margin: 0;">Mike Johnson</h3>
                        <p style="color: rgba(255,255,255,0.9); margin: 0.5rem 0 0 0;">Chief Instructor & Founder</p>
                    </div>
                    <div style="padding: 2rem;">
                        <div style="margin-bottom: 1.5rem;">
                            <span style="background: #007bff; color: white; padding: 0.3rem 0.8rem; border-radius: 15px; font-size: 0.8rem; margin-right: 0.5rem;">20+ Years</span>
                            <span style="background: #28a745; color: white; padding: 0.3rem 0.8rem; border-radius: 15px; font-size: 0.8rem; margin-right: 0.5rem;">Safety Expert</span>
                            <span style="background: #ffc107; color: #000; padding: 0.3rem 0.8rem; border-radius: 15px; font-size: 0.8rem;">State Certified</span>
                        </div>
                        <p style="color: #666; line-height: 1.6; margin-bottom: 1.5rem;">Founded Origin Driving School with a vision of making roads safer through quality education. Specializes in nervous drivers and has personally trained over 3,000 students with a 99% first-time pass rate.</p>
                        <div style="border-top: 1px solid #eee; padding-top: 1.5rem;">
                            <h4 style="margin-bottom: 1rem;">📊 Specializations:</h4>
                            <ul style="list-style: none; padding: 0; margin: 0;">
                                <li style="padding: 0.3rem 0;">🎯 Anxiety & Confidence Building</li>
                                <li style="padding: 0.3rem 0;">🚗 Advanced Defensive Driving</li>
                                <li style="padding: 0.3rem 0;">🏫 Instructor Training & Certification</li>
                                <li style="padding: 0.3rem 0;">📋 DMV Test Preparation</li>
                            </ul>
                        </div>
                    </div>
                </div>
                
                <!-- Priya Sharma -->
                <div style="background: white; border-radius: 20px; overflow: hidden; box-shadow: 0 15px 35px rgba(0,0,0,0.1); transition: transform 0.3s ease;" onmouseover="this.style.transform='translateY(-10px)'" onmouseout="this.style.transform='translateY(0)'">
                    <div style="background: linear-gradient(135deg, #28a745 0%, #20c997 100%); padding: 2rem; text-align: center;">
                        <div style="width: 120px; height: 120px; background: rgba(255,255,255,0.2); border-radius: 50%; margin: 0 auto 1rem auto; display: flex; align-items: center; justify-content: center; font-size: 3.5rem; color: white; border: 4px solid rgba(255,255,255,0.3);">👩‍🏫</div>
                        <h3 style="color: white; margin: 0;">Priya Sharma</h3>
                        <p style="color: rgba(255,255,255,0.9); margin: 0.5rem 0 0 0;">Senior Driving Instructor</p>
                    </div>
                    <div style="padding: 2rem;">
                        <div style="margin-bottom: 1.5rem;">
                            <span style="background: #dc3545; color: white; padding: 0.3rem 0.8rem; border-radius: 15px; font-size: 0.8rem; margin-right: 0.5rem;">15+ Years</span>
                            <span style="background: #17a2b8; color: white; padding: 0.3rem 0.8rem; border-radius: 15px; font-size: 0.8rem; margin-right: 0.5rem;">Teen Specialist</span>
                            <span style="background: #6f42c1; color: white; padding: 0.3rem 0.8rem; border-radius: 15px; font-size: 0.8rem;">Bilingual</span>
                        </div>
                        <p style="color: #666; line-height: 1.6; margin-bottom: 1.5rem;">Originally from Mumbai, Priya brings patience and cultural understanding to her teaching. She specializes in working with teenage drivers and international students, with fluency in English, Hindi, and Gujarati.</p>
                        <div style="border-top: 1px solid #eee; padding-top: 1.5rem;">
                            <h4 style="margin-bottom: 1rem;">📊 Specializations:</h4>
                            <ul style="list-style: none; padding: 0; margin: 0;">
                                <li style="padding: 0.3rem 0;">👶 Teen Driver Education</li>
                                <li style="padding: 0.3rem 0;">🌍 International Student Support</li>
                                <li style="padding: 0.3rem 0;">🗣️ Hindi & Gujarati Instruction</li>
                                <li style="padding: 0.3rem 0;">🎓 Parent-Teen Program Coordinator</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        
        <!-- Regular Instructors -->
        <section style="margin: 4rem 0;">
            <h2 style="text-align: center; margin-bottom: 3rem; color: #333;">🚗 Our Certified Instructors</h2>
            
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(350px, 1fr)); gap: 2rem;">
                
                <!-- Rajesh Patel -->
                <div style="background: white; border-radius: 15px; overflow: hidden; box-shadow: 0 10px 25px rgba(0,0,0,0.1); transition: transform 0.3s ease;" onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='translateY(0)'">
                    <div style="background: linear-gradient(135deg, #007bff 0%, #6f42c1 100%); padding: 1.5rem; text-align: center;">
                        <div style="width: 80px; height: 80px; background: rgba(255,255,255,0.2); border-radius: 50%; margin: 0 auto 1rem auto; display: flex; align-items: center; justify-content: center; font-size: 2.5rem; color: white;">👨‍🏫</div>
                        <h3 style="color: white; margin: 0; font-size: 1.3rem;">Rajesh Patel</h3>
                        <p style="color: rgba(255,255,255,0.9); margin: 0.3rem 0 0 0; font-size: 0.9rem;">Driving Instructor</p>
                    </div>
                    <div style="padding: 1.5rem;">
                        <div style="margin-bottom: 1rem;">
                            <span style="background: #28a745; color: white; padding: 0.2rem 0.6rem; border-radius: 10px; font-size: 0.75rem; margin-right: 0.3rem;">8 Years</span>
                            <span style="background: #ffc107; color: #000; padding: 0.2rem 0.6rem; border-radius: 10px; font-size: 0.75rem; margin-right: 0.3rem;">Manual Cars</span>
                            <span style="background: #17a2b8; color: white; padding: 0.2rem 0.6rem; border-radius: 10px; font-size: 0.75rem;">Highway Expert</span>
                        </div>
                        <p style="color: #666; font-size: 0.9rem; line-height: 1.5; margin-bottom: 1rem;">From Ahmedabad, specializes in manual transmission and highway driving. Known for his methodical approach and technical expertise in vehicle mechanics.</p>
                        <div style="font-size: 0.8rem; color: #888;">
                            <p style="margin: 0.3rem 0;">🎯 Students Taught: 850+</p>
                            <p style="margin: 0.3rem 0;">⭐ Rating: 4.9/5</p>
                            <p style="margin: 0.3rem 0;">🗣️ Languages: English, Hindi, Gujarati</p>
                        </div>
                    </div>
                </div>
                
                <!-- Suman Thapa -->
                <div style="background: white; border-radius: 15px; overflow: hidden; box-shadow: 0 10px 25px rgba(0,0,0,0.1); transition: transform 0.3s ease;" onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='translateY(0)'">
                    <div style="background: linear-gradient(135deg, #dc3545 0%, #fd7e14 100%); padding: 1.5rem; text-align: center;">
                        <div style="width: 80px; height: 80px; background: rgba(255,255,255,0.2); border-radius: 50%; margin: 0 auto 1rem auto; display: flex; align-items: center; justify-content: center; font-size: 2.5rem; color: white;">👩‍🏫</div>
                        <h3 style="color: white; margin: 0; font-size: 1.3rem;">Suman Thapa</h3>
                        <p style="color: rgba(255,255,255,0.9); margin: 0.3rem 0 0 0; font-size: 0.9rem;">Senior Instructor</p>
                    </div>
                    <div style="padding: 1.5rem;">
                        <div style="margin-bottom: 1rem;">
                            <span style="background: #6f42c1; color: white; padding: 0.2rem 0.6rem; border-radius: 10px; font-size: 0.75rem; margin-right: 0.3rem;">12 Years</span>
                            <span style="background: #e83e8c; color: white; padding: 0.2rem 0.6rem; border-radius: 10px; font-size: 0.75rem; margin-right: 0.3rem;">Women's Safety</span>
                            <span style="background: #20c997; color: white; padding: 0.2rem 0.6rem; border-radius: 10px; font-size: 0.75rem;">City Driving</span>
                        </div>
                        <p style="color: #666; font-size: 0.9rem; line-height: 1.5; margin-bottom: 1rem;">Originally from Kathmandu, Nepal. Expert in city driving and women's safety programs. Creates comfortable learning environment for all students.</p>
                        <div style="font-size: 0.8rem; color: #888;">
                            <p style="margin: 0.3rem 0;">🎯 Students Taught: 1,200+</p>
                            <p style="margin: 0.3rem 0;">⭐ Rating: 4.8/5</p>
                            <p style="margin: 0.3rem 0;">🗣️ Languages: English, Nepali, Hindi</p>
                        </div>
                    </div>
                </div>
                
                <!-- David Chen -->
                <div style="background: white; border-radius: 15px; overflow: hidden; box-shadow: 0 10px 25px rgba(0,0,0,0.1); transition: transform 0.3s ease;" onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='translateY(0)'">
                    <div style="background: linear-gradient(135deg, #17a2b8 0%, #20c997 100%); padding: 1.5rem; text-align: center;">
                        <div style="width: 80px; height: 80px; background: rgba(255,255,255,0.2); border-radius: 50%; margin: 0 auto 1rem auto; display: flex; align-items: center; justify-content: center; font-size: 2.5rem; color: white;">👨‍💻</div>
                        <h3 style="color: white; margin: 0; font-size: 1.3rem;">David Chen</h3>
                        <p style="color: rgba(255,255,255,0.9); margin: 0.3rem 0 0 0; font-size: 0.9rem;">Tech Integration Specialist</p>
                    </div>
                    <div style="padding: 1.5rem;">
                        <div style="margin-bottom: 1rem;">
                            <span style="background: #007bff; color: white; padding: 0.2rem 0.6rem; border-radius: 10px; font-size: 0.75rem; margin-right: 0.3rem;">6 Years</span>
                            <span style="background: #28a745; color: white; padding: 0.2rem 0.6rem; border-radius: 10px; font-size: 0.75rem; margin-right: 0.3rem;">Tech Savvy</span>
                            <span style="background: #ffc107; color: #000; padding: 0.2rem 0.6rem; border-radius: 10px; font-size: 0.75rem;">Modern Methods</span>
                        </div>
                        <p style="color: #666; font-size: 0.9rem; line-height: 1.5; margin-bottom: 1rem;">Combines traditional driving instruction with modern technology. Uses simulators and apps to enhance learning experience for tech-oriented students.</p>
                        <div style="font-size: 0.8rem; color: #888;">
                            <p style="margin: 0.3rem 0;">🎯 Students Taught: 650+</p>
                            <p style="margin: 0.3rem 0;">⭐ Rating: 4.9/5</p>
                            <p style="margin: 0.3rem 0;">🗣️ Languages: English, Mandarin</p>
                        </div>
                    </div>
                </div>
                
                <!-- Anita Gurung -->
                <div style="background: white; border-radius: 15px; overflow: hidden; box-shadow: 0 10px 25px rgba(0,0,0,0.1); transition: transform 0.3s ease;" onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='translateY(0)'">
                    <div style="background: linear-gradient(135deg, #e83e8c 0%, #6f42c1 100%); padding: 1.5rem; text-align: center;">
                        <div style="width: 80px; height: 80px; background: rgba(255,255,255,0.2); border-radius: 50%; margin: 0 auto 1rem auto; display: flex; align-items: center; justify-content: center; font-size: 2.5rem; color: white;">👩‍🎓</div>
                        <h3 style="color: white; margin: 0; font-size: 1.3rem;">Anita Gurung</h3>
                        <p style="color: rgba(255,255,255,0.9); margin: 0.3rem 0 0 0; font-size: 0.9rem;">Patience Specialist</p>
                    </div>
                    <div style="padding: 1.5rem;">
                        <div style="margin-bottom: 1rem;">
                            <span style="background: #28a745; color: white; padding: 0.2rem 0.6rem; border-radius: 10px; font-size: 0.75rem; margin-right: 0.3rem;">7 Years</span>
                            <span style="background: #dc3545; color: white; padding: 0.2rem 0.6rem; border-radius: 10px; font-size: 0.75rem; margin-right: 0.3rem;">Anxiety Help</span>
                            <span style="background: #17a2b8; color: white; padding: 0.2rem 0.6rem; border-radius: 10px; font-size: 0.75rem;">Patient Teacher</span>
                        </div>
                        <p style="color: #666; font-size: 0.9rem; line-height: 1.5; margin-bottom: 1rem;">From the mountains of Nepal, brings exceptional patience and understanding. Specializes in helping anxious and first-time drivers build confidence.</p>
                        <div style="font-size: 0.8rem; color: #888;">
                            <p style="margin: 0.3rem 0;">🎯 Students Taught: 780+</p>
                            <p style="margin: 0.3rem 0;">⭐ Rating: 5.0/5</p>
                            <p style="margin: 0.3rem 0;">🗣️ Languages: English, Nepali, Hindi</p>
                        </div>
                    </div>
                </div>
                
                <!-- James Rodriguez -->
                <div style="background: white; border-radius: 15px; overflow: hidden; box-shadow: 0 10px 25px rgba(0,0,0,0.1); transition: transform 0.3s ease;" onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='translateY(0)'">
                    <div style="background: linear-gradient(135deg, #fd7e14 0%, #ffc107 100%); padding: 1.5rem; text-align: center;">
                        <div style="width: 80px; height: 80px; background: rgba(255,255,255,0.2); border-radius: 50%; margin: 0 auto 1rem auto; display: flex; align-items: center; justify-content: center; font-size: 2.5rem; color: white;">👨‍🚒</div>
                        <h3 style="color: white; margin: 0; font-size: 1.3rem;">James Rodriguez</h3>
                        <p style="color: rgba(255,255,255,0.9); margin: 0.3rem 0 0 0; font-size: 0.9rem;">Safety & Emergency Expert</p>
                    </div>
                    <div style="padding: 1.5rem;">
                        <div style="margin-bottom: 1rem;">
                            <span style="background: #dc3545; color: white; padding: 0.2rem 0.6rem; border-radius: 10px; font-size: 0.75rem; margin-right: 0.3rem;">10 Years</span>
                            <span style="background: #28a745; color: white; padding: 0.2rem 0.6rem; border-radius: 10px; font-size: 0.75rem; margin-right: 0.3rem;">Ex-Firefighter</span>
                            <span style="background: #007bff; color: white; padding: 0.2rem 0.6rem; border-radius: 10px; font-size: 0.75rem;">Emergency Prep</span>
                        </div>
                        <p style="color: #666; font-size: 0.9rem; line-height: 1.5; margin-bottom: 1rem;">Former firefighter with extensive emergency response experience. Teaches defensive driving and emergency handling with real-world expertise.</p>
                        <div style="font-size: 0.8rem; color: #888;">
                            <p style="margin: 0.3rem 0;">🎯 Students Taught: 950+</p>
                            <p style="margin: 0.3rem 0;">⭐ Rating: 4.7/5</p>
                            <p style="margin: 0.3rem 0;">🗣️ Languages: English, Spanish</p>
                        </div>
                    </div>
                </div>
                
                <!-- Kavitha Nair -->
                <div style="background: white; border-radius: 15px; overflow: hidden; box-shadow: 0 10px 25px rgba(0,0,0,0.1); transition: transform 0.3s ease;" onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='translateY(0)'">
                    <div style="background: linear-gradient(135deg, #20c997 0%, #28a745 100%); padding: 1.5rem; text-align: center;">
                        <div style="width: 80px; height: 80px; background: rgba(255,255,255,0.2); border-radius: 50%; margin: 0 auto 1rem auto; display: flex; align-items: center; justify-content: center; font-size: 2.5rem; color: white;">👩‍⚕️</div>
                        <h3 style="color: white; margin: 0; font-size: 1.3rem;">Kavitha Nair</h3>
                        <p style="color: rgba(255,255,255,0.9); margin: 0.3rem 0 0 0; font-size: 0.9rem;">Senior Citizens Specialist</p>
                    </div>
                    <div style="padding: 1.5rem;">
                        <div style="margin-bottom: 1rem;">
                            <span style="background: #6f42c1; color: white; padding: 0.2rem 0.6rem; border-radius: 10px; font-size: 0.75rem; margin-right: 0.3rem;">9 Years</span>
                            <span style="background: #e83e8c; color: white; padding: 0.2rem 0.6rem; border-radius: 10px; font-size: 0.75rem; margin-right: 0.3rem;">Senior Focus</span>
                            <span style="background: #17a2b8; color: white; padding: 0.2rem 0.6rem; border-radius: 10px; font-size: 0.75rem;">Adaptive Methods</span>
                        </div>
                        <p style="color: #666; font-size: 0.9rem; line-height: 1.5; margin-bottom: 1rem;">From Kerala, India. Specializes in teaching senior citizens and those returning to driving. Uses adaptive teaching methods for different learning needs.</p>
                        <div style="font-size: 0.8rem; color: #888;">
                            <p style="margin: 0.3rem 0;">🎯 Students Taught: 680+</p>
                            <p style="margin: 0.3rem 0;">⭐ Rating: 4.9/5</p>
                            <p style="margin: 0.3rem 0;">🗣️ Languages: English, Malayalam, Hindi</p>
                        </div>
                    </div>
                </div>
                
                <!-- Arjun Singh -->
                <div style="background: white; border-radius: 15px; overflow: hidden; box-shadow: 0 10px 25px rgba(0,0,0,0.1); transition: transform 0.3s ease;" onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='translateY(0)'">
                    <div style="background: linear-gradient(135deg, #007bff 0%, #17a2b8 100%); padding: 1.5rem; text-align: center;">
                        <div style="width: 80px; height: 80px; background: rgba(255,255,255,0.2); border-radius: 50%; margin: 0 auto 1rem auto; display: flex; align-items: center; justify-content: center; font-size: 2.5rem; color: white;">👨‍🔧</div>
                        <h3 style="color: white; margin: 0; font-size: 1.3rem;">Arjun Singh</h3>
                        <p style="color: rgba(255,255,255,0.9); margin: 0.3rem 0 0 0; font-size: 0.9rem;">Mechanics & Maintenance Expert</p>
                    </div>
                    <div style="padding: 1.5rem;">
                        <div style="margin-bottom: 1rem;">
                            <span style="background: #ffc107; color: #000; padding: 0.2rem 0.6rem; border-radius: 10px; font-size: 0.75rem; margin-right: 0.3rem;">11 Years</span>
                            <span style="background: #28a745; color: white; padding: 0.2rem 0.6rem; border-radius: 10px; font-size: 0.75rem; margin-right: 0.3rem;">Mechanic</span>
                            <span style="background: #dc3545; color: white; padding: 0.2rem 0.6rem; border-radius: 10px; font-size: 0.75rem;">Maintenance</span>
                        </div>
                        <p style="color: #666; font-size: 0.9rem; line-height: 1.5; margin-bottom: 1rem;">From Punjab, India. Former mechanic who teaches both driving and vehicle maintenance. Provides comprehensive automotive education.</p>
                        <div style="font-size: 0.8rem; color: #888;">
                            <p style="margin: 0.3rem 0;">🎯 Students Taught: 1,100+</p>
                            <p style="margin: 0.3rem 0;">⭐ Rating: 4.8/5</p>
                            <p style="margin: 0.3rem 0;">🗣️ Languages: English, Punjabi, Hindi</p>
                        </div>
                    </div>
                </div>
                
                <!-- Sarah Williams -->
                <div style="background: white; border-radius: 15px; overflow: hidden; box-shadow: 0 10px 25px rgba(0,0,0,0.1); transition: transform 0.3s ease;" onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='translateY(0)'">
                    <div style="background: linear-gradient(135deg, #6f42c1 0%, #e83e8c 100%); padding: 1.5rem; text-align: center;">
                        <div style="width: 80px; height: 80px; background: rgba(255,255,255,0.2); border-radius: 50%; margin: 0 auto 1rem auto; display: flex; align-items: center; justify-content: center; font-size: 2.5rem; color: white;">👩‍🏫</div>
                        <h3 style="color: white; margin: 0; font-size: 1.3rem;">Sarah Williams</h3>
                        <p style="color: rgba(255,255,255,0.9); margin: 0.3rem 0 0 0; font-size: 0.9rem;">Advanced Techniques Specialist</p>
                    </div>
                    <div style="padding: 1.5rem;">
                        <div style="margin-bottom: 1rem;">
                            <span style="background: #007bff; color: white; padding: 0.2rem 0.6rem; border-radius: 10px; font-size: 0.75rem; margin-right: 0.3rem;">14 Years</span>
                            <span style="background: #28a745; color: white; padding: 0.2rem 0.6rem; border-radius: 10px; font-size: 0.75rem; margin-right: 0.3rem;">Advanced Skills</span>
                            <span style="background: #ffc107; color: #000; padding: 0.2rem 0.6rem; border-radius: 10px; font-size: 0.75rem;">Parallel Parking</span>
                        </div>
                        <p style="color: #666; font-size: 0.9rem; line-height: 1.5; margin-bottom: 1rem;">Expert in advanced driving techniques including parallel parking, three-point turns, and highway merging. Known for making complex maneuvers simple.</p>
                        <div style="font-size: 0.8rem; color: #888;">
                            <p style="margin: 0.3rem 0;">🎯 Students Taught: 1,350+</p>
                            <p style="margin: 0.3rem 0;">⭐ Rating: 4.9/5</p>
                            <p style="margin: 0.3rem 0;">🗣️ Languages: English</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        
        <!-- Instructor Qualities -->
        <section style="margin: 4rem 0;">
            <h2 style="text-align: center; margin-bottom: 3rem; color: #333;">🌟 What Makes Our Instructors Special</h2>
            
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 2rem;">
                <div style="background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%); padding: 2rem; border-radius: 15px; text-align: center;">
                    <div style="font-size: 3rem; margin-bottom: 1rem;">🎓</div>
                    <h3>Certified & Licensed</h3>
                    <p>All instructors are state-certified with regular training updates and safety certifications to ensure the highest standards.</p>
                </div>
                
                <div style="background: linear-gradient(135deg, #e8f5e8 0%, #c8e6c9 100%); padding: 2rem; border-radius: 15px; text-align: center;">
                    <div style="font-size: 3rem; margin-bottom: 1rem;">💝</div>
                    <h3>Patient & Understanding</h3>
                    <p>Our instructors understand that everyone learns at their own pace and provide supportive, judgment-free instruction.</p>
                </div>
                
                <div style="background: linear-gradient(135deg, #fff3e0 0%, #ffe0b2 100%); padding: 2rem; border-radius: 15px; text-align: center;">
                    <div style="font-size: 3rem; margin-bottom: 1rem;">🌍</div>
                    <h3>Culturally Diverse</h3>
                    <p>Our team represents various cultures and languages, ensuring comfortable learning for students from all backgrounds.</p>
                </div>
                
                <div style="background: linear-gradient(135deg, #f3e5f5 0%, #e1bee7 100%); padding: 2rem; border-radius: 15px; text-align: center;">
                    <div style="font-size: 3rem; margin-bottom: 1rem;">🔄</div>
                    <h3>Continuous Learning</h3>
                    <p>Regular training sessions and workshops keep our instructors updated with the latest teaching methods and safety protocols.</p>
                </div>
                
                <div style="background: linear-gradient(135deg, #e1f5fe 0%, #b3e5fc 100%); padding: 2rem; border-radius: 15px; text-align: center;">
                    <div style="font-size: 3rem; margin-bottom: 1rem;">🛡️</div>
                    <h3>Safety First</h3>
                    <p>Every instructor prioritizes safety above all else, with extensive training in defensive driving and emergency procedures.</p>
                </div>
                
                <div style="background: linear-gradient(135deg, #fce4ec 0%, #f8bbd9 100%); padding: 2rem; border-radius: 15px; text-align: center;">
                    <div style="font-size: 3rem; margin-bottom: 1rem;">🎯</div>
                    <h3>Specialized Expertise</h3>
                    <p>Each instructor has specialized training in different areas like teen education, anxiety management, or advanced techniques.</p>
                </div>
            </div>
        </section>
        
        <!-- Instructor Matching -->
        <section style="margin: 4rem 0;">
            <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 4rem 2rem; border-radius: 20px; text-align: center;">
                <h2 style="margin-bottom: 2rem;">🎯 Find Your Perfect Instructor Match</h2>
                <p style="font-size: 1.2rem; margin-bottom: 3rem; opacity: 0.9; max-width: 700px; margin-left: auto; margin-right: auto;">We believe in matching students with the right instructor for their needs. Whether you prefer a specific teaching style, language, or have special requirements, we'll find the perfect fit for you.</p>
                
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 2rem; margin: 2rem 0;">
                    <div style="background: rgba(255,255,255,0.1); padding: 2rem; border-radius: 15px;">
                        <div style="font-size: 2.5rem; margin-bottom: 1rem;">👶</div>
                        <h3>Teen Drivers</h3>
                        <p>Patient instructors experienced in working with teenage students and nervous first-time drivers.</p>
                    </div>
                    
                    <div style="background: rgba(255,255,255,0.1); padding: 2rem; border-radius: 15px;">
                        <div style="font-size: 2.5rem; margin-bottom: 1rem;">👴</div>
                        <h3>Senior Citizens</h3>
                        <p>Specialized instruction for older adults returning to driving or updating their skills.</p>
                    </div>
                    
                    <div style="background: rgba(255,255,255,0.1); padding: 2rem; border-radius: 15px;">
                        <div style="font-size: 2.5rem; margin-bottom: 1rem;">🌍</div>
                        <h3>International Students</h3>
                        <p>Multilingual instructors who understand different driving cultures and regulations.</p>
                    </div>
                    
                    <div style="background: rgba(255,255,255,0.1); padding: 2rem; border-radius: 15px;">
                        <div style="font-size: 2.5rem; margin-bottom: 1rem;">😰</div>
                        <h3>Anxiety Support</h3>
                        <p>Specially trained instructors who excel at helping nervous and anxious drivers build confidence.</p>
                    </div>
                </div>
                
                <div style="margin-top: 3rem;">
                    <a href="register.php" class="btn btn-success" style="margin: 0.5rem; padding: 1rem 2rem; font-size: 1.1rem;">🚗 Start Learning Today</a>
                    <a href="contact.php" class="btn" style="margin: 0.5rem; padding: 1rem 2rem; font-size: 1.1rem; background: rgba(255,255,255,0.2); color: white;">📞 Request Instructor Match</a>
                </div>
            </div>
        </section>
        
        <!-- Testimonials -->
        <section style="margin: 4rem 0;">
            <h2 style="text-align: center; margin-bottom: 3rem; color: #333;">💬 What Our Students Say</h2>
            
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(350px, 1fr)); gap: 2rem;">
                <div style="background: white; padding: 2rem; border-radius: 15px; box-shadow: 0 10px 25px rgba(0,0,0,0.1);">
                    <div style="display: flex; margin-bottom: 1rem;">
                        <span style="color: #ffc107;">⭐⭐⭐⭐⭐</span>
                        <span style="margin-left: 1rem; font-weight: 600;">Emily Johnson</span>
                    </div>
                    <p style="color: #666; font-style: italic; margin-bottom: 1rem;">"Priya was absolutely amazing! As a nervous driver, she made me feel so comfortable and confident. Her patience and encouragement helped me pass on my first try!"</p>
                    <div style="font-size: 0.9rem; color: #888;">Instructor: Priya Sharma</div>
                </div>
                
                <div style="background: white; padding: 2rem; border-radius: 15px; box-shadow: 0 10px 25px rgba(0,0,0,0.1);">
                    <div style="display: flex; margin-bottom: 1rem;">
                        <span style="color: #ffc107;">⭐⭐⭐⭐⭐</span>
                        <span style="margin-left: 1rem; font-weight: 600;">Michael Brown</span>
                    </div>
                    <p style="color: #666; font-style: italic; margin-bottom: 1rem;">"Rajesh taught me manual transmission and highway driving like a pro. His technical knowledge and methodical approach made everything click. Highly recommend!"</p>
                    <div style="font-size: 0.9rem; color: #888;">Instructor: Rajesh Patel</div>
                </div>
                
                <div style="background: white; padding: 2rem; border-radius: 15px; box-shadow: 0 10px 25px rgba(0,0,0,0.1);">
                    <div style="display: flex; margin-bottom: 1rem;">
                        <span style="color: #ffc107;">⭐⭐⭐⭐⭐</span>
                        <span style="margin-left: 1rem; font-weight: 600;">Lisa Chen</span>
                    </div>
                    <p style="color: #666; font-style: italic; margin-bottom: 1rem;">"Anita's patience is unmatched! I was terrified to drive, but she helped me overcome my anxiety step by step. Now I drive confidently every day!"</p>
                    <div style="font-size: 0.9rem; color: #888;">Instructor: Anita Gurung</div>
                </div>
            </div>
        </section>
    </div>
    
<?php include 'includes/footer.php'; ?>
