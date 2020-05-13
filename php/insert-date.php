<?php

require_once('conn.php');

$groepsnaam = $_GET['groepsnaam'];
$datum = $_GET['date'];
$trekking = $_GET['trekking'];

$sql = "INSERT INTO Groep (GroepsNaam, DatumViering, DatumTrekking)
VALUES ('$groepsnaam', '$datum', '$trekking')";

if($conn->query($sql) === TRUE){
    echo "Data is ingevoerd";
} else {
    echo "Actie mislukt";
}
$conn->close();

header('Location: ../created.php');