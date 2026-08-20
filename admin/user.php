<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Parfy.ID Admin - User</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        body {
            margin: 0;
            font-family: 'Poppins', sans-serif;
            height: 100vh;
            background: radial-gradient(circle at center, #005c97 0%, #0f1029 100%);
            background-size: cover;
            display: flex;
        }

        .sidebar {
            width: 270px;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(6px);
            padding-top: 25px;
            height: 100vh;
            color: white;
            position: fixed;
            display: flex;
            flex-direction: column;
            overflow-y: auto;
        }

        .brand-box {
            text-align: center;
            margin-bottom: 35px;
        }

        .brand-box img {
            width: 80px;
            filter: drop-shadow(2px 2px 4px rgba(0, 0, 0, 0.3));
        }

        .brand-box h4 {
            margin-top: 12px;
            font-weight: 600;
        }

        .menu-item {
            padding: 15px 25px;
            font-size: 18px;
            cursor: pointer;
            display: flex;
            align-items: center;
            transition: 0.3s ease;
            border-radius: 6px;
            margin: 0 15px 5px 15px;
            color: white;
            text-decoration: none;
        }

        .menu-item i {
            font-size: 22px;
            margin-right: 12px;
        }

        .menu-item:hover {
            background: rgba(255, 255, 255, 0.20);
            padding-left: 32px;
            color: white;
        }

        .menu-item.active {
            background: rgba(255, 255, 255, 0.35);
            border-left: 4px solid #ffffff;
            padding-left: 32px;
            font-weight: 600;
        }

        .content {
            margin-left: 270px;
            padding: 35px;
            width: calc(100% - 270px);
            color: white;
            overflow-y: auto;
            height: 100vh;
        }

        .topbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 25px;
        }

        .topbar-right {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        #content-area {
            margin-top: 20px;
            background: rgba(255, 255, 255, 0.15);
            padding: 25px;
            border-radius: 12px;
            backdrop-filter: blur(5px);
        }

        .table-custom {
            background: rgba(255, 255, 255, 0.1);
            color: white;
            border-radius: 8px;
            overflow: hidden;
        }

        .table-custom th {
            background: rgba(0, 0, 0, 0.3);
            border-color: rgba(255, 255, 255, 0.2) !important;
            color: #f0f0f0;
        }

        .table-custom td,
        .table-custom th {
            border-color: rgba(255, 255, 255, 0.2) !important;
        }

        .btn-action {
            background: none;
            border: none;
            color: white;
            padding: 5px 10px;
        }

        .btn-action:hover {
            color: #ddd;
        }

        .btn-back {
            background: rgba(255, 255, 255, 0.25);
            border: 1px solid rgba(255, 255, 255, 0.4);
            color: white;
            padding: 8px 15px;
            border-radius: 8px;
        }

        .btn-back:hover {
            background: rgba(255, 255, 255, 0.35);
        }
            .menu-bottom {
            margin-bottom: 20px;
            margin-top: auto;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            padding-top: 10px;
        }

        /* Mobile Responsiveness */
        @media (max-width: 768px) {
            .sidebar {
                left: -270px;
                transition: 0.3s;
                z-index: 1050;
            }

            .sidebar.active {
                left: 0;
            }

            .content {
                margin-left: 0;
                width: 100%;
                padding: 15px;
            }

            .topbar {
                justify-content: space-between !important;
            }
        }
    </style>

</head>

