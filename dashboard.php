<?php
session_start();

// // Check if user is logged in
// if (!isset($_SESSION['user'])) {
//     // Redirect to login if not logged in
//     header('Location: index.php');
//     exit();
// }

// Get user information from session
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
                <a href="logout.php" class="btn btn-light">Logout</a>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h4>User Profile</h4>
                        <p><strong>Name:</strong> <?= htmlspecialchars($user['name']) ?></p>
                        <p><strong>Email:</strong> <?= htmlspecialchars($user['email']) ?></p>
                    </div>
                    <div class="col-md-6">
                        <h4>Quick Actions</h4>
                        <div class="list-group">
                            <a href="#" class="list-group-item list-group-item-action">
                                Edit Profile
                            </a>
                            <a href="#" class="list-group-item list-group-item-action">
                                Change Password
                            </a>
                            <a href="#" class="list-group-item list-group-item-action">
                                View Notifications
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>