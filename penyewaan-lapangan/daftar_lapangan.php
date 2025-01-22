<?php
session_start();
require_once 'db.php';

// Cek apakah pengguna sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php?error=Anda harus login terlebih dahulu.");
    exit();
}

// Ambil data lapangan dari database
try {
    $stmt = $pdo->query("SELECT * FROM fields");
    $fields = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Terjadi kesalahan: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Lapangan</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body { font-family: Arial, sans-serif; margin: 0; padding: 0; background-color: #f8f9fa; color: #333; }
        header { background-color: #007bff; color: white; padding: 1rem 2rem; display: flex; justify-content: space-between; align-items: center; }
        header h1 { font-size: 1.5rem; }
        nav a { color: white; margin-left: 1rem; text-decoration: none; font-size: 1rem; }
        nav a:hover { text-decoration: underline; }
        .container { max-width: 1200px; margin: 2rem auto; padding: 1rem; }
        .card { background-color: white; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); border-radius: 10px; overflow: hidden; margin-bottom: 1.5rem; }
        .card img { width: 100%; height: 200px; object-fit: cover; }
        .card-content { padding: 1rem; }
        .card-content h3 { margin-bottom: 1rem; font-size: 1.2rem; }
        .card-content p { color: #555; font-size: 0.9rem; margin-bottom: 1rem; }
        .card-content .btn { display: inline-block; padding: 0.5rem 1rem; background-color: #007bff; color: white; text-decoration: none; border-radius: 5px; transition: background-color 0.3s ease; }
        .card-content .btn:hover { background-color: #0056b3; }
        .footer { background-color: #343a40; color: white; text-align: center; padding: 1rem; margin-top: 2rem; }
    </style>
</head>
<body>
<header>
    <h1>Daftar Lapangan</h1>
    <nav>
        <a href="dashboard_user.php">Beranda</a>
        <a href="daftar_lapangan.php">Daftar Lapangan</a>
        <a href="riwayat_pemesanan.php">Riwayat Pemesanan</a>
        <a href="profil_saya.php">Profil Saya</a>
        <a href="logout.php">Logout</a>
    </nav>
</header>

<div class="container">
    <h2>Lapangan Tersedia</h2>
    <p>Berikut adalah daftar lapangan yang dapat Anda pesan:</p>

    <!-- Menampilkan daftar lapangan -->
    <?php foreach ($fields as $field): ?>
        <div class="card">
            <img src="<?= htmlspecialchars($field['image_url']); ?>" alt="<?= htmlspecialchars($field['name']); ?>">
            <div class="card-content">
                <h3><?= htmlspecialchars($field['name']); ?></h3>
                <p>Lokasi: <?= htmlspecialchars($field['location']); ?></p>
                <p>Harga: Rp <?= number_format($field['price'], 0, ',', '.'); ?> / jam</p>
                <p>Status: <?= $field['status'] ? 'Tersedia' : 'Sudah Dipesan'; ?></p>
                <?php if ($field['status']): ?>
                    <a href="booking.php?field_id=<?= $field['id']; ?>" class="btn">Booking Sekarang</a>
                <?php else: ?>
                    <button class="btn" style="background-color: grey; cursor: not-allowed;" disabled>Tidak Tersedia</button>
                <?php endif; ?>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<footer class="footer">
    <p>&copy; 2025 Booking Lapangan Badminton. All rights reserved.</p>
</footer>
</body>
</html>