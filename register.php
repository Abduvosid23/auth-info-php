<?php
session_start();
require_once 'auth_functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate input
    $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm_password'];
    
    // Validate inputs
    $errors = [];
    if (empty($name)) $errors[] = 'Name is required';
    if (empty($email)) $errors[] = 'Email is required';
    if (empty($password)) $errors[] = 'Password is required';
    if ($password !== $confirmPassword) $errors[] = 'Passwords do not match';
    

    
    if (empty($errors)) {
        // Attempt registration
        $result = registerUser($name, $email, $password);
        
        if ($result['success']) {
            // Automatically log in the user after successful registration
            $loginResult = loginUser($email, $password);
            
            if ($loginResult['success']) {
                // Store user info in session
                $_SESSION['user'] = $loginResult['user'];
                
                // Redirect to dashboard
                header('Location: dashboard.php');
                exit();
            } else {
                // Fallback if login fails after registration
                $_SESSION['error'] = 'Registration successful, but login failed. Please log in manually.';
                header('Location: index.php?tab=login');
                exit();
            }
        } else {
            $_SESSION['error'] = $result['message'];
            header('Location: index.php?tab=register');
            exit();
        }
    } else {
        // Store errors in session and redirect
        $_SESSION['error'] = implode('<br>', $errors);
        header('Location: index.php?tab=register');
        exit();
    }
}