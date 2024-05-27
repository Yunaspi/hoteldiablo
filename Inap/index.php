<?php
require 'config.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hotel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="styles.css"> <!-- Gaya CSS opsional -->
</head>
<body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <!-- <header>
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
    </header> -->
    <!--  -->
    <nav class="navbar bg-navy navbar-expand-lg border-body">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">HOTEL GRAHITO</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" aria-current="page" href="index.php">Home</a>
        </li>
        <?php if (isset($_SESSION['user_id'])): ?>
        <li class="nav-item">
          <a class="nav-link" href="logout.php">Logout</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="dashboard.php">Dashboard</a>
        </li>
        <?php if (isset($_SESSION['pesan_data'])): ?>
        <li class="nav-item">
          <a class="nav-link" href="ubah.php">Ubah pesanan</a>
          <?php endif; ?>
        <?php else: ?>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="login.php">Login</a>
        </li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</nav>
    <main>
        <!-- Konten utama di sini -->
        <div class="group-name">
            <h2>Nama Kelompok</h2>
            <ul>
                <li>Azvin Andika Halim (301222258)</li>
                <li>Esan Grahito (NPM)</li>
                <li>Muhammad Rifa Maulana (NPM)</li>
                <li>Virziawan Adi Listato (NPM)</li>
            </ul>
        </div>
        <div class="main-content">
            <a href="pesan.php" class="btn">Pesan Kamar</a>
        </div>
    </main>
</body>
</html>
