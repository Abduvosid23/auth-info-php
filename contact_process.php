<?php
session_start(); // Nachinaem sessiyu

if ($_SERVER['REQUEST_METHOD'] === 'POST') { // Proverka, esli zapros tipa POST
    // Sanitarizaciya i proverka vkhodyashchikh dannix
    $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING); 
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL); // Sanitarizaciya 
    $message = filter_input(INPUT_POST, 'message', FILTER_SANITIZE_STRING); 
    $option = filter_input(INPUT_POST, 'option', FILTER_SANITIZE_STRING); 
    $agree = isset($_POST['agree']) ? true : false; // Proverka, odobril li polzovatel usloviya
    $category = filter_input(INPUT_POST, 'category', FILTER_SANITIZE_STRING); 

    $errors = []; // Massiv dlya oshibok

    // Proverka, esli odno iz polei pusto
    if (empty($name)) $errors[] = 'Name is required'; // Esli net imeni
    if (empty($email)) $errors[] = 'Email is required'; // Esli net emaila
    if (empty($message)) $errors[] = 'Message is required'; // Esli net soobshheniya
    if (!$agree) $errors[] = 'You must agree to the terms'; // Esli ne odobreno soglashenije

    if (empty($errors)) { // Esli net oshibok
        // Obrabotka formy (naprimer, sohranenie v baze dannykh, otpravka pis'ma)
        // Dlya demonstracii my prosto soxranim dannye v sessii
        $_SESSION['contact'] = [
            'name' => $name,
            'email' => $email,
            'message' => $message,
            'option' => $option,
            'category' => $category,
        ];

        $_SESSION['success'] = 'Your message has been sent successfully!'; // Soobshhenie o uspeshnom otpravlenii
        header('Location: dashboard.php'); // Perehod na dashboard
        exit(); // Zakonchit rabotu skripta
    } else { // Esli est' oshibki
        $_SESSION['error'] = implode('<br>', $errors); // Soedinyaem vse oshibki v odno soobshhenie
        header('Location: dashboard.php'); // Perehod na dashboard
        exit(); // Zakonchit rabotu skripta
    }
}
?>
