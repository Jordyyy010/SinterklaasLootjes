<?php

require_once('conn.php');

$oprichter = $_GET['own-name'];
if (!preg_match("/^[a-zA-Z ]*$/",$oprichter)) {
    echo $oprichter . "Alleen letters en spaties toegestaan<br>";
} else {
    $sql = "INSERT INTO Oprichter (OprichtersNaam)
    VALUES ('$oprichter')";
    $conn->query($sql);
    echo "Beheerder aangemaakt<br>";
}

for($i = 2; $i < 7; $i++){
    $deelnemer = $_GET["name".$i];
    if (!preg_match("/^[a-zA-Z ]*$/",$deelnemer)) {
        echo $deelnemer . "Alleen letters en spaties toegestaan<br>";
    } else {
        $sql = "INSERT INTO Deelnemers (DeelnemersNaam)
        VALUES ('$deelnemer')";
        $conn->query($sql);
        echo "Deelnemer aangemaakt<br>";
    }
}

$conn->close();