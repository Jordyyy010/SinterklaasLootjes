<?php

require "conn.php";

if(isset($_POST['add'])){
    $newdeelnemer = $_POST['nieuwlid'];
    $groepid = intval($_GET['groepid']);

    if(empty($newdeelnemer)){
        header("Location: ".$_SERVER['HTTP_REFERER']."?error=emptyfields");
        exit();
    }
    else if(!preg_match("/^[a-zA-Z]*$/", $newdeelnemer)) {
        header("Location: ".$_SERVER['HTTP_REFERER']."?error=invalidname");
        exit();
    }
    else {
        $sql = "INSERT INTO Deelnemer (DeelnemersNaam, GroepID) VALUES (?, ?)";
        $stmt = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt, $sql)){
            header("Location: ".$_SERVER['HTTP_REFERER']."?error=sqlerror");
            exit();
        }
        else {
            mysqli_stmt_bind_param($stmt, "si", $newdeelnemer, $groepid);
            mysqli_stmt_execute($stmt);
            header("Location: ".$_SERVER['HTTP_REFERER']);
            exit();
        }
    }
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}
else {
    header("Location: ".$_SERVER['HTTP_REFERER']);
    exit();
}
