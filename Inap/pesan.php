<?php
require 'config.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$error = $success = '';

// Ambil data kamar dari database
$sql = "SELECT id_kamar, tipe_kamar FROM kamar WHERE status_kamar = 'tersedia'";
$result = $conn->query($sql);
$kamar_options = array();
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $kamar_options[$row['id_kamar']] = $row['tipe_kamar'];
    }
} else {
    $error = "Tidak ada kamar yang tersedia.";
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $no_ktp = $_POST['no_ktp'];
    $id_kamar = $_POST['id_kamar'];
    $nama_pemesan = $_POST['nama_pemesan'];
    $no_tlp = $_POST['no_tlp'];
    $tgl_pesan = $_POST['tgl_pesan'];
    $lama_inap = $_POST['lama_inap'];

    // Periksa apakah kamar tersedia
    $sql_check = "SELECT * FROM kamar WHERE id_kamar = ? AND status_kamar = 'tersedia'";
    $stmt_check = $conn->prepare($sql_check);
    $stmt_check->bind_param('i', $id_kamar);
    $stmt_check->execute();
    $result_check = $stmt_check->get_result();

    if ($result_check->num_rows === 1) {
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

            // Simpan pesanan ke database
            $sql_insert = "INSERT INTO Pemesan (no_ktp, id_kamar, nama_pemesan, no_tlp, tgl_pesan, lama_inap, total_biaya) VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmt_insert = $conn->prepare($sql_insert);
            $stmt_insert->bind_param('sisssii', $no_ktp, $id_kamar, $nama_pemesan, $no_tlp, $tgl_pesan, $lama_inap, $total_biaya);

            if ($stmt_insert->execute()) {
                // Update status kamar menjadi terisi
                $sql_update = "UPDATE kamar SET status_kamar = 'terisi' WHERE id_kamar = ?";
                $stmt_update = $conn->prepare($sql_update);
                $stmt_update->bind_param('i', $id_kamar);
                $stmt_update->execute();

                // Simpan data pesanan ke sesi
                $_SESSION['pesan_data'] = array(
                    'no_ktp' => $no_ktp,
                    'id_kamar' => $id_kamar,
                    'nama_pemesan' => $nama_pemesan,
                    'no_tlp' => $no_tlp,
                    'tgl_pesan' => $tgl_pesan,
                    'lama_inap' => $lama_inap,
                    'total_biaya' => $total_biaya
                );

                // Redirect to pembayaran.php
                header('Location: pembayaran.php');
                exit();
            } else {
                $error = "Gagal menyimpan pesanan ke database.";
            }
        } else {
            $error = "Kamar tidak ditemukan.";
        }
    } else {
        $error = "Kamar tidak tersedia.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesan Kamar</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="pesan-container">
        <h2>Pesan Kamar</h2>
        <?php if ($error): ?>
            <p><?php echo $error; ?></p>
        <?php elseif ($success): ?>
            <p><?php echo $success; ?></p>
        <?php endif; ?>
        <form action="pesan.php" method="POST">
            <label for="no_ktp">No KTP:</label>
            <input type="text" id="no_ktp" name="no_ktp" placeholder="No KTP" required>
            
            <label for="id_kamar">Pilih Kamar:</label>
            <select id="id_kamar" name="id_kamar" required>
                <option value="" selected disabled>Pilih Kamar</option>
                <?php foreach ($kamar_options as $id => $tipe): ?>
                    <?php $option_label = "$id - $tipe"; ?>
                    <option value="<?php echo $id; ?>"><?php echo $option_label; ?></option>
                <?php endforeach; ?>
            </select>
            
            <label for="nama_pemesan">Nama Pemesan:</label>
            <input type="text" id="nama_pemesan" name="nama_pemesan" placeholder="Nama Pemesan" required>
            
            <label for="no_tlp">No Telepon:</label>
            <input type="text" id="no_tlp" name="no_tlp" placeholder="No Telepon" required>
            
            <label for="tgl_pesan">Tanggal Pesan:</label>
            <input type="date" id="tgl_pesan" name="tgl_pesan" placeholder="Tanggal Pesan" required>
            
            <label for="lama_inap">Lama Inap (malam):</label>
            <input type="number" id="lama_inap" name="lama_inap" placeholder="Lama Inap (malam)" required>
            
            <!-- Input total_biaya tidak diperlukan karena dihitung -->
            <button type="submit">Pesan</button>
        </form>
    </div>
</body>
</html>
