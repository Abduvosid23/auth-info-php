<?php
session_start();
require_once 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize inputs
    $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $source = filter_input(INPUT_POST, 'source', FILTER_SANITIZE_STRING);
    $experience = filter_input(INPUT_POST, 'experience', FILTER_SANITIZE_STRING);
    $detailed_feedback = filter_input(INPUT_POST, 'detailed_feedback', FILTER_SANITIZE_STRING);
    
    // Process services checkbox array
    $services = isset($_POST['services']) ? implode(', ', array_map('htmlspecialchars', $_POST['services'])) : '';
    
    // Validate inputs
    $errors = [];
    if (empty($name)) $errors[] = 'Name is required';
    if (empty($email)) $errors[] = 'Email is required';
    if (empty($source)) $errors[] = 'Please select how you heard about us';
    if (empty($experience)) $errors[] = 'Please select your experience level';
    
    if (empty($errors)) {
        // Connect to database
        $conn = connectDatabase();
        
        // Prepare SQL statement
        $stmt = $conn->prepare("INSERT INTO feedback (name, email, source, services, experience, detailed_feedback) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $name, $email, $source, $services, $experience, $detailed_feedback);
        
        if ($stmt->execute()) {
            $_SESSION['success'] = 'Feedback submitted successfully!';
            header('Location: dashboard.php');
        } else {
            $_SESSION['error'] = 'Failed to submit feedback. Please try again.';
            header('Location: dashboard.php');
        }
        
        $stmt->close();
        $conn->close();
    } else {
        // Store errors in session and redirect
        $_SESSION['errors'] = $errors;
        header('Location: dashboard.php');
    }
    
    exit();
} else {
    // Redirect if accessed directly
    header('Location: dashboard.php');
    exit();
}