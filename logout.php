<?php
session_start(); // Nachinaem sessiyu
session_destroy(); // Udalyaem vse dannye sessii
header('Location: index.php'); // Perehodim na stranitsu logina
exit(); // Zavershayem skrypt
