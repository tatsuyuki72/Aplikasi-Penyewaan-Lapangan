<?php
session_start();
// Cek apakah pengguna sudah login atau belum
if (isset($_SESSION['user_id'])) {
    // Jika sudah login, arahkan ke dashboard admin atau halaman utama pengguna
    header("Location: admin_dashboard.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Beranda - Penyewaan Lapangan Badminton</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f5f5f5; margin: 0; padding: 0; }
        header { background-color: #007bff; color: white; padding: 1rem; text-align: center; }
        main { padding: 2rem; text-align: center; }
        a { text-decoration: none; color: #007bff; margin: 0 1rem; }
        a:hover { text-decoration: underline; }
    </style>
</head>
<body>
    <header>
        <h1>Selamat Datang di Penyewaan Lapangan Badminton</h1>
    </header>
    <main>
        <p>Aplikasi untuk mempermudah penyewaan lapangan badminton di Kota Serang.</p>
        <!-- Menu navigasi untuk pengguna yang belum login -->
        <a href="login.php">Login</a> | 
        <a href="register.php">Register</a> | 
        <a href="booking_list.php">Daftar Lapangan</a>
    </main>
</body>
</html>