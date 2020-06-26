<?php
    require "redirect.php";

    if(isset($_POST['add'])) {
        require "localhost-conn.php";

        $mail = $_POST['updatemail'];
        $groepid = intval($_GET['groepid']);
        $deelnemerid = intval($_GET['deelnemerid']);


        // Checking for errors
        if(empty($mail)) {
            redirectError("empty=fields&email");
        }
        else if (!filter_var($mail, FILTER_VALIDATE_EMAIL)) {
            redirectError("error=invalidmail&email");
        }
        else if(!preg_match("/^[0-9]*$/", $deelnemerid)) {
            redirectError("error=invalidid&email");
        }
        else {
            $sql = "UPDATE Deelnemer SET Email=? WHERE DeelnemerID=?";
            $stmt = mysqli_stmt_init($conn);
            if(!mysqli_stmt_prepare($stmt, $sql)) {
                redirectError("error=sqlerror&email");
            }
            else {
                mysqli_stmt_bind_param($stmt, "si", $mail, $deelnemerid);
                mysqli_stmt_execute($stmt);
                redirectURL("/sinterklaaslootjes/user/detail.php?groepid=".$groepid."&update=succes&email");
            }
        }
    } else {
        redirectError("eerst=login&email");
    }