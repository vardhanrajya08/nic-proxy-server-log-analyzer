<?php
// MySQL database credentials
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "logs";

// Create a new MySQL connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>