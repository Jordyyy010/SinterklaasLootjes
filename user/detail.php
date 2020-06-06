<?php
    require "../header.php";
?>
<div class="jusify-content">
    <div class="groep-container">
        <div class="back-section">
            <a href="index.php">&#8592;   Terug naar overzicht</a>
        </div>
        <div class="details">
        <?php
            require "../includes/conn.php";

            $sql = "SELECT GroepsNaam
            FROM Groep
            WHERE GroepID=?";
            $stmt = mysqli_stmt_init($conn);
            if(!mysqli_stmt_prepare($stmt, $sql)){
                header("Location: ".$_SERVER['HTTP_REFERER']."?error=sqlerror");
                exit();
            }
            else {
                $id = intval($_GET['id']);
                mysqli_stmt_bind_param($stmt, "i", $id);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);
                while($row = mysqli_fetch_assoc($result)){
                    echo '<h2 class="card-header-centered">Dit is het overzicht van groep '.$row['GroepsNaam'].'</h2>';

                    $sql = "SELECT DeelnemersNaam FROM Deelnemers WHERE GroepID=?";
                    $stmt = mysqli_stmt_init($conn);
                    if(!mysqli_stmt_prepare($stmt, $sql)) {
                        header("Location ".$_SERVER['HTTP_REFERER']."?error=nodeelnemers");
                        exit();
                    }
                    else {
                        mysqli_stmt_bind_param($stmt, "i", $id);
                        mysqli_stmt_execute($stmt);
                        $result = mysqli_stmt_get_result($stmt);
                        echo '<table>
                                <tr>
                                    <th>Deelnemers</th>
                                    <th>Verwijderen</th>
                                </tr>';
                        while($row = mysqli_fetch_assoc($result)){
                            echo '<tr>
                                    <td>' . $row['DeelnemersNaam'].'</td>
                                    <td><a class="signuperror" href="#">Verwijderen</a></td>
                                </tr>';
                        }
                        echo '</table';
                    }
                }
            }
        
        ?>
        </div>
    </div>
</div>


<?php
    require "../footer.php";
?>