<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Portal | PARFY.ID</title>

    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background: radial-gradient(circle at center, #0d3256 0%, #08091a 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .admin-card {
            width: 100%;
            max-width: 440px;
            background: rgba(255, 255, 255, 0.07);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.15);
            border-radius: 24px;
            padding: 40px 35px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.4);
            color: white;
        }

        .brand-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .brand-header img {
            height: 70px;
            margin-bottom: 12px;
            filter: drop-shadow(0 4px 8px rgba(0, 0, 0, 0.3));
        }

        .brand-header h1 {
            font-family: 'Playfair Display', serif;
            font-size: 26px;
            letter-spacing: 2px;
            font-weight: 700;
        }

        .brand-header p {
            font-size: 12px;
            opacity: 0.7;
            letter-spacing: 1px;
            text-transform: uppercase;
            margin-top: 4px;
        }

        .form-group {
            margin-bottom: 20px;
            position: relative;
        }

        .form-group label {
            font-size: 13px;
            margin-bottom: 8px;
            display: block;
            opacity: 0.9;
            font-weight: 500;
        }

        .input-box {
            position: relative;
        }

        .input-box i {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: rgba(255, 255, 255, 0.5);
            font-size: 16px;
        }

        .input-box input {
            width: 100%;
            padding: 14px 16px 14px 45px;
            background: rgba(255, 255, 255, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 12px;
            color: white;
            font-size: 14px;
            outline: none;
            transition: all 0.3s ease;
        }

        .input-box input:focus {
            border-color: #82c4e4;
            background: rgba(255, 255, 255, 0.12);
            box-shadow: 0 0 12px rgba(130, 196, 228, 0.3);
        }

        .input-box input::placeholder {
            color: rgba(255, 255, 255, 0.4);
        }

        .error-alert {
            background: rgba(220, 53, 69, 0.2);
            border: 1px solid rgba(220, 53, 69, 0.5);
            color: #ff8d96;
            padding: 12px 15px;
            border-radius: 10px;
            font-size: 13px;
            margin-bottom: 20px;
            display: none;
        }

        .btn-admin-login {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, #005c97, #36d1dc);
            border: none;
            border-radius: 30px;
            color: white;
            font-weight: 600;
            font-size: 15px;
            cursor: pointer;
            transition: transform 0.2s, box-shadow 0.2s;
            margin-top: 10px;
        }

        .btn-admin-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(0, 92, 151, 0.4);
        }

        .btn-admin-login:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }

        .footer-note {
            text-align: center;
            margin-top: 25px;
            font-size: 12px;
            opacity: 0.5;
        }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>

    <div class="admin-card">
        <div class="brand-header">
            <img src="/coding web IMK/parfy-php/assets/logo_parfum_bk.png" alt="PARFY.ID Logo">
            <h1>PARFY.ID</h1>
            <p>Portal Otentikasi Administrator</p>
        </div>

        <div class="error-alert" id="errorAlert"></div>

        <form id="adminLoginForm">
            <div class="form-group">
                <label for="email">Email Administrator</label>
                <div class="input-box">
                    <i class="bi bi-shield-lock"></i>
                    <input type="email" id="email" placeholder="admin@parfy.id" required autocomplete="username">
                </div>
            </div>

            <div class="form-group">
                <label for="password">Kata Sandi</label>
                <div class="input-box">
                    <i class="bi bi-key"></i>
                    <input type="password" id="password" placeholder="••••••••" required autocomplete="current-password">
                </div>
            </div>

            <button type="submit" class="btn-admin-login" id="btnLogin">
                Masuk Portal Admin
            </button>
        </form>

        <div class="footer-note">
            Sistem Keamanan Terisolasi &copy; 2024 PARFY.ID
        </div>
    </div>

    <script>
        document.getElementById('adminLoginForm').addEventListener('submit', async function (e) {
            e.preventDefault();

            const email = document.getElementById('email').value.trim();
            const password = document.getElementById('password').value;
            const errorAlert = document.getElementById('errorAlert');
            const btnLogin = document.getElementById('btnLogin');

            errorAlert.style.display = 'none';
            btnLogin.disabled = true;
            btnLogin.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span> Memverifikasi...';

            try {
                const response = await fetch('/coding web IMK/parfy-php/api/auth/admin-login.php', {
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
                        window.location.href = '/coding web IMK/parfy-php/admin/dashboard.php';
                    });
                } else {
                    errorAlert.textContent = data.error || 'Akses ditolak!';
                    errorAlert.style.display = 'block';
                }
            } catch (error) {
                errorAlert.textContent = 'Terjadi kesalahan koneksi server.';
                errorAlert.style.display = 'block';
            } finally {
                btnLogin.disabled = false;
                btnLogin.textContent = 'Masuk Portal Admin';
            }
        });
    </script>

</body>

</html>
