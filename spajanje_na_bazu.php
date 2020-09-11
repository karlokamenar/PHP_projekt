<?php
$servername = "localhost";
        $username = "karlo";
        $password = "";
        $db = "baza_funkcije";

        $conn = new mysqli($servername, $username, $password, $db);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        //echo "Uspiješno spojeno na bazu.\n";
        ?>