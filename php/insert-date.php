<?php

require_once('conn.php');

$groepsnaam = $_GET['groepsnaam'];
$bedrag = $_GET['bedrag'];
$datum = $_GET['date'];

echo $bedrag;

if($bedrag == "") {
    $bedrag = NULL;
    echo $bedrag;
}

// $sql = "INSERT INTO Groep (GroepsNaam, Bedrag, Datum)
// VALUES ('$groepsnaam', '$bedrag', '$datum')";

// if($conn->query($sql) === TRUE){
//     echo "Datum is ingevoerd";
// } else {
//     echo "Actie mislukt";
// }
$conn->close();