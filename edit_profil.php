<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}
include "db.php";

if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $nama = $_POST['nama'];
    mysqli_query($conn, "UPDATE siswa SET nama='$nama' WHERE id=$id");
    echo "<p class='success'>✅ Profil siswa berhasil diperbarui!</p>";
}

$siswa = mysqli_query($conn, "SELECT * FROM siswa ORDER BY nama ASC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Profil</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
    <img src="img/logo techno.jpg" alt="Logo Techno Informatika">
    <h1>Techno Informatika - Sistem Absensi</h1>
</header>
<div class="container">
    <h2>👤 Edit Profil Siswa</h2>
    <form method="POST">
        <label>Pilih Siswa:</label>
        <select name="id" required>
            <option value="">-- Pilih --</option>
            <?php while($row = mysqli_fetch_assoc($siswa)) { ?>
                <option value="<?php echo $row['id']; ?>"><?php echo $row['nama']; ?></option>
            <?php } ?>
        </select>
        <label>Nama Baru:</label>
        <input type="text" name="nama" required placeholder="Masukkan nama baru">
        <button type="submit" name="update">Update</button>
    </form>
    <br>
    <p><a href="index.php">⬅️ Kembali ke Absensi</a></p>
</div>
</body>
</html>
