<?php


if(isset($_POST['submit'])) {
    // Database connections
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
    else if(!preg_match("/^[a-zA-Z ]*$/",$groepsnaam)) {
        header("Location: ../index.php?error=invalidgroepsnaam");
        exit();
    }
    else {
        $sql = "INSERT INTO Groep (GroepsNaam, DatumViering, DatumTrekking, Postcode, Compleet)
        VALUES (?, ?, ?, ?, ?)";
        $stmt = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt, $sql)) {
            header("Location: ../index.php?error=sqlerror");
            exit();
        }
        else {
            mysqli_stmt_bind_param($stmt, "sssss", $groepsnaam, $datum, $trekking, $postcode, $compleet);
            mysqli_stmt_execute($stmt);
        }
    }




    // Opslaan van Beheerder
    if(empty($beheerder) || empty($mail) || empty($bericht)){
        header("Location: ../index.php?error=emptyfields");
        exit();
    }
    else if(!preg_match("/^[a-zA-Z ]*$/",$beheerder && !filter_var($mail, FILTER_VALIDATE_EMAIL))) {
        header("Location: ../index.php?error=invalidnamemail");
        exit();
    }
    else {
        $sql = "SELECT Email FROM Beheerder WHERE Email=?";
        $stmt = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt, $sql)){
            header("Location: ../index.php?error=sqlerror");
            exit();
        }
        else {
            mysqli_stmt_bind_param($stmt, "s", $mail);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_store_result($stmt);
            $resultCheck = mysqli_stmt_num_rows($stmt);
            // If there is a Beheerder with that email, throw an error
            if($resultCheck > 0) {
                header("Location: ../index.php?error=emailtaken");
                exit();
            }
            else {
                $sql = "INSERT INTO Beheerder (BeheerdersNaam, Email, Bericht) VALUES (?, ?, ?)";
                $stmt = mysqli_stmt_init($conn);
                if(!mysqli_stmt_prepare($stmt, $sql)) {
                    header("Location: ../index.php?error=sqlerror");
                    exit();
                }
                else {
                    mysqli_stmt_bind_param($stmt, "sss", $beheerder, $mail, $bericht);
                    mysqli_stmt_execute($stmt);
                }
            }
        }
    }



    // Opslaan van deelnemers
    if($_COOKIE['counter'] >= 0){
        $standaardaantal = 1 + $_COOKIE['counter'];
        $loopaantal = 2 + $standaardaantal;
    }
    else {
        header("Location: ../index.php?error=cookieerror");
        exit();
    }
    // Sla elk ingevoerde naam op in de database
    for($i = 2; $i <= $loopaantal; $i++){
        $deelnemer = $_POST["name".$i];
        if($deelnemer === NULL){
            header("Location: ../index.php?error=emptydeelnemer".$i);
            exit();
        }
        else if(!preg_match("/^[a-zA-Z ]*$/", $deelnemer)) {
            header("Location: ../index.php?error=invalidname");
            exit();
        }
        else {
            $sql = "INSERT INTO Deelnemers (DeelnemersNaam) VALUES (?)";
            $stmt = mysqli_stmt_init($conn);
            if(!mysqli_stmt_prepare($stmt, $sql)) {
                header("Location: ../index.php?error=sqlerror");
                exit();
            }
            else {
                mysqli_stmt_bind_param($stmt, "s", $deelnemer);
                mysqli_stmt_execute($stmt);
                
                
                
                // Opslaan deelnemerdetails
                $sql = "SELECT GroepId FROM Groep WHERE GroepsNaam=?";
                $stmt = mysqli_stmt_init($conn);
                if(!mysqli_stmt_prepare($stmt, $sql)){
                    header("Location: ../index.php?error=sqlerror");
                    exit();
                }
                else {
                    mysqli_stmt_bind_param($stmt, "i", $groepsnaam);
                    mysqli_stmt_execute($stmt);
                    mysqli_stmt_store_result($stmt);
                    $result = mysqli_stmt_num_rows($stmt);
                    $reality = $result['GroepId'];
                    if(!$result > 0) {
                        header("Location: ../index.php?error=noresults");
                        exit();
                    }
                    else {
                        $sql = "INSERT INTO DeelnemerDetails (GroepId) VALUES (?)";
                        $stmt = mysqli_stmt_init($conn);
                        if(!mysqli_stmt_prepare($stmt, $sql)) {
                            header("Location: ../index.php?error=sqlerror");
                            exit();
                        }
                        else {
                            mysqli_stmt_bind_param($stmt, "i", $reality);
                            mysqli_stmt_execute($stmt);
                            header("Location: ../index.php?save=succes");
                            exit();
                        }
                    }
                }
            }
        }
    }
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}
else {
    header("Location: ../index.php");
    exit();
}