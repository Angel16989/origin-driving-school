<?php 
session_start();
require_once 'php/db_connect.php';

// Get instructors from database
$instructors = [];
try {
    $query = "SELECT * FROM instructors ORDER BY experience_years DESC";
    $result = $conn->query($query);
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $instructors[] = $row;
        }
    }
} catch (Exception $e) {
    // If no data, show sample instructors
    $instructors = [
        [
            'name' => 'Mike Brown',
            'email' => 'mike@origindriving.com',
            'specialization' => 'Defensive Driving',
            'experience_years' => 8,
            'rating' => 4.9,
            'students_taught' => 450
        ],
        [
            'name' => 'Sara Lee',
            'email' => 'sara@origindriving.com',
            'specialization' => 'Highway Training',
            'experience_years' => 6,
            'rating' => 4.8,
            'students_taught' => 320
        ],
        [
            'name' => 'David Chen',
            'email' => 'david@origindriving.com',
            'specialization' => 'City Driving',
            'experience_years' => 5,
            'rating' => 4.7,
            'students_taught' => 280
        ]
    ];
}

$instructorImages = [
    "images/Mike Johnson.png",
    "images/Sarah Wlliams.png",
    "images/David Chen.png",
    "images/Maria Rodriguez.png",
    "images/james wilson.png"
];

$page_title = "Our Instructors - Origin Driving School";
$page_description = "Meet our professional driving instructors";
include 'includes/header.php';
?>

<link rel="stylesheet" href="css/enhanced-styles.css">

<style>
/* Desktop-Specific Instructor Page Styles */
@media screen and (min-width: 1024px) {
    .instructor-hero {
        padding: 8rem 2rem !important;
    }
    
    .instructor-hero h1 {
        font-size: 4.5rem !important;
    }
    
    .instructor-hero p {
        font-size: 1.8rem !important;
    }
    
    .instructor-stats {
        gap: 5rem !important;
    }
    
    .instructor-grid {
        grid-template-columns: repeat(auto-fit, minmax(400px, 1fr)) !important;
        gap: 3rem !important;
    }
    
    .instructor-card {
        padding: 3rem !important;
        min-height: 450px !important;
    }
    
    .instructor-card h3 {
        font-size: 1.8rem !important;
    }
    
    .instructor-card p {
        font-size: 1.3rem !important;
    }
    
    .instructor-card .stats {
        font-size: 1.1rem !important;
    }
}
</style>

<!-- Simple Hero Section -->
<section class="instructor-hero hero-with-photo" style="background: linear-gradient(135deg, rgba(12, 36, 97, 0.84) 0%, rgba(64, 115, 158, 0.78) 100%), url('https://images.unsplash.com/photo-1521737604893-d14cc237f11d?auto=format&fit=crop&w=2000&q=80'); color: white; padding: 4rem 2rem; text-align: center; background-size: cover; background-position: center;">
    <div style="max-width: 800px; margin: 0 auto;">
        <h1 style="font-size: 2.5rem; margin-bottom: 1rem; font-weight: 700;">Meet Our Instructors</h1>
        <p style="font-size: 1.2rem; opacity: 0.9; margin-bottom: 2rem;">Professional, certified, and experienced driving instructors ready to help you succeed</p>
        <div class="instructor-stats" style="display: flex; justify-content: center; gap: 3rem; margin-top: 2rem;">
            <div style="text-align: center;">
                <div style="font-size: 2rem; font-weight: bold;"><?php echo count($instructors); ?>+</div>
                <div style="opacity: 0.8;">Expert Instructors</div>
            </div>
            <div style="text-align: center;">
                <div style="font-size: 2rem; font-weight: bold;">1000+</div>
                <div style="opacity: 0.8;">Students Taught</div>
            </div>
            <div style="text-align: center;">
                <div style="font-size: 2rem; font-weight: bold;">4.8★</div>
                <div style="opacity: 0.8;">Average Rating</div>
            </div>
        </div>
    </div>
</section>

