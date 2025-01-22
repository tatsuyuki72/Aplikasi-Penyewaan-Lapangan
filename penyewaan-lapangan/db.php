<?php
$host = '127.0.0.1';    // Host server database
$db = 'penyewaan_badminton';  // Nama database yang telah Anda buat
$user = 'root';         // Username default di XAMPP
$pass = '';             // Password kosong (default di XAMPP)
$charset = 'utf8mb4';   // Charset untuk mendukung karakter internasional

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";  // DSN untuk koneksi
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
];

try {
    // Membuat objek PDO untuk koneksi ke database
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    // Jika gagal, tampilkan pesan error
    echo "Koneksi gagal: " . $e->getMessage();
}
?>
