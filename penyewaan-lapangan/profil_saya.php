<?php
session_start();
require_once 'db.php';

// Pastikan pengguna sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php?error=Anda harus login terlebih dahulu.");
    exit();
}

$user_id = $_SESSION['user_id'];

// Ambil data pengguna dari database
try {
    $stmt = $pdo->prepare("SELECT * FROM users WHERE id = :id");
    $stmt->execute(['id' => $user_id]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        die("Pengguna tidak ditemukan.");
    }
} catch (PDOException $e) {
    die("Terjadi kesalahan: " . $e->getMessage());
}

// Perbarui data pengguna
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = !empty($_POST['password']) ? password_hash($_POST['password'], PASSWORD_DEFAULT) : $user['password'];

    try {
        $stmt = $pdo->prepare("
            UPDATE users 
            SET name = :name, email = :email, password = :password 
            WHERE id = :id
        ");
        $stmt->execute([
            'name' => $name,
            'email' => $email,
            'password' => $password,
            'id' => $user_id
        ]);

        $user['name'] = $name;
        $user['email'] = $email;

        $success_message = "Profil berhasil diperbarui.";
    } catch (PDOException $e) {
        $error_message = "Terjadi kesalahan: " . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Saya</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            background: #f9f9f9;
            color: #333;
        }
        .profile-container {
            max-width: 700px;
            margin: 50px auto;
            background: white;
            border-radius: 10px;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        .profile-header {
            background: #bde0fe;
            padding: 20px;
            text-align: center;
            color: #333;
        }
        .profile-header h1 {
            font-size: 1.8rem;
            margin: 0;
        }
        .profile-header p {
            margin: 5px 0;
            font-size: 0.9rem;
            opacity: 0.8;
        }
        .profile-body {
            padding: 20px;
        }
        .profile-body label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        .profile-body input {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .profile-body button {
            display: inline-block;
            padding: 10px 15px;
            background: #bde0fe;
            color: #333;
            border: none;
            font-size: 1rem;
            border-radius: 5px;
            cursor: pointer;
            transition: 0.3s;
        }
        .profile-body button:hover {
            background: #a2d2ff;
        }
        .nav-buttons {
            display: flex;
            justify-content: space-between;
            padding: 20px;
            background: #f9f9f9;
        }
        .nav-button {
            padding: 10px 15px;
            color: white;
            text-decoration: none;
            border: none;
            font-size: 1rem;
            border-radius: 5px;
            transition: 0.3s;
        }
        .nav-button-green {
            background: #28a745;
        }
        .nav-button-green:hover {
            background: #218838;
        }
        .nav-button-red {
            background: #dc3545;
        }
        .nav-button-red:hover {
            background: #c82333;
        }
        .page-title {
            text-align: center;
            margin: 20px 0;
            font-size: 1.6rem;
            color: #555;
        }
        .message {
            text-align: center;
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 5px;
            font-size: 0.9rem;
        }
        .success {
            background-color: #d4edda;
            color: #155724;
        }
        .error {
            background-color: #f8d7da;
            color: #721c24;
        }
    </style>
</head>
<body>
    <div class="profile-header">
        <h1>Profil Saya</h1>
    </div>

    <div class="profile-container">
        <div class="profile-body">
            <?php if (isset($success_message)): ?>
                <div class="message success"><?= htmlspecialchars($success_message); ?></div>
            <?php elseif (isset($error_message)): ?>
                <div class="message error"><?= htmlspecialchars($error_message); ?></div>
            <?php endif; ?>

            <form method="POST">
                <label for="name">Nama</label>
                <input type="text" id="name" name="name" value="<?= htmlspecialchars($user['name']); ?>" required>

                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="<?= htmlspecialchars($user['email']); ?>" required>

                <label for="password">Password Baru (Opsional)</label>
                <input type="password" id="password" name="password" placeholder="Isi jika ingin mengganti password.">

                <button type="submit">Perbarui Profil</button>
            </form>
        </div>
    </div>

    <div class="nav-buttons">
        <a href="user_dashboard.php" class="nav-button nav-button-green">Kembali ke Dashboard</a>
        <a href="logout.php" class="nav-button nav-button-red">Logout</a>
    </div>
</body>
</html>
