<?php
session_start();
require_once 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') { 
    $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $source = filter_input(INPUT_POST, 'source', FILTER_SANITIZE_STRING);
    $experience = filter_input(INPUT_POST, 'experience', FILTER_SANITIZE_STRING);
    $detailed_feedback = filter_input(INPUT_POST, 'detailed_feedback', FILTER_SANITIZE_STRING);
    
    
    $services = isset($_POST['services']) ? implode(', ', array_map('htmlspecialchars', $_POST['services'])) : '';
    
    // Validate the inputs
    $errors = [];
    if (empty($name)) $errors[] = 'Name is required';
    if (empty($email)) $errors[] = 'Email is required';
    if (empty($source)) $errors[] = 'Please select how you heard about us';
    if (empty($experience)) $errors[] = 'Please select your experience level';
    
    if (empty($errors)) { // If there are no errors
        // Connect to the database
        $conn = connectDatabase();
        
        // Prepare SQL query to insert the feedback into the database
        $stmt = $conn->prepare("INSERT INTO feedback (name, email, source, services, experience, detailed_feedback) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $name, $email, $source, $services, $experience, $detailed_feedback);
        
        if ($stmt->execute()) { // Execute the query
            $_SESSION['success'] = 'Feedback submitted successfully!'; // Success message
            header('Location: dashboard.php'); // Redirect to dashboard
        } else {
            $_SESSION['error'] = 'Failed to submit feedback. Please try again.'; // Error message
            header('Location: dashboard.php');
        }
        
        $stmt->close(); // Close the prepared statement
        $conn->close(); // Close the database connection
    } else {
        // If there are validation errors, store them in the session
        $_SESSION['errors'] = $errors;
        header('Location: dashboard.php');
    }
    
    exit(); // Exit to avoid further execution
} else {
    // Redirect if this page is accessed directly
    header('Location: dashboard.php');
    exit();
}
