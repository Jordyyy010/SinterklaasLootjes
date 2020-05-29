<?php

$beheerdersql = "SELECT BeheerderId FROM Beheerder WHERE BeheerdersNaam=?";
$resultstmt = $conn->query($sql);
if($resultstmt->num_rows > 0){
    $secondId = $resultstmt->fetch_assoc();
    echo $secondId['BeheerderId'];
}