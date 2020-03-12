<?php
// Haal de ingevoerde inputs op
// Randomize personen over het aantal deelgenomen personen
// Er moet geen limiet aan personen zijn
// De datum moet meegegeven worden in de mail die iedereen toegestuurd krijgt
// Er moet een aantal dagen aangegeven kunnen worden tot aan de datum van de viering
// zodat de mail met mail verzonden word



    

if(isset($_POST)){
    for ($i=1; $i < 6; $i++){
        $name = $_POST["name".$i];
        $email = $_POST["email".$i];
        $random = mt_rand(1, 5);
        echo $random;        
        echo "Your name  is ".$name." and your e-mail is ".$email."<br>";
    }
}

// $random = mt_rand(1, 5);
// $array = [1, 2, 3, 4, 5];
// for ($i=1; $i < 6; $i++) { 
//     if($random = $array){

//         $newResult = mt_rand(1, 5);
//         echo $newResult;
//     }
// }

// $max = 5;
// $done = false;
// while(!$done){
//     $numbers = range(0, $max);
//     shuffle($numbers);
//     $done = true;
//     foreach($numbers as $key => $val){
//         if($key == $val){
//             $done = false;
//             break;
//         }
//     }
// }
