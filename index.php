<?php

session_start(); // Nachinaem sessiyu

require_once 'auth_functions.php'; // Podklyuchayem funktsii dlya autentifikatsii

// Opredelyaem, kotoruyu vkladku pokazyvat'
$activeTab = isset($_GET['tab']) && $_GET['tab'] === 'register' ? 'register' : 'login';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Authentication Forms</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">

                    <?php if(isset($_SESSION['error'])): ?>
                    <div class="alert alert-danger" role="alert">
                        <?php 
                        echo $_SESSION['error']; 
                        unset($_SESSION['error']); // Ochishchaem soobshchenie ob oshibke
                        ?>
                    </div>
                <?php endif; ?> 
                
                    <?php if(isset($_SESSION['success'])): ?>
                    <div class="alert alert-success" role="alert">
                        <?php 
                        echo $_SESSION['success']; 
                        unset($_SESSION['success']); // Ochishchaem soobshchenie ob uspekhe
                        ?>
                    </div>
                <?php endif; ?>

                <ul class="nav nav-tabs" id="authTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link <?= $activeTab === 'login' ? 'active' : '' ?>" id="login-tab" data-bs-toggle="tab" data-bs-target="#login" type="button" role="tab" aria-controls="login" aria-selected="<?= $activeTab === 'login' ? 'true' : 'false' ?>">Login</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link <?= $activeTab === 'register' ? 'active' : '' ?>" id="register-tab" data-bs-toggle="tab" data-bs-target="#register" type="button" role="tab" aria-controls="register" aria-selected="<?= $activeTab === 'register' ? 'true' : 'false' ?>">Register</button>
                    </li>
                </ul>
                <div class="tab-content" id="authTabsContent">
                    <div class="tab-pane fade <?= $activeTab === 'login' ? 'show active' : '' ?>" id="login" role="tabpanel" aria-labelledby="login-tab">
                        <div class="card">
                            <div class="card-body">
                                <h3 class="card-title text-center mb-4">Login</h3>
                                <form action="login.php" method="POST">
                                    <div class="mb-3">
                                        <label for="loginEmail" class="form-label">Email address</label>
                                        <input type="email" class="form-control" id="loginEmail" name="email" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="loginPassword" class="form-label">Password</label>
                                        <input type="password" class="form-control" id="loginPassword" name="password" required>
                                    </div>
                                    <div class="mb-3 form-check">
                                        <input type="checkbox" class="form-check-input" id="rememberMe">
                                        <label class="form-check-label" for="rememberMe">Remember me</label>
                                    </div>
                                    <div class="d-grid">
                                        <button type="submit" class="btn btn-primary">Login</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade <?= $activeTab === 'register' ? 'show active' : '' ?>" id="register" role="tabpanel" aria-labelledby="register-tab">
                        <div class="card">
                            <div class="card-body">
                                <h3 class="card-title text-center mb-4">Register</h3>
                                <form action="register.php" method="POST">
                                <div class="mb-3">
                                    <label for="registerName" class="form-label">Full Name</label>
                                    <input type="text" class="form-control" id="registerName" name="name" required>
                                </div>
                                <div class="mb-3">
                                    <label for="registerEmail" class="form-label">Email address</label>
                                    <input type="email" class="form-control" id="registerEmail" name="email" required>
                                </div>
                                <div class="mb-3">
                                    <label for="registerPassword" class="form-label">Password</label>
                                    <input type="password" class="form-control" id="registerPassword" name="password" required>
                                </div>
                                <div class="mb-3">
                                    <label for="confirmPassword" class="form-label">Confirm Password</label>
                                    <input type="password" class="form-control" id="confirmPassword" name="confirm_password" required>
                                </div>
                                <div class="d-grid">
                                    <button type="submit" class="btn btn-primary">Register</button>
                                </div>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
