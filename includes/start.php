<?php

session_start();

if(isset($_SESSION['userId'])){
    require "localhost-conn.php";
    require "redirect.php";
    $id = intval($_GET['id']);

    
    
    // Ophalen deelnemers
    $sql = "SELECT DeelnemerID, DeelnemersNaam FROM Deelnemer WHERE GroepID=?";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql)) {
        redirectError("error=sqlerror");
    }
    else {
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);
        $get2 = mysqli_stmt_get_result($stmt);
        while($deelnemer = mysqli_fetch_assoc($get2)) {
            $ids[] = $deelnemer['DeelnemerID'];
            $info[$deelnemer['DeelnemerID']] = $deelnemer;
        }

        $names = $got = $ids;

        $himself = true;
        $huidig = true;

        while($himself == true) {
            shuffle($got);
            foreach($names as $key => $value) {
                if($value == $got[$key]) {
                    $huidig = true;
                }
            }
            if($huidig == true) {
                $himself = true;
            }
            else {
                $himself = false;
            }
            $huidig = false;
        }

        foreach($names as $key => $value){
            // If selected ids from al participants are the same as the result from shuffle($got)
            if($value == $got[$key]){
                echo '<p class="signuperror">Iemand heeft zichzelf getrokken!</p>';
                exit();
            }
            if($value !== $ids){
                $self = $got[$key];
                echo $value . ' ' . $got[$key]. '<br />';
            }
            $sql = "UPDATE Deelnemer SET Getrokken=? WHERE DeelnemerID=?";
            $stmt = mysqli_stmt_init($conn);
            if(!mysqli_stmt_prepare($stmt, $sql)) {
                redirectError("error=sqlerror");
            }
            else {
                mysqli_stmt_bind_param($stmt, "si", $got[$key], $value);
                mysqli_stmt_execute($stmt);

                $trekking = "1";
                $sql = "UPDATE Groep SET Trekking=? WHERE GroepID=?";
                $stmt = mysqli_stmt_init($conn);
                if(!mysqli_stmt_prepare($stmt, $sql)) {
                    redirectError("error=sqlerror");
                }
                else {
                    mysqli_stmt_bind_param($stmt, "ii", $trekking, $id);
                    mysqli_stmt_execute($stmt);
                    // Beginnen aan de mail versturen
            }
            }
        }
        header("Location: \sinterklaaslootjes\user\detail.php?id=".$id);
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
        exit();
    }
}