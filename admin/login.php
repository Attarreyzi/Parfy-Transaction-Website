<?php require_once __DIR__ . '/../config/database.php'; ?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin | PARFY.ID</title>

    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background: linear-gradient(135deg, #0d3256 0%, #08091a 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .container {
            width: 100%;
            max-width: 950px;
            min-height: 540px;
            background: #ffffff;
            border-radius: 24px;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.4);
            display: flex;
            overflow: hidden;
        }

        /* LEFT PANEL */
        .left {
            width: 50%;
            padding: 50px 45px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            background: #ffffff;
        }

        .left-header {
            margin-bottom: 25px;
        }

        .left-header a {
            text-decoration: none;
            color: #666;
            font-size: 13px;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            margin-bottom: 15px;
            transition: color 0.2s;
        }

        .left-header a:hover {
            color: #005c97;
        }

        .title {
            font-size: 28px;
            font-weight: 700;
            color: #0d3256;
            letter-spacing: -0.5px;
        }

        .subtitle {
            font-size: 13px;
            color: #777;
            margin-top: 4px;
        }

        .form {
            margin-top: 10px;
        }

        .input-group {
            margin-bottom: 18px;
            position: relative;
        }

        .input-group label {
            display: block;
            font-size: 13px;
            font-weight: 500;
            color: #444;
            margin-bottom: 8px;
        }

        .input-wrapper {
            position: relative;
        }

        .input-wrapper i {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: #999;
            font-size: 15px;
        }

        .form input {
            width: 100%;
            padding: 14px 16px 14px 44px;
            border-radius: 12px;
            border: 1px solid #ddd;
            background: #f8f9fa;
            font-size: 14px;
            color: #333;
            transition: all 0.3s;
        }

        .form input:focus {
            outline: none;
            background: #ffffff;
            border-color: #005c97;
            box-shadow: 0 0 0 4px rgba(0, 92, 151, 0.1);
        }

        .remember-row {
            display: flex;
            align-items: center;
            margin-bottom: 22px;
            font-size: 14px;
            color: #555;
        }

        .remember-row label {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            cursor: pointer;
            white-space: nowrap;
            user-select: none;
        }

        .remember-row input[type="checkbox"] {
            width: 18px;
            height: 18px;
            accent-color: #005c97;
            cursor: pointer;
            margin: 0;
            flex-shrink: 0;
        }

        .login-btn {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, #005c97, #36d1dc);
            color: white;
            border: none;
            border-radius: 30px;
            font-size: 16px;
            cursor: pointer;
            font-weight: 600;
            transition: transform 0.2s, box-shadow 0.2s;
            box-shadow: 0 6px 18px rgba(0, 92, 151, 0.3);
        }

        .login-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 92, 151, 0.4);
        }

        .login-btn:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none;
        }

        .error {
            background: #fff0f1;
            border: 1px solid #ffccd0;
            color: #dc3545;
            padding: 10px 14px;
            border-radius: 10px;
            font-size: 13px;
            display: none;
            margin-bottom: 15px;
        }

        /* RIGHT PANEL */
        .right {
            width: 50%;
            background: linear-gradient(135deg, #0d3256 0%, #08091a 100%);
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            color: white;
            padding: 40px;
            text-align: center;
            position: relative;
        }

        .logo-parfy {
            width: 130px;
            margin-bottom: 20px;
            filter: drop-shadow(0px 4px 10px rgba(0, 0, 0, 0.5));
        }

        .brand {
            font-size: 42px;
            font-family: 'Playfair Display', serif;
            font-weight: 700;
            letter-spacing: 3px;
        }

        .tagline {
            font-size: 13px;
            margin-top: 6px;
            letter-spacing: 2px;
            opacity: 0.85;
            text-transform: uppercase;
        }

        .admin-badge {
            margin-top: 30px;
            background: rgba(255, 255, 255, 0.12);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            padding: 8px 22px;
            border-radius: 20px;
            font-size: 12px;
            letter-spacing: 1px;
            font-weight: 500;
            color: #82c4e4;
        }

        @media (max-width: 768px) {
            .container {
                flex-direction: column-reverse;
                max-width: 450px;
            }
            .left, .right {
                width: 100%;
            }
            .right {
                padding: 35px 20px;
            }
            .left {
                padding: 35px 25px;
            }
        }
    </style>
</head>

<body>

    <div class="container">

        <!-- LEFT PANEL -->
        <div class="left">
            <div class="left-header">
                <h1 class="title">Login Admin</h1>
                <p class="subtitle">Silakan login untuk melanjutkan</p>
            </div>

            <div class="error" id="errorMsg">Email atau password salah!</div>

            <form class="form" id="adminLoginForm">
                <div class="input-group">
                    <label for="email">Email Admin</label>
                    <div class="input-wrapper">
                        <i class="fa-solid fa-envelope"></i>
                        <input type="email" id="email" placeholder="admin@parfy.id" required autocomplete="username">
                    </div>
                </div>

                <div class="input-group">
                    <label for="password">Password</label>
                    <div class="input-wrapper">
                        <i class="fa-solid fa-lock"></i>
                        <input type="password" id="password" placeholder="••••••••" required autocomplete="current-password">
                    </div>
                </div>

                <div class="remember-row">
                    <label><input type="checkbox" checked> Ingat Saya</label>
                </div>

                <button type="submit" class="login-btn" id="btnLogin">Login Admin</button>
            </form>
        </div>

        <!-- RIGHT PANEL -->
        <div class="right">
            <img src="<?php echo url('/assets/logo_parfum_bk.png'); ?>" alt="PARFY.ID Logo" class="logo-parfy" onerror="this.onerror=null; this.src='<?php echo url('/assets/default.jpg'); ?>';">
            <h1 class="brand">PARFY.ID</h1>
            <p class="tagline">PREMIUM PERFUME STORE</p>
            <div class="admin-badge">
                <i class="fa-solid fa-user-shield me-1"></i> PORTAL ADMINISTRATOR
            </div>
        </div>

    </div>

    <script>
        const BASE_PATH = window.location.pathname.includes('/parfy-php') 
            ? window.location.pathname.substring(0, window.location.pathname.indexOf('/parfy-php') + 10) 
            : '';

        document.getElementById('adminLoginForm').addEventListener('submit', async function (e) {
            e.preventDefault();

            const email = document.getElementById('email').value.trim();
            const password = document.getElementById('password').value;
            const errorMsg = document.getElementById('errorMsg');
            const loginBtn = document.getElementById('btnLogin');

            errorMsg.style.display = 'none';
            loginBtn.disabled = true;
            loginBtn.innerHTML = '<i class="fa-solid fa-circle-notch fa-spin me-2"></i> Memverifikasi...';

            try {
                const response = await fetch(BASE_PATH + '/api/auth/admin-login.php', {
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

                    Swal.fire({
                        title: 'Akses Diberikan!',
                        text: 'Selamat datang di Portal Admin, ' + data.user.name,
                        icon: 'success',
                        timer: 1200,
                        showConfirmButton: false,
                        background: '#0d3256',
                        color: '#ffffff'
                    }).then(() => {
                        window.location.href = BASE_PATH + '/admin/dashboard.php';
                    });
                } else {
                    errorMsg.textContent = data.error || 'Akses ditolak!';
                    errorMsg.style.display = 'block';
                }
            } catch (err) {
                errorMsg.textContent = 'Terjadi kesalahan koneksi server.';
                errorMsg.style.display = 'block';
            } finally {
                loginBtn.disabled = false;
                loginBtn.textContent = 'Login Admin';
            }
        });
    </script>

</body>

</html>
