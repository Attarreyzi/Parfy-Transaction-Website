<?php
require_once __DIR__ . '/../config/google.php';
$googleClientId = defined('GOOGLE_CLIENT_ID') ? GOOGLE_CLIENT_ID : 'YOUR_GOOGLE_CLIENT_ID.apps.googleusercontent.com';
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | PARFY.ID</title>

    <!-- FONT WEBSITE -->
    <link
        href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    <!-- ICON -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background: radial-gradient(circle at center, #005c97 0%, #0f1029 100%);
            height: 100vh;
            display: flex;
        }

        .container {
            width: 100%;
            display: flex;
            flex-wrap: wrap;
        }

        /* LEFT PANEL */
        .left {
            width: 50%;
            background: white;
            padding: 60px 80px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .title {
            font-size: 45px;
            margin-bottom: 40px;
            font-weight: 700;
            color: #0f1029;
            font-family: 'Playfair Display', serif;
            letter-spacing: 1px;
        }

        .form input {
            width: 100%;
            padding: 18px;
            margin-bottom: 18px;
            border-radius: 12px;
            border: 1px solid #ddd;
            background: #efefef;
            font-size: 15px;
        }

        .form input:focus {
            outline: none;
            background: white;
            border-color: #005c97;
        }

        .remember-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 25px;
            font-size: 14px;
            color: #333;
        }

        .login-btn {
            width: 100%;
            padding: 15px;
            background: #005c97;
            color: white;
            border: none;
            border-radius: 30px;
            font-size: 18px;
            cursor: pointer;
            margin-top: 10px;
            font-weight: 600;
        }

        .login-btn:hover {
            background: #0f1029;
        }

        .error {
            color: red;
            font-size: 14px;
            display: none;
            margin-bottom: 10px;
        }

        /* SOCIAL LOGIN */
        .divider {
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 25px 0 15px;
        }

        .divider span {
            width: 130px;
            height: 1px;
            background: #ccc;
        }

        .divider p {
            margin: 0 10px;
            font-size: 12px;
            color: #777;
        }

        .google-btn-wrapper {
            width: 100%;
            display: flex;
            justify-content: center;
            margin-top: 10px;
        }

        /* RIGHT PANEL */
        .right {
            width: 50%;
            background: transparent;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            color: white;
            padding: 40px;
            text-align: center;
        }

        /* LOGO */
        .logo-parfy {
            width: 160px;
            margin-bottom: 20px;
            filter: drop-shadow(0px 0px 6px rgba(255, 255, 255, 0.4));
        }

        .brand {
            font-size: 55px;
            font-family: 'Playfair Display', serif;
            font-weight: 700;
            letter-spacing: 3px;
        }

        .tagline {
            font-size: 15px;
            margin-top: 5px;
            letter-spacing: 1px;
        }

        .register-btn {
            margin-top: 40px;
            background: white;
            border: none;
            padding: 15px 60px;
            border-radius: 30px;
            font-size: 20px;
            color: #005c97;
            cursor: pointer;
            font-weight: 600;
        }

        .register-btn:hover {
            background: #dcdcdc;
        }

        @media (max-width: 768px) {

            .left,
            .right {
                width: 100%;
            }

            body {
                height: auto;
            }

            .left {
                padding: 40px 25px;
            }
        }
    </style>
    <script src="https://accounts.google.com/gsi/client" async defer></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>

    <div class="container">

        <!-- LEFT PANEL -->
        <div class="left">
            <div style="margin-bottom: 20px;">
                <a href="/coding web IMK/parfy-php/"
                    style="text-decoration: none; color: #555; font-size: 14px; display: flex; align-items: center; gap: 5px;">
                    <i class="fas fa-arrow-left"></i> Kembali ke Beranda
                </a>
            </div>
            <h1 class="title">Login ke PARFY.ID</h1>

            <form class="form" id="loginForm">
                <input type="email" id="email" placeholder="Email" required>
                <input type="password" id="password" placeholder="Password" required>

                <div class="error" id="errorMsg">Email atau password salah!</div>

                <div class="remember-row">
                    <label><input type="checkbox"> Ingat saya</label>
                    <a href="/coding web IMK/parfy-php/forgot-password" style="text-decoration:none;color:#444;">Lupa Password?</a>
                </div>

                <button type="submit" class="login-btn">Login</button>

                <div class="divider">
                    <span></span>
                    <p>atau masuk dengan</p>
                    <span></span>
                </div>

                <!-- Element Resmi Google Sign-In -->
                <div id="g_id_onload"
                     data-client_id="<?= htmlspecialchars($googleClientId) ?>"
                     data-callback="handleGoogleLogin"
                     data-auto_prompt="true">
                </div>

                <div class="google-btn-wrapper">
                    <div class="g_id_signin"
                         data-type="standard"
                         data-size="large"
                         data-theme="outline"
                         data-text="sign_in_with"
                         data-shape="pill"
                         data-logo_alignment="left"
                         data-width="320">
                    </div>
                </div>

            </form>
        </div>

        <!-- RIGHT PANEL -->
        <div class="right">

            <!-- LOGO DI ATAS TULISAN -->
            <img src="/coding web IMK/parfy-php/assets/logo_parfum_bk.png" alt="PARFY.ID Logo" class="logo-parfy">

            <h1 class="brand">PARFY.ID</h1>
            <p class="tagline">PREMIUM PERFUME STORE</p>

            <button class="register-btn" onclick="window.location.href = '/coding web IMK/parfy-php/register'">Register</button>
        </div>

    </div>

    <script>
        const googleClientId = <?= json_encode($googleClientId) ?>;

        document.getElementById('loginForm').addEventListener('submit', async function (e) {
            e.preventDefault();

            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;
            const errorMsg = document.getElementById('errorMsg');
            const loginBtn = document.querySelector('.login-btn');

            // Disable button while loading
            loginBtn.disabled = true;
            loginBtn.textContent = 'Loading...';
            errorMsg.style.display = 'none';

            try {
                const response = await fetch('/coding web IMK/parfy-php/api/auth/login.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ email, password })
                });

                const data = await response.json();

                if (response.ok) {
                    localStorage.setItem('parfy_token', data.token);
                    localStorage.setItem('parfy_user', JSON.stringify(data.user));

                    if (data.user.role === 'admin') {
                        window.location.href = '/coding web IMK/parfy-php/admin/dashboard.php';
                    } else {
                        window.location.href = '/coding web IMK/parfy-php/dashboard';
                    }
                } else {
                    errorMsg.textContent = data.error || 'Login gagal!';
                    errorMsg.style.display = 'block';
                }
            } catch (err) {
                errorMsg.textContent = 'Terjadi kesalahan. Coba lagi.';
                errorMsg.style.display = 'block';
            } finally {
                loginBtn.disabled = false;
                loginBtn.textContent = 'Login';
            }
        });

        // Google Sign-In Callback Handler (Resmi dari Google SDK)
        async function handleGoogleLogin(response) {
            if (!response || !response.credential) return;

            const errorMsg = document.getElementById('errorMsg');
            errorMsg.style.display = 'none';

            try {
                const res = await fetch('/coding web IMK/parfy-php/api/auth/google.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ credential: response.credential })
                });

                const data = await res.json();

                if (res.ok) {
                    localStorage.setItem('parfy_token', data.token);
                    localStorage.setItem('parfy_user', JSON.stringify(data.user));

                    if (data.user.role === 'admin') {
                        window.location.href = '/coding web IMK/parfy-php/admin/dashboard.php';
                    } else {
                        window.location.href = '/coding web IMK/parfy-php/dashboard';
                    }
                } else {
                    errorMsg.textContent = data.error || 'Login Google gagal!';
                    errorMsg.style.display = 'block';
                }
            } catch (err) {
                errorMsg.textContent = 'Terjadi kesalahan sistem.';
                errorMsg.style.display = 'block';
            }
        }
    </script>

</body>

</html>
