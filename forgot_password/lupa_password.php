<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/../config/database.php';

$conn = getDB();
$error = "";
$success = "";

if (isset($_POST['check_email'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $q = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");

    if (mysqli_num_rows($q) > 0) {
        $user = mysqli_fetch_assoc($q);
        
        // Generate 6 digit OTP
        $otp = sprintf("%06d", mt_rand(1, 999999));
        
        // Update to DB
        mysqli_query($conn, "UPDATE users SET reset_token='$otp', reset_expires=DATE_ADD(NOW(), INTERVAL 15 MINUTE) WHERE email='$email'");

        // Send Email
        require_once __DIR__ . '/../libs/PHPMailer/src/Exception.php';
        require_once __DIR__ . '/../libs/PHPMailer/src/PHPMailer.php';
        require_once __DIR__ . '/../libs/PHPMailer/src/SMTP.php';
        require_once __DIR__ . '/../config/mail.php';

        $mail = new PHPMailer\PHPMailer\PHPMailer(true);

        try {
            //Server settings
            $mail->isSMTP();
            $mail->Host       = SMTP_HOST;
            $mail->SMTPAuth   = true;
            $mail->Username   = SMTP_USER;
            $mail->Password   = SMTP_PASS;
            $mail->SMTPSecure = PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = SMTP_PORT;

            //Recipients
            $mail->setFrom(SMTP_FROM_EMAIL, SMTP_FROM_NAME);
            $mail->addAddress($email, $user['name']);

            //Content
            $mail->isHTML(true);
            $mail->Subject = 'Kode OTP Reset Password PARFY.ID';
            $mail->Body    = "Halo {$user['name']},<br><br>Kode OTP Anda untuk mereset password adalah: <b>{$otp}</b><br><br>Kode ini berlaku selama 15 menit. JANGAN BERIKAN KODE INI KEPADA SIAPAPUN.<br><br>Salam,<br>Tim PARFY.ID";

            $mail->send();
            
            // Redirect to verify OTP
            header("Location: /coding web IMK/parfy-php/verify-otp?email=" . urlencode($email));
            exit;
        } catch (Exception $e) {
            $error = "Gagal mengirim email OTP. Silakan periksa konfigurasi SMTP Anda.";
        }
    } else {
        $error = "Email tidak ditemukan!";
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Password | PARFY.ID</title>
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

        .back-link {
            display: block;
            margin-top: 20px;
            font-size: 14px;
            color: #555;
            text-decoration: none;
        }

        .error {
            color: red;
            margin-bottom: 15px;
            font-size: 14px;
        }
    </style>
</head>

<body>

    <div class="card">
        <h1 class="title">Lupa Password?</h1>
        <p class="subtitle">Masukkan email Anda untuk mereset kata sandi.</p>

        <?php if ($error)
            echo "<div class='error'>$error</div>"; ?>

        <form method="POST">
            <input type="email" name="email" placeholder="Masukkan Email Anda" required>
            <button type="submit" name="check_email">Reset Password</button>
        </form>

        <a href="/coding web IMK/parfy-php/login" class="back-link">Kembali ke Login</a>
    </div>

</body>

</html>