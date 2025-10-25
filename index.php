<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

include "db.php";

// Proses form hanya jika POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // ambil & bersihkan input
    $nama    = isset($_POST['nama']) ? mysqli_real_escape_string($conn, trim($_POST['nama'])) : '';
    $materi  = isset($_POST['materi']) ? mysqli_real_escape_string($conn, trim($_POST['materi'])) : '';
    $status  = isset($_POST['status']) ? mysqli_real_escape_string($conn, trim($_POST['status'])) : '';
    $tanggal = isset($_POST['tanggal']) ? mysqli_real_escape_string($conn, $_POST['tanggal']) : date('Y-m-d');

    // validasi sederhana
    if ($nama === '') {
        $error = "Nama siswa wajib diisi.";
    } else {
        // 1) Cek apakah siswa sudah ada berdasarkan nama
        $cek = mysqli_query($conn, "SELECT id FROM siswa WHERE nama = '$nama' LIMIT 1");
        if ($cek && mysqli_num_rows($cek) > 0) {
            $row = mysqli_fetch_assoc($cek);
            $siswa_id = (int)$row['id'];
        } else {
            // 2) Jika belum ada -> insert siswa baru
            $ins = mysqli_query($conn, "INSERT INTO siswa (nama) VALUES ('$nama')");
            if ($ins) {
                $siswa_id = mysqli_insert_id($conn);
            } else {
                $error = "Gagal menyimpan data siswa: " . mysqli_error($conn);
            }
        }
    }

    // 3) Jika $siswa_id sudah tersedia -> simpan absensi
    if (empty($error) && isset($siswa_id)) {
        $sql = "INSERT INTO absensi (siswa_id, materi, status, tanggal)
                VALUES ($siswa_id, '$materi', '$status', '$tanggal')";
        if (mysqli_query($conn, $sql)) {
            $success = "✅ Absensi berhasil disimpan!";
        } else {
            $error = "Gagal menyimpan absensi: " . mysqli_error($conn);
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <title>Absensi - Techno Informatika</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <header>
        <img src="images/logo.png" alt="Logo Techno Informatika" style="height:48px; margin-right:12px;">
        <h1>Techno Informatika - Sistem Absensi</h1>
    </header>

    <div class="container">
        <h2>📝 Form Absensi</h2>

        <?php if (!empty($error)): ?>
            <p class="error"><?php echo $error; ?></p>
        <?php endif; ?>

        <?php if (!empty($success)): ?>
            <p class="success"><?php echo $success; ?></p>
        <?php endif; ?>

        <form method="POST" action="">
            <label>Nama Siswa:</label>
            <input type="text" name="nama" value="<?php echo isset($nama) ? htmlspecialchars($nama, ENT_QUOTES) : ''; ?>" required>

            <label>Materi:</label>
            <select name="materi" required>
                <option value="Ms Word" <?php if (isset($materi) && $materi == 'Ms Word') echo 'selected'; ?>>Ms Word</option>
                <option value="Ms Excel" <?php if (isset($materi) && $materi == 'Ms Excel') echo 'selected'; ?>>Ms Excel</option>
                <option value="Desain Grafis" <?php if (isset($materi) && $materi == 'Desain Grafis') echo 'selected'; ?>>Desain Grafis</option>
                <option value="Pemrograman Web" <?php if (isset($materi) && $materi == 'Pemrograman Web') echo 'selected'; ?>>Pemrograman Web</option>
            </select>

            <label>Status:</label>
            <select name="status" required>
                <option value="Hadir" <?php if (isset($status) && $status == 'Hadir') echo 'selected'; ?>>Hadir</option>
                <option value="Izin" <?php if (isset($status) && $status == 'Izin') echo 'selected'; ?>>Izin</option>
                <option value="Sakit" <?php if (isset($status) && $status == 'Sakit') echo 'selected'; ?>>Sakit</option>
                <option value="Alpa" <?php if (isset($status) && $status == 'Alpa') echo 'selected'; ?>>Alpa</option>
            </select>

            <label>Tanggal:</label>
            <input type="date" name="tanggal" value="<?php echo isset($tanggal) ? htmlspecialchars($tanggal) : date('Y-m-d'); ?>" required>

            <button type="submit">Simpan</button>
        </form>
        <br>

        <p><a href="riwayat.php">📋 Lihat Riwayat Absensi</a></p>
        <br>
        <p><a href="edit_profil.php">👤 Edit Profil Siswa</a></p>
        <br>
        <p><a href="logout.php">🚪 Logout</a></p>
    </div>
</body>

</html>