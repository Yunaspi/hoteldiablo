<?php
session_start();

require 'config.php';

if (!isset($_SESSION['pesan_data'])) {
    header('Location: pesan.php');
    exit();
}

$pesan_data = $_SESSION['pesan_data'];

// Ambil data kwitansi dari database
$sql = "SELECT * FROM kwitansi WHERE tgl_pesan = ? AND total_biaya = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('sd', $pesan_data['tgl_pesan'], $pesan_data['total_biaya']);
$stmt->execute();
$result = $stmt->get_result();

// Periksa apakah data kwitansi berhasil diambil
if ($result->num_rows > 0) {
    $kwitansi = $result->fetch_assoc();
} else {
    // Jika data kwitansi tidak ditemukan, berikan nilai default untuk menghindari error
    $kwitansi = array(
        'kode_kwitansi' => 'Kode Kwitansi Tidak Ditemukan'
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
        <p><strong>Nama Pemesan:</strong> <?php echo $pesan_data['nama_pemesan']; ?></p>
        <p><strong>No Kamar:</strong> <?php echo $pesan_data['id_kamar']; ?></p>
        <p><strong>Total Biaya:</strong> <?php echo $pesan_data['total_biaya']; ?></p>
        <div class="button-container">
            <form action="cetak.php" method="POST">
                <input type="hidden" name="kode_kwitansi" value="<?php echo $kwitansi['kode_kwitansi']; ?>">
                <button type="submit">Cetak</button>
            </form>
            <a href="index.php" class="button">Kembali ke Tampilan Utama</a>
        </div>
    </div>
</body>
</html>
