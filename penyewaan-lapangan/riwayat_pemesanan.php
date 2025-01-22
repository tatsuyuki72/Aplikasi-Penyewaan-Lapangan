<?php
session_start();
require_once 'db.php';

// Cek apakah pengguna sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php?error=Anda harus login terlebih dahulu.");
    exit();
}

// Ambil data pemesanan pengguna dari database
try {
    $stmt = $pdo->prepare("
        SELECT bookings.*, fields.name AS field_name, fields.location AS field_location 
        FROM bookings
        JOIN fields ON bookings.field_id = fields.id
        WHERE bookings.user_id = ?
        ORDER BY bookings.booking_date DESC, bookings.start_time DESC
    ");
    $stmt->execute([$_SESSION['user_id']]);
    $bookings = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Terjadi kesalahan: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Pemesanan</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; padding: 0; background-color: #f8f9fa; color: #333; }
        header { background-color: #007bff; color: white; padding: 1rem 2rem; display: flex; justify-content: space-between; align-items: center; }
        header h1 { font-size: 1.5rem; }
        nav a { color: white; margin-left: 1rem; text-decoration: none; font-size: 1rem; }
        nav a:hover { text-decoration: underline; }
        .container { max-width: 1200px; margin: 2rem auto; padding: 1rem; background-color: white; border-radius: 10px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); }
        table { width: 100%; border-collapse: collapse; margin: 1rem 0; }
        table th, table td { border: 1px solid #ddd; padding: 0.8rem; text-align: center; }
        table th { background-color: #007bff; color: white; }
        .footer { background-color: #343a40; color: white; text-align: center; padding: 1rem; margin-top: 2rem; }
    </style>
</head>
<body>
<header>
    <h1>Riwayat Pemesanan</h1>
    <nav>
        <a href="dashboard_user.php">Beranda</a>
        <a href="daftar_lapangan.php">Daftar Lapangan</a>
        <a href="riwayat_pemesanan.php">Riwayat Pemesanan</a>
        <a href="profil_saya.php">Profil Saya</a>
        <a href="logout.php">Logout</a>
    </nav>
</header>

<div class="container">
    <h2>Riwayat Pemesanan Anda</h2>
    <?php if (count($bookings) > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Lapangan</th>
                    <th>Lokasi</th>
                    <th>Tanggal</th>
                    <th>Waktu</th>
                    <th>Durasi (jam)</th>
                    <th>Dipesan Pada</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($bookings as $index => $booking): ?>
                    <tr>
                        <td><?= $index + 1; ?></td>
                        <td><?= htmlspecialchars($booking['field_name']); ?></td>
                        <td><?= htmlspecialchars($booking['field_location']); ?></td>
                        <td><?= htmlspecialchars($booking['booking_date']); ?></td>
                        <td><?= htmlspecialchars($booking['start_time']); ?></td>
                        <td><?= htmlspecialchars($booking['duration']); ?></td>
                        <td><?= htmlspecialchars($booking['created_at']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>Anda belum memiliki riwayat pemesanan.</p>
    <?php endif; ?>
</div>

<footer class="footer">
    <p>&copy; 2025 Booking Lapangan Badminton. All rights reserved.</p>
</footer>
</body>
</html>
