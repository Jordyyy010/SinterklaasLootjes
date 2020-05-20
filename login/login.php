<?php 
    require "../extends/loginheader.php";
?>

<div class="header">
    <form action="../includes/login.php" method="POST">
        <input type="text" name="mailuid" placeholder="Gebruikersnaam/E-mail...">
        <input type="password" name="pwd" placeholder="Wachtwoord...">
        <button type="submit" name="login">Login</button>
    </form>
</div>

<?php 
    require "../extends/footer.php";
?>