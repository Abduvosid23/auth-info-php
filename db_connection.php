<?php

define('DB_HOST', 'localhost'); // Opredelyaem adres servera baz dannykh
define('DB_USER', 'root'); // Opredelyaem imya pol'zovatelya dlya podklyucheniya k baze dannykh
define('DB_PASS', ''); // Opredelyaem parol' dlya pol'zovatelya
define('DB_NAME', 'auth-info'); // Opredelyaem imya bazy dannykh

function connectDatabase() {
    // Sozdanie podklyucheniya k baze dannykh
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    
    // Proverka na oshibku pri podklyuchenii k baze
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error); // Soobshchenie ob oshibke
    }
    
    return $conn; // Vozvrashaem objekt soedinenia
}
