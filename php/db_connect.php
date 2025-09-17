<?php
// db_connect.php - Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "origin_driving_school";
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
