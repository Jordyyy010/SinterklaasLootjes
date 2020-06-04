<?php
    require "../header.php";
?>


<div class="justify-content">
    <div class="container">
        <?php
            if(isset($_SESSION['userId'])){
                echo '<h1 class="card-header-centered">Groep overzicht'.$_SESSION["userUsername"].'</h1>';
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