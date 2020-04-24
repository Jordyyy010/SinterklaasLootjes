<?php

require_once('conn.php');

$uitsluiting = $_GET['uitsluiting'];

if($uitsluiting == "set") {
    // document.getElementById('uitsluiting').style.display = inline;
    echo "de div wordt nu open geklapt";
} else {
    // Laat de uitsluitingen div gesloten
    echo "de div blijft ingeklapt";
}

$conn->close();