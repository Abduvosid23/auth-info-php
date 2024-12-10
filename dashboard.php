<?php
session_start(); // Nachinaem sessiyu

// Proverka, est' li pol'zovatel' v sessii (avtorizaciya)
if (!isset($_SESSION['user'])) { 
    // Perehod k stranitse vkhoda, esli ne avtorizovany
    header('Location: index.php');
    exit();
}

// Polucheniye dannykh o pol'zovatele iz sessii
$user = $_SESSION['user']; 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="card">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h2>Welcome to Dashboard</h2>
                <a href="logout.php" class="btn btn-light">Logout</a> <!-- Knopka dlya vykhoda -->
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h4>User Profile</h4>
                        <p><strong>Name:</strong> <?= htmlspecialchars($user['name']) ?></p> <!-- Imya pol'zovatelya -->
                        <p><strong>Email:</strong> <?= htmlspecialchars($user['email']) ?></p> <!-- Email pol'zovatelya -->
                    </div>
                    <div class="col-md-6">
                        <h4>Quick Actions</h4>
                        <div class="list-group">
                            <a href="#" class="list-group-item list-group-item-action">Edit Profile</a> <!-- Ssilka na redaktirovanie profilya -->
                            <a href="#" class="list-group-item list-group-item-action">Change Password</a> <!-- Ssilka na izmenenie parolya -->
                            <a href="#" class="list-group-item list-group-item-action">View Notifications</a> <!-- Ssilka na prosmotr opoveshcheniy -->
                        </div>
                    </div>
                </div>

                <!-- Forma obratnoy svyazi -->
                <div class="mt-5">
                    <h3>Contact Us</h3> <!-- Заголовок формы обратной связи -->
                    <form action="contact_process.php" method="POST"> <!-- Otpravka dannykh na contact_process.php -->
                        <div class="mb-3">
                            <label for="name" class="form-label">Full Name</label>
                            <input type="text" class="form-control" id="name" name="name" required> <!-- Pole dlya imeni -->
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email Address</label>
                            <input type="email" class="form-control" id="email" name="email" required> <!-- Pole dlya emaila -->
                        </div>
                        <div class="mb-3">
                            <label for="message" class="form-label">Message</label>
                            <textarea class="form-control" id="message" name="message" rows="4" required></textarea> <!-- Pole dlya soobshcheniya -->
                        </div>
                        <div class="mb-3">
                            <label for="category" class="form-label">Category</label>
                            <select class="form-select" id="category" name="category" required> <!-- Spisok dlya kategorii -->
                                <option value="general">General Inquiry</option>
                                <option value="support">Support</option>
                                <option value="feedback">Feedback</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-check-label">Choose an option</label><br> <!-- Tekst dlya radio knopok -->
                            <input type="radio" id="option1" name="option" value="option1"> Option 1<br> <!-- Radio knopka 1 -->
                            <input type="radio" id="option2" name="option" value="option2"> Option 2<br> <!-- Radio knopka 2 -->
                        </div>
                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="agree" name="agree">
                            <label class="form-check-label" for="agree">I agree to the terms and conditions</label> <!-- Fiazhok dlya soglasheniya -->
                        </div>
                        <div class="d-flex justify-content-between">
                            <button type="reset" class="btn btn-secondary">Reset</button> <!-- Knopka dlya sbrosa -->
                            <button type="submit" class="btn btn-primary">Submit</button> <!-- Knopka otpravki -->
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script> <!-- Bootstrap JS -->
</body>
</html>
