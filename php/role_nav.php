<?php
// php/role_nav.php - Role-based navigation system
function getRoleBasedNavigation($role, $current_page = '') {
    $nav_items = [];
    
    // Common items for all logged-in users
    $nav_items[] = ['url' => '../dashboard.php', 'label' => '🏠 Dashboard', 'icon' => '🏠'];
    
    switch($role) {
        case 'admin':
            $nav_items[] = ['url' => 'students.php', 'label' => '👥 Students', 'icon' => '👥'];
            $nav_items[] = ['url' => 'instructors.php', 'label' => '👨‍🏫 Instructors', 'icon' => '👨‍🏫'];
            $nav_items[] = ['url' => 'bookings.php', 'label' => '📅 All Bookings', 'icon' => '📅'];
            $nav_items[] = ['url' => 'invoices.php', 'label' => '💰 All Invoices', 'icon' => '💰'];
            $nav_items[] = ['url' => 'messages.php', 'label' => '💬 All Messages', 'icon' => '💬'];
            $nav_items[] = ['url' => 'reports.php', 'label' => '📊 Reports', 'icon' => '📊'];
            break;
            
        case 'instructor':
            $nav_items[] = ['url' => 'my_schedule.php', 'label' => '📅 My Schedule', 'icon' => '📅'];
            $nav_items[] = ['url' => 'my_students.php', 'label' => '👥 My Students', 'icon' => '👥'];
            $nav_items[] = ['url' => 'instructor_messages.php', 'label' => '💬 Messages', 'icon' => '💬'];
            break;
            
        case 'student':
            $nav_items[] = ['url' => 'my_profile.php', 'label' => '👤 My Profile', 'icon' => '👤'];
            $nav_items[] = ['url' => 'my_bookings.php', 'label' => '📅 My Lessons', 'icon' => '📅'];
            $nav_items[] = ['url' => 'my_invoices.php', 'label' => '💳 My Payments', 'icon' => '💳'];
            $nav_items[] = ['url' => 'student_messages.php', 'label' => '💬 Messages', 'icon' => '💬'];
            break;
    }
    
    $nav_items[] = ['url' => 'logout.php', 'label' => '🚪 Logout', 'icon' => '🚪'];
    
    return $nav_items;
}

function renderNavigation($role, $current_page = '') {
    $nav_items = getRoleBasedNavigation($role, $current_page);
    echo "<nav class='role-nav role-nav-{$role}'>";
    
    foreach($nav_items as $item) {
        $active_class = (basename($_SERVER['PHP_SELF']) == basename($item['url'])) ? 'active' : '';
        echo "<a href='{$item['url']}' class='nav-item {$active_class}' data-tooltip='{$item['label']}'>";
        echo "<span class='nav-icon'>{$item['icon']}</span>";
        echo "<span class='nav-label'>" . str_replace($item['icon'] . ' ', '', $item['label']) . "</span>";
        echo "</a>";
    }
    
    echo "</nav>";
}

function checkRoleAccess($required_roles, $user_role) {
    if (!is_array($required_roles)) {
        $required_roles = [$required_roles];
    }
    
    if (!in_array($user_role, $required_roles)) {
        header('Location: ../dashboard.php?error=access_denied');
        exit;
    }
}
?>
