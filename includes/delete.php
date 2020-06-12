<!-- Delete page WITHOUT HTML -->
<?php

require "localhost-conn.php";

$id = intval($_GET['id']);
$groepid = intval($_GET['groepid']);

$sql = "DELETE FROM Deelnemer WHERE DeelnemerID=? AND GroepID=?";
$stmt = mysqli_stmt_init($conn);
if(!mysqli_stmt_prepare($stmt, $sql)) {
    header("Location: ".$_SERVER['HTTP_REFERER']."?error=sqlerror");
    exit();
}
else {
    mysqli_stmt_bind_param($stmt, "ii", $id, $groepid);
    mysqli_stmt_execute($stmt);
    
    // Check if there are still people participating in the group
    $sql = "SELECT DeelnemerID FROM Deelnemer WHERE GroepID=?";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql)) {
        header("Location: ".$_SERVER['HTTP_REFERER']."?error=sqlerror");
        exit();
    }
    else {
        mysqli_stmt_bind_param($stmt, "i", $groepid);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);
        $participants = mysqli_stmt_num_rows($stmt);
        if($participants > 0){
            header("Location: ".$_SERVER['HTTP_REFERER']);
            exit();
        }
        else {
            // First delete Beheerders row bc off the FK
            $sql = "DELETE FROM Beheerder WHERE GroepID=?";
            $stmt = mysqli_stmt_init($conn);
            if(!mysqli_stmt_prepare($stmt, $sql)) {
                header("Location: ".$_SERVER['HTTP_REFERER']."?error=sqlerror");
                exit();
            }
            else {
                mysqli_stmt_bind_param($stmt, "i", $groepid);
                mysqli_stmt_execute($stmt);
                
                // Second delete Groep row when Beheerder row is deleted
                $sql = "DELETE FROM Groep WHERE GroepID=?";
                $stmt = mysqli_stmt_init($conn);
                if(!mysqli_stmt_prepare($stmt, $sql)) {
                    header("Location: ".$_SERVER['HTTP_REFERER']."?error=sqlerror");
                    exit();
                }
                else {
                    mysqli_stmt_bind_param($stmt, "i", $groepid);
                    mysqli_stmt_execute($stmt);
                    header("Location: ../user/index.php");
                    exit();
                }
            }
        }
    }
}
mysqli_stmt_close($stmt);
mysqli_close($conn);