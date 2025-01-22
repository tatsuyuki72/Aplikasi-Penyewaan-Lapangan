<?php
session_start();
require_once 'db.php';

// Cek apakah pengguna sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php?error=Anda harus login terlebih dahulu.");
    exit();
}

// Ambil ID lapangan dari URL
if (!isset($_GET['field_id'])) {
    die("Lapangan tidak ditemukan.");
}
$field_id = $_GET['field_id'];

// Ambil data lapangan berdasarkan ID
try {
    $stmt = $pdo->prepare("SELECT * FROM fields WHERE id = ?");
    $stmt->execute([$field_id]);
    $field = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$field) {
        die("Lapangan tidak ditemukan.");
    }
} catch (PDOException $e) {
    die("Terjadi kesalahan: " . $e->getMessage());
}

// Tangani form pemesanan
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $booking_date = $_POST['booking_date'];
    $start_time = $_POST['start_time'];
    $duration = $_POST['duration'];

    // Validasi input
    if (empty($booking_date) || empty($start_time) || empty($duration)) {
        $error = "Semua bidang harus diisi.";
    } else {
        try {
            // Tambahkan pemesanan ke database
            $stmt = $pdo->prepare("INSERT INTO bookings (user_id, field_id, booking_date, start_time, duration) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$_SESSION['user_id'], $field_id, $booking_date, $start_time, $duration]);

            // Tandai lapangan sebagai tidak tersedia
            $pdo->prepare("UPDATE fields SET availability = 0 WHERE id = ?")->execute([$field_id]);

            // Redirect ke halaman riwayat pemesanan
            header("Location: riwayat_pemesanan.php?success=Pemesanan berhasil.");
            exit();
        } catch (PDOException $e) {
            $error = "Terjadi kesalahan saat menyimpan pemesanan: " . $e->getMessage();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Lapangan</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f8f9fa; margin: 0; padding: 0; }
        .container { max-width: 600px; margin: 2rem auto; padding: 1rem; background-color: white; border-radius: 10px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); }
        h2 { text-align: center; }
        form { display: flex; flex-direction: column; gap: 1rem; }
        input, select, button { padding: 0.8rem; border: 1px solid #ccc; border-radius: 5px; }
        button { background-color: #007bff; color: white; border: none; cursor: pointer; }
        button:hover { background-color: #0056b3; }
        .error { color: red; text-align: center; }
    </style>
</head>
<body>
<div class="container">
    <h2>Booking Lapangan: <?= htmlspecialchars($field['name']); ?></h2>
    <p>Lokasi: <?= htmlspecialchars($field['location']); ?></p>
    <p>Harga: Rp <?= number_format($field['price'], 0, ',', '.'); ?> / jam</p>

    <?php if (isset($error)): ?>
        <p class="error"><?= htmlspecialchars($error); ?></p>
    <?php endif; ?>

    <form method="POST">
        <label for="booking_date">Tanggal</label>
        <input type="date" id="booking_date" name="booking_date" required>

        <label for="start_time">Jam Mulai</label>
        <input type="time" id="start_time" name="start_time" required>

        <label for="duration">Durasi (jam)</label>
        <select id="duration" name="duration" required>
            <option value="1">1 Jam</option>
            <option value="2">2 Jam</option>
            <option value="3">3 Jam</option>
        </select>

        <button type="submit">Konfirmasi Booking</button>
    </form>
</div>
</body>
</html>
