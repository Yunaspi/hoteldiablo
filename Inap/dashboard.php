<?php
require 'config.php';

// Pastikan hanya pengguna yang telah login yang dapat mengakses dashboard
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// Query untuk mengambil data kamar dari database
$sql = "SELECT * FROM kamar";
$result = $conn->query($sql);

$kamars = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $kamars[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="styles.css"> <!-- Gaya CSS opsional -->
</head>
<body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
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
        <div class="container">
            <h2>Kamar Hotel</h2>
            <table>
                <thead>
                    <tr>
                        <th>No Kamar</th>
                        <th>Tipe Kamar</th>
                        <th>Harga Kamar</th>
                        <th>Status Kamar</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($kamars as $kamar): ?>
                        <tr>
                            <td><?php echo $kamar['id_kamar']; ?></td>
                            <td><?php echo $kamar['tipe_kamar']; ?></td>
                            <td><?php echo $kamar['harga_kamar']; ?></td>
                            <td><?php echo $kamar['status_kamar']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </main>
</body>
</html>
