<?php

require_once('conn.php');

$oprichter = $_GET['own-name'];
if (!preg_match("/^[a-zA-Z ]*$/",$oprichter)) {
    echo $oprichter . "Alleen letters en spaties toegestaan<br>";
} else {
    echo $oprichter;
    $sql = "INSERT INTO Oprichter (OprichtersNaam)
    VALUES ('$oprichter')";
    $conn->query($sql);
    echo "Beheerder aangemaakt<br>";
}

for($i = 2; $i < 7; $i++){
    $deelnemer = $_GET["name".$i];
    if (!preg_match("/^[a-zA-Z ]*$/",$deelnemer)) {
        echo $deelnemer . " Alleen letters en spaties toegestaan<br>";
    } else {
        echo $deelnemer;
        $sql = "INSERT INTO Deelnemers (DeelnemersNaam)
        VALUES ('$deelnemer')";
        $conn->query($sql);
        echo " Deelnemer aangemaakt<br>";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lootjes Trekken</title>
</head>
<body>
    <?php
        require_once('conn.php');

        $sql = "SELECT * FROM deelnemerdetails WHERE GroepId = '1'";

        $conn->query($sql);

        foreach($sql as $deelnemer)
            echo "<h1>" . $deelnemer . "</h1><br>";
    ?>
</body>
</html>