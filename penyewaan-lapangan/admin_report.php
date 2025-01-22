<?php
session_start();

// Cek apakah pengguna sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Sambungkan ke database
require_once 'db.php';

// Ambil data pemesanan dari database
try {
    $stmt = $pdo->query("
        SELECT bookings.id, users.name AS user_name, fields.name AS field_name, bookings.booking_date, bookings.start_time, bookings.duration, (fields.price * bookings.duration) AS total_price 
        FROM bookings
        JOIN users ON bookings.user_id = users.id
        JOIN fields ON bookings.field_id = fields.id
    ");
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
    <title>Laporan Pemesanan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
        }
        table {
            width: 90%;
            margin: 20px auto;
            border-collapse: collapse;
        }
        table th, table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
        }
        table th {
            background-color: #007bff;
            color: white;
        }
        .btn-container {
            text-align: center;
            margin: 20px 0;
        }
        .btn {
            padding: 10px 20px;
            color: white;
            background-color: #007bff;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            font-size: 1rem;
            cursor: pointer;
        }
        .btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

    <h1 style="text-align: center; margin: 20px;">Laporan Pemesanan</h1>

    <div class="btn-container">
        <a href="report.php" class=""></a>
    </div>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama Pengguna</th>
                <th>Lapangan</th>
                <th>Tanggal</th>
                <th>Jam Mulai</th>
                <th>Durasi</th>
                <th>Total Harga</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($bookings as $booking): ?>
                <tr>
                    <td><?= htmlspecialchars($booking['id']) ?></td>
                    <td><?= htmlspecialchars($booking['user_name']) ?></td>
                    <td><?= htmlspecialchars($booking['field_name']) ?></td>
                    <td><?= htmlspecialchars($booking['booking_date']) ?></td>
                    <td><?= htmlspecialchars($booking['start_time']) ?></td>
                    <td><?= htmlspecialchars($booking['duration']) ?> jam</td>
                    <td>Rp <?= number_format($booking['total_price'], 0, ',', '.') ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

</body>
</html>
