<?php
    $host = "localhost"; 
    $user = "root";
    $db = "auto_sportive";
    $pass = "";
    $conn = mysqli_connect($host, $user, $pass, $db); //variabile di connessione
    if (!$conn) {
        die("Connessione al database fallita: " . mysqli_connect_error());
    }
?>