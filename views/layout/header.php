<?php
session_start();
// require_once __DIR__ . '../../config/Database.php';

$user = isset($_SESSION['user']) ? unserialize($_SESSION['user']) : null;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Spotify Clone</title>
    <!-- Add your CSS, meta tags, or any other head content here -->
</head>
<body>
    <nav class="main-nav">
        <div class="nav-left">
            <a href="/">Home</a>
            <?php if ($user): ?>
                <a href="/views/player/home.php">Player</a>
                <?php if ($user->getRole() === 'artist'): ?>
                    <a href="/views/artist/dashboard.php">Artist Dashboard</a>
                <?php elseif ($user->getRole() === 'admin'): ?>
                    <a href="/views/admin/dashboard.php">Admin Dashboard</a>
                <?php endif; ?>
            <?php endif; ?>
        </div>
        <div class="nav-right">
            <?php if ($user): ?>
                <span>Welcome, <?php echo htmlspecialchars($user->getUsername()); ?></span>
                <a href="/views/auth/logout.php">Logout</a>
            <?php else: ?>
                <a href="/views/auth/login.php">Login</a>
                <a href="/views/auth/register.php">Register</a>
            <?php endif; ?>
        </div>
    </nav>
</body>
</html>
