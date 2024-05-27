<?php
require 'config.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$pesan_data = $_SESSION['pesan_data'];
$error = $success = '';

// Ambil data kamar yang tersedia dari database
$sql = "SELECT id_kamar, tipe_kamar FROM kamar WHERE status_kamar = 'tersedia' OR id_kamar = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $pesan_data['id_kamar']);
$stmt->execute();
$result = $stmt->get_result();
$kamar_options = array();
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $kamar_options[$row['id_kamar']] = $row['tipe_kamar'];
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['hapus'])) {
        // Hapus pesanan
        $id_kamar = $pesan_data['id_kamar'];
        $sql_delete = "DELETE FROM Pemesan WHERE id_kamar = ?";
        $stmt_delete = $conn->prepare($sql_delete);
        $stmt_delete->bind_param('i', $id_kamar);
        if ($stmt_delete->execute()) {
            // Update status_kamar menjadi tersedia
            $sql_update = "UPDATE kamar SET status_kamar = 'tersedia' WHERE id_kamar = ?";
            $stmt_update = $conn->prepare($sql_update);
            $stmt_update->bind_param('i', $id_kamar);
            $stmt_update->execute();

            unset($_SESSION['pesan_data']);
            $success = "Pesanan berhasil dihapus.";
        } else {
            $error = "Gagal menghapus pesanan.";
        }
    } else {
        $no_ktp = $_POST['no_ktp'];
        $id_kamar = $_POST['id_kamar'];
        $nama_pemesan = $_POST['nama_pemesan'];
        $no_tlp = $_POST['no_tlp'];
        $tgl_pesan = $_POST['tgl_pesan'];
        $lama_inap = $_POST['lama_inap'];

        // Ambil harga kamar dari database berdasarkan id_kamar
        $sql = "SELECT harga_kamar FROM kamar WHERE id_kamar = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('i', $id_kamar);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $row = $result->fetch_assoc();
            $harga_kamar = $row['harga_kamar'];

            // Hitung total biaya berdasarkan harga kamar dan lama inap
            $total_biaya = $harga_kamar * $lama_inap;

            // Perbarui pesanan di database
            $sql_update = "UPDATE Pemesan SET no_ktp=?, id_kamar=?, nama_pemesan=?, no_tlp=?, tgl_pesan=?, lama_inap=?, total_biaya=? WHERE id_kamar=?";
            $stmt_update = $conn->prepare($sql_update);
            $stmt_update->bind_param('sisssiii', $no_ktp, $id_kamar, $nama_pemesan, $no_tlp, $tgl_pesan, $lama_inap, $total_biaya, $id_kamar);

            if ($stmt_update->execute()) {
                // Simpan perubahan ke dalam session
                $_SESSION['pesan_data'] = array(
                    'no_ktp' => $no_ktp,
                    'id_kamar' => $id_kamar,
                    'nama_pemesan' => $nama_pemesan,
                    'no_tlp' => $no_tlp,
                    'tgl_pesan' => $tgl_pesan,
                    'lama_inap' => $lama_inap,
                    'total_biaya' => $total_biaya
                );

                $success = "Pesanan berhasil diperbarui.";
            } else {
                $error = "Gagal memperbarui pesanan.";
            }
        } else {
            $error = "Kamar tidak ditemukan.";
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ubah Pesanan</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="ubah-container">
        <h2>Ubah Pesanan</h2>
        <?php if ($error): ?>
            <p><?php echo $error; ?></p>
        <?php elseif ($success): ?>
            <p><?php echo $success; ?></p>
        <?php endif; ?>
        <form action="ubah.php" method="POST">
            <label for="no_ktp">No KTP:</label>
            <input type="text" id="no_ktp" name="no_ktp" placeholder="No KTP" value="<?php echo $pesan_data['no_ktp']; ?>" required>

            <label for="id_kamar">Pilih Kamar:</label>
            <select id="id_kamar" name="id_kamar" required>
                <option value="" selected disabled>Pilih Kamar</option>
                <?php foreach ($kamar_options as $id => $tipe): ?>
                    <option value="<?php echo $id; ?>" <?php echo $id == $pesan_data['id_kamar'] ? 'selected' : ''; ?>>
                        <?php echo $tipe; ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <label for="nama_pemesan">Nama Pemesan:</label>
            <input type="text" id="nama_pemesan" name="nama_pemesan" placeholder="Nama Pemesan" value="<?php echo $pesan_data['nama_pemesan']; ?>" required>

            <label for="no_tlp">No Telepon:</label>
            <input type="text" id="no_tlp" name="no_tlp" placeholder="No Telepon" value="<?php echo $pesan_data['no_tlp']; ?>" required>

            <label for="tgl_pesan">Tanggal Pesan:</label>
            <input type="date" id="tgl_pesan" name="tgl_pesan" placeholder="Tanggal Pesan" value="<?php echo $pesan_data['tgl_pesan']; ?>" required>

<label for="lama_inap">Lama Inap (malam):</label>
<input type="number" id="lama_inap" name="lama_inap" placeholder="Lama Inap (malam)" value="<?php echo $pesan_data['lama_inap']; ?>" required>

<button type="submit">Ubah Pesanan</button>
<button type="submit" name="hapus" value="hapus">Hapus Pesanan</button>
<a class="ubhu" href="index.php">Kembali ke Halaman Utama</a>
</form>
</div>
</body>
</html>

