<?php
session_start(); // Nachinaem sessiyu

require_once 'auth_functions.php'; // Podklyuchayem funktsii dlya avtorizatsii

if ($_SERVER['REQUEST_METHOD'] === 'POST') { // Esli zapros POST
    // Validatsiya vvedennykh dannykh
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL); // Otrezayem vse ne nuzhnye simvoly v email
    $password = $_POST['password']; // Parol'

    // Proverka, chto vse pole zapolneno
    if (empty($email) || empty($password)) { // Esli odno iz poley pusto
        $_SESSION['error'] = 'Email and password are required'; // Sohranenie oshibki
        header('Location: index.php?tab=login'); // Perehod na stranitsu login
        exit(); // Zavershenie skrypta
    }

    // Popytka avtorizatsii
    $result = loginUser($email, $password); // Vyzyvayem funktsiyu dlya avtorizatsii

    if ($result['success']) { // Esli avtorizatsiya udalas'
        $_SESSION['user'] = $result['user']; // Sohranenie dannykh pol'zovatelya v sessii
        header('Location: dashboard.php'); // Perehod na dashbord
        exit(); // Zavershenie skrypta
    } else { // Esli avtorizatsiya ne udalas'
        $_SESSION['error'] = $result['message']; // Sohranenie soobshcheniya ob oshibke
        header('Location: index.php?tab=login'); // Perehod nazad na login stranitsu
        exit(); // Zavershenie skrypta
    }
}
?>
