<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sinterklaas lootjes</title>
    <link rel="stylesheet" type="text/css" href="/sinterklaaslootjes/styling/style.css">
    <link rel="stylesheet" href="/sinterklaaslootjes/styling/css/all.css">
</head>
<body>

<header>
    <nav>
        <div class="navigation">
            <div class="left-nav">
                <a href="/sinterklaaslootjes/index.php"><img class="img" src="/sinterklaaslootjes/img/present.png" alt="cadeau"></a>
            </div>
            <div class="right-nav">
                <?php
                    if(isset($_SESSION['userId'])){
                        echo '<form action="/sinterklaaslootjes/includes/logout.php">
                            <a href="/sinterklaaslootjes/user/index.php">'.$_SESSION['userUsername'].'</a>
                            <button type="submit" name="logout" class="uitlog-button-link">Uitloggen</button>
                            </form>';
                    }
                    else {
                        echo '<a href="/sinterklaaslootjes/login/login.php">Inloggen</a>';
                    }
                ?>
            </div>
        </div>
    </nav>
</header>