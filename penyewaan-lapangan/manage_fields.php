<?php
session_start();

// Cek apakah pengguna sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Sertakan file koneksi ke database
require_once 'db.php';

// Ambil data lapangan dari database
$stmt = $pdo->query("SELECT * FROM fields");
$fields = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Lapangan</title>
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
            width: 80%;
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
    <h1>Kelola Lapangan</h1>
</header>

<main>
    <table>
        <thead>
            <tr>
                <th>ID Lapangan</th>
                <th>Nama Lapangan</th>
                <th>Harga Sewa (Rp)</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($fields as $field): ?>
                <tr>
                    <td><?php echo htmlspecialchars($field['id']); ?></td>
                    <td><?php echo htmlspecialchars($field['name']); ?></td>
                    <td><?php echo htmlspecialchars(number_format($field['price'], 0, ',', '.')); ?></td>
                    <td><?php echo htmlspecialchars($field['status']); ?></td>
                    <td>
                        <a href="edit_field.php?id=<?php echo $field['id']; ?>">Edit</a> 
                        
                    </td>
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
