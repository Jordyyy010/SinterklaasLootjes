<?php
    require "../header.php";
?>


<div class="justify-content">
    <div class="groep-container">
        <?php
        $groepid = intval($_GET['groepid']);
        $deelnemerid = intval($_GET['deelnemerid']);
        echo '<div class="back-section">
                <a href="detail.php?groepid='.$groepid.'&email">&#8592;   Terug naar overzicht</a>
            </div>
            <div class="details">';

        if(isset($_SESSION['userId'])){
            require "../includes/localhost-conn.php";
            require "../includes/redirect.php";

            $sql = "SELECT DeelnemersNaam, Email FROM Deelnemer WHERE DeelnemerID=?";
            $stmt = mysqli_stmt_init($conn);
            if(!mysqli_stmt_prepare($stmt, $sql)) {
                redirectError("error=sqlerror&email");
            }
            else {
                mysqli_stmt_bind_param($stmt, "i", $deelnemerid);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);
            
                while($row = mysqli_fetch_assoc($result)){
                    echo '<h2 class="card-header-centered">'.$row['DeelnemersNaam'].' '.$row['Email'].'</h2>
                        <form action="/sinterklaaslootjes/includes/update.php?groepid='.$groepid.'&deelnemerid='.$deelnemerid.'" method="POST">
                            <div class="names">
                                <div class="flex-area">
                                    <input class="new-input" type="text" name="addmail" placeholder="Voeg email toe">
                                    <button class="add-participant-button" type="submit" name="add">Voeg toe</button>
                                </div>
                            </div>
                        </form>';

                }
            }
        }
        else {
            echo '<h2 class="card-header-centered"><a class="signuperror" href="/sinterklaaslootjes/login/login.php">Log in om het overzicht van jouw groepen te zien</a></h2>';
        }
        ?>
        </div>
    </div>
</div>

<?php
    require "../footer.php";
?>