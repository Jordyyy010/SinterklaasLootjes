<?php

// Remote server verbinding
// require_once('conn.php');

// Localhost verbinding
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "lootjes";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);



// Alle inputs ophalen
$beheerder = $_GET['admin'];
$mail = $_GET['mailadmin'];
$groepsnaam = $_GET['groepsnaam'];
$datum = $_GET['date'];
$trekking = $_GET['trekking'];
$postcode = $_GET['zip'];
$bericht = $_GET['bericht'];
$compleet = $_GET['compleet'];



// Opslaan van Groep
if (!preg_match("/^[a-zA-Z ]*$/",$groepsnaam)) {
    // Toekomstig redirect naar de vorige pagina en een 
    // alert melding "Alleen letters en spaties toegestaan"
    echo "Ongeldige groepsnaam of trekking<br>";
} else {
    $sql = "INSERT INTO Groep (GroepsNaam, DatumViering, DatumTrekking, Postcode, Compleet)
    VALUES ('$groepsnaam', '$datum', '$trekking', '$postcode', '$compleet')";
    $conn->query($sql);
}



// Opslaan van Beheerder
if (!preg_match("/^[a-zA-Z ]*$/",$beheerder && !filter_var($mail, FILTER_VALIDATE_EMAIL))) {
    // Toekomstig redirect naar de vorige pagina en een 
    // alert melding "Alleen letters en spaties toegestaan"
    echo "Ongeldige naam of email<br>";
} else {
    $sql = "INSERT INTO Beheerder (BeheerdersNaam, Email, Bericht)
    VALUES ('$beheerder', '$mail', '$bericht')";
    $conn->query($sql);
}

// Opslaan van deelnemerdetails
// $sql = "SELECT BeheerderId FROM Beheerder WHERE BeheerdersNaam == '$beheerder'";
// $result = $conn->query($sql);
// if ($result->num_rows > 0) {
//     // output data of each row
//     while($row = $result->fetch_assoc()) {
//       echo "id: " . $row["id"]. " - Name: " . $row["firstname"]. " " . $row["lastname"]. "<br>";
//     }
//   } else {
//     echo "0 results";
//   }
// $sql = "INSERT INTO deelnemersdetails (BeheerderId, GroepId)
// VALUES ('$beheerderid', '$groepid')";


// Opslaan van deelnemers
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

header('Location: ../index.php');