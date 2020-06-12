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
                $sql = "SELECT Beheerder.BeheerdersNaam, Groep.GroepID, Groep.GroepsNaam, Groep.DatumViering
                        FROM Beheerder
                        INNER JOIN Groep
                        ON Beheerder.GroepID = Groep.GroepID
                        WHERE GebruikerID=?";
                $stmt = mysqli_stmt_init($conn);
                if(!mysqli_stmt_prepare($stmt, $sql)){
                    echo '<p class="signuperror">Error: Sql error</p>';
                }
                else if(mysqli_stmt_prepare($stmt, $sql)) {
                    mysqli_stmt_bind_param($stmt, "i", $_SESSION['userId']);
                    mysqli_stmt_execute($stmt);
                    $resultCheck = mysqli_stmt_get_result($stmt);
                    echo '<table>
                            <tr>
                                <th>Groepsnaam</th>
                                <th class="groep-overzicht-center-td">Beheerder</th>
                                <th>Datum Viering</th>
                            </tr>';
                    while($row = mysqli_fetch_assoc($resultCheck)) {
                        echo '<tr>
                                <td><a href="detail.php?id=' . $row["GroepID"] . '">' . $row["GroepsNaam"] . '</a></td>
                                <td class="groep-overzicht-center-td">' . $row["BeheerdersNaam"] . '</td>
                                <td>' . $row["DatumViering"] . '</td>
                            </tr>';
                    }
                    echo '</table>';
                    mysqli_stmt_close($stmt);
                    mysqli_close($conn);
                }
                else {
                    echo '<p class="signuperror">No results</p>';
                }
                echo '</div>';
            }
            else {
                echo '<h2 class="card-header-centered"><a class="signuperror" href="/login/login.php">Log in om het overzicht van jouw groepen te zien</a></h2>';
            }
        ?>
    </div>
</div>

<?php
    require "../footer.php";
?>