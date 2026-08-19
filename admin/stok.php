<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Parfy.ID Admin - Stok</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">

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

        .btn-custom {
            background: rgba(255, 255, 255, 0.2);
            color: white;
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        .btn-custom:hover {
            background: rgba(255, 255, 255, 0.3);
            color: white;
        }

        .btn-back {
            background: rgba(255, 255, 255, 0.25);
            color: white;
            border: 1px solid rgba(255, 255, 255, 0.4);
        }

        .btn-back:hover {
            background: rgba(255, 255, 255, 0.40);
            color: white;
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
            .menu-bottom {
            margin-bottom: 20px;
            margin-top: auto;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            padding-top: 10px;
        }
    </style>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
        <a href="stok.php" class="menu-item active">
            <i class="bi bi-clipboard-check"></i> Stok
        </a>
        <a href="transaksi.php" class="menu-item">
            <i class="bi bi-receipt"></i> Transaksi
        </a>
        <a href="user.php" class="menu-item">
            <i class="bi bi-person"></i> User
        </a>
        <!-- VOUCHER DIHAPUS -->
        <a href="review.php" class="menu-item">
            <i class="bi bi-star"></i> Review
        </a>
        <a href="analysis.php" class="menu-item">
            <i class="bi bi-graph-up"></i> Analysis
        </a>
    </div>

    <div class="content">

        <div class="topbar">
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

        <div id="content-area">
            <div class="d-flex justify-content-between align-items-center mb-1">
                <h3>Stok</h3>

                <!-- TOMBOL KEMBALI KE DASHBOARD -->
                <a href="dashboard.php" class="btn btn-back">
                    <i class="bi bi-arrow-left-circle me-2"></i> Kembali ke Dashboard
                </a>
            </div>

            <p class="text-white-50">Monitor dan kelola inventaris produk Anda.</p>

            <!-- Filter -->
            <div class="d-flex gap-2 mb-3">
                <button class="btn btn-custom btn-sm active" onclick="filterStock('all')">Semua</button>
                <button class="btn btn-custom btn-sm" onclick="filterStock('low')">Stok Rendah</button>
                <button class="btn btn-custom btn-sm" onclick="filterStock('out')">Habis</button>
            </div>

            <div class="table-responsive">
                <table class="table table-custom align-middle">
                    <thead>
                        <tr>
                            <th style="width: 60px">Gambar</th>
                            <th>Nama Produk</th>
                            <th>Brand</th>
                            <th>Stok</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="stockTable">
                        <!-- Data akan dimuat dari API -->
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    <!-- Modal Update Stok -->
    <div class="modal fade" id="stockModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content" style="background: rgba(30,30,60,0.95); color: white;">
                <div class="modal-header border-0">
                    <h5 class="modal-title">Update Stok</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="d-flex align-items-center mb-3">
                        <img id="stockProductImage" src=""
                            style="width: 60px; height: 60px; object-fit: cover; border-radius: 8px; margin-right: 15px;"
                            onerror="this.style.display='none'">
                        <div>
                            <p class="mb-0 text-white-50">Produk</p>
                            <h5 id="stockProductName" class="mb-0"></h5>
                        </div>
                    </div>
                    <div class="row align-items-center">
                        <div class="col-4">
                            <label class="form-label">Stok Saat Ini</label>
                            <input type="number" class="form-control bg-secondary text-white" id="currentStock"
                                readonly>
                        </div>
                        <div class="col-2 text-center pt-4">
                            <i class="bi bi-arrow-right fs-4"></i>
                        </div>
                        <div class="col-6">
                            <label class="form-label">Stok Baru</label>
                            <input type="number" class="form-control bg-dark text-white border-secondary" id="newStock"
                                min="0">
                        </div>
                    </div>
                    <div class="mt-3">
                        <label class="form-label">Quick Add</label>
                        <div class="btn-group w-100">
                            <button class="btn btn-outline-light" onclick="quickAdd(5)">+5</button>
                            <button class="btn btn-outline-light" onclick="quickAdd(10)">+10</button>
                            <button class="btn btn-outline-light" onclick="quickAdd(25)">+25</button>
                            <button class="btn btn-outline-light" onclick="quickAdd(50)">+50</button>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-success" onclick="saveStock()">
                        <i class="bi bi-check-lg me-1"></i> Simpan
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/coding web IMK/parfy-php/js/api.js"></script>
    <script>
        let stockModal;
        let editingId = null;
        let allProducts = [];

        document.addEventListener('DOMContentLoaded', async () => {
            const user = PARFY.getUser();
            if (!user || user.role !== 'admin') {
                window.location.href = '/coding web IMK/parfy-php/login';
                return;
            }

            stockModal = new bootstrap.Modal(document.getElementById('stockModal'));
            await loadStock();
        });

        async function loadStock() {
            try {
                allProducts = await PARFY.products.getAll();
                renderStock(allProducts);
            } catch (error) {
                console.error('Error loading stock:', error);
            }
        }

        function renderStock(products) {
            const tbody = document.getElementById('stockTable');

            tbody.innerHTML = products.map(p => {
                let badgeClass = 'badge-custom-success';
                let status = 'Tersedia';
                let icon = 'bi-check-circle-fill';

                if (p.stock === 0) {
                    badgeClass = 'badge-custom-danger';
                    status = 'Habis';
                    icon = 'bi-x-circle-fill';
                } else if (p.stock < 10) {
                    badgeClass = 'badge-custom-warning';
                    status = 'Hampir Habis';
                    icon = 'bi-exclamation-circle-fill';
                }

                return `
                <tr>
                    <td>
                        <img src="${p.image || '/coding web IMK/parfy-php/foto/default.jpg'}" alt="${p.name}" 
                             style="width: 50px; height: 50px; object-fit: cover; border-radius: 6px;"
                             onerror="this.onerror=null; this.src='/coding web IMK/parfy-php/foto/default.jpg';">
                    </td>
                    <td>${p.name}</td>
                    <td><span class="badge bg-info">${p.brand || '-'}</span></td>
                    <td><strong class="${p.stock === 0 ? 'text-danger fw-bold fs-6' : (p.stock < 10 ? 'text-warning fw-bold fs-6' : 'text-white')}">${p.stock}</strong></td>
                    <td><span class="badge ${badgeClass}"><i class="bi ${icon} me-1"></i>${status}</span></td>
                    <td>
                        <button class="btn btn-sm btn-warning text-dark fw-bold" onclick="showStockModal('${p.id}', '${p.name.replace(/'/g, "\\'")}', ${p.stock}, '${p.image || ''}')">
                            <i class="bi bi-pencil-square me-1"></i> Update
                        </button>
                    </td>
                </tr>`;
            }).join('');
        }

        function filterStock(type) {
            let filtered = allProducts;
            if (type === 'low') {
                filtered = allProducts.filter(p => p.stock > 0 && p.stock < 10);
            } else if (type === 'out') {
                filtered = allProducts.filter(p => p.stock === 0);
            }
            renderStock(filtered);
        }

        function showStockModal(id, name, stock, image) {
            editingId = id;
            const imgEl = document.getElementById('stockProductImage');
            if (image) {
                imgEl.src = image;
                imgEl.style.display = 'block';
            } else {
                imgEl.style.display = 'none';
            }
            document.getElementById('stockProductName').textContent = name;
            document.getElementById('currentStock').value = stock;
            document.getElementById('newStock').value = stock;
            stockModal.show();
        }

        function quickAdd(amount) {
            const input = document.getElementById('newStock');
            input.value = parseInt(input.value || 0) + amount;
        }

        async function saveStock() {
            const newStock = parseInt(document.getElementById('newStock').value);

            if (isNaN(newStock) || newStock < 0) {
                Swal.fire('Informasi', 'Stok harus berupa angka positif!', 'info');
                return;
            }

            try {
                await PARFY.products.updateStock(editingId, newStock);
                stockModal.hide();
                Swal.fire('Berhasil!', 'Stok berhasil diupdate!', 'success');
                await loadStock();
            } catch (error) {
                Swal.fire('Error!', error.message, 'error');
            }
        }
    </script>
</body>

</html>
