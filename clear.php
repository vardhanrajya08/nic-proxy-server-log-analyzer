<?php
// Include the database connection file
include 'db_connection.php';

// Run your query 2 here
$sql = "TRUNCATE TABLE logs";

if ($conn->query($sql) === TRUE) {
    echo "Query 2 executed successfully.";
} else {
    echo "Error executing Query 2: " . $conn->error;
}

// Close the database connection
$conn->close();
?>