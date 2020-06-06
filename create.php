<?php
    require "header.php";
?>

    <div class="justify-content">
        <div class="container">
            <h1 class="card-header">
                Lootjes trekken 
            </h1>
            <p class="card-body">
                Super snel lootjes trekken met E-mail of WhatsApp<br>
            </p>
            <p>
                <strong>Heb je al eens lootjes getrokken?</strong><br>
                Gebruik je <a class="links" href="#">groep van 2019</a> zodat niemand 
                hetzelfde lootje trekt als vorig jaar.
            </p>
            <div>
                <form action="includes/submit.php" method="POST">
                    <div class="content-area">
                        <div id="first-section">
                            <a class="links" href="#"><i class="fa fa-home">1</i>Namen invullen</a>
                            <?php
                                if(isset($_SESSION['userId'])){
                                    echo '<div class="names">
                                            <div class="flex-area">
                                                <strong>Jouw naam</strong>
                                            </div>
                                            <input type="text" name="admin" value="'.$_SESSION['userUsername'].'">';
                                }
                                else {
                                    if(isset($_GET['error'])){
                                        if($_GET['error'] == "emptyfields"){
                                            echo '<p class="signuperror">Vul alles in!</p>';
                                        }
                                        else if($_GET['error'] == "invalidmailuid"){
                                            echo '<p class="signuperror">Ongeldige e-mail en gebruikersnaam!</p>';
                                        }
                                        else if($_GET['error'] == "invalidmail"){
                                            echo '<p class="signuperror">Ongeldige e-mail!</p>';
                                        }
                                        else if($_GET['error'] == "invaliduid"){
                                            echo '<p class="signuperror">Ongeldige gebruikersnaam!</p>';
                                        }
                                        else if($_GET['error'] == "passwordcheck"){
                                            echo '<p class="signuperror">De wachtwoorden komen niet overeen!</p>';
                                        }
                                        else if($_GET['error'] == "usertaken"){
                                            echo '<p class="signuperror">Deze gebruikersnaam is al in gebruik!</p>';
                                        }
                                    }
                                    if(isset($_POST['submit']) && !isset($_GET['error'])){
                                        header("Location: ". $_SERVER['HTTP_REFERER']);
                                    }

                                    echo '<div class="names">
                                            <div class="flex-area">
                                                <strong>Account aanmaken</strong><small>*</small>
                                            </div>
                                            <input type="text" name="uid" placeholder="Gebruikersnaam..">
                                            <input type="text" name="mail" placeholder="E-mail..">
                                            <input type="password" name="pwd" placeholder="Wachtwoord..">
                                            <input type="password" name="pwdrepeat" placeholder="Herhaal wachtwoord..">
                                        </div>';
                                }
                            
                            ?>
                            <div class="names" id="participants">
                                <div class="flex-area">
                                    <strong>Lootjes trekken met</strong><small>*</small>
                                </div>
                                <input type="text" name="name2" placeholder="Vul deelnemer 2 in" required>
                                <input type="text" name="name3" placeholder="Vul deelnemer 3 in" required>
                            </div>
                            <div class="names">
                                <div class="flex-area">
                                    <button onclick="addNames()" class="button-links">Meer namen invullen</button>
                                </div>
                            </div>
                            <script type="text/javascript">
                                var deelnemers = document.getElementById("participants");
                                createCookie("counter", "0", "10");
                                var clicks = 0;

                                // Update clicks by 1
                                // Create new HTML code
                                // Add that new HTML code at the bottom of the parent div
                                function addNames(){
                                    clicks += 1;
                                    var newInput = createNewInput();
                                    createCookie("counter", clicks, "10");
                                }

                                // Create each element for the new input field
                                // Set all the attributes
                                // Sort all the elements with each parent
                                function createNewInput(){
                                    var input = document.createElement("input");
                                    var currentUser = 3 + clicks;

                                    input.type = "text";
                                    input.name = "name" + currentUser;
                                    input.placeholder = "Vul deelnemer " + currentUser + " in";

                                    deelnemers.appendChild(input);
                                    return deelnemers;
                                }

                                // Function to create the cookie
                                function createCookie(name, value, days) {
                                    var expires;

                                    if (days) {
                                            var date = new Date();
                                            date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
                                            expires = "; expires=" + date.toGMTString();
                                        }
                                        else {
                                            expires = "";
                                        }
                                        document.cookie = escape(name) + "=" + escape(value) + expires + ";path=/";
                                }
                            </script>
                            <div class="names">
                                <strong>Is de groep compleet?</strong>
                                <div class="flex-area">
                                    <input type="radio" name="compleet" value="ja" required><b>Ja,</b> alle namen zijn ingevuld en iedereen doet zeker mee
                                </div>
                                <div class="flex-area">
                                    <input type="radio" name="compleet" value="nee" required><b>Nee,</b> later meer namen invullen of namen verwijderen
                                </div>
                            </div>
                        </div>
                    </div><br>

    

                    
                    <div id="third-section" class="content-area">
                        <a class="links" href="#"><i class="fa fa-home">2</i>Details viering instellen</a>
                            <div class="names">
                            <div class="flex-area">
                                <strong>Groepsnaam</strong><small>*</small>
                            </div>
                            <input type="text" name="groepsnaam" placeholder="Vul een titel in voor deze viering" required>
                        </div>
                        <div class="names">
                            <div class="flex-area">
                                <strong>Datum viering</strong><small>*</small>
                            </div>
                            <input type="date" name="date" placeholder="Kies een datum" required>
                        </div>
                        <div class="names">
                            <div class="flex-area">
                                <strong>Datum trekking</strong><small>*</small>
                            </div>
                            <input type="number" min="1" name="trekking" placeholder="Kies het aantal dagen voor de trekking" required>
                        </div>
                        <div class="names">
                            <div class="flex-area">
                                <strong>Postadres</strong><small>*</small>
                            </div>
                            <input type="text" name="zip" placeholder="Voer de postcode in waar de viering plaats zal vinden">
                        </div>
                        <div class="names">
                            <div class="flex-area">
                                <strong>Cadeaubedrag</strong><small>- optioneel</small>
                            </div>
                            <input type="text" name="bedrag" placeholder="Vul het cadeaubedrag in, bijv: 0 25 of 50">
                        </div>
                        <div class="names">
                            <div class="flex-area">
                                <strong>Jouw e-mail</strong>
                            </div>
                            <input type="text" name="mailadmin" placeholder="Vul hier uw email in" required>
                        </div>
                        <div class="names">
                            <div class="flex-area">
                                <strong>Bericht</strong>
                            </div>
                            <textarea name="bericht" placeholder="Schrijf een bericht"></textarea>
                        </div>
                        <div class="names">
                            <div class="flex-area">
                                <strong>Lootjes trekken</strong>
                            </div>
                            <p>De lootjes worden <b>direct getrokken.</b> Hierna kun 
                            je de uitsluitingen niet meer wijzigen. Bevestig de groep
                            en kies daarna hoe je de lootjes wilt versturen.</p>
                        </div>
                        <input type="submit" name="submit" value="Bevestigen" class="button-links">
                    </div>
                </div>
            </form>
        </div>
    </div>




    <!-- <a class="links" href="#"><i class="fa fa-home">2</i>Uitsluitingen opgeven</a>
                    <div id="second-section" class="content-area">
                        <form action="php/get-value.php" method="GET">
                            <div class="names">
                                <p>Met uitsluitingen bepaal je wie welke naam <b>niet</b> mag trekken.</p>
                                <div class="flex-area">
                                    <input type="radio" id="uitsluiting" name="uitsluiting" value="none" required><b>Geen</b> uitsluiting gebruiken
                                </div>
                                <div class="flex-area">
                                    <input type="radio" id="uitsluiting" name="uitsluiting" value="set" required>Uitsluitingen opgeven
                                </div>
                            </div>
                            <script>
                                var uitsluiting = document.getElementById("uitsluiting").value;
                                console.log(uitsluiting);
                                if(var uitsluiting == "set") {
                                    document.getElementById('active').style.display = inline;
                                } else {
                                    document.getElementById('active').style.display = none;
                                }
                            </script>
                            <div id="active">
                                <div class="names">
                                    <strong>Naam deelnemer 1</strong>
                                    <select id="deelnemers">
                                        <option value="Deelnemer1">Deelnemer 2</option>
                                        <option value="Deelnemer1">Deelnemer 3</option>
                                        <option value="Deelnemer1">Deelnemer 4</option>
                                        <option value="Deelnemer1">Deelnemer 5</option>
                                    </select>
                                </div>
                                <div class="names">
                                    <strong>Naam deelnemer 2</strong>
                                    <select id="deelnemers">
                                        <option value="Deelnemer1">Deelnemer 1</option>
                                        <option value="Deelnemer1">Deelnemer 3</option>
                                        <option value="Deelnemer1">Deelnemer 4</option>
                                        <option value="Deelnemer1">Deelnemer 5</option>
                                    </select>
                                </div>
                                <div class="names">
                                    <strong>Naam deelnemer 3</strong>
                                    <select id="deelnemers">
                                        <option value="Deelnemer1">Deelnemer 1</option>
                                        <option value="Deelnemer1">Deelnemer 2</option>
                                        <option value="Deelnemer1">Deelnemer 4</option>
                                        <option value="Deelnemer1">Deelnemer 5</option>
                                    </select>
                                </div>
                                <div class="names">
                                    <strong>Naam deelnemer 4</strong>
                                    <select id="deelnemers">
                                        <option value="Deelnemer1">Deelnemer 1</option>
                                        <option value="Deelnemer1">Deelnemer 2</option>
                                        <option value="Deelnemer1">Deelnemer 3</option>
                                        <option value="Deelnemer1">Deelnemer 5</option>
                                    </select>
                                </div>
                                <div class="names">
                                    <strong>Naam deelnemer 5</strong>
                                    <select id="deelnemers">
                                        <option value="Deelnemer1">Deelnemer 1</option>
                                        <option value="Deelnemer1">Deelnemer 2</option>
                                        <option value="Deelnemer1">Deelnemer 3</option>
                                        <option value="Deelnemer1">Deelnemer 4</option>
                                    </select>
                                </div>
                            </div>
                            <input type="submit" value="Volgende stap" class="next">
                        </form>
                    </div> -->




<?php
    require "footer.php";
?>