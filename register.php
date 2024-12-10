<?php
session_start(); // Nachinaem sessiyu
require_once 'auth_functions.php'; // Podklyuchayem funktsii dlya avtorizatsii

if ($_SERVER['REQUEST_METHOD'] === 'POST') { // Proverka, chto zapros POST
    // Validatsiya vkhodnykh dannykh
    $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING); // Otsenziruem imya
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL); // Otsenziruem email
    $password = $_POST['password']; // Parol
    $confirmPassword = $_POST['confirm_password']; // Podtverzhdenie parolya
    
    // Validatsiya dannykh
    $errors = [];
    if (empty($name)) $errors[] = 'Name is required'; // Oshuushchestvlyaem proverku na pustoje pole
    if (empty($email)) $errors[] = 'Email is required';
    if (empty($password)) $errors[] = 'Password is required';
    if ($password !== $confirmPassword) $errors[] = 'Passwords do not match'; // Proverka na soootvetstvie parolya
    
    if (empty($errors)) { // Esli oshibok net
        // Popytka zaregistrirovat' pol'zovatelya
        $result = registerUser($name, $email, $password);
        
        if ($result['success']) { // Esli registratsiya uspekhnaya
            // Avtomaticheskaya avtorizatsiya posle uspekhnoy registratsii
            $loginResult = loginUser($email, $password);
            
            if ($loginResult['success']) { // Esli login uspekhen
                // Sokranyaem dannye pol'zovatelya v sessii
                $_SESSION['user'] = $loginResult['user'];
                
                // Perehod na dashbord
                header('Location: dashboard.php');
                exit();
            } else { // Esli login ne udelalsya
                $_SESSION['error'] = 'Registration successful, but login failed. Please log in manually.'; // Uvedomlenie ob oshibke
                header('Location: index.php?tab=login');
                exit();
            }
        } else { // Esli registratsiya ne uspekha
            $_SESSION['error'] = $result['message']; // Ukazanie oshibki
            header('Location: index.php?tab=register');
            exit();
        }
    } else { // Esli est' oshibki
        // Sohranyaem oshibki v sessii i perekhodim
        $_SESSION['error'] = implode('<br>', $errors);
        header('Location: index.php?tab=register');
        exit();
    }
}
