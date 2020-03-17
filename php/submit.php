<?php
// Haal de ingevoerde inputs op
// Randomize personen over het aantal deelgenomen personen
// Er moet geen limiet aan personen zijn
// De datum moet meegegeven worden in de mail die iedereen toegestuurd krijgt
// Er moet een aantal dagen aangegeven kunnen worden tot aan de datum van de viering
// zodat de mail met mail verzonden word


$max = 4;

if(isset($_POST)){
    $numbers = range(0, $max);
    shuffle($numbers);
    for ($i=0; $i <= 4; $i++){
        $name = $_POST["name".$i];
        $email = $_POST["email".$i];
        $random = $_POST["name".$numbers[$i]];
        echo "Your name  is ".$name." and your e-mail is ".$email;
        if($name !== $random){
            echo $random."<br>";
        } else {
            echo "JE HEBT JEZELF GETROKKEN<br>";
            // begin van de if(isset($_POST)){ aanroepen totdat iedereen iemand anders heeft
        }
    }
}


