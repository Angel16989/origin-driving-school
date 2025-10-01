<?php
require_once 'php/db_connect.php';

echo "<h2>Messages Table Structure:</h2>";
$result = $conn->query('DESCRIBE messages');
if ($result) {
    while($row = $result->fetch_assoc()) {
        echo $row['Field'] . ' - ' . $row['Type'] . "<br>";
    }
} else {
    echo "Error: " . $conn->error;
}

echo "<h2>Sample Messages:</h2>";
$messages_result = $conn->query('SELECT * FROM messages LIMIT 5');
if ($messages_result) {
    while($row = $messages_result->fetch_assoc()) {
        echo "<pre>" . print_r($row, true) . "</pre>";
    }
} else {
    echo "Error: " . $conn->error;
}
?>
