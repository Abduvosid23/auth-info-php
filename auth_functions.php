<?php

require_once 'db_connection.php'; // Podklyuchayem fayl soedinenia s baza dannix

// Funktsiya dlya registrasiya polzovatelya
function registerUser($name, $email, $password) {
    $conn = connectDatabase(); // Soedinyaemsya s baza dannix
    
    // Proverka est li uje polzovatel s takim email
    $checkEmail = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $checkEmail->bind_param("s", $email);
    $checkEmail->execute();
    $result = $checkEmail->get_result();
    
    if ($result->num_rows > 0) { // Esli email uje est
        return ['success' => false, 'message' => 'Email already registered']; // Vozvrashaem soobshenie ob oshibke
    }
    
    // Xeshiruem parol
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    
    // Vstavlyaem novogo polzovatelya v baza dannix
    $stmt = $conn->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $email, $hashedPassword);
    
    if ($stmt->execute()) { 
        return ['success' => true, 'message' => 'Registration successful']; // Registraciya uspeshna
    } else {
        return ['success' => false, 'message' => 'Registration failed']; // Registraciya neudachna
    }
}

// Funktsiya dlya login-a polzovatelya
function loginUser($email, $password) {
    $conn = connectDatabase(); // Soedinyaemsya s baza dannix
    
    // Ispolzuem email dlya poiska polzovatelya
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 0) { // Esli polzovatel ne nayden
        return ['success' => false, 'message' => 'User not found']; // Soobshchaem ob otsutstvii polzovatelya
    }
    
    $user = $result->fetch_assoc(); // Poluchаем dannye polzovatelya
    
    if (!password_verify($password, $user['password'])) { // Proveryaem parol'
        return ['success' => false, 'message' => 'Incorrect password']; // Esli parol' ne sovpadaet
    }
    
    // Esli vse horosho, vozvrashaem dannye pol'zovatelya
    return [
        'success' => true, 
        'message' => 'Login successful', 
        'user' => [
            'id' => $user['id'],
            'name' => $user['name'],
            'email' => $user['email']
        ]
    ];
}
