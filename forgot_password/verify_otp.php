<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/../config/database.php';

$conn = getDB();
$error = "";
$success = "";
$email = $_GET['email'] ?? '';

if (empty($email)) {
    header("Location: /coding web IMK/parfy-php/login");
    exit;
}

if (isset($_POST['verify_otp'])) {
    $otp = mysqli_real_escape_string($conn, $_POST['otp']);
    
    $q = mysqli_query($conn, "SELECT * FROM users WHERE email='$email' AND reset_token='$otp' AND reset_expires > NOW()");
    
    if (mysqli_num_rows($q) > 0) {
        // OTP Valid, arahkan ke halaman ubah password
        header("Location: /coding web IMK/parfy-php/reset-password?email=" . urlencode($email) . "&token=" . urlencode($otp));
        exit;
    } else {
        $error = "Kode OTP tidak valid atau sudah kadaluarsa!";
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi OTP | PARFY.ID</title>
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
            margin: 0;
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
            margin-bottom: 10px;
            color: #0f1029;
        }

        .subtitle {
            font-size: 14px;
            color: #666;
            margin-bottom: 30px;
        }

        input {
            width: 100%;
            padding: 15px;
            border-radius: 10px;
            border: 1px solid #ddd;
            background: #f9f9f9;
            margin-bottom: 20px;
            font-size: 15px;
            text-align: center;
            letter-spacing: 5px;
            font-weight: bold;
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
        }
    </style>
</head>

<body>

    <div class="card">
        <h2 class="title">Verifikasi OTP</h2>
        <p class="subtitle">Kami telah mengirimkan 6 digit kode OTP ke email <b><?= htmlspecialchars($email) ?></b>. Masukkan kode tersebut di bawah ini.</p>

        <?php if ($error): ?>
            <p class="error"><?= $error ?></p>
        <?php endif; ?>
        
        <?php if ($success): ?>
            <p class="success"><?= $success ?></p>
        <?php endif; ?>

        <form method="POST" action="">
            <input type="text" name="otp" placeholder="XXXXXX" required maxlength="6" pattern="\d{6}" title="Masukkan 6 digit angka OTP">
            <button type="submit" name="verify_otp">Verifikasi</button>
        </form>
    </div>

</body>

</html>
