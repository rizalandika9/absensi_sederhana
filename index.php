<?php
session_start(); 
if (!isset($_SESSION['user'])) {
    header("Location: login.php"); 
    exit; 
}
include "db.php"; 

if (isset($_POST['simpan'])) { 
    $nama   = $_POST['nama']; 
    $materi = $_POST['materi']; 
    $status = $_POST['status']; 
    $tanggal = $_POST['tanggal']; 

    
    $cek = mysqli_query($conn, "SELECT * FROM siswa WHERE nama='$nama'"); 
    if (mysqli_num_rows($cek) == 0) { 
        mysqli_query($conn, "INSERT INTO siswa (nama) VALUES ('$nama')"); 
        $siswa_id = mysqli_insert_id($conn); 
        $s = mysqli_fetch_assoc($cek); 
        $siswa_id = $s['id']; 
    }

    mysqli_query($conn, "INSERT INTO absensi (siswa_id, materi, status, tanggal) VALUES 
    ('$siswa_id', '$materi', '$status', '$tanggal')");
    echo "<p class='success'>✅ Absensi berhasil disimpan!</p>";
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Absensi</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <header>
        <img src="img/logo techno.jpg" alt="Logo Techno Informatika">
        <h1>Techno Informatika - Sistem Absensi</h1>
    </header>
    <div class="container">
        <h2>Form Absensi Kursus Online</h2>
        <form method="POST">
            <label>Nama Siswa:</label>
            <input type="text" name="nama" required>
            <label>Materi:</label>
            <select name="materi" required>
                <option value="Ms Word">Ms Word</option>
                <option value="Ms Excel">Ms Excel</option>
                <option value="Desain Grafis">Desain Grafis</option>
                <option value="Pemrograman Web">Pemrograman Web</option>
                <option value="Auto Cad">Auto Cad</option>
            </select>
            <label>Status:</label>
            <select name="status" required>
                <option value="Hadir">Hadir</option>
                <option value="Izin">Izin</option>
                <option value="Sakit">Sakit</option>
                <option value="Alpa">Alpa</option>
            </select>
            <label>Tanggal:</label>
            <input type="date" name="tanggal" required>
            <button type="submit" name="simpan">Simpan</button>
        </form>

        <p><a href="riwayat.php">📋 Lihat Riwayat</a> | <a href="edit_profil.php">👤 Edit Profil</a> | <a href="logout.php">🚪 Logout</a></p>
    </div>
</body>

</html>