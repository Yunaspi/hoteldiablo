<?php
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['kode_kwitansi'])) {
    $kode_kwitansi = $_POST['kode_kwitansi'];

    // Ambil data kwitansi dari database berdasarkan kode kwitansi
    $sql = "SELECT * FROM kwitansi WHERE kode_kwitansi = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $kode_kwitansi);
    $stmt->execute();
    $result = $stmt->get_result();

    // Periksa apakah data kwitansi berhasil diambil
    if ($result->num_rows > 0) {
        $kwitansi = $result->fetch_assoc();
    } else {
        $kwitansi = array(
            'kode_kwitansi' => 'Kode Kwitansi Tidak Ditemukan',
            'tgl_pesan' => 'Tanggal Tidak Ditemukan',
            'total_biaya' => 'Biaya Tidak Ditemukan'
        );
    }
} else {
    // Jika tidak ada data POST atau kode kwitansi, arahkan kembali ke halaman sebelumnya
    header('Location: index.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Kwitansi</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="cetak-container">
        <h2>Kwitansi Pembayaran</h2>
        <div class="teksow3">
        <p><strong>Kode Kwitansi:</strong> <?php echo htmlspecialchars($kwitansi['kode_kwitansi']); ?></p>
        <p><strong>Tanggal Pesan:</strong> <?php echo htmlspecialchars($kwitansi['tgl_pesan']); ?></p>
        <p><strong>Total Biaya:</strong> <?php echo htmlspecialchars($kwitansi['total_biaya']); ?></p>
        </div>
        <div class="button-container">
            <button class="btnctk" onclick="window.print()">Cetak</button>
            <a href="index.php" class="button">Kembali ke Tampilan Utama</a>
        </div>
    </div>
</body>
</html>
