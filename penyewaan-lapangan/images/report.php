<?php
session_start();
require_once 'db.php';

// Cek apakah admin sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Ambil data laporan dari database
try {
    $stmt = $pdo->query("SELECT b.id, u.name AS user_name, f.name AS field_name, b.start_time, b.duration, f.price * b.duration AS total_cost
                         FROM bookings b
                         JOIN users u ON b.user_id = u.id
                         JOIN fields f ON b.field_id = f.id
                         ORDER BY b.start_time DESC");
    $reports = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Terjadi kesalahan: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            color: #333;
            margin: 0;
            padding: 0;
        }
        header {
            background-color: #007bff;
            color: white;
            padding: 1rem;
            text-align: center;
        }
        header h1 {
            margin: 0;
        }
        .container {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 1rem;
            background: white;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 1rem;
        }
        table th, table td {
            padding: 0.75rem;
            text-align: left;
            border: 1px solid #ddd;
        }
        table th {
            background-color: #007bff;
            color: white;
        }
        table tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        footer {
            text-align: center;
            padding: 1rem;
            background-color: #f1f1f1;
            margin-top: 2rem;
        }
    </style>
</head>
<body>

<header>
    <h1>Laporan Pemesanan</h1>
</header>

<div class="container">
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama Pengguna</th>
                <th>Nama Lapangan</th>
                <th>Waktu Mulai</th>
                <th>Durasi (jam)</th>
                <th>Total Biaya</th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($reports) > 0): ?>
                <?php foreach ($reports as $report): ?>
                    <tr>
                        <td><?= htmlspecialchars($report['id']); ?></td>
                        <td><?= htmlspecialchars($report['user_name']); ?></td>
                        <td><?= htmlspecialchars($report['field_name']); ?></td>
                        <td><?= htmlspecialchars($report['start_time']); ?></td>
                        <td><?= htmlspecialchars($report['duration']); ?></td>
                        <td>Rp <?= number_format($report['total_cost'], 0, ',', '.'); ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6" style="text-align: center;">Tidak ada data tersedia.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<footer>
    <p>&copy; 2025 Laporan Penyewaan Lapangan</p>
</footer>

</body>
</html>
