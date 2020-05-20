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

    if(empty($username) || empty($mail) || empty($password) || empty($passwordrepeat)){
         header("Location: ../login/signup.php?error=emptyfields&uid=".$username."$mail=".$mail);
         exit();
    }
    else if (!filter_var($mail, FILTER_VALIDATE_EMAIL) && !preg_match("/^[a-zA-Z0-9]*$/", $username)) {
        header("Location: ../login/signup.php?error=invalidmailuid");
        exit();
    } 
    else if (!filter_var($mail, FILTER_VALIDATE_EMAIL)) {
        header("Location: ../login/signup.php?error=invalidmail&uid=".$username);
        exit();
    } 
    else if (!preg_match("/^[a-zA-Z0-9]*$/", $username)) {
        header("Location: ../login/signup.php?error=invaliduid&mail=".$mail);
        exit();        
    }
    else if ($password !== $passwordrepeat) {
        header("Location: ../login/signup.php?error=passwordcheck&uid=".$username."$mail=".$mail);
        exit();
    }
    else {
        $sql = "SELECT GebruikersNaam FROM Gebruiker WHERE Gebruikersnaam=?";
        $stmt = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt, $sql)) {
            header("Location: ../login/signup.php?error=sqlerror");
            exit();
        }
        else {

        }

    }
}

?>