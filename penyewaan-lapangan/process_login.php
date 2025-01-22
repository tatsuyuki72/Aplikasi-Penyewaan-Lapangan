<?php
session_start();
require_once 'db.php';

// Aktifkan error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    try {
        // Cek apakah email ada di database
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user) {
            die("Debug: User dengan email $email tidak ditemukan.");
        }

        // Verifikasi password
        if (!password_verify($password, $user['password'])) {
            header("Location: login.php?error=Password salah!");
            exit();
        }

        // Simpan informasi login ke sesi
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['name'];
        $_SESSION['role'] = $user['role'];

        // Redirect berdasarkan role
        if ($user['role'] === 'admin') {
            header("Location: admin_dashboard.php?success=Login berhasil!");
        } elseif ($user['role'] === 'user') {
            header("Location: user_dashboard.php?success=Login berhasil!");
        } else {
            die("Debug: Role tidak dikenali.");
        }
        exit();
    } catch (PDOException $e) {
        die("Debug: Terjadi kesalahan pada server. Pesan: " . $e->getMessage());
    }
} else {
    header("Location: login.php");
    exit();
}
?>
