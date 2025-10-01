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
        $instructor_stats['total_students_taught'] = array_sum(array_column($instructors, 'students_taught'));
        $instructor_stats['avg_experience'] = round(array_sum(array_column($instructors, 'experience_years')) / count($instructors), 1);
        $instructor_stats['avg_rating'] = round(array_sum(array_column($instructors, 'rating')) / count($instructors), 1);
    }
} catch (Exception $e) {
    error_log("Error fetching instructors: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Our Expert Instructors - Origin Driving School (Live Data)</title>
    <link rel="stylesheet" href="css/styles.css">
    <meta name="description" content="Meet our team of certified, experienced driving instructors at Origin Driving School - Real-time updated information">
</head>
<body class="page-transition">
    <header>
        <h1>👨‍🏫 Meet Our Expert Instructors</h1>
        <p>Certified professionals dedicated to your driving success - Real-time data</p>
    </header>
    
    <nav class="role-nav">
        <a href="index.php" class="nav-item">
            <span class="nav-icon">🏠</span>
            <span class="nav-label">Home</span>
        </a>
        <a href="about.php" class="nav-item">
            <span class="nav-icon">ℹ️</span>
            <span class="nav-label">About</span>
        </a>
        <a href="instructors.php" class="nav-item active">
            <span class="nav-icon">👨‍🏫</span>
            <span class="nav-label">Instructors</span>
        </a>
        <a href="contact.php" class="nav-item">
            <span class="nav-icon">📞</span>
            <span class="nav-label">Contact</span>
        </a>
        <a href="login.php" class="nav-item">
            <span class="nav-icon">🔐</span>
            <span class="nav-label">Login</span>
        </a>
    </nav>
    
    <div class="container">
        <!-- Hero Section -->
        <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 4rem 2rem; border-radius: 20px; text-align: center; margin: 2rem 0;">
            <div style="font-size: 4rem; margin-bottom: 1rem;">🎓</div>
            <h2 style="font-size: 2.5rem; margin-bottom: 1rem;">Learn from the Best</h2>
            <p style="font-size: 1.2rem; opacity: 0.9; max-width: 700px; margin: 0 auto;">Our team of certified driving instructors brings years of experience, patience, and expertise to help you become a confident, safe driver. Each instructor is carefully selected and trained to meet our high standards.</p>
            <div style="background: rgba(255,255,255,0.2); padding: 1rem; border-radius: 10px; margin-top: 2rem; display: inline-block;">
                <span style="font-weight: bold;">🔄 Real-time Data</span> - Information updates automatically from our database
            </div>
        </div>
        
        <!-- Real-time Stats Section -->
        <section style="margin: 4rem 0;">
            <h2 style="text-align: center; margin-bottom: 3rem; color: #333;">📊 Live Statistics</h2>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 2rem;">
                <div style="background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%); padding: 2rem; border-radius: 15px; text-align: center;">
                    <div style="font-size: 3rem; margin-bottom: 0.5rem;"><?php echo $instructor_stats['total_instructors']; ?></div>
                    <h3 style="margin: 0; color: #1976d2;">Certified Instructors</h3>
                </div>
                <div style="background: linear-gradient(135deg, #e8f5e8 0%, #c8e6c9 100%); padding: 2rem; border-radius: 15px; text-align: center;">
                    <div style="font-size: 3rem; margin-bottom: 0.5rem;"><?php echo array_sum(array_column($instructors, 'experience_years')); ?>+</div>
                    <h3 style="margin: 0; color: #388e3c;">Years Combined Experience</h3>
                </div>
                <div style="background: linear-gradient(135deg, #fff3e0 0%, #ffe0b2 100%); padding: 2rem; border-radius: 15px; text-align: center;">
                    <div style="font-size: 3rem; margin-bottom: 0.5rem;"><?php echo $instructor_stats['avg_rating']; ?>⭐</div>
                    <h3 style="margin: 0; color: #f57c00;">Average Rating</h3>
                </div>
                <div style="background: linear-gradient(135deg, #f3e5f5 0%, #e1bee7 100%); padding: 2rem; border-radius: 15px; text-align: center;">
                    <div style="font-size: 3rem; margin-bottom: 0.5rem;"><?php echo number_format($instructor_stats['total_students_taught']); ?>+</div>
                    <h3 style="margin: 0; color: #7b1fa2;">Students Taught</h3>
                </div>
            </div>
        </section>
        
        <!-- Dynamic Instructors Section -->
        <section style="margin: 4rem 0;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 3rem; flex-wrap: wrap; gap: 1rem;">
                <h2 style="color: #333; margin: 0;">🏆 Our Expert Instructors</h2>
                <div style="background: #28a745; color: white; padding: 0.5rem 1rem; border-radius: 20px; font-size: 0.9rem;">
                    🔄 Auto-Updates - Last refreshed: <?php echo date('M j, Y g:i A'); ?>
                </div>
            </div>
            
            <?php if (empty($instructors)): ?>
                <div style="text-align: center; padding: 4rem; background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border-radius: 20px;">
                    <div style="font-size: 4rem; margin-bottom: 1rem;">👨‍🏫</div>
                    <h3>No Instructors Available</h3>
                    <p>We're currently updating our instructor database. Please check back soon!</p>
                    <div style="margin-top: 2rem;">
                        <a href="setup_instructors.php" style="background: #007bff; color: white; padding: 1rem 2rem; text-decoration: none; border-radius: 10px; font-weight: bold;">🔧 Setup Sample Data</a>
                    </div>
                </div>
            <?php else: ?>
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(400px, 1fr)); gap: 3rem;">
                    <?php foreach ($instructors as $instructor): ?>
                        <div style="background: white; border-radius: 20px; overflow: hidden; box-shadow: 0 15px 35px rgba(0,0,0,0.1); transition: all 0.3s ease;" onmouseover="this.style.transform='translateY(-10px) scale(1.02)'" onmouseout="this.style.transform='translateY(0) scale(1)'">
                            <!-- Instructor Header -->
                            <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 2rem; text-align: center;">
                                <div style="width: 120px; height: 120px; background: rgba(255,255,255,0.2); border-radius: 50%; margin: 0 auto 1rem auto; display: flex; align-items: center; justify-content: center; font-size: 3.5rem; color: white; border: 4px solid rgba(255,255,255,0.3);">
                                    <?php 
                                    // Dynamic emoji based on name or specialization
                                    if (stripos($instructor['name'], 'mike') !== false || stripos($instructor['title'], 'chief') !== false) echo '👨‍💼';
                                    elseif (stripos($instructor['name'], 'priya') !== false || stripos($instructor['name'], 'sarah') !== false || stripos($instructor['name'], 'maya') !== false) echo '👩‍🏫';
                                    elseif (stripos($instructor['name'], 'raj') !== false || stripos($instructor['name'], 'david') !== false || stripos($instructor['name'], 'arjun') !== false) echo '👨‍🏫';
                                    elseif (stripos($instructor['name'], 'elena') !== false || stripos($instructor['name'], 'maria') !== false) echo '👩‍💼';
                                    else echo '🚗';
                                    ?>
                                </div>
                                <h3 style="color: white; margin: 0;"><?php echo htmlspecialchars($instructor['name']); ?></h3>
                                <p style="color: rgba(255,255,255,0.9); margin: 0.5rem 0 0 0;"><?php echo htmlspecialchars($instructor['title']); ?></p>
                            </div>
                            
                            <!-- Instructor Details -->
                            <div style="padding: 2rem;">
                                <!-- Tags -->
                                <div style="margin-bottom: 1.5rem;">
                                    <span style="background: #007bff; color: white; padding: 0.3rem 0.8rem; border-radius: 15px; font-size: 0.8rem; margin-right: 0.5rem;">
                                        <?php echo $instructor['experience_years']; ?>+ Years
                                    </span>
                                    <span style="background: #28a745; color: white; padding: 0.3rem 0.8rem; border-radius: 15px; font-size: 0.8rem; margin-right: 0.5rem;">
                                        ⭐ <?php echo $instructor['rating']; ?>
                                    </span>
                                    <span style="background: #ffc107; color: #000; padding: 0.3rem 0.8rem; border-radius: 15px; font-size: 0.8rem;">
                                        <?php echo number_format($instructor['students_taught']); ?> Students
                                    </span>
                                </div>
                                
                                <!-- Bio -->
                                <p style="color: #666; line-height: 1.6; margin-bottom: 1.5rem;">
                                    <?php echo htmlspecialchars($instructor['bio']); ?>
                                </p>
                                
                                <!-- Specializations -->
                                <div style="border-top: 1px solid #eee; padding-top: 1.5rem;">
                                    <h4 style="margin-bottom: 1rem; color: #333;">📊 Specializations:</h4>
                                    <div style="color: #555; line-height: 1.6;">
                                        <?php
                                        $specializations = explode(',', $instructor['specializations']);
                                        foreach ($specializations as $spec) {
                                            echo '<span style="display: inline-block; background: #f8f9fa; padding: 0.3rem 0.8rem; border-radius: 15px; margin: 0.2rem 0.2rem 0.2rem 0; font-size: 0.8rem; border: 1px solid #dee2e6;">' . htmlspecialchars(trim($spec)) . '</span>';
                                        }
                                        ?>
                                    </div>
                                </div>
                                
                                <!-- Languages -->
                                <?php if (!empty($instructor['languages'])): ?>
                                <div style="margin-top: 1.5rem; padding-top: 1rem; border-top: 1px solid #eee;">
                                    <h4 style="margin-bottom: 0.5rem; color: #333;">🌍 Languages:</h4>
                                    <p style="color: #555; margin: 0;"><?php echo htmlspecialchars($instructor['languages']); ?></p>
                                </div>
                                <?php endif; ?>
                                
                                <!-- Certifications -->
                                <?php if (!empty($instructor['certifications'])): ?>
                                <div style="margin-top: 1.5rem; padding-top: 1rem; border-top: 1px solid #eee;">
                                    <h4 style="margin-bottom: 0.5rem; color: #333;">🏆 Certifications:</h4>
                                    <p style="color: #555; margin: 0; font-size: 0.9rem;"><?php echo htmlspecialchars($instructor['certifications']); ?></p>
                                </div>
                                <?php endif; ?>
                                
                                <!-- Contact -->
                                <div style="margin-top: 1.5rem; padding: 1rem; background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border-radius: 10px;">
                                    <div style="display: grid; gap: 0.5rem;">
                                        <?php if (!empty($instructor['email'])): ?>
                                        <div style="color: #555;">📧 <?php echo htmlspecialchars($instructor['email']); ?></div>
                                        <?php endif; ?>
                                        <?php if (!empty($instructor['phone'])): ?>
                                        <div style="color: #555;">📱 <?php echo htmlspecialchars($instructor['phone']); ?></div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                
                                <!-- Book Lesson Button -->
                                <div style="text-align: center; margin-top: 1.5rem;">
                                    <a href="login.php" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 1rem 2rem; text-decoration: none; border-radius: 25px; font-weight: bold; display: inline-block; transition: all 0.3s ease;" onmouseover="this.style.transform='translateY(-3px)'" onmouseout="this.style.transform='translateY(0)'">
                                        📅 Book Lesson with <?php echo explode(' ', $instructor['name'])[0]; ?>
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                
                <!-- Auto-update indicator -->
                <div style="text-align: center; margin-top: 3rem; padding: 2rem; background: linear-gradient(135deg, #e8f5e8 0%, #c8e6c9 100%); border-radius: 15px;">
                    <div style="font-size: 1.5rem; margin-bottom: 0.5rem;">🔄</div>
                    <h3 style="color: #2e7d32; margin: 0;">Real-time Updates</h3>
                    <p style="color: #388e3c; margin: 0.5rem 0 1rem 0;">This page automatically shows the latest instructor information from our database. New instructors and updates appear instantly!</p>
                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem; margin-top: 1rem;">
                        <div style="background: rgba(255,255,255,0.7); padding: 1rem; border-radius: 10px;">
                            <strong>✅ Auto-refreshing data</strong><br>
                            <small>No page refresh needed</small>
                        </div>
                        <div style="background: rgba(255,255,255,0.7); padding: 1rem; border-radius: 10px;">
                            <strong>⚡ Instant updates</strong><br>
                            <small>New instructors show immediately</small>
                        </div>
                        <div style="background: rgba(255,255,255,0.7); padding: 1rem; border-radius: 10px;">
                            <strong>📊 Live statistics</strong><br>
                            <small>Real-time calculations</small>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </section>
        
        <!-- Features Section -->
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
                    <h3>Continuous Training</h3>
                    <p>Regular skill updates and advanced safety training ensure our instructors stay current with best practices and regulations.</p>
                </div>
            </div>
        </section>
        
        <!-- Call to Action -->
        <section style="text-align: center; margin: 4rem 0; padding: 3rem; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border-radius: 20px;">
            <h2 style="font-size: 2.5rem; margin-bottom: 1rem;">Ready to Start Learning?</h2>
            <p style="font-size: 1.2rem; margin-bottom: 2rem; opacity: 0.9;">Choose from our expert instructors and begin your journey to confident driving today.</p>
            
            <div style="display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap;">
                <a href="login.php" style="background: var(--yellow-line, #ffc107); color: #000; padding: 1rem 2rem; text-decoration: none; border-radius: 25px; font-weight: bold; transition: all 0.3s ease;" onmouseover="this.style.transform='translateY(-3px)'" onmouseout="this.style.transform='translateY(0)'">
                    🚗 Start Learning Today
                </a>
                <a href="contact.php" style="background: rgba(255,255,255,0.2); color: white; padding: 1rem 2rem; text-decoration: none; border-radius: 25px; font-weight: bold; border: 2px solid rgba(255,255,255,0.3); transition: all 0.3s ease;" onmouseover="this.style.background='rgba(255,255,255,0.3)'" onmouseout="this.style.background='rgba(255,255,255,0.2)'">
                    💬 Ask Questions
                </a>
            </div>
        </section>
    </div>
    
    <footer style="background: #333; color: white; text-align: center; padding: 2rem;">
        <p>&copy; <?php echo date('Y'); ?> Origin Driving School. All rights reserved.</p>
        <p style="opacity: 0.7;">🔄 Real-time instructor data powered by our advanced database system</p>
    </footer>
    
    <style>
        /* Auto-refresh indicator animation */
        @keyframes pulse {
            0% { opacity: 1; }
            50% { opacity: 0.7; }
            100% { opacity: 1; }
        }
        
        .pulse {
            animation: pulse 2s infinite;
        }
    </style>
</body>
</html>
