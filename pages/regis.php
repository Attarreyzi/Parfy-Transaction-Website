<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register | PARFY.ID</title>

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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>

    <div class="container">

        <!-- LEFT PANEL -->
        <div class="left">
            <div style="margin-bottom: 20px;">
                <a href="./"
                    style="text-decoration: none; color: #555; font-size: 14px; display: flex; align-items: center; gap: 5px;">
                    <i class="fas fa-arrow-left"></i> Back to Home
                </a>
            </div>
            <h1 class="title">Create an Account</h1>

            <form class="form" id="registerForm">
                <input type="text" id="name" placeholder="Username (Hanya huruf)" pattern="[A-Za-z\s]+" title="Hanya boleh huruf dan spasi" required>
                <input type="email" id="email" placeholder="Email" required>
                <input type="password" id="password" placeholder="Password (Min 6 chars)" required>

                <div class="error" id="errorMsg">Registrasi gagal!</div>

                <div class="remember-row">
                    <label>Already have an account?</label>
                    <a href="login" style="text-decoration:none;color:#444;">Login here</a>
                </div>

                <button type="submit" class="login-btn">Register</button>
            </form>
        </div>

        <!-- RIGHT PANEL -->
        <div class="right">

            <!-- LOGO DI ATAS TULISAN -->
            <img src="assets/logo_parfum_bk.png" alt="PARFY.ID Logo" class="logo-parfy">

            <h1 class="brand">PARFY.ID</h1>
            <p class="tagline">PREMIUM PERFUME STORE</p>

            <button class="register-btn" onclick="window.location.href='login'">Login</button>
        </div>

    </div>

    <script>
        document.getElementById('registerForm').addEventListener('submit', async function (e) {
            e.preventDefault();

            const name = document.getElementById('name').value;
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;
            const errorMsg = document.getElementById('errorMsg');
            const registerBtn = document.querySelector('.login-btn');

            // Validasi nama hanya huruf dan spasi
            if (!/^[A-Za-z\s]+$/.test(name)) {
                errorMsg.textContent = 'Username hanya boleh berisi huruf dan spasi.';
                errorMsg.style.display = 'block';
                return;
            }

            // Disable button while loading
            registerBtn.disabled = true;
            registerBtn.textContent = 'Loading...';
            errorMsg.style.display = 'none';

            try {
                const response = await fetch('api/auth/register.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ name, email, password })
                });

                const data = await response.json();

                if (response.ok) {
                    Swal.fire('Berhasil!', 'Registrasi berhasil! Silakan login dengan akun Anda.', 'success');
                    window.location.href = 'login';
                } else {
                    errorMsg.textContent = data.error || 'Registrasi gagal!';
                    errorMsg.style.display = 'block';
                }
            } catch (err) {
                errorMsg.textContent = 'Terjadi kesalahan. Coba lagi.';
                errorMsg.style.display = 'block';
            } finally {
                registerBtn.disabled = false;
                registerBtn.textContent = 'Register';
            }
        });
    </script>

</body>

</html>
