<?php 

$max = 4;
if(isset($_POST["submit"])){
    $numbers = range(0, $max);
    shuffle($numbers);
    for ($i=0; $i <= 4; $i++){
        $name = $_POST["name".$i];
        $email = $_POST["email".$i];
        $random = $_POST["name".$numbers[$i]];
        echo "Your name  is ".$name." and your e-mail is ".$email;
        if($name !== $random){
            echo "Je hebt ".$random." op je lootje<br>";
        } else {
            echo "JE HEBT JEZELF GETROKKEN<br>";
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sinterklaas</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
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
                <a class="links" href="#"><i class="fa fa-home">1</i>Namen invullen</a>
                <div class="content-area active">
                    <form action="php/insert-names.php" method="GET">
                        <div class="names">
                            <strong>Jouw naam</strong>
                            <div class="flex-area">
                                <input type="text" name="own-name" placeholder="Vul deelnemer 1 in"><button>x</button>
                            </div>
                        </div>
                        <div class="names">
                            <strong>Lootjes trekken met</strong>
                            <div class="flex-area">
                                <input type="text" name="name2" placeholder="Vul deelnemer 2 in"><button>x</button>
                            </div>
                            <div class="flex-area">
                                <input type="text" name="name3" placeholder="Vul deelnemer 3 in"><button>x</button>
                            </div>
                            <div class="flex-area">
                                <input type="text" name="name4" placeholder="Vul deelnemer 4 in"><button>x</button>
                            </div>
                            <div class="flex-area">
                                <input type="text" name="name5" placeholder="Vul deelnemer 5 in"><button>x</button>
                            </div>
                            <div class="flex-area">
                                <input type="text" name="name6" placeholder="Vul deelnemer 6 in"><button>x</button>
                            </div>
                            <a class="links" href="#">Meer namen invullen</a>
                        </div>
                        <div class="names">
                            <strong>Is de groep compleet?</strong>
                            <div class="flex-area">
                                <input type="radio"><a href="#"><b>Ja,</b> alle namen zijn ingevuld en iedereen doet zeker mee</a>
                            </div>
                            <div class="flex-area">
                                <input type="radio"><a href="#"><b>Nee,</b> later meer namen invullen of namen verwijderen</a>
                            </div>
                        </div>
                        <div class="names">
                            <strong>Aantal trekkingen</strong>
                            <div class="flex-area">
                                <input type="radio"><a href="#"><b>Eén,</b> iedereen trekt één lootje</a>
                            </div>
                            <div class="flex-area">
                                <input type="radio"><a href="#"><b>Twee,</b> iedereen trekt twee lootjes</a>
                            </div>
                            <div class="flex-area">
                                <input type="radio"><a href="#"><b>Geen,</b> alleen verlanglijstjes maken</a>
                            </div>
                        </div>
                        <input type="submit" name="submit" value="Volgende stap" class="next">
                    </form>
                </div>



                <a class="links" href="#"><i class="fa fa-home">2</i>Uitsluitingen opgeven</a>
                <div class="content-area active">
                    <form action="#" method="GET">
                        <div class="names">
                            <p>Met uitsluitingen bepaal je wie welke naam <b>niet</b> mag trekken.</p>
                            <div class="flex-area">
                                <input type="radio"><a href="#"><b>Geen</b> uitsluiting gebruiken</a>
                            </div>
                            <div class="flex-area">
                                <input type="radio"><a href="#">Uitsluitingen opgeven</a>
                            </div>
                        </div>
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
                        <input type="submit" value="Volgende stap" class="next">
                    </form>
                </div>



                <a class="links" href="#"><i class="fa fa-home">3</i>Details viering instellen</a>
                <div class="content-area active">
                    <form action="#">
                        <div class="names">
                            <strong>Groepsnaam</strong>
                            <input type="text" placeholder="Vul een titel in voor deze viering">
                        </div>
                        <div class="names">
                            <div class="flex-area">
                                <strong>Datum viering</strong><small>- optioneel</small>
                            </div>
                            <input type="date" placeholder="Kies een datum">
                        </div>
                        <div class="names">
                            <div class="flex-area">
                                <strong>Postadres</strong><small>- optioneel</small>
                            </div>
                            <div class="flex-area">
                                <input type="checkbox"><a href="#">Stuur elkaar cadeaus per post</a>
                            </div>
                        </div>
                        <div class="names">
                            <div class="flex-area">
                                <strong>Cadeaubedrag</strong><small>- optioneel</small>
                            </div>
                            <select id="bedrag">
                                <option value="5.00">€5,00</option>
                                <option value="7.50">€7,50</option>
                                <option value="10.00">€10,00</option>
                                <option value="12.50">€12,50</option>
                                <option value="15.00">€15,00</option>
                                <option value="17.50">€17,50</option>
                                <option value="20.00">€20,00</option>
                                <option value="25.00">€25,00</option>
                                <option value="30.00">€30,00</option>
                                <option value="35.00">€35,00</option>
                                <option value="40.00">€40,00</option>
                                <option value="50.00">€50,00</option>
                                <option value="60.00">€60,00</option>
                                <option value="75.00">€75,00</option>
                                <option value="80.00">€80,00</option>
                                <option value="100.00">€100,00</option>
                                <option value="125.00">€125,00</option>
                                <option value="150.00">€150,00</option>
                                <option value="175.00">€175,00</option>
                                <option value="200.00">€200,00</option>
                                <option value="250.00">€250,00</option>
                                <option value="500.00">€500,00</option>
                            </select>
                        </div>
                        <div class="names">
                            <strong>Jouw e-mail</strong>
                            <input type="text" placeholder="Vul je e-mailadres in">
                        </div>
                        <div class="names">
                            <strong>Bericht</strong>
                            <textarea placeholder="Schrijf een bericht"></textarea>
                        </div>
                        <div class="names">
                            <strong>Lootjes trekken</strong>
                            <p>De lootjes worden <b>direct getrokken.</b> Hierna kun 
                            je de uitsluitingen niet meer wijzigen. Bevestig de groep
                            en kies daarna hoe je de lootjes wilt versturen.</p>
                        </div>
                        <input type="submit" name="submit" value="Bevestigen" class="next">
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>