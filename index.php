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
</head>
<body>
    <div class="justify-content">
        <div class="container">
            <h1 class="card-header">
                Sinterklaas lootjes trekken
            </h1>
            <p class="card-body">
                Zodra de pakjesboot van de Sint in aantocht is weten we het 
                de tijd van de sinterklaas surprises is weer aangebroken. 
                En dat betekent: sinterklaas lootjes trekken, pepernoten bakken, 
                chocoladeletters eten en cadeaus kopen. Meer dan één derde van 
                alle Nederlanders viert sinterklaas door het maken van surprises. 
                Maar veel van hen zien op tegen het sint lootjes trekken. 
                Elk jaar is het weer lastig om een goede datum te prikken voor 
                het sinterklaas lootjes trekken. Dan kan de één niet, dan 
                kan de ander weer niet. En tot grote ergernis van velen trekt 
                vaak iemand een sinterklaas lootje met zijn of haar eigen naam 
                erop of wordt er stiekem op elkaars sinterklaas lootjes gekeken. 
                Daarom is online loodjes trekken voor sinterklaas dé oplossing - 
                Snel, Eerlijk & Makkelijk!
            </p>
            <div>
                <form action="php/submit.php" method="post">
                    <button><strong>Stap 1:</strong> Deelnemers</button>
                    <header><strong>Datum viering:</strong><input type="number" value="5" max="31"><input type="number" value="12" max="12"><input type="number" value="2020" min="2020" max="2021"></header>
                    <div style="display:flex;width:100%;flex-direction:row;">
                        <div style="display:flex;flex-direction:column;">
                            <div>
                                <label for="">Deelnemer 1:</label>
                                <input type="text" name="name0">
                                <label for="">Email:</label>
                                <input type="email" name="email0">
                            </div>
                            <div>
                                <label for="">Deelnemer 2:</label>
                                <input type="text" name="name1">
                                <label for="">Email:</label>
                                <input type="email" name="email1">
                            </div>
                            <div>
                                <label for="">Deelnemer 3:</label>
                                <input type="text" name="name2">
                                <label for="">Email:</label>
                                <input type="email" name="email2">
                            </div>
                            <div>
                                <label for="">Deelnemer 4:</label>
                                <input type="text" name="name3">
                                <label for="">Email:</label>
                                <input type="email" name="email3">
                            </div>
                            <div>
                                <label for="">Deelnemer 5:</label>
                                <input type="text" name="name4">
                                <label for="">Email:</label>
                                <input type="email" name="email4">
                            </div>
                        </div>
                    </div>
                    <button type="submit">Ga naar stap 2</button>
                </form>
            </div>
            <h1 class="card-header">
                Sinterklaas lootjes trekken
            </h1>
            <p>
                SinterklaasLootjes.net voorziet je nu van alle gemakken! Sinterklaas 
                lootjes trekken doe je voortaan online! Nooit meer problemen met het 
                prikken van een datum en niemand trekt een sinterklaas lootje met zijn 
                of haar eigen naam erop. Online sinterklaas lootjes trekken is sneller, 
                makkelijker en ook nog eens eerlijker. Want op elkaars sinterklaas lootjes 
                spieken gaat nu niet meer! Online sinterklaas lootjes trekken is super eenvoudig. 
                Vul de naam en het e-mailadres van alle deelnemers in. Selecteer de 
                datum waarop de surprise avond gehouden wordt. Hierna verstuurt SinterklaasLoodjes.net 
                direct de sinterklaas lootjes naar de deelnemende e-mailadressen. 
                Op deze manier trek je nooit jezelf en je houdt gemakkelijk geheim 
                welke naam er op jouw sinterklaas lootje staat!
            </p>
        </div>
    </div>
</body>
</html>