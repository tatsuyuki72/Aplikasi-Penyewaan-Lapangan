<?php
require_once 'db.php';

// Ambil data pemesanan dari database
$stmt = $pdo->query("
    SELECT 
        bookings.id, 
        bookings.user_id, 
        bookings.field_id, 
        bookings.booking_date, 
        bookings.start_time, 
        bookings.duration, 
        bookings.created_at, 
        users.name AS user_name 
    FROM 
        bookings
    JOIN 
        users ON bookings.user_id = users.id
");

$bookings = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lihat Pemesanan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f4f8;
            margin: 0;
            padding: 0;
        }

        header {
            background-color: #007bff;
            color: white;
            padding: 1.5rem;
            text-align: center;
        }

        table {
            width: 90%;
            margin: 30px auto;
            border-collapse: collapse;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #007bff;
            color: white;
        }

        .button-container {
            text-align: center;
            margin-top: 20px;
        }

        .button-container a {
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }

        .button-container a:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

<header>
    <h1>Lihat Pemesanan</h1>
</header>

<main>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>User</th>
                <th>Lapangan</th>
                <th>Tanggal Pemesanan</th>
                <th>Waktu Mulai</th>
                <th>Durasi (jam)</th>
                <th>Waktu Dibuat</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($bookings as $booking): ?>
                <tr>
                    <td><?= htmlspecialchars($booking['id']) ?></td>
                    <td><?= htmlspecialchars($booking['user_name']) ?></td>
                    <td><?= htmlspecialchars($booking['field_id']) ?></td>
                    <td><?= htmlspecialchars($booking['booking_date']) ?></td>
                    <td><?= htmlspecialchars($booking['start_time']) ?></td>
                    <td><?= htmlspecialchars($booking['duration']) ?></td>
                    <td><?= htmlspecialchars($booking['created_at']) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div class="button-container">
    <a href="admin_dashboard.php" style="margin-left: 10px; background-color: #28a745;">Kembali ke Dashboard</a>
    </div>
</main>

</body>
</html>
