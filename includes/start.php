<?php

session_start();

if(isset($_SESSION['userId'])){
    require "localhost-conn.php";
    require "redirect.php";
    $groepid = intval($_GET['groepid']);

    
    
    // Ophalen deelnemers
    $sql = "SELECT DeelnemerID, DeelnemersNaam, Email FROM Deelnemer WHERE GroepID=?";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql)) {
        redirectError("error=sqlerror");
    }
    else {
        mysqli_stmt_bind_param($stmt, "i", $groepid);
        mysqli_stmt_execute($stmt);
        $get2 = mysqli_stmt_get_result($stmt);
        while($deelnemer = mysqli_fetch_assoc($get2)) {
            if($deelnemer['Email'] == null){
                redirectURL("../user/detail.php?email=empty&groepid=".$groepid);
            }
            else {
                // Voeg id van deelnemers toe aan array ids
                $ids[] = $deelnemer['DeelnemerID'];
                // Voeg alle andere data toe aan array info
                $info[$deelnemer['DeelnemerID']] = $deelnemer;
            }
        }

        $names = $got = $ids;

        $himself = true;
        $huidig = true;

        // Uitsluiten dat je jezelf trekt
        while($himself == true) {
            // Hussel de ids van deelnemers
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
                    mysqli_stmt_bind_param($stmt, "ii", $trekking, $groepid);
                    mysqli_stmt_execute($stmt);
                    // Beginnen aan de mail versturen

                    // Format van email moet voldoen aan RFC 2822 regels
                    mail($info[$value]['DeelnemersNaam'].' <'.$info[$value]['Email'].'>', 'Lootjes getrokken!', 'Hallo '.$info[$value]['DeelnemersNaam'].',
                    
                    Met lootjes trekken heb jij de volgende persoon getrokken: 
                    '.$info[$got[$key]]['DeelnemersNaam'].'
                    
                    Groetjes van,

                    Lootjes Trekker', 'From: De Lootjes Trekker <jordy4c@gmail.com>'
                    );

                    echo 'Je hebt zelf '.$info[$self]['DeelnemersNaam'].' getrokken.';
                }
            }
        }
        // Uitzoeken waar de mails opgeslagen worden
        // C:\laragon\bin\sendmail\output
        redirectURL("\sinterklaaslootjes\user\detail.php?groepid=".$groepid."&email");
    }
}