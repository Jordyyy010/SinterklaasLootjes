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
        if(isset($_SESSION['userId'])){
            require "../includes/localhost-conn.php";

            $sql = "SELECT GroepsNaam, Compleet, Trekking
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
                    echo '<h2 class="card-header-centered">'.$row['GroepsNaam'].'</h2>';
                    if($row["Compleet"] === "ja" && $row['Trekking'] == "0"){
                        echo '<form action="..\startnu.php?id='.$id.'&start=later" method="POST">
                                <div class="names">
                                    <div class="flex-area">
                                        <button class="add-participant-button" name="submit">Trekking starten</button>
                                    </div>
                                </div>
                            </form>';
                    } else if($row["Compleet"] === "nee" && $row['Trekking'] == "0"){
                        echo '<form action="/sinterklaaslootjes/includes/add.php?groepid=' . $id . '" method="POST">
                                <div class="names">
                                    <div class="flex-area">
                                        <input class="new-input" type="text" name="nieuwlid" placeholder="Voeg nog een deelnemer toe">
                                        <button class="add-participant-button" type="submit" name="add">Voeg deelnemer toe</button>
                                    </div>
                                </div>
                            </form>';
                        echo '<form action="../includes/complete.php?id=' . $id . '" method="POST">
                                <div class="names">
                                    <div class="flex-area">
                                        <button class="add-participant-button" type="submit" name="complete">Is de groep compleet?</button>
                                    </div>
                                </div>
                            </form>
                            <p class="card-header-centered"><section class="signuperror">Zodra u de groep compleet maakt door op de knop hierboven te klikken, kunt u geen extra deelenmers meer toevoegen</section></p>';
                    }
                    else if($row["Compleet"] === "ja" && $row['Trekking'] == "1") {
                        echo '<p class="card-header-centered"><h2 class="signupsucces">De trekking is al geweest</h2></p>';
                    }
                    else {
                        header("Location: ../create.php?create=group");
                        exit();
                    }
                }
                $sql = "SELECT DeelnemerID, DeelnemersNaam FROM Deelnemer WHERE GroepID=?";
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
                                <th>Bewerken</th>
                                <th>Verwijderen</th>
                            </tr>';
                    while($row = mysqli_fetch_assoc($result)){
                        echo '<tr>
                                <td>' . $row['DeelnemersNaam'].'</td>
                                <td><a class="signupsucces" href="/sinterklaaslootjes/user/update.php?deelnemerid='.$row['DeelnemerID'].'&groepid='.$id.'">Bewerken</a></td>
                                <td><a class="signuperror" href="/sinterklaaslootjes/includes/delete.php?id=' . $row['DeelnemerID'] . '&groepid='.$id.'">Verwijderen</a></td>
                            </tr>';
                    }
                    echo '</table';
                }
                mysqli_stmt_close($stmt);
                mysqli_close($conn);
            }
        }
        else {
            echo '<h3 class="card-header-centered"><a class="signuperror" href="../login/login.php">Log in om het overzicht van een groep te zien</a></h3>';
        }

        ?>
        </div>
    </div>
</div>



<?php
    require "../footer.php";
?>