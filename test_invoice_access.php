<?php
// Test invoice access
session_start();

// Set up a test session like we do in other files
$_SESSION['user_id'] = 1;
$_SESSION['role'] = 'admin';
$_SESSION['name'] = 'Test Admin';

echo "🔍 Testing Invoice Access<br>";
echo "Session User ID: " . ($_SESSION['user_id'] ?? 'Not set') . "<br>";
echo "Session Role: " . ($_SESSION['role'] ?? 'Not set') . "<br>";

echo "<h3>🔗 Testing Links:</h3>";

// Test direct access to invoices.php
echo "<a href='php/invoices.php' target='_blank'>📄 Test: php/invoices.php</a><br>";
echo "<a href='invoices.php' target='_blank'>📄 Test: invoices.php (root)</a><br>";

// Get the current working directory context
echo "<h3>📂 Path Context:</h3>";
echo "Current script: " . __FILE__ . "<br>";
echo "Document root: " . $_SERVER['DOCUMENT_ROOT'] . "<br>";
echo "Request URI: " . $_SERVER['REQUEST_URI'] . "<br>";

// Test the path prefix logic from header.php
$current_dir = __DIR__;
$is_subfolder = strpos($current_dir, 'php') !== false || strpos($current_dir, 'includes') !== false;
$path_prefix = $is_subfolder ? '../' : '';
$php_prefix = $is_subfolder ? '' : 'php/';

echo "<h3>🔧 Path Logic:</h3>";
echo "Is subfolder: " . ($is_subfolder ? 'Yes' : 'No') . "<br>";
echo "Path prefix: '" . $path_prefix . "'<br>";
echo "PHP prefix: '" . $php_prefix . "'<br>";

$admin_invoices_link = $path_prefix . $php_prefix . 'invoices.php';
echo "Constructed invoice link: '" . $admin_invoices_link . "'<br>";

echo "<a href='" . $admin_invoices_link . "' target='_blank'>🎯 Test: Constructed Link</a><br>";

?>