<?php
// Haal de ingevoerde inputs op
// Randomize personen over het aantal deelgenomen personen
// Er moet geen limiet aan personen zijn
// De datum moet meegegeven worden in de mail die iedereen toegestuurd krijgt
// Er moet een aantal dagen aangegeven kunnen worden tot aan de datum van de viering
// zodat de mail met mail verzonden word



$max = 5;    

if(isset($_POST)){
    $numbers = range(1, $max);
    shuffle($numbers);
    $number = print_r($numbers);
    echo "<br>".$number;
    for ($i=1; $i < 6; $i++){
        $name = $_POST["name".$i];
        $email = $_POST["email".$i];
        echo "Your name  is ".$name." and your e-mail is ".$email;
        echo $name.$number."<br>";
    }
    $newName = $_POST["name".$number];
    $newEmail = $_POST["email".$number];
    echo $newName.$newEmail;
}

// $random = mt_rand(1, 5);
// $array = [1, 2, 3, 4, 5];
// for ($i=1; $i < 6; $i++) { 
//     if($random = $array){

//         $newResult = mt_rand(1, 5);
//         echo $newResult;
//     }
// }


