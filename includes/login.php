<?php

if(isset($_POST['login'])){
    
    // Database connections
    // require "conn.php";
    require "conn.php";

    $mailuid = $_POST['mailuid'];
    $password = $_POST['pwd'];

    // Check if inputs are empty
    if(empty($mailuid) || empty($password)){
        header("Location: ../login/login.php?inputs=empty&mailuid=".$mailuid);
        exit();
    }
    // Checking if there is an user with that specific username or email
    else {
        $sql = "SELECT * FROM Gebruiker WHERE GebruikersNaam=? OR Email=?";
        $stmt = mysqli_stmt_init($conn);
        // Check if the sql statement has any errors before executing
        if(!mysqli_stmt_prepare($stmt, $sql)){
            header("Location: ../login/login.php?error=sqlerror");
            exit();
        }
        else {
            // Binding parameters to the sql string before executing
            mysqli_stmt_bind_param($stmt, "ss", $mailuid, $mailuid);
            // Executing the sql string with passed variables
            mysqli_stmt_execute($stmt);
            // Getting results from the database
            $result = mysqli_stmt_get_result($stmt);
            // Checking if there are results that were already stored in the database
            if($row = mysqli_fetch_assoc($result)) {
                $passwordCheck = password_verify($password, $row['Wachtwoord']);
                if($passwordCheck == false) {
                    header("Location: ../login/login.php?error=wrongpassword");
                    exit();
                }
                // Using else if stmt, $passwordCheck could be some other data then 1(true), when it's yes the user will be logged in. Now he won't
                else if($passwordCheck == true) {
                    session_start();
                    $_SESSION['userId'] = $row['GebruikerID'];
                    $_SESSION['userUsername'] = $row['GebruikersNaam'];

                    header("Location: ../index.php?login=succes");
                    exit();
                }
                else {
                    header("Location: ../login/login.php?error=wrongpassword");
                    exit();
                }
            }
            else {
                header("Location: ../login/login.php?error=nouser");
                exit();
            }
        }
    }
}
else {
    header("Location: ../");
    exit();
}