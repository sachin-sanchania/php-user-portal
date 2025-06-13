<?php
require_once __DIR__ . '/auth_check.php';
require_once __DIR__ . '/models/User.php';

$user = User::find($_SESSION['user_id']);
$profileImage = $user['profile_image'] ?? 'user.png';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="./assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="./assets/css/style.css" rel="stylesheet">
</head>
<body>

<div class="container">
    <div class="card text-center bg-white profile-card p-4">
        <div class="card-body">
            <div class="d-flex justify-content-center">
                <img src="uploads/<?= htmlspecialchars($profileImage) ?>" alt="Profile" class="profile-img shadow">
            </div>
            <h3 class="mt-3"><?= htmlspecialchars($user['name']) ?></h3>
            <p class="text-muted mb-4"><?= htmlspecialchars($user['email']) ?></p>
            <a href="logout.php" class="btn btn-danger logout-btn">Logout</a>
        </div>
    </div>
</div>

</body>
</html>
