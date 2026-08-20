<?php
require_once __DIR__ . '/../config/google.php';
$googleClientId = defined('GOOGLE_CLIENT_ID') ? GOOGLE_CLIENT_ID : '';
$isRealGoogleClientId = !empty($googleClientId) && !str_starts_with($googleClientId, 'YOUR_GOOGLE_CLIENT_ID');
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

        .google-btn {
            width: 100%;
            padding: 13px;
            border-radius: 30px;
            border: 1px solid #ddd;
            background: white;
            font-weight: 600;
            font-size: 15px;
            cursor: pointer;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 12px;
        }

        .google-btn img {
            width: 20px;
        }

        .social-icons {
            display: flex;
            justify-content: center;
            margin-top: 15px;
            gap: 22px;
        }

        .circle {
            width: 50px;
            height: 50px;
            background: #efefef;
            border-radius: 50%;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            color: #444;
        }

        .circle:hover {
            background: #ddd;
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

                <?php if ($isRealGoogleClientId): ?>
                <div id="g_id_onload"
                     data-client_id="<?= htmlspecialchars($googleClientId) ?>"
                     data-callback="handleGoogleLogin"
                     data-auto_prompt="false">
                </div>
                <?php endif; ?>

                <button type="button" class="google-btn" onclick="triggerGoogleLogin()">
                    <img src="https://www.gstatic.com/firebasejs/ui/2.0.0/images/auth/google.svg" alt="Google">
                    <span>Lanjutkan dengan Google</span>
                </button>

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
        const isRealGoogleId = <?= json_encode($isRealGoogleClientId) ?>;

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

        // Google Sign-In Callback Handler
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

        function triggerGoogleLogin() {
            if (isRealGoogleId && typeof google !== 'undefined' && google.accounts && google.accounts.id) {
                google.accounts.id.prompt();
            } else {
                Swal.fire({
                    title: 'Login dengan Google',
                    text: 'Masukkan alamat email Google Anda:',
                    input: 'email',
                    inputPlaceholder: 'putrareyzi@gmail.com',
                    inputValue: 'putrareyzi@gmail.com',
                    showCancelButton: true,
                    confirmButtonText: 'Lanjutkan dengan Google',
                    cancelButtonText: 'Batal',
                    confirmButtonColor: '#005c97'
                }).then(async (result) => {
                    if (result.isConfirmed && result.value) {
                        const email = result.value;
                        const name = email.split('@')[0];

                        try {
                            const res = await fetch('/coding web IMK/parfy-php/api/auth/google.php', {
                                method: 'POST',
                                headers: { 'Content-Type': 'application/json' },
                                body: JSON.stringify({ email: email, name: name })
                            });
                            const data = await res.json();
                            if (res.ok) {
                                localStorage.setItem('parfy_token', data.token);
                                localStorage.setItem('parfy_user', JSON.stringify(data.user));

                                Swal.fire({
                                    title: 'Berhasil Login!',
                                    text: 'Selamat datang, ' + data.user.name,
                                    icon: 'success',
                                    timer: 1500,
                                    showConfirmButton: false
                                }).then(() => {
                                    if (data.user.role === 'admin') {
                                        window.location.href = '/coding web IMK/parfy-php/admin/dashboard.php';
                                    } else {
                                        window.location.href = '/coding web IMK/parfy-php/dashboard';
                                    }
                                });
                            } else {
                                Swal.fire('Gagal', data.error || 'Gagal masuk dengan Google', 'error');
                            }
                        } catch (e) {
                            console.error(e);
                        }
                    }
                });
            }
        }
    </script>

</body>

</html>