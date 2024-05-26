<?php
require 'config.php';

if (!isset($_SESSION['pesan_data'])) {
    header('Location: pesan.php');
    exit();
}

$pesan_data = $_SESSION['pesan_data'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Simpan data ke tabel kwitansi
    $tgl_pesan = $pesan_data['tgl_pesan'];
    $total_biaya = $pesan_data['total_biaya'];

    $sql = "INSERT INTO kwitansi (tgl_pesan, total_biaya) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('sd', $tgl_pesan, $total_biaya);

    if ($stmt->execute()) {
        // Ambil ID terakhir yang diinsert
        $kode_kwitansi = $conn->insert_id;

        // Simpan kode kwitansi ke dalam session
        $_SESSION['kode_kwitansi'] = $kode_kwitansi;

        // Redirect ke halaman kwitansi
        header('Location: kwitansi.php');
        exit();
    } else {
        $error = "Terjadi kesalahan saat menyimpan data.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="pembayaran-container">
        <h2>Pembayaran</h2>
        <?php if (isset($error)): ?>
            <p><?php echo $error; ?></p>
        <?php endif; ?>
        <p><strong>Nama Pemesan:</strong> <?php echo htmlspecialchars($pesan_data['nama_pemesan']); ?></p>
        <p><strong>No Kamar:</strong> <?php echo htmlspecialchars($pesan_data['id_kamar']); ?></p>
        <p><strong>Total Biaya:</strong> <?php echo htmlspecialchars($pesan_data['total_biaya']); ?></p>
        <form action="pembayaran.php" method="POST">
            <button type="submit">Bayar</button>
        </form>
    </div>
</body>
</html>
