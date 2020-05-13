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

if(isset($_GET['testname'])){
    $testName = $_GET['testname'];
    $sql = "INSERT INTO oprichter (OprichtersNaam)
    VALUES ($testName)";

    $conn->query($sql);
    echo "Data is opgeslagen in de database";
} else {
    echo "Je bent niet opgeslagen in de database";
}

$conn->close();