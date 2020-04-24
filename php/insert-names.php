<?php

require_once('conn.php');

$oprichter = $_GET['own-name'];
$sql = "INSERT INTO Oprichter (OprichtersNaam)
VALUES ('$oprichter')";
$conn->query($sql);

for($i = 2; $i < 7; $i++){
    $deelnemer = $_GET["name".$i];
    $sql = "INSERT INTO Deelnemers (DeelnemersNaam)
    VALUES ('$deelnemer')";
    $conn->query($sql);
}

echo "<h1>Alle deelnemers zijn opgegeven!</h1>";

$conn->close();