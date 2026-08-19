<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/../config/database.php';

$conn = getDB();
$error = "";
$success = "";
$email = $_GET['email'] ?? '';
$token = $_GET['token'] ?? '';

if (empty($email) || empty($token)) {
    header("Location: /coding web IMK/parfy-php/login");
    exit;
}

if (isset($_POST['reset_password'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $token = mysqli_real_escape_string($conn, $_POST['token']);
    $pass1 = $_POST['pass1'];
    $pass2 = $_POST['pass2'];

    if ($pass1 !== $pass2) {
        $error = "Password tidak sama!";
    } else {
        // Validate token again before reset
        $q = mysqli_query($conn, "SELECT * FROM users WHERE email='$email' AND reset_token='$token' AND reset_expires > NOW()");
        if (mysqli_num_rows($q) > 0) {
            $new_password = password_hash($pass1, PASSWORD_DEFAULT);
            $update = mysqli_query($conn, "UPDATE users SET password='$new_password', reset_token=NULL, reset_expires=NULL WHERE email='$email'");

            if ($update) {
                $success = "Password berhasil diubah! Silakan login.";
            } else {
                $error = "Gagal mengubah password!";
            }
        } else {
            $error = "Kode OTP tidak valid atau sudah kadaluarsa. Silakan request ulang.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password | PARFY.ID</title>
    <link
        href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <style>
        body {
            background: radial-gradient(circle at center, #005c97 0%, #0f1029 100%);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: 'Poppins', sans-serif;
        }

        .card {
            background: white;
            padding: 40px;
            border-radius: 20px;
            width: 100%;
            max-width: 450px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
            text-align: center;
        }

        .title {
            font-family: 'Playfair Display', serif;
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 20px;
            color: #0f1029;
        }

        input {
            width: 100%;
            padding: 15px;
            border-radius: 10px;
            border: 1px solid #ddd;
            background: #f9f9f9;
            margin-bottom: 20px;
            font-size: 15px;
        }

        button {
            width: 100%;
            padding: 15px;
            background: #005c97;
            color: white;
            border: none;
            border-radius: 30px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: 0.3s;
        }

        button:hover {
            background: #0f1029;
        }

        .error {
            color: red;
            margin-bottom: 15px;
            font-size: 14px;
        }

        .success {
            color: green;
            margin-bottom: 15px;
            font-size: 14px;
            font-weight: bold;
        }
    </style>
</head>

<body>

    <div class="card">
        <h1 class="title">Reset Password</h1>

        <?php if ($error)
            echo "<div class='error'>$error</div>"; ?>
        <?php if ($success) {
            echo "<div class='success'>$success</div>";
            echo "<a href='/coding web IMK/parfy-php/login' style='display:block;margin-top:20px;text-decoration:none;color:#005c97;font-weight:600;'>Login Sekarang -></a>";
        } else { ?>

            <form method="POST">
                <input type="hidden" name="email" value="<?= htmlspecialchars($email) ?>">
                <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">
                
                <input type="password" name="pass1" placeholder="Masukkan Password Baru" required minlength="6">
                <input type="password" name="pass2" placeholder="Ulangi Password Baru" required minlength="6">
                
                <button type="submit" name="reset_password">Simpan Password Baru</button>
            </form>

        <?php } ?>
    </div>

</body>

</html>