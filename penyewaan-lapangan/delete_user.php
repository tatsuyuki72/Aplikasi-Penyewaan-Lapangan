<?php
session_start();

// Cek apakah pengguna sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Sertakan file koneksi ke database
require_once 'db.php';

// Periksa apakah parameter ID disertakan
if (!isset($_GET['id'])) {
    echo "ID pengguna tidak ditemukan.";
    exit();
}

$id = $_GET['id'];

// Hapus data terkait di tabel bookings
$deleteBookingsStmt = $pdo->prepare("DELETE FROM bookings WHERE user_id = :id");
$deleteBookingsStmt->execute(['id' => $id]);

// Hapus data pengguna dari tabel users
$deleteUserStmt = $pdo->prepare("DELETE FROM users WHERE id = :id");
$deleteUserStmt->execute(['id' => $id]);

// Redirect ke halaman manajemen pengguna
header("Location: manage_users.php");
exit();
?>
