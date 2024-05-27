<?php
require 'config.php';

if (!isset($_SESSION['pesan_data']) || !isset($_SESSION['kode_kwitansi'])) {
    header('Location: pesan.php');
    exit();
}

$pesan_data = $_SESSION['pesan_data'];
$kode_kwitansi = $_SESSION['kode_kwitansi'];

// Ambil data kwitansi dari database
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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kwitansi</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="kwitansi-container">
        <h2>Kwitansi Pembayaran</h2>
        <div class="teksow2">
        <p><strong>Nama Pemesan:</strong> <?php echo htmlspecialchars($pesan_data['nama_pemesan']); ?></p>
        <p><strong>No Kamar:</strong> <?php echo htmlspecialchars($pesan_data['id_kamar']); ?></p>
        <p><strong>Total Biaya:</strong> <?php echo htmlspecialchars($pesan_data['total_biaya']); ?></p>
        <p><strong>Kode Kwitansi:</strong> <?php echo htmlspecialchars($kwitansi['kode_kwitansi']); ?></p>
        <p><strong>Tanggal Pesan:</strong> <?php echo htmlspecialchars($kwitansi['tgl_pesan']); ?></p>
        </div>
        <div class="button-container">
            <form action="cetak.php" method="POST">
                <input type="hidden" name="kode_kwitansi" value="<?php echo htmlspecialchars($kwitansi['kode_kwitansi']); ?>">
                <button type="submit">Cetak</button>
            </form>
            <a href="index.php" class="button">Kembali ke Tampilan Utama</a>
        </div>
    </div>
</body>
</html>
