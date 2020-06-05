<?php


if(isset($_POST['submit'])) {
    // Database connections
    // require "conn.php";
    require "localhost-conn.php";

    // Alle inputs ophalen
    $mailadmin = $_POST['mailadmin'];
    $groepsnaam = $_POST['groepsnaam'];
    $datum = $_POST['date'];
    $trekking = $_POST['trekking'];
    $postcode = $_POST['zip'];
    $bericht = $_POST['bericht'];
    $compleet = $_POST['compleet'];
    $bedrag = $_POST['bedrag'];

    // Ophalen registreren inputs
    $mail = $_POST['mail'];
    $password = $_POST['pwd'];
    $passwordrepeat = $_POST['pwdrepeat'];



    // Opslaan van Groep
    if(empty($groepsnaam) || empty($datum) || empty($trekking) || empty($postcode) || empty($compleet)){
        header("Location: ".$_SERVER['HTTP_REFERER']."?error=emptyfields");
        exit();
    }
    else if(!preg_match("/^[a-zA-Z]*$/",$groepsnaam) || !preg_match("/^[0-9]*$/",$bedrag)) {
        header("Location: ".$_SERVER['HTTP_REFERER']."?error=invalidgroepsnaam&invalidbedrag");
        exit();
    }
    else {
        $sql = "INSERT INTO Groep (GroepsNaam, Bedrag, DatumViering, DatumTrekking, Postcode, Compleet)
        VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt, $sql)) {
            header("Location: ".$_SERVER['HTTP_REFERER']."?error=sqlerror");
            exit();
        }
        else {
            mysqli_stmt_bind_param($stmt, "sisiss", $groepsnaam, $bedrag, $datum, $trekking, $postcode, $compleet);
            mysqli_stmt_execute($stmt);
        }
    }



    // Opslaan van Gebruiker
    if(isset($_POST['uid'])){
        $username = $_POST['uid'];
        // Check if inputs are empty
        if(empty($username) || empty($mail) || empty($password) || empty($passwordrepeat)){
            header("Location: ".$_SERVER['HTTP_REFERER']."?error=emptyfields&uid=".$username."&mail=".$mail);
            exit();
        }
        // Check if mail and username aren't invalid
        else if (!filter_var($mail, FILTER_VALIDATE_EMAIL) && !preg_match("/^[a-zA-Z0-9]*$/", $username)) {
            header("Location: ".$_SERVER['HTTP_REFERER']."?error=invalidmailuid");
            exit();
        }
        // Check if mail isn't invalid
        else if (!filter_var($mail, FILTER_VALIDATE_EMAIL)) {
            header("Location: ".$_SERVER['HTTP_REFERER']."?error=invalidmail&uid=".$username);
            exit();
        } 
        // Check if username isn't invalid
        else if (!preg_match("/^[a-zA-Z0-9]*$/", $username)) {
            header("Location: ".$_SERVER['HTTP_REFERER']."?error=invaliduid&mail=".$mail);
            exit();        
        }
        // Check if password and repeated password are the same
        else if ($password !== $passwordrepeat) {
            header("Location: ".$_SERVER['HTTP_REFERER']."?error=passwordcheck&uid=".$username."&mail=".$mail);
            exit();
        }
        // Check if there are other users with the same username
        else {
            $sql = "SELECT GebruikersNaam FROM Gebruikers WHERE Gebruikersnaam=?";
            // Preparing the database to insert new data
            $stmt = mysqli_stmt_init($conn);
            if(!mysqli_stmt_prepare($stmt, $sql)) {
                header("Location: ".$_SERVER['HTTP_REFERER']."?error=sqlerror");
                exit();
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
                    header("Location: ".$_SERVER['HTTP_REFERER']."?error=usertaken&mail=".$mail);
                    exit();
                }
                // If username isn't taken, insert new user
                else {
                    $sql = "INSERT INTO Gebruikers (GebruikersNaam, Email, Wachtwoord) VALUES (?, ?, ?)";
                    // Preparing the database to insert new data
                    $stmt = mysqli_stmt_init($conn);
                    if(!mysqli_stmt_prepare($stmt, $sql)) {
                        header("Location: ".$_SERVER['HTTP_REFERER']."?error=sqlerror");
                        exit();
                    }
                    else {
                        // Hash inserted pwd, so no pwd get saved as the are inserted from the sign up form
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
            header("Location: ".$_SERVER['HTTP_REFERER']."?error=emptyfields");
            exit();
        }
        else {
            $sql = "SELECT * FROM Gebruikers WHERE Email=?";
            $stmt = mysqli_stmt_init($conn);
            if(!mysqli_stmt_prepare($stmt, $sql)){
                header("Location: ".$_SERVER['HTTP_REFERER']."?error=sqlerror");
                exit();
            }
            else {
                mysqli_stmt_bind_param($stmt, "s", $mail);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);
                if($row = mysqli_fetch_assoc($result)){
                    $passwordCheck = password_verify($password, $row['Wachtwoord']);
                    if($passwordCheck == false) {
                        header("Location: ".$_SERVER['HTTP_REFERER']."?error=passwordincorrect");
                        exit();
                    }
                    else if($passwordCheck == true) {
                        session_start();
                        $_SESSION['userId'] = $row['GebruikerID'];
                        $_SESSION['userUsername'] = $row['GebruikersNaam'];
                        $_SESSION['userEmail'] = $row['Email'];
                    }
                    else {
                        header("Location: ".$_SERVER['HTTP_REFERER']."?error");
                        exit();
                    }
                }
                else {
                    header("Location: ".$_SERVER['HTTP_REFERER']."?error=nouser");
                    exit();
                }
            }
        }
    }



    // Opslaan van beheerder met aanmaken nieuw account
    if(isset($_POST['uid'])){
        $username = $_POST['uid'];
        if(empty($username) || empty($mailadmin) || empty($bericht)){
            header("Location: ".$_SERVER['HTTP_REFERER']."?error=emptyfields");
            exit();
        }
        else if(!preg_match("/^[a-zA-Z ]*$/",$username && !filter_var($mailadmin, FILTER_VALIDATE_EMAIL))) {
            header("Location: ".$_SERVER['HTTP_REFERER']."?error=invalidnamemail");
            exit();
        }
        else {
            $sql = "SELECT * FROM Groep WHERE GroepsNaam=? AND Postcode=? AND Bedrag=?";
            $stmt = mysqli_stmt_init($conn);
            if(!mysqli_stmt_prepare($stmt, $sql)){
                header("Location: ".$_SERVER['HTTP_REFERER']."?error=sqlerror");
                exit();
            }
            else {
                mysqli_stmt_bind_param($stmt, "ssi", $groepsnaam, $postcode, $bedrag);
                mysqli_stmt_execute($stmt);
                $resultgroepid = mysqli_stmt_get_result($stmt);
                if($groep = mysqli_fetch_assoc($resultgroepid)) {
                    $sql = "SELECT * FROM Gebruikers WHERE GebruikersNaam=?";
                    $stmt = mysqli_stmt_init($conn);
                    if(!mysqli_stmt_prepare($stmt, $sql)){
                        header("Location: ".$_SERVER['HTTP_REFERER']."?error=sqlerror");
                        exit();
                    }
                    else {
                        mysqli_stmt_bind_param($stmt, "s", $username);
                        mysqli_stmt_execute($stmt);
                        $resultid = mysqli_stmt_get_result($stmt);
                        if($gebruiker = mysqli_fetch_assoc($resultid)) {
                            $sql = "INSERT INTO Beheerders (BeheerdersNaam, Email, Bericht, GroepID, GebruikerID) VALUES (?, ?, ?, ?, ?)";
                            $stmt = mysqli_stmt_init($conn);
                            if(!mysqli_stmt_prepare($stmt, $sql)) {
                                header("Location: ".$_SERVER['HTTP_REFERER']."?error=sqlerror");
                                exit();
                            }
                            else {
                                mysqli_stmt_bind_param($stmt, "sssii", $username, $mailadmin, $bericht, $groep['GroepID'], $gebruiker['GebruikerID']);
                                mysqli_stmt_execute($stmt);
                            }
                        }
                        else {
                            header("Location: ".$_SERVER['HTTP_REFERER']."?error=noresults");
                            exit();
                        }
                    }
                }
                else {
                    header("Location: ".$_SERVER['HTTP_REFERER']."?error=noresults");
                    exit();
                }
            }
        }
    }
    // Beheerder opslaan met al ingelogde gebruiker
    else if(isset($_POST['admin'])) {
        $beheerder = $_POST['admin'];
        if(empty($beheerder) || empty($mailadmin) || empty($bericht)){
            header("Location: ".$_SERVER['HTTP_REFERER']."?error=emptyfields");
            exit();
        }
        else if(!preg_match("/^[a-zA-Z ]*$/",$beheerder && !filter_var($mailadmin, FILTER_VALIDATE_EMAIL))) {
            header("Location: ".$_SERVER['HTTP_REFERER']."?error=invalidnamemail");
            exit();
        }
        else {
            $sql = "SELECT * FROM Groep WHERE GroepsNaam=? AND Postcode=? AND Bedrag=?";
            $stmt = mysqli_stmt_init($conn);
            if(!mysqli_stmt_prepare($stmt, $sql)){
                header("Location: ".$_SERVER['HTTP_REFERER']."?error=sqlerror");
                exit();
            }
            else {
                mysqli_stmt_bind_param($stmt, "ssi", $groepsnaam, $postcode, $bedrag);
                mysqli_stmt_execute($stmt);
                $resultgroepid = mysqli_stmt_get_result($stmt);
                if($groep = mysqli_fetch_assoc($resultgroepid)) {
                    $sql = "SELECT * FROM Gebruikers WHERE GebruikersNaam=?";
                    $stmt = mysqli_stmt_init($conn);
                    if(!mysqli_stmt_prepare($stmt, $sql)){
                        header("Location: ".$_SERVER['HTTP_REFERER']."?error=sqlerror");
                        exit();
                    }
                    else {
                        mysqli_stmt_bind_param($stmt, "s", $beheerder);
                        mysqli_stmt_execute($stmt);
                        $resultid = mysqli_stmt_get_result($stmt);
                        if($gebruiker = mysqli_fetch_assoc($resultid)) {
                            $sql = "INSERT INTO Beheerders (BeheerdersNaam, Email, Bericht, GroepID, GebruikerID) VALUES (?, ?, ?, ?, ?)";
                            $stmt = mysqli_stmt_init($conn);
                            if(!mysqli_stmt_prepare($stmt, $sql)) {
                                header("Location: ".$_SERVER['HTTP_REFERER']."?error=sqlerror");
                                exit();
                            }
                            else {
                                mysqli_stmt_bind_param($stmt, "sssii", $beheerder, $mailadmin, $bericht, $groep['GroepID'], $gebruiker['GebruikerID']);
                                mysqli_stmt_execute($stmt);
                            }
                        }
                        else {
                            header("Location: ".$_SERVER['HTTP_REFERER']."?error=noresults");
                            exit();
                        }
                    }
                }
                else {
                    header("Location: ".$_SERVER['HTTP_REFERER']."?error=noresults");
                    exit();
                }
            }
        }
    }
    else {
        header("Location: ".$_SERVER['HTTP_REFERER']."?errorrrr");
        exit();
    }



    // Opslaan van deelnemers
    if($_COOKIE['counter'] >= 0){
        $standaardaantal = 1 + $_COOKIE['counter'];
        $loopaantal = 2 + $standaardaantal;
        // Sla elk ingevoerde naam op in de database
        for($i = 2; $i <= $loopaantal; $i++){
            $deelnemer = $_POST["name".$i];
            if($deelnemer === NULL){
                header("Location: ".$_SERVER['HTTP_REFERER']."?error=emptydeelnemer".$i);
                exit();
            }
            else if(!preg_match("/^[a-zA-Z ]*$/", $deelnemer)) {
                header("Location: ".$_SERVER['HTTP_REFERER']."?error=invalidname");
                exit();
            }
            else {
                $sql = "SELECT * FROM Groep WHERE GroepsNaam=? AND Postcode=? AND Bedrag=?";
                $stmt = mysqli_stmt_init($conn);
                if(!mysqli_stmt_prepare($stmt, $sql)){
                    header("Location: ".$_SERVER['HTTP_REFERER']."?error=sqlerror");
                    exit();
                }
                else {
                    mysqli_stmt_bind_param($stmt, "ssi", $groepsnaam, $postcode, $bedrag);
                    mysqli_stmt_execute($stmt);
                    $resultgroepid = mysqli_stmt_get_result($stmt);
                    if($groep = mysqli_fetch_assoc($resultgroepid)) {
                        $sql = "INSERT INTO Deelnemers (DeelnemersNaam, GroepID) VALUES (?, ?)";
                        $stmt = mysqli_stmt_init($conn);
                        if(!mysqli_stmt_prepare($stmt, $sql)) {
                            header("Location: ".$_SERVER['HTTP_REFERER']."?error=sqlerror");
                            exit();
                        }
                        else {
                            mysqli_stmt_bind_param($stmt, "si", $deelnemer, $groep['GroepID']);
                            mysqli_stmt_execute($stmt);
                            header("Location: /sinterklaaslootjes/user/index.php?save=succes");
                            exit();
                        }
                    }
                    else {
                        header("Location: ".$_SERVER['HTTP_REFERER']."?error=noresults");
                        exit();   
                    }
                }
            }
        }
    }
    else {
        header("Location: ".$_SERVER['HTTP_REFERER']."?error=cookieerror");
        exit();
    }
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}
else {
    header("Location: ".$_SERVER['HTTP_REFERER']);
    exit();
}