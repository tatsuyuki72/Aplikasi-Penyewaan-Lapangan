<?php
session_start();

// Cek apakah pengguna sudah login, jika belum arahkan ke halaman login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Logout jika tombol logout ditekan
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f0f4f8;
            position: relative;
            min-height: 100vh;
        }

        header {
            background-color: #007bff;
            color: white;
            padding: 1.5rem;
            text-align: center;
            border-bottom: 5px solid #0056b3;
        }

        header h1 {
            margin: 0;
            font-size: 2rem;
        }

        header p {
            font-size: 1.1rem;
        }

        main {
            padding: 3rem;
            text-align: center;
            position: relative;
        }

        .content {
            margin-bottom: 100px; /* Space for footer */
        }

        .button-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 20px;
            margin-top: 30px;
        }

        .button-container a {
            display: block;
            padding: 15px 30px;
            background: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 8px;
            font-size: 1.1rem;
            transition: background-color 0.3s;
            width: 250px;
            text-align: center;
        }

        .button-container a:hover {
            background-color: #0056b3;
        }

        .button-container a:active {
            background-color: #003d82;
        }

        .badminton-court-image {
            margin-top: 50px;
            max-width: 100%;
            height: auto;
        }

        footer {
            position: fixed;
            left: 0;
            bottom: 0;
            width: 100%;
            background-color: #f1f1f1;
            text-align: center;
            padding: 1rem;
            font-size: 0.9rem;
        }
    </style>
</head>
<body>

    <header>
        <h1>Dashboard Admin</h1>
        <p>Selamat datang, Admin!</p>
    </header>

    <main>
        <div class="content">
            <div class="button-container">
                <a href="manage_users.php">Kelola Pengguna</a>
                <a href="manage_fields.php">Kelola Lapangan</a>
                <a href="booking_requests.php">Lihat Pemesanan</a>
                <a href="admin_report.php">Laporan</a>
                <a href="?logout=true">Logout</a>
            </div>

        </div>
    </main>

    <footer>
        <p>&copy; 2025 Semua Hak Dilindungi.</p>
    </footer>

</body>
</html>
