<?php 
    require "../header.php";
?>

<div class="justify-content">
    <div class="container">
        <?php
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
                header("Location: index.php");
            }
        ?>
        <form action="../includes/signup.php" method="POST">
            <h1>Registreren</h1>
            <input type="text" name="uid" placeholder="Gebruikersnaam..">
            <input type="text" name="mail" placeholder="E-mail..">
            <input type="password" name="pwd" placeholder="Wachtwoord..">
            <input type="password" name="pwdrepeat" placeholder="Herhaal wachtwoord..">
            <button type="submit" name="signup">Registreren</button>
        </form>
    </div>
</div>

<?php 
    require "../footer.php";
?>