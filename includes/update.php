<?php
    require "redirect.php";

    if(isset($_POST['add'])) {
        require "conn.php";

        $mail = $_POST['addmail'];
        $deelnemerid = intval($_GET['deelnemerid']);

        // Checking for errors
        if(empty($mail)) {
            redirectError("empty=fields");
        }
        else if (!filter_var($mail, FILTER_VALIDATE_EMAIL)) {
            redirectError("error=invalidmail");
        }
        else if(!preg_match("/^[0-9]*$/", $deelnemerid)) {
            redirectError("error=invalidid");
        }
        else {
            $sql = "UPDATE Deelnemer SET Email=? WHERE DeelnemerID=?";
            $stmt = mysqli_stmt_init($conn);
            if(!mysqli_stmt_prepare($stmt, $sql)) {
                redirectError("error=sqlerror");
            }
            else {
                mysqli_stmt_bind_param($stmt, "si", $mail, $deelnemerid);
                mysqli_stmt_execute($stmt);
                redirectSucces("update=succes");
            }
        }
    } else {
        redirectError("eerst=login");
    }