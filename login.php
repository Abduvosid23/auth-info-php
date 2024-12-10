<?php
session_start();
require_once 'auth_functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate input
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];
    
    // Validate inputs
    if (empty($email) || empty($password)) {
        $_SESSION['error'] = 'Email and password are required';
        header('Location: index.php?tab=login');
        exit();
    }
    
    // Attempt login
    $result = loginUser($email, $password);
    
    if ($result['success']) {
        // Store user info in session
        $_SESSION['user'] = $result['user'];
        
        // Redirect to dashboard
        header('Location: dashboard.php');
        exit();
    } else {
        $_SESSION['error'] = $result['message'];
        header('Location: index.php?tab=login');
        exit();
    }
}