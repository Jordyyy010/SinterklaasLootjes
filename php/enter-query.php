<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "lootjes";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    echo "Connection failed: " . $conn->connect_error;
} else {
    echo "Connected to database<br>";
}

$sql = "INSERT INTO DeelnemerDetails (OprichterId, GroepId)
VALUES ('1', '1')";
$conn->query($sql);

echo "oprichter details toegevoegd aan de database";


$conn->close();