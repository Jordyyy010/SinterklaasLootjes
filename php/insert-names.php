<?php

require_once('conn.php');

$oprichter = $_GET['own-name'];
if (!preg_match("/^[a-zA-Z ]*$/",$oprichter)) {
    // Toekomstig redirect naar de vorige pagina en een 
    // alert melding "Alleen letters en spaties toegestaan"
    echo "Alleen letters en spaties toegestaan<br>";
} else {
    $sql = "INSERT INTO Oprichter (OprichtersNaam)
    VALUES ('$oprichter')";
    $conn->query($sql);
}

$standaardaantal = 1 + $_COOKIE['counter'];
$loopaantal = 2 + $standaardaantal;
// Sla elk ingevoerde naam op in de database
for($i = 2; $i <= $loopaantal; $i++){
    if($_GET["name".$i] === NULL){
        // Redirect naar de vorige pagina met alert, "Niet alle vakjes zijn ingevoerd"
        echo "Niet alle vakjes zijn ingevoerd";
    } else {
        $deelnemer = $_GET["name".$i];
        if (!preg_match("/^[a-zA-Z ]*$/",$deelnemer)) {
            // Redirect naar de vorige pagina met alert, "Alleen letters en spaties toegestaan"
            echo $deelnemer . " Alleen letters en spaties toegestaan<br>";
        } else {
            $sql = "INSERT INTO Deelnemers (DeelnemersNaam)
            VALUES ('$deelnemer')";
            $conn->query($sql);
        }   
    }
}

$conn->close();

header('Location: ../created.php');