<!-- Simple Instructor Grid -->
<section style="padding: 4rem 2rem; background: #f8f9fa;">
    <div style="max-width: 1200px; margin: 0 auto;">
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 2rem;">
            <?php foreach ($instructors as $index => $instructor): ?>
            <?php $portrait = $instructorImages[$index % count($instructorImages)]; ?>
            <div style="background: white; border-radius: 10px; padding: 2rem; text-align: center; box-shadow: 0 20px 45px rgba(12,36,97,0.12); transition: transform 0.3s ease; overflow: hidden;" onmouseover="this.style.transform='translateY(-8px)'" onmouseout="this.style.transform='translateY(0)';">
                <div style="width: 120px; height: 120px; border-radius: 50%; overflow: hidden; margin: 0 auto 1.5rem; box-shadow: 0 12px 30px rgba(12, 36, 97, 0.18);">
                    <img src="<?php echo $portrait; ?>" alt="Portrait of <?php echo htmlspecialchars($instructor['name'] ?? 'driving instructor'); ?>" style="width: 100%; height: 100%; object-fit: cover;">
                </div>
                
                <!-- Instructor Info -->
                <h3 style="color: #0c2461; margin-bottom: 0.5rem; font-size: 1.3rem;"><?php echo htmlspecialchars($instructor['name'] ?? 'Unknown Instructor'); ?></h3>
                <p style="color: #40739e; margin-bottom: 1rem; font-weight: 500;"><?php echo htmlspecialchars($instructor['specialization'] ?? 'General Instruction'); ?></p>
                
                <!-- Simple Stats -->
                <div style="margin-bottom: 1.5rem;">
                    <div style="display: flex; justify-content: space-between; margin-bottom: 0.5rem;">
                        <span style="color: #666;">Experience:</span>
                        <span style="font-weight: 500;"><?php echo $instructor['experience_years'] ?? 0; ?> years</span>
                    </div>
                    <div style="display: flex; justify-content: space-between; margin-bottom: 0.5rem;">
                        <span style="color: #666;">Students Taught:</span>
                        <span style="font-weight: 500;"><?php echo $instructor['students_taught'] ?? 0; ?>+</span>
                    </div>
                    <div style="display: flex; justify-content: space-between;">
                        <span style="color: #666;">Rating:</span>
                        <span style="font-weight: 500; color: #ffc107;">⭐ <?php echo $instructor['rating'] ?? 5.0; ?>/5</span>
                    </div>
                </div>
                
                <!-- Simple Contact Button -->
                <a href="book_lesson.php" style="background: #0c2461; color: white; padding: 0.8rem 2rem; border-radius: 25px; text-decoration: none; font-weight: 500; transition: background 0.3s ease;" onmouseover="this.style.background='#40739e'" onmouseout="this.style.background='#0c2461'">
                    Book Lesson
                </a>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Simple Why Choose Us -->
<section style="padding: 4rem 2rem; background: white;">
    <div style="max-width: 800px; margin: 0 auto; text-align: center;">
        <h2 style="color: #0c2461; margin-bottom: 2rem; font-size: 2rem;">Why Choose Our Instructors?</h2>
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 2rem; margin-top: 3rem;">
            <div style="padding: 1.5rem;">
                <div style="font-size: 3rem; margin-bottom: 1rem;">✅</div>
                <h3 style="color: #0c2461; margin-bottom: 0.5rem;">Certified</h3>
                <p style="color: #666; font-size: 0.9rem;">All instructors are fully licensed and certified</p>
            </div>
            <div style="padding: 1.5rem;">
                <div style="font-size: 3rem; margin-bottom: 1rem;">🎯</div>
                <h3 style="color: #0c2461; margin-bottom: 0.5rem;">Experienced</h3>
                <p style="color: #666; font-size: 0.9rem;">Years of professional driving instruction</p>
            </div>
            <div style="padding: 1.5rem;">
                <div style="font-size: 3rem; margin-bottom: 1rem;">💪</div>
                <h3 style="color: #0c2461; margin-bottom: 0.5rem;">Patient</h3>
                <p style="color: #666; font-size: 0.9rem;">Supportive and understanding teaching approach</p>
            </div>
            <div style="padding: 1.5rem;">
                <div style="font-size: 3rem; margin-bottom: 1rem;">🚗</div>
                <h3 style="color: #0c2461; margin-bottom: 0.5rem;">Modern</h3>
                <p style="color: #666; font-size: 0.9rem;">Up-to-date with latest driving techniques</p>
            </div>
        </div>
    </div>
</section>

<!-- Simple CTA -->
<section style="background: #0c2461; color: white; padding: 4rem 2rem; text-align: center;">
    <div style="max-width: 600px; margin: 0 auto;">
        <h2 style="margin-bottom: 1rem; font-size: 2rem;">Ready to Start Learning?</h2>
        <p style="opacity: 0.9; margin-bottom: 2rem; font-size: 1.1rem;">Book your first lesson with one of our professional instructors today</p>
        <a href="book_lesson.php" style="background: #ffc107; color: #0c2461; padding: 1rem 3rem; border-radius: 30px; text-decoration: none; font-weight: 600; font-size: 1.1rem; transition: transform 0.3s ease;" onmouseover="this.style.transform='translateY(-3px)'" onmouseout="this.style.transform='translateY(0)'">
            Book Your Lesson Now
        </a>
    </div>
</section>

<?php include 'includes/footer.php'; ?>