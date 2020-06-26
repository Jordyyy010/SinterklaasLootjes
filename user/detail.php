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

            if(strval($_GET['email']) == "empty"){
                echo '<div class="card-header-centered">
                        <h2 class="signuperror">Niet alle email adressen zijn ingevuld</h2>
                    </div>';
            } else if(!strval($_GET['email'])) {
            }

            $sql = "SELECT GroepsNaam, Compleet, Trekking
            FROM Groep
            WHERE GroepID=?";
            $stmt = mysqli_stmt_init($conn);
            if(!mysqli_stmt_prepare($stmt, $sql)){
                header("Location: ".$_SERVER['HTTP_REFERER']."?error=sqlerror");
                exit();
            }
            else {
                $groepid = intval($_GET['groepid']);
                mysqli_stmt_bind_param($stmt, "i", $groepid);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);
                while($row = mysqli_fetch_assoc($result)){
                    echo '<h2 class="card-header-centered">'.$row['GroepsNaam'].'</h2>';
                    if($row["Compleet"] === "ja" && $row['Trekking'] == "0"){
                        echo '<form action="..\startnu.php?groepid='.$groepid.'&start=later" method="POST">
                                <div class="names">
                                    <div class="flex-area">
                                        <button class="add-participant-button" name="submit">Trekking starten</button>
                                    </div>
                                </div>
                            </form>';
                    } 
                    else if($row["Compleet"] === "nee" && $row['Trekking'] == "0"){
                        echo '<form action="/sinterklaaslootjes/includes/add.php?groepid=' . $groepid . '" method="POST">
                                <div class="names">
                                    <div class="flex-area">
                                        <input class="new-input" type="text" name="nieuwlid" placeholder="Voeg nog een deelnemer toe">
                                        <button class="add-participant-button" type="submit" name="add">Voeg deelnemer toe</button>
                                    </div>
                                </div>
                            </form>';
                        echo '<form action="../includes/complete.php?id=' . $groepid . '" method="POST">
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

                $sql = "SELECT DeelnemerID, DeelnemersNaam, Email FROM Deelnemer WHERE GroepID=?";
                $stmt = mysqli_stmt_init($conn);
                if(!mysqli_stmt_prepare($stmt, $sql)) {
                    header("Location ".$_SERVER['HTTP_REFERER']."?error=nodeelnemers");
                    exit();
                }
                else {
                    mysqli_stmt_bind_param($stmt, "i", $groepid);
                    mysqli_stmt_execute($stmt);
                    $result = mysqli_stmt_get_result($stmt);
                    echo '<table>
                            <tr>
                                <th>Deelnemers</th>
                                <th>Email</th>
                                <th><i class="far fa-trash-alt"></i></th>
                            </tr>';

                    $counter = 0;
                    while($row = mysqli_fetch_assoc($result)){
                    echo '<tr id="tabs'.$counter.'">
                            <td class="firsttab">' . $row['DeelnemersNaam'].'</td>



                            <td class="secondtab">
                                <label>'.$row['Email'].'</label>
                                <form action="../includes/update.php?deelnemerid='.$row['DeelnemerID'].'&groepid='.$groepid.'" method="POST">
                                    <input type="text" name="updatemail"></input>
                                    <button class="uitlog-button-link" name="add" type="submit">Save</button>
                                </form>
                                <a class="uitlog-button-link">Edit</a>
                            </td>
                            
                            
                            
                            
                            <td class="thirdtab"><a class="signuperror" href="../includes/delete.php?id=' . $row['DeelnemerID'] . '&groepid='.$groepid.'"><i class="far fa-trash-alt"></i></a></td>
                        </tr>';

                        
                        $counter = $counter + 1;
                    }
                        
                    ?>

                    <script>
                    function init() {
                        var counter = <?php echo $counter ?>;
                        for (var i = 0; i < counter; i++) {
                            // Get all the edit buttons
                            var tablinks = document.getElementById("tabs"+[i]).getElementsByTagName("a");
                            tablinks[0].onclick = doit;
                        }
                    }
                    function doit() {
                        var containsClass = this.parentNode.classList.toggle("edit");

                        if(containsClass) {
                            this.parentNode.querySelector("input").value = this.parentNode.querySelector("label").innerText;
                        }
                        else {
                            this.parentNode.querySelector("label").innerText = this.parentNode.querySelector("input").value;
                        }
                    }
                    window.onload = init;

                    </script>


                    <?php

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