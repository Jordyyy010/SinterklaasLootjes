<?php


if(isset($_POST['submit'])) {
    // require "conn.php";
    require "localhost-conn.php";
    require "redirect.php";

    // Alle inputs ophalen
    $mailadmin = $_POST['mailadmin'];
    $groepsnaam = $_POST['groepsnaam'];
    $datum = $_POST['date'];
    $trekkingsdatum = $_POST['trekking'];
    $postcode = $_POST['zip'];
    $bericht = $_POST['bericht'];
    $compleet = $_POST['compleet'];
    $bedrag = $_POST['bedrag'];
    $trekking = "0";



    // Opslaan van Groep
    if(empty($groepsnaam) || empty($datum) || empty($trekkingsdatum) || empty($postcode) || empty($compleet)){
        redirectError("error=emptyfields");
    }
    else if(!preg_match("/^[a-zA-Z]*$/",$groepsnaam) || !preg_match("/^[0-9]*$/",$bedrag)) {
        redirectError("error=invalidgroepsnaam&invalidbedrag");
    }
    else {
        // Creating a SQL query
        $sql = "INSERT INTO Groep (GroepsNaam, Bedrag, DatumViering, DatumTrekking, Postcode, Compleet, Trekking)
        VALUES (?, ?, ?, ?, ?, ?, ?)";
        // Initialize a statement, object
        $stmt = mysqli_stmt_init($conn);
        // Prepare a sql query to execute
        if(!mysqli_stmt_prepare($stmt, $sql)) {
            redirectError("error=sqlerror");
        }
        else {
            // Binds variables to a prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sisissi", $groepsnaam, $bedrag, $datum, $trekkingsdatum, $postcode, $compleet, $trekking);
            // Execute the query to insert data in database
            mysqli_stmt_execute($stmt); 
        }
    }



    // Opslaan van Gebruiker
    if(isset($_POST['uid'])){
        // Ophalen registratie inputs
        $username = $_POST['uid'];
        $mail = $_POST['mail'];
        $password = $_POST['pwd'];
        $passwordrepeat = $_POST['pwdrepeat'];
        // Check if inputs are empty
        if(empty($username) || empty($mail) || empty($password) || empty($passwordrepeat)){
            redirectError("error=emptyfields&uid=".$username."&mail=".$mail);
        }
        // Check if mail and username aren't invalid
        else if (!filter_var($mail, FILTER_VALIDATE_EMAIL) && !preg_match("/^[a-zA-Z0-9]*$/", $username)) {
            redirectError("error=invalidmailuid");
        }
        // Check if mail isn't invalid
        else if (!filter_var($mail, FILTER_VALIDATE_EMAIL)) {
            redirectError("error=invalidmail&uid=".$username);
        } 
        // Check if username isn't invalid
        else if (!preg_match("/^[a-zA-Z0-9]*$/", $username)) {
            redirectError("error=invaliduid&mail=".$mail);        
        }
        // Check if password and repeated password are the same
        else if ($password !== $passwordrepeat) {
            redirectError("error=passwordcheck&uid=".$username."&mail=".$mail);
        }
        // Check if there are other users with the same username
        else {
            $sql = "SELECT GebruikersNaam FROM Gebruiker WHERE Gebruikersnaam=?";
            // Initialize a statement
            $stmt = mysqli_stmt_init($conn);
            // Prepare sql query to execute
            if(!mysqli_stmt_prepare($stmt, $sql)) {
                redirectError("error=sqlerror");
            }
            // Defining 1 string called $username
            // Run sql code with prepared statements
            else {
                mysqli_stmt_bind_param($stmt, "s", $username);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_store_result($stmt);
                $resultCheck = mysqli_stmt_num_rows($stmt);
                // If there are users with that username, throw an error
                if($resultCheck > 0) {
                    redirectError("error=usertaken&mail=".$mail);
                }
                // If username isn't taken, insert new user
                else {
                    $sql = "INSERT INTO Gebruiker (GebruikersNaam, Email, Wachtwoord) VALUES (?, ?, ?)";
                    // Initialize SQL query to execute
                    $stmt = mysqli_stmt_init($conn);
                    // Prepare SQL to insert data
                    if(!mysqli_stmt_prepare($stmt, $sql)) {
                        redirectError("error=sqlerror");
                    }
                    else {
                        // Hash inserted pwd, so no pwd get saved as they are inserted from the sign up form
                        // PASSWORD_DEFAULT is volgens de normale
                        $hashedPwd = password_hash($password, PASSWORD_DEFAULT);
                        // Defining inputs to the sql statement through prepared statements
                        mysqli_stmt_bind_param($stmt, "sss", $username, $mail, $hashedPwd);
                        mysqli_stmt_execute($stmt);
                    }
                }
            }
        }



        // Direct inloggen na aanmaken nieuwe gebruiker
        if(empty($mail) || empty($password)){
            redirectError("error=emptyfields");
        }
        else {
            $sql = "SELECT * FROM Gebruiker WHERE Email=?";
            $stmt = mysqli_stmt_init($conn);
            if(!mysqli_stmt_prepare($stmt, $sql)){
                redirectError("error=sqlerror");
            }
            else {
                mysqli_stmt_bind_param($stmt, "s", $mail);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);
                if($row = mysqli_fetch_assoc($result)){
                    // Word $password geincript en dan vergeleken
                    // Of word $row['Wachtwoor'] gedecript en vergeleken met de ingevoerde input
                    $passwordCheck = password_verify($password, $row['Wachtwoord']);
                    if($passwordCheck == false) {
                        redirectError("error=passwordincorrect");
                    }
                    else if($passwordCheck == true) {
                        session_start();
                        $_SESSION['userId'] = $row['GebruikerID'];
                        $_SESSION['userUsername'] = $row['GebruikersNaam'];
                        $_SESSION['userEmail'] = $row['Email'];
                    }
                    else {
                        redirectError("error=error");                    }
                }
                else {
                    redirectError("error=nouser");
                }
            }
        }
    }



    // Opslaan van beheerder met aanmaken nieuw account
    if(isset($_POST['uid'])){
        $username = $_POST['uid'];
        if(empty($username) || empty($mailadmin) || empty($bericht)){
            redirectError("error=emptyfields");
        }
        else if(!preg_match("/^[a-zA-Z ]*$/",$username && !filter_var($mailadmin, FILTER_VALIDATE_EMAIL))) {
            redirectError("error=invalidnamemail");
        }
        else {
            $sql = "SELECT * FROM Groep WHERE GroepsNaam=? AND Postcode=? AND Bedrag=?";
            $stmt = mysqli_stmt_init($conn);
            if(!mysqli_stmt_prepare($stmt, $sql)){
                redirectError("error=sqlerror");
            }
            else {
                mysqli_stmt_bind_param($stmt, "ssi", $groepsnaam, $postcode, $bedrag);
                mysqli_stmt_execute($stmt);
                $resultgroepid = mysqli_stmt_get_result($stmt);
                if($groep = mysqli_fetch_assoc($resultgroepid)) {
                    $sql = "SELECT * FROM Gebruiker WHERE GebruikersNaam=?";
                    $stmt = mysqli_stmt_init($conn);
                    if(!mysqli_stmt_prepare($stmt, $sql)){
                        redirectError("error=sqlerror");
                    }
                    else {
                        mysqli_stmt_bind_param($stmt, "s", $username);
                        mysqli_stmt_execute($stmt);
                        $resultid = mysqli_stmt_get_result($stmt);
                        if($gebruiker = mysqli_fetch_assoc($resultid)) {
                            $sql = "INSERT INTO Beheerder (BeheerdersNaam, Email, Bericht, GroepID, GebruikerID) VALUES (?, ?, ?, ?, ?)";
                            $stmt = mysqli_stmt_init($conn);
                            if(!mysqli_stmt_prepare($stmt, $sql)) {
                                redirectError("error=sqlerror");
                            }
                            else {
                                mysqli_stmt_bind_param($stmt, "sssii", $username, $mailadmin, $bericht, $groep['GroepID'], $gebruiker['GebruikerID']);
                                mysqli_stmt_execute($stmt);

                                $sql = "INSERT INTO Deelnemer (DeelnemersNaam, Email, GroepID) VALUES (?, ?, ?)";
                                $stmt = mysqli_stmt_init($conn);
                                if(!mysqli_stmt_prepare($stmt, $sql)) {
                                    redirectError("error=sqlerror");
                                }
                                else {
                                    mysqli_stmt_bind_param($stmt, "ssi", $username, $mailadmin, $groep['GroepID']);
                                    mysqli_stmt_execute($stmt);
                                }
                            }
                        }
                        else {
                            redirectError("error=noresults");
                        }
                    }
                }
                else {
                    redirectError("error=noresults");
                }
            }
        }
    }
    // Beheerder opslaan met al ingelogde gebruiker
    else if(isset($_POST['admin'])) {
        $beheerder = $_POST['admin'];
        if(empty($beheerder) || empty($mailadmin) || empty($bericht)){
            redirectError("error=emptyfields");
        }
        else if(!preg_match("/^[a-zA-Z ]*$/",$beheerder && !filter_var($mailadmin, FILTER_VALIDATE_EMAIL))) {
            redirectError("error=invalidnamemail");
        }
        else {
            $sql = "SELECT * FROM Groep WHERE GroepsNaam=? AND Postcode=? AND Bedrag=?";
            $stmt = mysqli_stmt_init($conn);
            if(!mysqli_stmt_prepare($stmt, $sql)){
                redirectError("error=sqlerror");
            }
            else {
                mysqli_stmt_bind_param($stmt, "ssi", $groepsnaam, $postcode, $bedrag);
                mysqli_stmt_execute($stmt);
                $resultgroepid = mysqli_stmt_get_result($stmt);
                if($groep = mysqli_fetch_assoc($resultgroepid)) {
                    $sql = "SELECT * FROM Gebruiker WHERE GebruikersNaam=?";
                    $stmt = mysqli_stmt_init($conn);
                    if(!mysqli_stmt_prepare($stmt, $sql)){
                        redirectError("error=sqlerror");
                    }
                    else {
                        mysqli_stmt_bind_param($stmt, "s", $beheerder);
                        mysqli_stmt_execute($stmt);
                        $resultid = mysqli_stmt_get_result($stmt);
                        if($gebruiker = mysqli_fetch_assoc($resultid)) {
                            $sql = "INSERT INTO Beheerder (BeheerdersNaam, Email, Bericht, GroepID, GebruikerID) VALUES (?, ?, ?, ?, ?)";
                            $stmt = mysqli_stmt_init($conn);
                            if(!mysqli_stmt_prepare($stmt, $sql)) {
                                redirectError("error=sqlerror");
                            }
                            else {
                                mysqli_stmt_bind_param($stmt, "sssii", $beheerder, $mailadmin, $bericht, $groep['GroepID'], $gebruiker['GebruikerID']);
                                mysqli_stmt_execute($stmt);

                                $sql = "INSERT INTO Deelnemer (DeelnemersNaam, Email, GroepID) VALUES (?, ?, ?)";
                                $stmt = mysqli_stmt_init($conn);
                                if(!mysqli_stmt_prepare($stmt, $sql)) {
                                    redirectError("error=sqlerror");
                                }
                                else {
                                    mysqli_stmt_bind_param($stmt, "ssi", $username, $mailadmin, $groep['GroepID']);
                                    mysqli_stmt_execute($stmt);
                                }
                            }
                        }
                        else {
                            redirectError("error=noresults");
                        }
                    }
                }
                else {
                    redirectError("error=noresults");
                }
            }
        }
    }
    else {
        redirectError("error=error");
    }



    // Opslaan van deelnemers
    if($_COOKIE['counter'] >= 0){
        $standaardaantal = 1 + $_COOKIE['counter'];
        $loopaantal = 2 + $standaardaantal;
        // Sla elk ingevoerde naam op in de database
        for($i = 2; $i <= $loopaantal; $i++){
            $deelnemer = $_POST["name".$i];
            if($deelnemer === NULL){
                redirectError("error=emptyfield".$i);
            }
            else if(!preg_match("/^[a-zA-Z ]*$/", $deelnemer)) {
                redirectError("error=invalidname");
            }
            else {
                $sql = "SELECT * FROM Groep WHERE GroepsNaam=? AND Postcode=? AND Bedrag=?";
                $stmt = mysqli_stmt_init($conn);
                if(!mysqli_stmt_prepare($stmt, $sql)){
                    redirectError("error=sqlerror");
                }
                else {
                    mysqli_stmt_bind_param($stmt, "ssi", $groepsnaam, $postcode, $bedrag);
                    mysqli_stmt_execute($stmt);
                    $resultgroepid = mysqli_stmt_get_result($stmt);
                    if($groep = mysqli_fetch_assoc($resultgroepid)) {
                        $sql = "INSERT INTO Deelnemer (DeelnemersNaam, GroepID) VALUES (?, ?)";
                        $stmt = mysqli_stmt_init($conn);
                        if(!mysqli_stmt_prepare($stmt, $sql)) {
                            redirectError("error=sqlerror");
                        }
                        else {
                            mysqli_stmt_bind_param($stmt, "si", $deelnemer, $groep['GroepID']);
                            mysqli_stmt_execute($stmt);
                        }
                    }
                    else {
                        redirectError("error=noresults");   
                    }
                }
            }
        }
        redirectSucces("save=succes");
    }
    else {
        redirectError("error=cookieerror");
    }
}
else {
    redirectError("error=emptyfields");
}