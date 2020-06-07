<?php

if(isset($_POST['submit'])){
    require "localhost-conn.php";
    $id = intval($_GET['id']);

    // Alle deelnemers ophalen uit de database
    // Error first behandelen
    // !DeelnemerID(2) == DeelnemerID(2)
    
    // For loop voor het aantal deelnemers
    // Een functie die een van de opgehaalde ID's selecteerd
    // Dat id word door de hele code heen gehaald
    
    
    // echo '<table>
            // <tr>
                // <th>Deelnemers</th>
                // <th>Getrokken Lootje</th>
            // </tr>';
    // for($i = 0; $i < $opgehaaldeIDs; $i++){
        // if(!$pickedID == Het eerste id vanuit de opgehaalde rijen){
            // echo '<tr>
                // <td>Naam van deelnemer</td>
                // <td>Naam van lootje</td>
            // </tr>';
        // }
        // echo '</table>
    // }

    $sql = "SELECT DeelnemerID FROM Deelnemers WHERE GroepID=?";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql)) {
        header("Location: ".$_SERVER['HTTP_REFERER']."?error=sqlerror");
        exit();
    }
    else {
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        while($row = mysqli_fetch_array($result)) {
            echo $row['DeelnemerID'];
        }
    }
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}
else {
    header("Location: ".$_SERVER['HTTP_REFERER']);
    exit();
}