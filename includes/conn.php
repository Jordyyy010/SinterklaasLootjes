<?php 

$servername = "localhost";
$username = "lootjes_lootjes";
$password = "8wGvW6fVPv";
$dbname = "lootjes_lootjes";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    echo "Connection failed: " . $conn->connect_error;
} else {
    echo "Connected to database";
}