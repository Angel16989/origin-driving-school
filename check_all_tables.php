<?php
require_once 'php/db_connect.php';

echo "Checking ALL table structures...\n\n";

$tables = ['bookings', 'students', 'instructors', 'invoices', 'payments'];

foreach ($tables as $table) {
    echo "=== " . strtoupper($table) . " TABLE ===\n";
    $result = $conn->query("DESCRIBE $table");
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            echo "- " . $row['Field'] . " (" . $row['Type'] . ")\n";
        }
    } else {
        echo "Error: " . $conn->error . "\n";
    }
    echo "\n";
    
    // Show sample data
    echo "Sample data:\n";
    $result = $conn->query("SELECT * FROM $table LIMIT 2");
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "  ";
            print_r($row);
        }
    } else {
        echo "  No data\n";
    }
    echo "\n";
}
?>