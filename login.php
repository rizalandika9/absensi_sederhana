<?php
session_start();
include "db.php";

if (isset($_SESSION['user'])) {
    header("Location: index.php");
    exit;
}

if (isset($_POST['login'])) {  
    $username = $_POST['username'];
    $password = md5($_POST['password']);

    $q = mysqli_query($conn, "SELECT * FROM users WHERE username='$username' AND password='$password'");
    if (mysqli_num_rows($q) > 0) {
        $_SESSION['user'] = $username;
        header("Location: index.php");
        exit;
    } else {
        $error = "❌ Username atau password salah!";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
    <img src="img/logo techno.jpg" alt="Logo Techno Informatika">
    <h1>Techno Informatika - Sistem Absensi</h1>
</header>
<div class="container">
    <h2>🔑 Login</h2>
    <?php if (!empty($error)) echo "<p class='error'>$error</p>"; ?>
    <form method="POST">
        <label>Username:</label>
        <input type="text" name="username" required>
        <label>Password:</label>
        <input type="password" name="password" required>
        <button type="submit" name="login">Login</button>
    </form>
</div>
</body>
</html>
