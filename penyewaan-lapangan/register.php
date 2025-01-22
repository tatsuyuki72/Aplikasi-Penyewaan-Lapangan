<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; padding: 0; background-color: #f5f5f5; }
        form { width: 300px; margin: 100px auto; padding: 20px; border: 1px solid #ddd; border-radius: 5px; background: #fff; }
        input { width: 100%; padding: 10px; margin-bottom: 10px; }
        button { width: 100%; padding: 10px; background: #007bff; color: #fff; border: none; border-radius: 5px; }
        button:hover { background: #0056b3; }
    </style>
</head>
<body>
    <form action="process_register.php" method="POST">
        <h2>Register</h2>
        <input type="text" name="name" placeholder="Nama Lengkap" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Daftar</button>
    </form>
</body>
</html>
