<?php

require "localhost-conn.php";

$standaardaantal = 1 + $_COOKIE['counter'];
$loopaantal = 2 + $standaardaantal;
// Sla elk ingevoerde naam op in de database
for($i = 2; $i <= $loopaantal; $i++){
    if($_POST["name".$i] === NULL){
        echo "Niet alle vakjes zijn ingevoerd";
    } else {
        $deelnemer = $_POST["name".$i];
        if (!preg_match("/^[a-zA-Z ]*$/",$deelnemer)) {
            // Redirect naar de vorige pagina met alert, "Alleen letters en spaties toegestaan"
            echo $deelnemer . " Alleen letters en spaties toegestaan<br>";
        } else {
            $sql = "INSERT INTO Deelnemers (DeelnemersNaam, GroepID)
            VALUES ('$deelnemer', '33')";
            $conn->query($sql);
            
        }
    }
}
header("Location: ".$_SERVER['HTTP_REFERER']."?save=succes");
exit();