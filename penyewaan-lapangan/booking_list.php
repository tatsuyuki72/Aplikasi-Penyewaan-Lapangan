<?php
// Mulai session untuk memeriksa status login
session_start();

// Jika belum login, arahkan ke halaman login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Data lapangan (diambil dari database)
$fields = [
    ['id' => 1, 'name' => 'Lapangan A', 'price' => 100000],
    ['id' => 2, 'name' => 'Lapangan B', 'price' => 120000],

];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Lapangan - Penyewaan Lapangan</title>
</head>
<body>
    <h2>Daftar Lapangan</h2>
    <table>
        <thead>
            <tr>
                <th>Nama Lapangan</th>
                <th>Harga</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($fields as $field): ?>
                <tr>
                    <td><?php echo $field['name']; ?></td>
                    <td>Rp <?php echo number_format($field['price'], 0, ',', '.'); ?></td>
                    <td><a href="booking_create.php?field_id=<?php echo $field['id']; ?>">Pesan</a></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>