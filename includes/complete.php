<?php

if(isset($_POST['complete'])){
    require "localhost-conn.php";
    require "redirect.php";

    $groepid = $_GET['groepid'];

    $sql = "SELECT Email FROM Deelnemer WHERE GroepID=?";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql)) {
        redirectError("error=sql");
    }
    else {
        mysqli_stmt_bind_param($stmt, "i", $groepid);
        mysqli_stmt_execute($stmt);
        $getmail = mysqli_stmt_get_result($stmt);
        while ($mail = mysqli_fetch_assoc($getmail)) {
            if($mail['Email'] == null) {
                redirectURL("../user/detail.php?email=empty&groepid=".$groepid);
            }
        }
        $sql = "UPDATE Groep SET Compleet='ja' WHERE GroepID=?";
        $stmt = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt, $sql)) {
            redirectError("error=sqlerror&email");
        }
        else {
            mysqli_stmt_bind_param($stmt, "i", $groepid);
            mysqli_stmt_execute($stmt);
            redirectError("save=succes&groepid=".$groepid."&email");
        }
    }
}
else {
    redirectError("error=unknown");
}