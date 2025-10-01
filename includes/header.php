<?php
// includes/header.php - Consistent header for all pages
$current_page = basename($_SERVER['PHP_SELF'], '.php');

// Determine navigation links based on current page
// If on main page (index), use anchor links for scrolling
// If on other pages, link back to index.php sections
$is_index = ($current_page === 'index');
$about_link = $is_index ? '#about' : 'index.php#about';
$services_link = $is_index ? '#services' : 'index.php#services';
$contact_link = $is_index ? '#contact' : 'index.php#contact';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title ?? 'Origin Driving School'; ?></title>
    <link rel="stylesheet" href="css/styles.css">
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
    <!-- Professional Navigation Header (Consistent across all pages) -->
    <nav class="main-nav" style="background: rgba(12, 36, 97, 0.95); backdrop-filter: blur(20px); padding: 1rem 0; position: fixed; top: 0; left: 0; right: 0; z-index: 1000; box-shadow: 0 4px 20px rgba(0,0,0,0.15);">
        <div style="max-width: 1200px; margin: 0 auto; display: flex; justify-content: space-between; align-items: center; padding: 0 2rem;">
            <a href="index.php" style="display: flex; align-items: center; text-decoration: none;">
                <div style="width: 50px; height: 50px; background: linear-gradient(135deg, var(--yellow-line), #ffed4e); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; margin-right: 1rem;">🚗</div>
                <div>
                    <h1 style="color: white; font-size: 1.5rem; margin: 0; font-weight: 800;">Origin Driving School</h1>
                    <p style="color: rgba(255,255,255,0.8); font-size: 0.9rem; margin: 0;">Professional Driving Education</p>
                </div>
            </a>
            <div style="display: flex; gap: 2rem; align-items: center;">
                <a href="<?php echo $about_link; ?>" class="nav-link" style="color: white; text-decoration: none; font-weight: 500; transition: color 0.3s;">About</a>
                <a href="<?php echo $services_link; ?>" class="nav-link" style="color: white; text-decoration: none; font-weight: 500; transition: color 0.3s;">Services</a>
                <a href="instructors.php" class="nav-link" style="color: <?php echo $current_page === 'instructors' ? 'var(--yellow-line)' : 'white'; ?>; text-decoration: none; font-weight: 500; transition: color 0.3s;">Instructors</a>
                <a href="<?php echo $contact_link; ?>" class="nav-link" style="color: white; text-decoration: none; font-weight: 500; transition: color 0.3s;">Contact</a>
                <a href="login.php" class="btn cta-button" style="background: var(--yellow-line); color: var(--tire-black); font-size: 0.9rem; padding: 0.8rem 1.5rem;">
                    <?php echo isset($_SESSION['username']) ? 'Dashboard' : 'Student Portal'; ?>
                </a>
            </div>
        </div>
    </nav>
    
    <!-- Add spacing for fixed nav -->
    <div style="height: 100px;"></div>
