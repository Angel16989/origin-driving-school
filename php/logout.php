<?php
// logout.php - Secure session termination
session_start();

// Log logout attempt (optional - remove in production)
error_log("Logout attempt for session: " . session_id());

// Destroy all session data
$_SESSION = array();

// Delete session cookie
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Destroy the session
session_destroy();

// Clear any authentication cookies
setcookie('remember_me', '', time() - 3600, '/');

// Prevent caching
header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");

// Regenerate session to prevent fixation
session_regenerate_id(true);

// Redirect to login page with logout message
header('Location: ../login.php?logout=success');
exit();
?>
