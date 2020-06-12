<?php
    require "header.php";

    if(isset($_SESSION['userId'])){
        $id = intval($_GET['id']);
        if($_GET['start'] == "later"){
            echo 'Weet je zeker dat je de trekking wilt uitvoeren?
                    Zodra de trekking gestart is, kunt u geen deelnemers meer toevoegen
                    <a class="signuperror" href="'.$_SERVER['PHP_SELF'].'?id='.$id.'&start=nu">Ja</a>
                    <a class="signuperror" href="\sinterklaaslootjes\user\detail.php?id='.$id.'">Nee</a>';
        }
        else if($_GET['start'] == "nu" || $_GET['start'] !== "later") {
            header("Location: \sinterklaaslootjes\includes\start.php?id=" . $id);
            exit();
        } 
        else {
            header("Location: \sinterklaaslootjes");
            exit();
        }
    }

    require "footer.php";