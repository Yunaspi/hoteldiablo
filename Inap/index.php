<?php
require 'config.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hotel</title>
    <link rel="stylesheet" href="styles.css"> <!-- Gaya CSS opsional -->
</head>
<body>
    <header>
        <div class="container">
            <h1>Welcome to Grahito Hotel</h1>
            <div class="menu">
                <ul>
                <li><a href="index.php">Home</a></li>
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <li><a href="dashboard.php">Dashboard</a></li>
                        <li><a href="logout.php">Logout</a></li> 
                    <?php else: ?>
                        <li><a href="login.php">Login</a></li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </header>
    <main>
        <!-- Konten utama di sini -->
        <div class="main-content">
            <a href="pesan.php" class="btn">Pesan Kamar</a>
        </div>
    </main>
</body>
</html>
