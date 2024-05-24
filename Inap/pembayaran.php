<?php
session_start();

if (!isset($_SESSION['pesan_data'])) {
    header('Location: pesan.php');
    exit();
}

$pesan_data = $_SESSION['pesan_data'];

// Jika tombol pembayaran diklik
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require 'config.php';

    // Masukkan data ke tabel kwitansi
    $tgl_pesan = $pesan_data['tgl_pesan'];
    $total_biaya = $pesan_data['total_biaya'];

    $sql = "INSERT INTO kwitansi (tgl_pesan, total_biaya) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('sd', $tgl_pesan, $total_biaya);

    if ($stmt->execute()) {
        // Hapus data pesanan dari session setelah pembayaran berhasil
        unset($_SESSION['pesan_data']);

        // Redirect ke halaman kwitansi
        header('Location: kwitansi.php');
        exit();
    } else {
        echo "Gagal menyimpan data pembayaran ke dalam tabel kwitansi.";
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
        <h2>Data Pemesanan</h2>
        <p><strong>Nama Pemesan:</strong> <?php echo $pesan_data['nama_pemesan']; ?></p>
        <p><strong>No Kamar:</strong> <?php echo $pesan_data['id_kamar']; ?></p>
        <p><strong>Tanggal Pesan:</strong> <?php echo $pesan_data['tgl_pesan']; ?></p>
        <p><strong>Lama Inap:</strong> <?php echo $pesan_data['lama_inap']; ?> malam</p>
        <p><strong>Total Biaya:</strong> <?php echo $pesan_data['total_biaya']; ?></p>
        <h2>Pilih Metode Pembayaran</h2>
        <form action="" method="POST">
            <button type="submit" name="pembayaran"><a href="kwitansi.php">Pembayaran QRIS</button>
            <button type="submit" name="pembayaran"><a href="kwitansi.php">Pembayaran Bank</button>
        </form>
    </div>
</body>
</html>
