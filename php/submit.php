<?php

// Remote server verbinding
// require "conn.php";
require "localhost-conn.php";


// Alle inputs ophalen
$beheerder = $_POST['admin'];
$mail = $_POST['mailadmin'];
$groepsnaam = $_POST['groepsnaam'];
$datum = $_POST['date'];
$trekking = $_POST['trekking'];
$postcode = $_POST['zip'];
$bericht = $_POST['bericht'];
$compleet = $_POST['compleet'];



// Opslaan van Groep
if(empty($groepsnaam) || empty($datum) || empty($trekking) || empty($postcode) || empty($compleet)){
    header("Location: ../index.php?error=emptyfields");
    exit();
}
else {
    if (!preg_match("/^[a-zA-Z ]*$/",$groepsnaam)) {
        header("Location: ../index.php?error=invalidgroepsnaam");
        exit();
    } else {
        $sql = "INSERT INTO Groep (GroepsNaam, DatumViering, DatumTrekking, Postcode, Compleet)
        VALUES ('$groepsnaam', '$datum', '$trekking', '$postcode', '$compleet')";
        $conn->query($sql);
    }
}




// Opslaan van Beheerder
if(empty($beheerder) || empty($mail) || empty($bericht)){
    header("Location: ../index.php?error=emptyfields");
    exit();
}
else {
    if (!preg_match("/^[a-zA-Z ]*$/",$beheerder && !filter_var($mail, FILTER_VALIDATE_EMAIL))) {
        header("Location: ../index.php?error=invalidnamemail");
        exit();
    } else {
        $sql = "INSERT INTO Beheerder (BeheerdersNaam, Email, Bericht)
        VALUES ('$beheerder', '$mail', '$bericht')";
        $conn->query($sql);
    }
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
    if($_POST["name".$i] === NULL){
        header("Location: ../index.php?error=emptydeelnemer".$i);
        exit();
    } else {
        $deelnemer = $_POST["name".$i];
        if (!preg_match("/^[a-zA-Z ]*$/",$deelnemer)) {
            header("Location: ../index.php?error=invalidname");
            exit();
        } else {
            $sql = "INSERT INTO Deelnemers (DeelnemersNaam)
            VALUES ('$deelnemer')";
            $conn->query($sql);
        }   
    }

}



$conn->close();

header('Location: ../index.php');