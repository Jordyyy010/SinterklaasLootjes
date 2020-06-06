<?php
    require "../header.php";
?>


<div class="justify-content">
    <div class="groep-container">
        <?php
            if(isset($_SESSION['userId'])){
                echo '<h1 class="card-header-centered">Groep overzicht van '.$_SESSION["userUsername"].'</h1>
                <div class="flex-area">';

                require "../includes/conn.php";
                $sql = "SELECT Beheerders.BeheerdersNaam, Groep.GroepID, Groep.GroepsNaam, Groep.DatumViering
                        FROM Beheerders
                        INNER JOIN Groep
                        ON Beheerders.GroepID = Groep.GroepID
                        WHERE GebruikerID=?";
                $stmt = mysqli_stmt_init($conn);
                if(!mysqli_stmt_prepare($stmt, $sql)){
                    echo '<p class="signuperror">Error: Sql error</p>';
                }
                else if(mysqli_stmt_prepare($stmt, $sql)) {
                    mysqli_stmt_bind_param($stmt, "i", $_SESSION['userId']);
                    mysqli_stmt_execute($stmt);
                    $resultCheck = mysqli_stmt_get_result($stmt);
                    while($row = mysqli_fetch_assoc($resultCheck)) {
                        echo '<div class="group-item">
                                <h2><a class="group-header" href="detail.php?id=' . $row['GroepID'] . '">' . $row["GroepsNaam"] . '</a></h2>
                                <div class="navigation">
                                    <div class="left">' . $row["BeheerdersNaam"] . '</div>
                                    <div class="right">' . $row["DatumViering"] . '</div>
                                </div>
                            </div>';
                    }
                }
                
                else {
                    echo '<p class="signuperror">No results</p>';
                }
                echo '</div>';
            }
            else {
                echo '<h1 class="card-header-centered">Eerst inloggen</h1>
                <p class="card-body">
                    <a class="links" href="/sinterklaaslootjes/login/login.php">Klik hier om in te loggen</a>
                </p>';
            }
        ?>
    </div>
</div>

<?php
    require "../footer.php";
?>