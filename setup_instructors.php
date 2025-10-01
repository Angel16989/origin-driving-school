<?php
// Database connection
require_once 'includes/config.php';

// Create instructors table if it doesn't exist
$create_instructors = "CREATE TABLE IF NOT EXISTS instructors (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    title VARCHAR(100) NOT NULL,
    experience_years INT NOT NULL,
    specializations TEXT,
    bio TEXT,
    languages TEXT,
    rating DECIMAL(2,1) DEFAULT 5.0,
    students_taught INT DEFAULT 0,
    profile_image VARCHAR(255),
    email VARCHAR(100),
    phone VARCHAR(20),
    status ENUM('active', 'inactive') DEFAULT 'active',
    certifications TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

if ($conn->query($create_instructors) === TRUE) {
    echo "✅ Instructors table created successfully\n";
} else {
    echo "❌ Error creating table: " . $conn->error . "\n";
    exit;
}

// Sample instructor data with Indian, Nepali, and diverse names
$instructors = [
    [
        'name' => 'Mike Johnson',
        'title' => 'Chief Instructor & Founder',
        'experience_years' => 20,
        'specializations' => 'Anxiety & Confidence Building, Advanced Defensive Driving, Instructor Training, DMV Test Preparation',
        'bio' => 'Founded Origin Driving School with a vision of making roads safer through quality education. Specializes in nervous drivers and has personally trained over 3,000 students with a 99% first-time pass rate.',
        'languages' => 'English',
        'rating' => 4.9,
        'students_taught' => 3000,
        'email' => 'mike.johnson@origindriving.com',
        'phone' => '(555) 001-0001',
        'certifications' => 'State Certified Instructor, Advanced Safety Training, Instructor Trainer Certification'
    ],
    [
        'name' => 'Priya Sharma',
        'title' => 'Senior Driving Instructor',
        'experience_years' => 15,
        'specializations' => 'Teen Driver Education, International Student Support, Parent-Teen Program Coordination',
        'bio' => 'Originally from Mumbai, Priya brings patience and cultural understanding to her teaching. She specializes in working with teenage drivers and international students.',
        'languages' => 'English, Hindi, Gujarati',
        'rating' => 4.8,
        'students_taught' => 1850,
        'email' => 'priya.sharma@origindriving.com',
        'phone' => '(555) 001-0002',
        'certifications' => 'Teen Driver Specialist, International Student Instructor, Bilingual Teaching Certification'
    ],
    [
        'name' => 'Rajesh Patel',
        'title' => 'Manual Transmission Specialist',
        'experience_years' => 8,
        'specializations' => 'Manual Cars, Highway Driving, Technical Vehicle Knowledge',
        'bio' => 'From Ahmedabad, specializes in manual transmission and highway driving. Known for his methodical approach and technical expertise in vehicle mechanics.',
        'languages' => 'English, Hindi, Gujarati',
        'rating' => 4.9,
        'students_taught' => 850,
        'email' => 'rajesh.patel@origindriving.com',
        'phone' => '(555) 001-0003',
        'certifications' => 'Manual Transmission Specialist, Highway Driving Expert, Vehicle Mechanics Certification'
    ],
    [
        'name' => 'Suman Thapa',
        'title' => 'Women\'s Safety Specialist',
        'experience_years' => 12,
        'specializations' => 'Women\'s Safety Programs, City Driving, Defensive Techniques',
        'bio' => 'Originally from Kathmandu, Nepal. Expert in city driving and women\'s safety programs. Creates comfortable learning environment for all students.',
        'languages' => 'English, Nepali, Hindi',
        'rating' => 4.8,
        'students_taught' => 1200,
        'email' => 'suman.thapa@origindriving.com',
        'phone' => '(555) 001-0004',
        'certifications' => 'Women\'s Safety Instructor, City Driving Expert, Cultural Sensitivity Training'
    ],
    [
        'name' => 'David Chen',
        'title' => 'Tech Integration Specialist',
        'experience_years' => 6,
        'specializations' => 'Technology Integration, Modern Teaching Methods, App-Based Learning',
        'bio' => 'Combines traditional driving instruction with modern technology. Uses simulators and apps to enhance learning experience for tech-oriented students.',
        'languages' => 'English, Mandarin',
        'rating' => 4.9,
        'students_taught' => 650,
        'email' => 'david.chen@origindriving.com',
        'phone' => '(555) 001-0005',
        'certifications' => 'Technology Integration Specialist, Modern Teaching Methods, Digital Learning Certification'
    ],
    [
        'name' => 'Anita Gurung',
        'title' => 'Patience & Confidence Specialist',
        'experience_years' => 7,
        'specializations' => 'Anxiety Help, Patient Teaching, Confidence Building',
        'bio' => 'From the mountains of Nepal, brings exceptional patience and understanding. Specializes in helping anxious and first-time drivers build confidence.',
        'languages' => 'English, Nepali, Hindi',
        'rating' => 5.0,
        'students_taught' => 780,
        'email' => 'anita.gurung@origindriving.com',
        'phone' => '(555) 001-0006',
        'certifications' => 'Anxiety Management Specialist, Patient Teaching Certification, Confidence Building Expert'
    ],
    [
        'name' => 'James Rodriguez',
        'title' => 'Safety & Emergency Expert',
        'experience_years' => 10,
        'specializations' => 'Emergency Response, Defensive Driving, Safety Protocols',
        'bio' => 'Former firefighter with extensive emergency response experience. Teaches defensive driving and emergency handling with real-world expertise.',
        'languages' => 'English, Spanish',
        'rating' => 4.7,
        'students_taught' => 950,
        'email' => 'james.rodriguez@origindriving.com',
        'phone' => '(555) 001-0007',
        'certifications' => 'Emergency Response Specialist, Former Firefighter, Advanced Safety Training'
    ],
    [
        'name' => 'Kavitha Nair',
        'title' => 'Senior Citizens Specialist',
        'experience_years' => 9,
        'specializations' => 'Senior Citizen Training, Adaptive Methods, Return-to-Driving Programs',
        'bio' => 'From Kerala, India. Specializes in teaching senior citizens and those returning to driving. Uses adaptive teaching methods for different learning needs.',
        'languages' => 'English, Malayalam, Hindi',
        'rating' => 4.9,
        'students_taught' => 680,
        'email' => 'kavitha.nair@origindriving.com',
        'phone' => '(555) 001-0008',
        'certifications' => 'Senior Citizen Specialist, Adaptive Teaching Methods, Return-to-Driving Certification'
    ],
    [
        'name' => 'Arjun Singh',
        'title' => 'Mechanics & Maintenance Expert',
        'experience_years' => 11,
        'specializations' => 'Vehicle Mechanics, Maintenance Education, Technical Training',
        'bio' => 'From Punjab, India. Former mechanic who teaches both driving and vehicle maintenance. Provides comprehensive automotive education.',
        'languages' => 'English, Punjabi, Hindi',
        'rating' => 4.8,
        'students_taught' => 1100,
        'email' => 'arjun.singh@origindriving.com',
        'phone' => '(555) 001-0009',
        'certifications' => 'Certified Mechanic, Vehicle Maintenance Expert, Technical Education Specialist'
    ],
    [
        'name' => 'Sarah Williams',
        'title' => 'Advanced Techniques Specialist',
        'experience_years' => 14,
        'specializations' => 'Advanced Driving Skills, Parallel Parking, Complex Maneuvers',
        'bio' => 'Expert in advanced driving techniques including parallel parking, three-point turns, and highway merging. Known for making complex maneuvers simple.',
        'languages' => 'English',
        'rating' => 4.9,
        'students_taught' => 1350,
        'email' => 'sarah.williams@origindriving.com',
        'phone' => '(555) 001-0010',
        'certifications' => 'Advanced Techniques Specialist, Parallel Parking Expert, Complex Maneuvers Certification'
    ],
    [
        'name' => 'Deepak Maharjan',
        'title' => 'Mountain Driving Expert',
        'experience_years' => 13,
        'specializations' => 'Mountain Driving, Weather Conditions, Steep Terrain Navigation',
        'bio' => 'From the hills of Nepal, expert in mountain and hill driving. Teaches students how to navigate challenging terrain and weather conditions safely.',
        'languages' => 'English, Nepali, Hindi',
        'rating' => 4.8,
        'students_taught' => 920,
        'email' => 'deepak.maharjan@origindriving.com',
        'phone' => '(555) 001-0011',
        'certifications' => 'Mountain Driving Specialist, Weather Conditions Expert, Steep Terrain Navigation'
    ],
    [
        'name' => 'Maria Garcia',
        'title' => 'Bilingual Education Coordinator',
        'experience_years' => 9,
        'specializations' => 'Spanish Instruction, Cultural Integration, Community Outreach',
        'bio' => 'Dedicated to serving the Spanish-speaking community. Provides culturally sensitive instruction and helps students integrate into local driving culture.',
        'languages' => 'English, Spanish',
        'rating' => 4.9,
        'students_taught' => 1075,
        'email' => 'maria.garcia@origindriving.com',
        'phone' => '(555) 001-0012',
        'certifications' => 'Bilingual Education Specialist, Cultural Integration Expert, Community Outreach Coordinator'
    ]
];

