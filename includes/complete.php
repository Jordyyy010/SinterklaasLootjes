<?php

if(isset($_POST['complete'])){
    require "conn.php";

    $id = $_GET['id'];

    $sql = "UPDATE Groep SET Compleet='ja' WHERE GroepID=?";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql)) {
        header("Location: ".$_SERVER['HTTP_REFERER']."?error=sqlerror");
        exit();
    }
    else {
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);
        header("Location: ".$_SERVER['HTTP_REFERER']);
        exit();
    }
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}
else {
    header("Location: ".$_SERVER['HTTP_REFERER']);
    exit();
}