<?php
session_start();

// Cek apakah pengguna sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Sertakan file koneksi ke database
require_once 'db.php';

// Cek apakah ID ada di URL
if (!isset($_GET['id'])) {
    header("Location: manage_fields.php");
    exit();
}

$field_id = $_GET['id'];

// Ambil data lapangan berdasarkan ID
$stmt = $pdo->prepare("SELECT * FROM fields WHERE id = ?");
$stmt->execute([$field_id]);
$field = $stmt->fetch();

// Jika data lapangan tidak ditemukan
if (!$field) {
    header("Location: manage_fields.php");
    exit();
}

// Proses form jika disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $status = $_POST['status'];

    // Update data lapangan
    $stmt = $pdo->prepare("UPDATE fields SET name = ?, price = ?, status = ? WHERE id = ?");
    $stmt->execute([$name, $price, $status, $field_id]);

    // Redirect kembali ke halaman manage_fields.php
    header("Location: manage_fields.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Lapangan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f4f8;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 50%;
            margin: 50px auto;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        label {
            margin-bottom: 5px;
            font-weight: bold;
        }

        input, select {
            margin-bottom: 15px;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        button {
            padding: 10px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background-color: #0056b3;
        }

        a {
            display: block;
            text-align: center;
            margin-top: 20px;
            color: #007bff;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Edit Lapangan</h1>
    <form method="POST">
        <label for="name">Nama Lapangan:</label>
        <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($field['name']); ?>" required>

        <label for="price">Harga (Rp):</label>
        <input type="number" id="price" name="price" value="<?php echo htmlspecialchars($field['price']); ?>" required>

        <label for="status">Status:</label>
        <select id="status" name="status">
            <option value="Tersedia" <?php echo $field['status'] === 'Tersedia' ? 'selected' : ''; ?>>Tersedia</option>
            <option value="Tidak Tersedia" <?php echo $field['status'] === 'Tidak Tersedia' ? 'selected' : ''; ?>>Tidak Tersedia</option>
        </select>

        <button type="submit">Simpan Perubahan</button>
    </form>
    <a href="manage_fields.php">Kembali ke Kelola Lapangan</a>
</div>

</body>
</html>
