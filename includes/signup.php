<?php

if (isset($_POST['signup'])) {
 
    // require "conn.php";

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "lootjes";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    $username = $_POST['uid'];
    $mail = $_POST['mail'];
    $password = $_POST['pwd'];
    $passwordrepeat = $_POST['pwdrepeat'];

    // Check if inputs are empty
    if(empty($username) || empty($mail) || empty($password) || empty($passwordrepeat)){
         header("Location: ../login/signup.php?error=emptyfields&uid=".$username."$mail=".$mail);
         exit();
    }
    // Check if mail and username aren't invalid
    else if (!filter_var($mail, FILTER_VALIDATE_EMAIL) && !preg_match("/^[a-zA-Z0-9]*$/", $username)) {
        header("Location: ../login/signup.php?error=invalidmailuid");
        exit();
    } 
    // Check if mail isn't invalid
    else if (!filter_var($mail, FILTER_VALIDATE_EMAIL)) {
        header("Location: ../login/signup.php?error=invalidmail&uid=".$username);
        exit();
    } 
    // Check if username isn't invalid
    else if (!preg_match("/^[a-zA-Z0-9]*$/", $username)) {
        header("Location: ../login/signup.php?error=invaliduid&mail=".$mail);
        exit();        
    }
    // Check if password and repeated password are the same
    else if ($password !== $passwordrepeat) {
        header("Location: ../login/signup.php?error=passwordcheck&uid=".$username."$mail=".$mail);
        exit();
    }
    // Check if there are other users with the same username
    else {
        $sql = "SELECT GebruikersNaam FROM Gebruikers WHERE Gebruikersnaam=?";
        // Preparing the database to insert new data
        $stmt = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt, $sql)) {
            header("Location: ../login/signup.php?error=sqlerror");
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
                header("Location: ../login/signup.php?error=usertaken?mail=".$mail);
                exit();
            }
            // If username isn't taken, insert new user
            else {
                $sql = "INSERT INTO Gebruikers (GebruikersNaam, Email, Wachtwoord) VALUES (?, ?, ?)";
                // Preparing the database to insert new data
                $stmt = mysqli_stmt_init($conn);
                if(!mysqli_stmt_prepare($stmt, $sql)) {
                    header("Location: ../login/signup.php?error=sqlerror");
                    exit();
                }
                else {
                    // Hash inserted pwd, so no pwd get saved as the are inserted from the sign up form
                    $hashedPwd = password_hash($password, PASSWORD_DEFAULT);
                    // Defining inputs to the sql statement through prepared statements
                    mysqli_stmt_bind_param($stmt, "sss", $username, $mail, $hashedPwd);
                    mysqli_stmt_execute($stmt);
                    header("Location: ../login/signup.php?registreren=succesvol");
                    exit();
                }
            }
        }

    }
    // Close statement and connection to database
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}
// If page entered by typing URL and not by submitted the signup button, redirect to signup page
else {
    header("Location: ../login/signup.php");
    exit();
}

?>