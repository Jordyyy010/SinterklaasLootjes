<?php 
    require "../extends/signupheader.php";
?>

<div class="header">
    <form action="../includes/signup.php" method="POST">
        <h1>Registreren</h1>
        <input type="text" name="uid" placeholder="Gebruikersnaam..">
        <input type="text" name="mail" placeholder="E-mail..">
        <input type="password" name="pwd" placeholder="Wachtwoord..">
        <input type="password" name="pwdrepeat" placeholder="Herhaal wachtwoord..">
        <button type="submit" name="signup">Registreren</button>
    </form>
</div>

<?php 
    require "../extends/footer.php";
?>