<body>

    <div class="sidebar">

        <div class="brand-box">
            <img src="/coding web IMK/parfy-php/assets/logo_parfum_bk.png" alt="Logo">
            <h4>PARFY.ID</h4>
        </div>

        <a href="dashboard.php" class="menu-item">
            <i class="bi bi-grid"></i> Dashboard
        </a>
        <a href="produk.php" class="menu-item">
            <i class="bi bi-box-seam"></i> Produk
        </a>
        <a href="stok.php" class="menu-item">
            <i class="bi bi-clipboard-check"></i> Stok
        </a>
        <a href="transaksi.php" class="menu-item">
            <i class="bi bi-receipt"></i> Transaksi
        </a>
        <a href="user.php" class="menu-item active">
            <i class="bi bi-person"></i> User
        </a>
        <!-- Voucher telah dihapus -->
        <a href="review.php" class="menu-item">
            <i class="bi bi-star"></i> Review
        </a>
        <a href="analysis.php" class="menu-item">
            <i class="bi bi-graph-up"></i> Analysis
        </a>
    </div>

    <div class="content">

        <div class="topbar">
            <i class="bi bi-list fs-2 text-white d-md-none" id="sidebar-toggle" style="cursor: pointer;"></i>
            <div class="dropdown ms-auto">
                <div class="d-flex align-items-center text-white text-decoration-none dropdown-toggle"
                    id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false" style="cursor: pointer;">
                    <i class="bi bi-person-circle fs-4 me-2"></i>
                    <span class="d-none d-md-block fw-bold">Admin PARFY</span>
                </div>
                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-dark shadow"
                    aria-labelledby="dropdownUser1">
                    <li><a class="dropdown-item text-danger" href="#" onclick="PARFY.auth.logout()"><i
                                class="bi bi-box-arrow-right me-2"></i> Keluar</a></li>
                </ul>
            </div>
        </div>

        <div id="content-area">
            <div class="d-flex justify-content-between align-items-center mb-1">
                <h3>User</h3>

                <!-- TOMBOL KEMBALI KE DASHBOARD -->
                <a href="dashboard.php" class="btn btn-back">
                    <i class="bi bi-arrow-left-circle me-2"></i> Kembali ke Dashboard
                </a>
            </div>

            <p class="text-white-50">Kelola akun pengguna yang terdaftar.</p>
            <div class="table-responsive">
                <table class="table table-custom align-middle">
                    <thead>
                        <tr>
                            <th>User ID</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Tanggal Bergabung</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="usersTable">
                        <!-- Data akan dimuat dari API -->
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/coding web IMK/parfy-php/js/api.js?v=3"></script>
    <script>
        document.addEventListener('DOMContentLoaded', async () => {
            const user = PARFY.getUser();
            if (!user || user.role !== 'admin') {
                window.location.href = '/coding web IMK/parfy-php/admin/login.php';
                return;
            }

            await loadUsers();
        });

        async function loadUsers() {
            try {
                const users = await PARFY.users.getAll();
                const tbody = document.getElementById('usersTable');

                tbody.innerHTML = users.map(u => `
                <tr>
                    <td>${u.id}</td>
                    <td>${u.name}</td>
                    <td>${u.email}</td>
                    <td>${PARFY.formatDate(u.createdAt)}</td>
                    <td>
                        <button class="btn btn-sm btn-danger border-0 shadow-sm" onclick="deleteUser('${u.id}')"><i class="bi bi-trash"></i> Hapus</button>
                    </td>
                </tr>
            `).join('');
            } catch (error) {
                console.error('Error loading users:', error);
            }
        }

        async function deleteUser(id) {
            Swal.fire({
                title: 'Yakin ingin menghapus user ini?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya!',
                cancelButtonText: 'Batal'
            }).then(async (result) => {
                if (result.isConfirmed) {
                    try {
                        await PARFY.users.delete(id);
                        Swal.fire('Berhasil!', 'User berhasil dihapus!', 'success');
                        await loadUsers();
                    } catch (error) {
                        Swal.fire('Error!', error.message, 'error');
                    }
                }
            });
        }

        // Sidebar Toggle Mobile
        document.getElementById('sidebar-toggle')?.addEventListener('click', function() {
            document.querySelector('.sidebar')?.classList.toggle('active');
        });
        document.addEventListener('click', (e) => {
            const sidebar = document.querySelector('.sidebar');
            const toggleBtn = document.getElementById('sidebar-toggle');
            if (window.innerWidth < 768 && sidebar && sidebar.classList.contains('active') && !sidebar.contains(e.target) && e.target !== toggleBtn) {
                sidebar.classList.remove('active');
            }
        });
    </script>
</body>

</html>
