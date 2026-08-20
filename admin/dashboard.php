<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Parfy.ID Admin - Dashboard</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">

    <style>
        body {
            margin: 0;
            font-family: 'Poppins', sans-serif;
            height: 100vh;
            /* Gradient background fallback */
            background: radial-gradient(circle at center, #005c97 0%, #0f1029 100%);
            background-size: cover;
            display: flex;
            overflow: hidden;
        }

        /* Sidebar */
        .sidebar {
            width: 270px;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(6px);
            padding-top: 25px;
            height: 100vh;
            color: white;
            position: fixed;
            display: flex;
            /* Menggunakan flexbox untuk tata letak vertikal */
            flex-direction: column;
            /* Susunan atas ke bawah */
            overflow-y: auto;
            z-index: 1000;
        }

        .brand-box {
            text-align: center;
            margin-bottom: 35px;
            flex-shrink: 0;
        }

        .brand-box img {
            width: 80px;
            filter: drop-shadow(2px 2px 4px rgba(0, 0, 0, 0.3));
        }

        .brand-box h4 {
            margin-top: 12px;
            font-weight: 600;
        }

        .menu-container {
            flex-grow: 1;
            /* Menu utama mengisi ruang tengah */
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
            /* Sedikit jarak antar menu */
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

        /* Tombol Keluar di bawah */
        .menu-bottom {
            margin-bottom: 20px;
            margin-top: auto;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            padding-top: 10px;
        }

        .menu-item.logout {
            color: #ffcccc;
        }

        .menu-item.logout:hover {
            background: rgba(220, 53, 69, 0.2);
            color: #fff;
        }

        /* Content */
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
            justify-content: flex-end;
            align-items: center;
            gap: 25px;
        }

        .topbar i {
            font-size: 22px;
            cursor: pointer;
        }

        #content-area {
            margin-top: 20px;
            background: rgba(255, 255, 255, 0.15);
            padding: 25px;
            border-radius: 12px;
            backdrop-filter: blur(5px);
            margin-bottom: 50px;
            /* Tambahan margin bawah agar tidak terpotong */
        }

        /* === CSS TAMBAHAN UNTUK KONTEN === */
        .data-card {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 12px;
            color: white;
            backdrop-filter: blur(10px);
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .data-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
        }

        .data-card .card-body {
            color: white;
        }

        .data-card h1,
        .data-card h2,
        .data-card h3,
        .data-card h4 {
            font-weight: 600;
        }

        /* Colorful stat cards */
        .stat-card-revenue {
            background: linear-gradient(135deg, #11998e, #38ef7d) !important;
            border: none !important;
        }

        .stat-card-orders {
            background: linear-gradient(135deg, #667eea, #764ba2) !important;
            border: none !important;
        }

        .stat-card-users {
            background: linear-gradient(135deg, #f093fb, #f5576c) !important;
            border: none !important;
        }

        .stat-card-warning {
            background: linear-gradient(135deg, #f6d365, #fda085) !important;
            border: none !important;
        }

        .stat-card-danger {
            background: linear-gradient(135deg, #ff416c, #ff4b2b) !important;
            border: none !important;
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

        .badge-custom-success {
            background-color: rgba(40, 167, 69, 0.7);
            color: white;
        }

        .badge-custom-warning {
            background-color: rgba(255, 193, 7, 0.7);
            color: #333;
        }

        .badge-custom-danger {
            background-color: rgba(220, 53, 69, 0.7);
            color: white;
        }

        /* Mobile Responsiveness */
        @media (max-width: 768px) {
            .sidebar {
                left: -270px;
                transition: 0.3s;
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

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>

    <div class="sidebar">

        <div class="brand-box">
            <!-- Pastikan path foto logo benar -->
            <img src="/coding web IMK/parfy-php/assets/logo_parfum_bk.png" alt="Logo" onerror="this.src='https://placehold.co/80x80?text=Logo';">
            <h4>PARFY.ID</h4>
        </div>

        <!-- Container Menu Utama -->
        <div class="menu-container">
            <a href="dashboard.php" class="menu-item active">
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
            <a href="user.php" class="menu-item">
                <i class="bi bi-person"></i> User
            </a>
            <!-- MENU VOUCHER DIHAPUS DISINI -->
            <a href="review.php" class="menu-item">
                <i class="bi bi-star"></i> Review
            </a>
            <a href="analysis.php" class="menu-item">
                <i class="bi bi-graph-up"></i> Analysis
            </a>
        </div>

        <!-- Tombol Kembali / Keluar di bagian bawah -->

    </div>

    <div class="content">

        <div class="topbar">
            <i class="bi bi-list fs-2 text-white d-md-none" id="sidebar-toggle" style="cursor: pointer;"></i>
            <div class="dropdown">
                <div class="d-flex align-items-center text-white text-decoration-none dropdown-toggle"
                    id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false" style="cursor: pointer;">
                    <i class="bi bi-person-circle fs-4 me-2"></i>
                    <span class="d-none d-md-block fw-bold">Admin PARFY</span>
                </div>
                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-dark shadow" aria-labelledby="dropdownUser1">
                    
                    <li><a class="dropdown-item text-danger" href="#" onclick="PARFY.auth.logout()"><i
                                class="bi bi-box-arrow-right me-2"></i> Keluar</a></li>
                </ul>
            </div>
        </div>

        <h2 class="fw-bold mt-4">Selamat Datang, Boss Muda!</h2>

        <div id="content-area">
            <h3>Dashboard</h3>
            <p class="text-white-50">Ringkasan performa toko Anda hari ini.</p>

            <div class="row g-3 g-lg-4">
                <div class="col-6 col-xl-3">
                    <div class="card data-card stat-card-revenue h-100 shadow-sm">
                        <div class="card-body d-flex flex-column justify-content-between p-3">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <span class="card-subtitle text-white-50 fw-semibold" style="font-size: 0.88rem;">Total Pendapatan</span>
                                <div style="background: rgba(255, 255, 255, 0.2); width: 40px; height: 40px; border-radius: 10px; display: flex; align-items: center; justify-content: center; backdrop-filter: blur(5px);">
                                    <i class="bi bi-cash-coin fs-4 text-white"></i>
                                </div>
                            </div>
                            <div>
                                <h3 class="card-title fw-bold mb-0 text-white" id="totalRevenue" style="font-size: 1.35rem; letter-spacing: -0.3px;">Rp 0</h3>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-xl-3">
                    <div class="card data-card stat-card-orders h-100 shadow-sm">
                        <div class="card-body d-flex flex-column justify-content-between p-3">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <span class="card-subtitle text-white-50 fw-semibold" style="font-size: 0.88rem;">Total Pesanan</span>
                                <div style="background: rgba(255, 255, 255, 0.2); width: 40px; height: 40px; border-radius: 10px; display: flex; align-items: center; justify-content: center; backdrop-filter: blur(5px);">
                                    <i class="bi bi-receipt fs-4 text-white"></i>
                                </div>
                            </div>
                            <div>
                                <h3 class="card-title fw-bold mb-0 text-white" id="totalOrders" style="font-size: 1.35rem;">0</h3>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-xl-3">
                    <div class="card data-card stat-card-users h-100 shadow-sm">
                        <div class="card-body d-flex flex-column justify-content-between p-3">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <span class="card-subtitle text-white-50 fw-semibold" style="font-size: 0.88rem;">Total User</span>
                                <div style="background: rgba(255, 255, 255, 0.2); width: 40px; height: 40px; border-radius: 10px; display: flex; align-items: center; justify-content: center; backdrop-filter: blur(5px);">
                                    <i class="bi bi-people fs-4 text-white"></i>
                                </div>
                            </div>
                            <div>
                                <h3 class="card-title fw-bold mb-0 text-white" id="totalUsers" style="font-size: 1.35rem;">0</h3>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-xl-3">
                    <div class="card data-card stat-card-warning h-100 shadow-sm" id="statCardStock">
                        <div class="card-body d-flex flex-column justify-content-between p-3">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <span class="card-subtitle text-white-50 fw-semibold" id="stockCardSubtitle" style="font-size: 0.88rem;">Stok Hampir Habis</span>
                                <div style="background: rgba(255, 255, 255, 0.2); width: 40px; height: 40px; border-radius: 10px; display: flex; align-items: center; justify-content: center; backdrop-filter: blur(5px);">
                                    <i class="bi bi-exclamation-triangle fs-4 text-white"></i>
                                </div>
                            </div>
                            <div>
                                <h3 class="card-title fw-bold mb-0 text-white" id="lowStock" style="font-size: 1.35rem;">0 Produk</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row g-4 mt-3">
                <div class="col-md-8">
                    <div class="card data-card h-100">
                        <div class="card-body">
                            <h5 class="card-title">Grafik Penjualan 6 Bulan Terakhir</h5>
                            <div style="position: relative; height:300px; width:100%">
                                <canvas id="salesChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card data-card h-100">
                        <div class="card-body">
                            <h5 class="card-title">Pesanan Terbaru</h5>
                            <div class="table-responsive">
                                <table class="table table-custom mb-0">
                                    <tbody id="recentOrders">
                                        <tr>
                                            <td>#INV1023</td>
                                            <td>Rp 150K</td>
                                            <td><span class="badge badge-custom-success">Selesai</span></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row g-4 mt-3">

                <div class="col-md-6">
                    <div class="card data-card h-100">
                        <div class="card-body">
                            <h5 class="card-title">Produk Terlaris</h5>
                            <div class="table-responsive">
                                <table class="table table-custom mb-0">
                                    <thead>
                                        <tr>
                                            <th>Produk</th>
                                            <th>Terjual</th>
                                        </tr>
                                    </thead>
                                    <tbody id="topProducts">
                                        <tr>
                                            <td>Parfum "Ocean Breeze"</td>
                                            <td>120</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card data-card h-100">
                        <div class="card-body">
                            <h5 class="card-title">Review Terbaru</h5>
                            <div id="recentReviews">
                                <div class="mb-2">
                                    <div class="d-flex justify-content-between">
                                        <strong>Ahmad S.</strong>
                                        <span class="text-warning"><i class="bi bi-star-fill"></i> 5.0</span>
                                    </div>
                                    <p class="text-white-50 mb-0 fst-italic">"Wanginya segar banget, tahan lama..."</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/coding web IMK/parfy-php/js/api.js?v=2"></script>
    <script>
        // Check if admin is logged in
        

        document.addEventListener('DOMContentLoaded', async () => {
            const user = PARFY.getUser();
            if (!user || user.role !== 'admin') {
                window.location.href = '/coding web IMK/parfy-php/admin/login.php';
                return;
            }

            // Update username di topbar
            document.querySelector('.topbar span').textContent = user.name;

            // Load dashboard data
            try {
                const stats = await PARFY.dashboard.getStats();

                // Update stats cards
                document.getElementById('totalRevenue').textContent = stats.formatted.totalRevenue;
                document.getElementById('totalOrders').textContent = stats.formatted.totalOrders;
                document.getElementById('totalUsers').textContent = stats.formatted.totalUsers;

                const stockCard = document.getElementById('statCardStock');
                const lowStockEl = document.getElementById('lowStock');
                const stockTitle = document.getElementById('stockCardSubtitle');
                
                const outCount = stats.outOfStock || 0;
                const lowCount = stats.lowStock || 0;
                
                if (outCount > 0 && lowCount > 0) {
                    lowStockEl.innerHTML = `<span style="color:#fff; background:#dc3545; padding:2px 8px; border-radius:6px; font-size:1.05rem; margin-right:4px;">${outCount} Habis</span><span style="color:#212529; background:#ffc107; padding:2px 8px; border-radius:6px; font-size:1.05rem;">${lowCount} Menipis</span>`;
                    if (stockCard) stockCard.className = 'card data-card stat-card-danger h-100 shadow-sm';
                    if (stockTitle) stockTitle.textContent = 'Stok Habis & Menipis';
                } else if (outCount > 0) {
                    lowStockEl.innerHTML = `<span style="color:#fff; background:#dc3545; padding:2px 8px; border-radius:6px; font-size:1.15rem;">${outCount} Produk Habis</span>`;
                    if (stockCard) stockCard.className = 'card data-card stat-card-danger h-100 shadow-sm';
                    if (stockTitle) stockTitle.textContent = 'Stok Habis';
                } else if (lowCount > 0) {
                    lowStockEl.innerHTML = `<span style="color:#212529; background:#ffc107; padding:2px 8px; border-radius:6px; font-size:1.15rem;">${lowCount} Hampir Habis</span>`;
                    if (stockCard) stockCard.className = 'card data-card stat-card-warning h-100 shadow-sm';
                    if (stockTitle) stockTitle.textContent = 'Stok Hampir Habis';
                } else {
                    lowStockEl.innerHTML = `<span class="text-white">Semua Aman</span>`;
                    if (stockCard) stockCard.className = 'card data-card stat-card-revenue h-100 shadow-sm';
                    if (stockTitle) stockTitle.textContent = 'Status Stok';
                }

                // Tampilkan Popup Peringatan Stok (Hanya sekali saat login / sesi ini)
                if (!sessionStorage.getItem('lowStockAlertShown')) {
                    sessionStorage.setItem('lowStockAlertShown', 'true');
                    try {
                        const products = await PARFY.products.getAll();
                        const lowStockProducts = products.filter(p => p.stock < 10);
                        
                        if (lowStockProducts.length > 0) {
                            let stockMsg = '<div style="text-align: left; max-height: 200px; overflow-y: auto;"><ul>';
                            lowStockProducts.forEach(p => {
                                const status = p.stock === 0 
                                    ? '<span class="badge bg-danger text-white fw-bold" style="background:#dc3545; color:white; padding:3px 8px; border-radius:4px;">HABIS (0)</span>' 
                                    : `<span class="badge bg-warning text-dark fw-bold" style="background:#ffc107; color:#212529; padding:3px 8px; border-radius:4px;">Sisa ${p.stock} (Hampir Habis)</span>`;
                                stockMsg += `<li class="mb-2">${p.name} - ${status}</li>`;
                            });
                            stockMsg += '</ul></div>';

                            Swal.fire({
                                title: 'Peringatan Stok!',
                                html: `Ada <b>${lowStockProducts.length} produk</b> yang stoknya menipis atau habis:<br><br>${stockMsg}`,
                                icon: 'warning',
                                confirmButtonText: 'Cek Halaman Stok',
                                showCancelButton: true,
                                cancelButtonText: 'Tutup'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.href = 'stok.php';
                                }
                            });
                        }
                    } catch (e) {
                        console.error('Gagal memuat data stok untuk alert', e);
                    }
                }

                


                // Load recent orders
                const recentOrders = await PARFY.dashboard.getRecentOrders();
                const ordersTable = document.getElementById('recentOrders');
                ordersTable.innerHTML = recentOrders.map(order => {
                    let badgeClass = 'badge-custom-warning';
                    if (order.status === 'selesai') badgeClass = 'badge-custom-success';
                    if (order.status === 'batal') badgeClass = 'badge-custom-danger';

                    return `<tr>
                    <td>#${order.id}</td>
                    <td>${PARFY.formatRupiah(order.total)}</td>
                    <td><span class="badge ${badgeClass}">${order.status}</span></td>
                </tr>`;
                }).join('');

                // Load chart data
            try {
                const chartData = await PARFY.dashboard.getChartData();
                const ctx = document.getElementById('salesChart').getContext('2d');
                new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: chartData.monthlySales.map(m => m.month),
                        datasets: [{
                            label: 'Pendapatan (Rp)',
                            data: chartData.monthlySales.map(m => m.revenue),
                            borderColor: '#fa709a',
                            backgroundColor: 'rgba(250, 112, 154, 0.2)',
                            borderWidth: 2,
                            fill: true,
                            tension: 0.4
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            y: {
                                beginAtZero: true,
                                grid: { color: 'rgba(255, 255, 255, 0.1)' },
                                ticks: { color: '#ddd' }
                            },
                            x: {
                                grid: { color: 'rgba(255, 255, 255, 0.1)' },
                                ticks: { color: '#ddd' }
                            }
                        },
                        plugins: {
                            legend: { display: false },
                            tooltip: {
                                callbacks: {
                                    label: function (context) {
                                        return ' Pendapatan: ' + PARFY.formatRupiah(context.parsed.y);
                                    }
                                }
                            }
                        }
                    }
                });
            } catch (error) {
                console.error('Error loading chart data:', error);
            }

            // Load top products
                const topProducts = await PARFY.dashboard.getTopProducts();
                const productsTable = document.getElementById('topProducts');
                productsTable.innerHTML = topProducts.map(p =>
                    `<tr><td>${p.name}</td><td>${p.sold}</td></tr>`
                ).join('');

                // Load recent reviews
                const recentReviews = await PARFY.dashboard.getRecentReviews();
                const reviewsContainer = document.getElementById('recentReviews');
                reviewsContainer.innerHTML = recentReviews.map(r => `
                <div class="mb-2">
                    <div class="d-flex justify-content-between">
                        <strong>${r.userName}</strong>
                        <span class="text-warning"><i class="bi bi-star-fill"></i> ${r.rating}.0</span>
                    </div>
                    <p class="text-white-50 mb-0 fst-italic">"${r.comment.substring(0, 50)}..."</p>
                </div>
            `).join('');

            } catch (error) {
                console.error('Error loading dashboard:', error);
            }
        });

        // Logout handler
        document.querySelector('.menu-item.logout').addEventListener('click', (e) => {
            e.preventDefault();
            PARFY.auth.logout();
        });

        // Sidebar Toggle
        const toggleBtn = document.getElementById('sidebar-toggle');
        const sidebar = document.querySelector('.sidebar');
        if (toggleBtn) {
            toggleBtn.addEventListener('click', () => {
                sidebar.classList.toggle('active');
            });
        }

        // Close sidebar when clicking outside on mobile
        document.addEventListener('click', (e) => {
            if (window.innerWidth < 768 &&
                sidebar.classList.contains('active') &&
                !sidebar.contains(e.target) &&
                e.target !== toggleBtn) {
                sidebar.classList.remove('active');
            }
        });
    
        

    </script>
</body>

</html>
