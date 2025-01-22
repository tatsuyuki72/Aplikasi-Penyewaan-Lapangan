<?php
session_start();

// Cek apakah pengguna sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Sertakan file koneksi ke database
require_once 'db.php';

// Periksa apakah parameter ID disertakan
if (!isset($_GET['id'])) {
    echo "ID pengguna tidak ditemukan.";
    exit();
}

$id = $_GET['id'];

// Ambil data pengguna berdasarkan ID
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = :id");
$stmt->execute(['id' => $id]);
$user = $stmt->fetch();

if (!$user) {
    echo "Pengguna tidak ditemukan.";
    exit();
}

// Proses pembaruan data
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];

    // Update data pengguna
    $updateStmt = $pdo->prepare("UPDATE users SET name = :name, email = :email WHERE id = :id");
    $updateStmt->execute([
        'name' => $name,
        'email' => $email,
        'id' => $id
    ]);

    // Redirect ke halaman manajemen pengguna
    header("Location: manage_users.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Pengguna</title>
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

        main {
            width: 50%;
            margin: 30px auto;
            background-color: white;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        form {
            display: flex;
            flex-direction: column;
        }

        label {
            margin-bottom: 5px;
            font-weight: bold;
        }

        input[type="text"], input[type="email"] {
            margin-bottom: 15px;
            padding: 10px;
            font-size: 1rem;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        button {
            padding: 10px;
            font-size: 1rem;
            color: white;
            background-color: #007bff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

<header>
    <h1>Edit Pengguna</h1>
</header>

<main>
    <form method="POST">
        <label for="name">Nama Pengguna</label>
        <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($user['name']); ?>" required>

        <label for="email">Email</label>
        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>

        <button type="submit">Simpan Perubahan</button>
    </form>
</main>

</body>
</html>
