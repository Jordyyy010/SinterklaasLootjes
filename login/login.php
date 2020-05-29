<?php 
    require "../header.php";
?>

<div class="justify-content">
    <div class="container">
        <form action="../includes/login.php" method="POST">
            <div class="system">
                <h1 class="card-header-centered">Inloggen</h1>
                <input type="text" name="mailuid" placeholder="Gebruikersnaam/E-mail...">
                <input type="password" name="pwd" placeholder="Wachtwoord...">
                <button type="submit" name="login">Login</button>
            </div>
        </form>
    </div>
</div>

<?php 
    require "../footer.php";
?>