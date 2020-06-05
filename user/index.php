<?php
    require "../header.php";
?>


<div class="justify-content">
    <div class="container">
        <?php
            if(isset($_SESSION['userId'])){
                echo '<h1 class="card-header-centered">Groep overzicht van '.$_SESSION["userUsername"].'</h1>';

                require "../includes/localhost-conn.php";
                // Check if there is a groep attached to the user
                // Display as many groups as there are attached
                $sql = "SELECT Beheerders.BeheerdersNaam, Groep.GroepsNaam, Groep.DatumViering
                        FROM Beheerders
                        INNER JOIN Groep
                        ON Beheerders.GroepID = Groep.GroepID
                        WHERE GebruikerID=?";
                $stmt = mysqli_stmt_init($conn);
                if(!mysqli_stmt_prepare($stmt, $sql)){
                    echo "Error: Sql error";
                }
                else if(mysqli_stmt_prepare($stmt, $sql)) {
                    mysqli_stmt_bind_param($stmt, "i", $_SESSION['userId']);
                    mysqli_stmt_execute($stmt);
                    $resultCheck = mysqli_stmt_get_result($stmt);
                    while($row = mysqli_fetch_assoc($resultCheck)) {
                        echo '<p class="signupsucces">Beheerder: ' . $row['BeheerdersNaam'] . ' Groepsnaam: ' . $row['GroepsNaam'] . ' en datum van de viering ' . $row['DatumViering'] . '</p>';
                    }
                }
                else {
                    echo '<p class="signuperror">No results</p>';
                }

                // If there are no results of groups
                // Display 'You are not participating to a group'
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