<?php
    require "../header.php";
?>


<div class="justify-content">
    <div class="container">
        <?php
            if(isset($_SESSION['userId'])){
                echo '<h1 class="card-header-centered">Groep overzicht van '.$_SESSION["userUsername"].'</h1>';

                // Check if there is a groep attached to the user
                // Display as many groups as there are attached
                $sql = "SELECT * FROM";


                // If there are no results of groups
                // Display 'You are not participating to a group'
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