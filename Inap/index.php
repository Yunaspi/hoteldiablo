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
            <h1>Welcome to Our Hotel</h1>
            <div class="login-button">
            <a href="index.php" class="button">Home</a>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <a href="logout.php" class="button">Logout</a>
                    <a href="dashboard.php" class="button">Dashboard</a>
                    <?php if (isset($_SESSION['pesan_data'])): ?>
                        <a href="ubah.php" class="button">Ubah Pesanan</a>
                    <?php endif; ?>
                <?php else: ?>
                    <a href="login.php" class="button">Login</a>
                <?php endif; ?>
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
