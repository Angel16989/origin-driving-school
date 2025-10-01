<?php
// test_logout.php - Debug logout functionality
session_start();

echo "<h2>Logout Debug Test</h2>";

echo "<h3>Current Session State:</h3>";
echo "<pre>";
print_r($_SESSION);
echo "</pre>";

echo "<h3>Session Info:</h3>";
echo "Session ID: " . session_id() . "<br>";
echo "Session Name: " . session_name() . "<br>";
echo "Session Status: " . session_status() . "<br>";

echo "<h3>Cookie Info:</h3>";
echo "<pre>";
print_r($_COOKIE);
echo "</pre>";

echo "<h3>Server Info:</h3>";
echo "PHP_SELF: " . $_SERVER['PHP_SELF'] . "<br>";
echo "REQUEST_URI: " . $_SERVER['REQUEST_URI'] . "<br>";

echo "<h3>Test Links:</h3>";
echo '<a href="php/logout.php" style="padding: 10px; background: #f44336; color: white; text-decoration: none; border-radius: 5px;">🚪 Test Logout (php/logout.php)</a><br><br>';

if (isset($_SESSION['user_id'])) {
    echo "User is logged in with ID: " . $_SESSION['user_id'] . " and role: " . ($_SESSION['role'] ?? 'none') . "<br>";
    echo '<a href="dashboard.php" style="padding: 10px; background: #4CAF50; color: white; text-decoration: none; border-radius: 5px;">Back to Dashboard</a>';
} else {
    echo "User is not logged in.<br>";
    echo '<a href="login.php" style="padding: 10px; background: #2196F3; color: white; text-decoration: none; border-radius: 5px;">Go to Login</a>';
}
?>

<style>
body { font-family: Arial, sans-serif; margin: 20px; }
pre { background: #f5f5f5; padding: 10px; border-radius: 5px; }
a { margin: 5px; display: inline-block; }
</style>
