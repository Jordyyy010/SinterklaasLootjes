<?php

function redirectError($errormsg){
    global $conn;
    header("Location: ".$_SERVER['HTTP_REFERER']."?".$errormsg);
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
    exit();
}

function redirectSucces($succesmsg){
    global $conn;
    header("Location: ".$_SERVER['HTTP_REFERER']."?".$succesmsg);
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
    exit();
}

function redirectURL($url){
    global $conn;
    header("Location: ".$url."");
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
    exit();
}