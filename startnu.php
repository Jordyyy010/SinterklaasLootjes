<?php
    require "header.php";

    if(isset($_SESSION['userId'])){
        $groepid = intval($_GET['groepid']);
        if($_GET['start'] == "later"){
            echo '<section class="card-header-centered">
                    <h2>Is de groep compleet?</h2>
                    <h2>Is iedereen zijn email ingevoerd?</h2>
                    <p class="signuperror">Weet je zeker dat je de trekking wilt uitvoeren?
                    Als de trekking gestart is, kan er niet opnieuw getrokken worden</p>
                    <h4><a class="signuperror" href="'.$_SERVER['PHP_SELF'].'?groepid='.$groepid.'&start=nu">Ja</a></h4>
                    <h4><a class="signuperror" href="user\detail.php?groepid='.$groepid.'&email">Nee</a></h4></section>';
        }
        else if($_GET['start'] == "nu" || $_GET['start'] !== "later") {
            header("Location: \sinterklaaslootjes\includes\start.php?groepid=" . $groepid);
            exit();
        } 
        else {
            header("Location: \sinterklaaslootjes\index.php");
            exit();
        }
    }

    require "footer.php";