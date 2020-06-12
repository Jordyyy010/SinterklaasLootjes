<?php
    require "header.php";

    if(isset($_SESSION['userId'])){
        $id = intval($_GET['id']);
        if($_GET['start'] == "later"){
            echo '<section class="card-header-centered">Weet je zeker dat je de trekking wilt uitvoeren?
                    Zodra de trekking gestart is, kunt u geen deelnemers meer toevoegen
                    <a class="signuperror" href="'.$_SERVER['PHP_SELF'].'?id='.$id.'&start=nu">Ja</a>
                    <a class="signuperror" href="\user\detail.php?id='.$id.'">Nee</a></section>';
        }
        else if($_GET['start'] == "nu" || $_GET['start'] !== "later") {
            header("Location: \includes\start.php?id=" . $id);
            exit();
        } 
        else {
            header("Location: \index.php");
            exit();
        }
    }

    require "footer.php";