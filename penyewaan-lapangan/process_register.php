<?php
require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    try {
        // Cek apakah email sudah terdaftar
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);

        if ($stmt->rowCount() > 0) {
            header("Location: register.php?error=Email sudah terdaftar!");
            exit();
        }

        // Enkripsi password menggunakan password_hash
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Masukkan data pengguna baru
        $stmt = $pdo->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
        $stmt->execute([$name, $email, $hashed_password]);

        // Setelah berhasil, arahkan ke halaman login
        header("Location: login.php?success=Pendaftaran berhasil! Silakan login.");
        exit();
    } catch (PDOException $e) {
        header("Location: register.php?error=Terjadi kesalahan saat registrasi.");
        exit();
    }
} else {
    header("Location: register.php");
    exit();
}
?>
