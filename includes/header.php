<?php
// includes/header.php - Consistent header for all pages
$current_page = basename($_SERVER['PHP_SELF'], '.php');

// Detect if we're in a subfolder (like php/)
$current_dir = dirname($_SERVER['PHP_SELF']);
$in_subfolder = (strpos($current_dir, '/php') !== false || strpos($current_dir, '\php') !== false);
$path_prefix = $in_subfolder ? '../' : '';

// Check if user is logged in and their role
$user_role = $_SESSION['role'] ?? '';
$is_admin = ($user_role === 'admin');
$is_instructor = ($user_role === 'instructor');
$is_student = ($user_role === 'student');

// Determine navigation links based on current page
// Link to dedicated pages instead of anchor sections
$is_index = ($current_page === 'index');
$about_link = $path_prefix . 'about.php';
$services_link = $path_prefix . 'services.php';
$contact_link = $path_prefix . 'contact.php';
$instructors_link = $path_prefix . 'instructors.php';
$login_link = $path_prefix . 'login.php';
$index_link = $path_prefix . 'index.php';
$dashboard_link = $path_prefix . 'dashboard.php';

// Admin-specific links - Fixed path logic
if ($in_subfolder) {
    // We're in php/ folder, so admin links are just filenames
    $admin_students_link = 'students.php';
    $admin_instructors_link = 'instructors.php';
    $admin_bookings_link = 'bookings.php';
    $admin_invoices_link = 'invoices.php';
    $admin_analytics_link = 'analytics.php';
    $logout_link = 'logout.php';
} else {
    // We're in root, so admin links need php/ prefix
    $admin_students_link = 'php/students.php';
    $admin_instructors_link = 'php/instructors.php';
    $admin_bookings_link = 'php/bookings.php';
    $admin_invoices_link = 'php/invoices.php';
    $admin_analytics_link = 'php/analytics.php';
    $logout_link = 'php/logout.php';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title ?? 'Origin Driving School'; ?></title>
    <link rel="stylesheet" href="<?php echo $path_prefix; ?>css/styles.css">
    <link rel="stylesheet" href="<?php echo $path_prefix; ?>css/enhanced-styles.css">
    <link rel="stylesheet" href="<?php echo $path_prefix; ?>css/desktop-responsive.css">
    <link rel="stylesheet" href="<?php echo $path_prefix; ?>css/footer-fix.css">
    <link rel="stylesheet" href="<?php echo $path_prefix; ?>css/mobile-responsive.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <meta name="description" content="<?php echo $page_description ?? 'Origin Driving School - Professional driving education and training'; ?>">
    <style>
        body { font-family: 'Inter', sans-serif; margin: 0; padding: 0; }
        .nav-link:hover { color: var(--yellow-line) !important; }
        .service-card:hover { transform: translateY(-10px); }
        .instructor-card:hover { transform: scale(1.05); }
        .cta-button { transition: all 0.3s ease; }
        .cta-button:hover { transform: translateY(-3px); box-shadow: 0 10px 30px rgba(0,0,0,0.2); }
        html { scroll-behavior: smooth; }
    </style>
</head>
<body class="page-transition">
    <!-- Professional Navigation Header (Role-based navigation) -->
    <nav class="main-nav" style="background: rgba(12, 36, 97, 0.95); backdrop-filter: blur(20px); padding: 1rem 0; position: relative; z-index: 1000; box-shadow: 0 4px 20px rgba(0,0,0,0.15);">
        <div class="nav-container" style="max-width: 1400px; margin: 0 auto; display: flex; justify-content: space-between; align-items: center; padding: 0 2rem;">
            <!-- Logo/Brand -->
            <a href="<?php echo $is_admin ? $dashboard_link : $index_link; ?>" class="logo" style="display: flex; align-items: center; text-decoration: none;">
                <div style="width: 50px; height: 50px; background: linear-gradient(135deg, var(--yellow-line), #ffed4e); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; margin-right: 1rem;">🚗</div>
                <div>
                    <h1 style="color: white; font-size: 1.5rem; margin: 0; font-weight: 800;">Origin Driving School</h1>
                    <p style="color: rgba(255,255,255,0.8); font-size: 0.9rem; margin: 0;">
                        <?php 
                        if ($is_admin) echo '🔐 Admin Panel';
                        elseif ($is_instructor) echo '👨‍🏫 Instructor Portal';
                        elseif ($is_student) echo '📚 Student Portal';
                        else echo 'Professional Driving Education';
                        ?>
                    </p>
                </div>
            </a>
            
            <!-- Mobile Menu Toggle -->
            <button class="mobile-menu-toggle" onclick="toggleMobileMenu()" style="display: none; background: none; border: none; color: white; font-size: 1.5rem; cursor: pointer; padding: 0.5rem;">
                ☰
            </button>
            
            <!-- Navigation Links -->
            <div class="nav-links" id="navLinks" style="display: flex; gap: 1.5rem; align-items: center;">
                <?php if ($is_admin): ?>
                    <!-- Admin Navigation -->
                    <a href="<?php echo $dashboard_link; ?>" class="nav-link" style="color: <?php echo $current_page === 'dashboard' ? 'var(--yellow-line)' : 'white'; ?>; text-decoration: none; font-weight: 500; transition: color 0.3s;">
                        🏠 Dashboard
                    </a>
                    <a href="<?php echo $admin_students_link; ?>" class="nav-link" style="color: <?php echo $current_page === 'students' ? 'var(--yellow-line)' : 'white'; ?>; text-decoration: none; font-weight: 500; transition: color 0.3s;">
                        👥 Students
                    </a>
                    <a href="<?php echo $admin_instructors_link; ?>" class="nav-link" style="color: <?php echo $current_page === 'instructors' ? 'var(--yellow-line)' : 'white'; ?>; text-decoration: none; font-weight: 500; transition: color 0.3s;">
                        👨‍🏫 Instructors
                    </a>
                    <a href="<?php echo $admin_bookings_link; ?>" class="nav-link" style="color: <?php echo $current_page === 'bookings' ? 'var(--yellow-line)' : 'white'; ?>; text-decoration: none; font-weight: 500; transition: color 0.3s;">
                        📅 Bookings
                    </a>
                    <a href="<?php echo $admin_invoices_link; ?>" class="nav-link" style="color: <?php echo $current_page === 'invoices' ? 'var(--yellow-line)' : 'white'; ?>; text-decoration: none; font-weight: 500; transition: color 0.3s;">
                        💰 Invoices
                    </a>
                    <a href="<?php echo $admin_analytics_link; ?>" class="nav-link" style="color: <?php echo $current_page === 'analytics' ? 'var(--yellow-line)' : 'white'; ?>; text-decoration: none; font-weight: 500; transition: color 0.3s;">
                        📊 Analytics
                    </a>
                    <a href="<?php echo $logout_link; ?>" class="btn cta-button" style="background: #dc3545; color: white; font-size: 0.9rem; padding: 0.8rem 1.5rem;">
                        🚪 Logout
                    </a>
                    
                <?php elseif ($is_instructor): ?>
                    <!-- Instructor Navigation -->
                    <a href="<?php echo $dashboard_link; ?>" class="nav-link" style="color: white; text-decoration: none; font-weight: 500; transition: color 0.3s;">
                        🏠 Dashboard
                    </a>
                    <a href="<?php echo $path_prefix . $php_prefix . 'my_schedule.php'; ?>" class="nav-link" style="color: white; text-decoration: none; font-weight: 500; transition: color 0.3s;">
                        📅 Schedule
                    </a>
                    <a href="<?php echo $path_prefix . $php_prefix . 'my_students.php'; ?>" class="nav-link" style="color: white; text-decoration: none; font-weight: 500; transition: color 0.3s;">
                        👥 Students
                    </a>
                    <a href="<?php echo $logout_link; ?>" class="btn cta-button" style="background: #dc3545; color: white; font-size: 0.9rem; padding: 0.8rem 1.5rem;">
                        🚪 Logout
                    </a>
                    
                <?php elseif ($is_student): ?>
                    <!-- Student Navigation -->
                    <a href="<?php echo $dashboard_link; ?>" class="nav-link" style="color: white; text-decoration: none; font-weight: 500; transition: color 0.3s;">
                        🏠 Dashboard
                    </a>
                    <a href="<?php echo $path_prefix . 'book_lesson.php'; ?>" class="nav-link" style="color: white; text-decoration: none; font-weight: 500; transition: color 0.3s;">
                        📚 Book Lesson
                    </a>
                    <a href="<?php echo $path_prefix . 'quick_pay.php'; ?>" class="nav-link" style="color: white; text-decoration: none; font-weight: 500; transition: color 0.3s;">
                        💳 Quick Pay
                    </a>
                    <a href="<?php echo $logout_link; ?>" class="btn cta-button" style="background: #dc3545; color: white; font-size: 0.9rem; padding: 0.8rem 1.5rem;">
                        🚪 Logout
                    </a>
                    
                <?php else: ?>
                    <!-- Public Navigation (Not logged in) -->
                    <a href="<?php echo $about_link; ?>" class="nav-link" style="color: white; text-decoration: none; font-weight: 500; transition: color 0.3s;">About</a>
                    <a href="<?php echo $services_link; ?>" class="nav-link" style="color: white; text-decoration: none; font-weight: 500; transition: color 0.3s;">Services</a>
                    <a href="<?php echo $instructors_link; ?>" class="nav-link" style="color: <?php echo $current_page === 'instructors' ? 'var(--yellow-line)' : 'white'; ?>; text-decoration: none; font-weight: 500; transition: color 0.3s;">Instructors</a>
                    <a href="<?php echo $path_prefix . 'gallery.php'; ?>" class="nav-link" style="color: <?php echo $current_page === 'gallery' ? 'var(--yellow-line)' : 'white'; ?>; text-decoration: none; font-weight: 500; transition: color 0.3s;">Gallery</a>
                    <a href="<?php echo $contact_link; ?>" class="nav-link" style="color: white; text-decoration: none; font-weight: 500; transition: color 0.3s;">Contact</a>
                    <a href="<?php echo $login_link; ?>" class="btn cta-button" style="background: var(--yellow-line); color: var(--tire-black); font-size: 0.9rem; padding: 0.8rem 1.5rem;">
                        Student Portal
                    </a>
                <?php endif; ?>
            </div>
            <!-- End nav-links -->
        </div>
        <!-- End nav-container -->
    </nav>
    
    <!-- Mobile Menu JavaScript -->
    <script>
        function toggleMobileMenu() {
            const navLinks = document.getElementById('navLinks');
            const isVisible = navLinks.style.display === 'flex' || navLinks.style.display === '';
            
            if (window.innerWidth <= 768) {
                navLinks.style.display = isVisible ? 'none' : 'flex';
            }
        }
        
        // Show mobile menu toggle on small screens
        function updateMobileMenu() {
            const toggle = document.querySelector('.mobile-menu-toggle');
            const navLinks = document.getElementById('navLinks');
            
            if (window.innerWidth <= 768) {
                toggle.style.display = 'block';
                navLinks.style.display = 'none';
            } else {
                toggle.style.display = 'none';
                navLinks.style.display = 'flex';
            }
        }
        
        // Initialize on load and resize
        window.addEventListener('load', updateMobileMenu);
        window.addEventListener('resize', updateMobileMenu);
    </script>
    
    <!-- Main Content Wrapper for Sticky Footer -->
    <main class="main-content">
