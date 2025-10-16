<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}
include "db.php";

if (isset($_GET['hapus'])) { 
    $id = $_GET['hapus']; 
    mysqli_query($conn, "DELETE FROM siswa WHERE id=$id"); 
    echo "<p class='success'>✅ Data siswa & semua absensinya berhasil dihapus!</p>"; 
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Riwayat Absensi</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <header>
        <img src="img/logo techno.jpg" alt="Logo Techno Informatika">
        <h1>Techno Informatika - Sistem Absensi</h1>
    </header>
    <div class="container">
        <h2>📋 Riwayat Absensi</h2>
        <?php
        $q = mysqli_query($conn, "SELECT absensi.id, absensi.tanggal, absensi.materi, absensi.status,siswa.nama, siswa.id AS siswa_id FROM absensi JOIN siswa ON absensi.siswa_id = siswa.id ORDER BY absensi.tanggal DESC"); 
        if (mysqli_num_rows($q) > 0) { 
            echo "<table>"; 
            echo "<tr><th>Nama</th><th>Materi</th><th>Status</th><th>Tanggal</th><th>Aksi</th><th>Aksi</th></tr>"; 
            while ($row = mysqli_fetch_assoc($q)) { 
                echo "<tr>
                    <td>" . $row['nama'] . "</td>
                    <td>" . $row['materi'] . "</td>
                    <td>" . $row['status'] . "</td>
                    <td>" . $row['tanggal'] . "</td>
                    <td>
                    <a href='edit_absensi.php?id=" . $row['id'] . "'>📝 Edit</a>
                    </td>
                    <td>
                    <a href='riwayat.php?hapus=" . $row['siswa_id'] . "' onclick=\"return confirm('Yakin ingin menghapus data siswa ini beserta semua absensinya?');\">❌ Hapus</a>
                    </td>
                </tr>";
            }
            echo "</table>";
        } else {
            echo "<p>❌ Tidak ada data absensi.</p>";
        }
        ?>
        <p><a href="index.php">⬅️ Kembali ke Absensi</a></p>
    </div>
</body>

</html>