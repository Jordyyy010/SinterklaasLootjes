<?php

require_once('conn.php');

$sql = "SELECT DeelnemerDetails.DetailsId, Deelnemers.DeelnemersNaam, Oprichter.OprichtersNaam FROM DeelnemerDetails INNER JOIN Deelnemers ON DeelnemerDetails.DeelnemerId = Deelnemers.DeelnemerId INNER JOIN Oprichter ON DeelnemerDetails.OprichterId = Oprichter.OprichterId";
$result = $conn->query($sql);


if ($result->num_rows > 0) {
    // output data of each row
    echo "<ul>";
    while($row = $result->fetch_assoc()) {
        echo "<li>".$row["DeelnemersNaam"].$row["OprichtersNaam"]."</li>";
    }
    echo "</ul>";
} else {
    echo "0 results";
}

$conn->close();