// Insert instructor data
$insert_sql = "INSERT INTO instructors (name, title, experience_years, specializations, bio, languages, rating, students_taught, email, phone, certifications) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($insert_sql);

$inserted_count = 0;
foreach ($instructors as $instructor) {
    $stmt->bind_param("ssisssdiiss", 
        $instructor['name'], 
        $instructor['title'], 
        $instructor['experience_years'], 
        $instructor['specializations'], 
        $instructor['bio'], 
        $instructor['languages'], 
        $instructor['rating'], 
        $instructor['students_taught'], 
        $instructor['email'], 
        $instructor['phone'], 
        $instructor['certifications']
    );
    
    if ($stmt->execute()) {
        $inserted_count++;
        echo "✅ Added instructor: " . $instructor['name'] . "\n";
    } else {
        echo "❌ Error adding " . $instructor['name'] . ": " . $conn->error . "\n";
    }
}

echo "\n🎉 Successfully added $inserted_count instructors to the database!\n";

// Create instructor_schedules table for future use
$create_schedules = "CREATE TABLE IF NOT EXISTS instructor_schedules (
    id INT AUTO_INCREMENT PRIMARY KEY,
    instructor_id INT,
    day_of_week ENUM('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'),
    start_time TIME,
    end_time TIME,
    is_available BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (instructor_id) REFERENCES instructors(id) ON DELETE CASCADE
)";

if ($conn->query($create_schedules) === TRUE) {
    echo "✅ Instructor schedules table created successfully\n";
} else {
    echo "❌ Error creating schedules table: " . $conn->error . "\n";
}

// Create instructor_reviews table for future use
$create_reviews = "CREATE TABLE IF NOT EXISTS instructor_reviews (
    id INT AUTO_INCREMENT PRIMARY KEY,
    instructor_id INT,
    student_name VARCHAR(100),
    rating INT CHECK (rating >= 1 AND rating <= 5),
    review_text TEXT,
    course_completed VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (instructor_id) REFERENCES instructors(id) ON DELETE CASCADE
)";

if ($conn->query($create_reviews) === TRUE) {
    echo "✅ Instructor reviews table created successfully\n";
} else {
    echo "❌ Error creating reviews table: " . $conn->error . "\n";
}

// Add some sample reviews
$sample_reviews = [
    [1, 'Emily Johnson', 5, 'Mike was absolutely amazing! His patience and expertise helped me overcome my driving anxiety completely.', 'Basic Driving Course'],
    [2, 'Alex Thompson', 5, 'Priya made learning to drive so comfortable. Her cultural understanding really helped me as an international student.', 'International Student Package'],
    [3, 'David Kim', 5, 'Rajesh taught me manual transmission perfectly. His technical knowledge is outstanding!', 'Manual Transmission Course'],
    [4, 'Lisa Chen', 5, 'Suman created such a safe learning environment. Perfect instructor for women drivers!', 'Women\'s Safety Course'],
    [5, 'Michael Brown', 4, 'David\'s use of technology made learning so much more engaging. Great for tech-savvy students.', 'Tech-Enhanced Course'],
    [6, 'Jessica Wilson', 5, 'Anita\'s patience is unmatched. She helped me build confidence step by step.', 'Confidence Building Program']
];

$review_sql = "INSERT INTO instructor_reviews (instructor_id, student_name, rating, review_text, course_completed) VALUES (?, ?, ?, ?, ?)";
$review_stmt = $conn->prepare($review_sql);

foreach ($sample_reviews as $review) {
    $review_stmt->bind_param("isiss", $review[0], $review[1], $review[2], $review[3], $review[4]);
    if ($review_stmt->execute()) {
        echo "✅ Added review from: " . $review[1] . "\n";
    }
}

echo "\n🌟 Database setup complete! Your driving school now has a professional instructor team.\n";
echo "📊 Total instructors: $inserted_count\n";
echo "📝 Sample reviews added: " . count($sample_reviews) . "\n";
echo "🔗 Visit: http://localhost/Groupprojectdevelopingweb/instructors.php to see your instructor team!\n";

$conn->close();
?>
