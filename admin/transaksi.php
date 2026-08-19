<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Parfy.ID Admin - Transaksi</title>

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
        <a href="stok.php" class="menu-item">
            <i class="bi bi-clipboard-check"></i> Stok
        </a>
        <a href="transaksi.php" class="menu-item active">
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
                <h3>Transaksi</h3>

                <!-- TOMBOL KEMBALI KE DASHBOARD -->
                <a href="dashboard.php" class="btn btn-back">
                    <i class="bi bi-arrow-left-circle me-2"></i> Kembali ke Dashboard
                </a>
            </div>

            <p class="text-white-50">Lihat riwayat semua transaksi yang masuk.</p>

            <!-- Filter Status -->
            <div class="d-flex gap-2 mb-3">
                <button class="btn btn-custom btn-sm active" onclick="filterTx('all')">Semua</button>
                <button class="btn btn-custom btn-sm" onclick="filterTx('pending')">Pending</button>
                <button class="btn btn-custom btn-sm" onclick="filterTx('lunas')">Di Konfirmasi</button>
                <button class="btn btn-custom btn-sm" onclick="filterTx('batal')">Batal</button>
            </div>

            <div class="table-responsive">
                <table class="table table-custom align-middle">
                    <thead>
                        <tr>
                            <th>ID Pesanan</th>
                            <th>Nama User</th>
                            <th>Tanggal</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="transactionsTable">
                        <!-- Data akan dimuat dari API -->
                    </tbody>
                </table>
            </div>

        </div>

    </div>

    <!-- Modal Detail Transaksi -->
    <div class="modal fade" id="txModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content" style="background: rgba(30,30,60,0.95); color: white;">
                <div class="modal-header border-0">
                    <h5 class="modal-title">Detail Transaksi <span id="txId"></span></h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <p class="mb-1 text-white-50">Nama Customer</p>
                            <h5 id="txCustomer"></h5>
                        </div>
                        <div class="col-md-6">
                            <p class="mb-1 text-white-50">Tanggal Transaksi</p>
                            <h5 id="txDate"></h5>
                        </div>
                    </div>
                    <hr class="border-secondary">
                    <h6>Produk Dipesan:</h6>
                    <div id="txItems" class="mb-3"></div>
                    <hr class="border-secondary">
                    <div class="row">
                        <div class="col-md-6">
                            <p class="mb-1 text-white-50">Total Pembayaran</p>
                            <h4 id="txTotal" class="text-success"></h4>
                        </div>
                        <div class="col-md-6">
                            <p class="mb-1 text-white-50">Status</p>
                            <select class="form-select bg-dark text-white border-secondary" id="txStatus">
                                <option value="konfirmasi">Konfirmasi</option>
                                <option value="batalkan">Batalkan</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="button" class="btn btn-success" onclick="updateStatus()">
                        <i class="bi bi-check-lg me-1"></i> Update Status
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/coding web IMK/parfy-php/js/api.js"></script>
    <script>
        let txModal;
        let currentTxId = null;
        let allTransactions = [];

        document.addEventListener('DOMContentLoaded', async () => {
            const user = PARFY.getUser();
            if (!user || user.role !== 'admin') {
                window.location.href = '/coding web IMK/parfy-php/login';
                return;
            }

            txModal = new bootstrap.Modal(document.getElementById('txModal'));
            await loadTransactions();
        });

        async function loadTransactions() {
            try {
                allTransactions = await PARFY.transactions.getAll();
                renderTransactions(allTransactions);
            } catch (error) {
                console.error('Error loading transactions:', error);
            }
        }

        function renderTransactions(transactions) {
            const tbody = document.getElementById('transactionsTable');

            if (transactions.length === 0) {
                tbody.innerHTML = '<tr><td colspan="6" class="text-center text-white-50">Tidak ada transaksi</td></tr>';
                return;
            }

            tbody.innerHTML = transactions.map(t => {
                let badgeClass = 'badge-custom-warning';
                let icon = 'bi-clock';
                let statusLabel = 'Pending';

                // Use order status (not paymentStatus) for display
                if (t.status === 'processing' || t.status === 'shipped' || t.status === 'delivered') {
                    badgeClass = 'badge-custom-success';
                    icon = 'bi-check-circle-fill';
                    statusLabel = 'Di Konfirmasi';
                }
                if (t.status === 'cancelled') {
                    badgeClass = 'badge-custom-danger';
                    icon = 'bi-x-circle-fill';
                    statusLabel = 'Batal';
                }

                return `
                <tr>
                    <td><strong>#${t.id}</strong></td>
                    <td>${t.userName || 'Guest'}</td>
                    <td>${PARFY.formatDate(t.date || t.createdAt || new Date())}</td>
                    <td>${PARFY.formatRupiah(t.total)}</td>
                    <td><span class="badge ${badgeClass}"><i class="bi ${icon} me-1"></i>${statusLabel}</span></td>
                    <td style="text-align: center;">
                        <button class="btn btn-sm btn-primary" onclick="viewDetail('${t.id}')">
                            <i class="bi bi-eye me-1"></i> Detail / Konfirmasi
                        </button>
                    </td>
                </tr>`;
            }).join('');
        }

        function filterTx(status) {
            let filtered = allTransactions;
            if (status !== 'all') {
                if (status === 'pending') {
                    filtered = allTransactions.filter(t => t.status === 'pending');
                } else if (status === 'lunas') {
                    filtered = allTransactions.filter(t => t.status === 'processing' || t.status === 'shipped' || t.status === 'delivered');
                } else if (status === 'batal') {
                    filtered = allTransactions.filter(t => t.status === 'cancelled');
                }
            }
            renderTransactions(filtered);
        }

        async function viewDetail(id) {
            currentTxId = id;
            const tx = allTransactions.find(t => t.id === id);

            if (!tx) return;

            document.getElementById('txId').textContent = '#' + tx.id;
            document.getElementById('txCustomer').textContent = tx.userName;
            document.getElementById('txDate').textContent = PARFY.formatDate(tx.date);
            document.getElementById('txTotal').textContent = PARFY.formatRupiah(tx.total);
            // document.getElementById('txStatus').value = tx.paymentStatus; // Disabled as options are actions now

            // Display items
            const itemsHtml = (tx.items || []).map(item => `
                < div class="d-flex justify-content-between align-items-center py-2 border-bottom border-secondary" >
                    <div>
                        <strong>${item.productName || 'Produk'}</strong>
                        <small class="text-white-50 d-block">${item.quantity}x @ ${PARFY.formatRupiah(item.price)}</small>
                    </div>
                    <span>${PARFY.formatRupiah(item.quantity * item.price)}</span>
                </div >
            `).join('') || '<p class="text-white-50">Detail item tidak tersedia</p>';

            document.getElementById('txItems').innerHTML = itemsHtml;
            txModal.show();
        }

        async function updateStatus() {
            const action = document.getElementById('txStatus').value;

            let newStatus = null;
            let newPaymentStatus = null;

            if (action === 'konfirmasi') {
                newStatus = 'processing';
                newPaymentStatus = 'lunas';
            } else if (action === 'batalkan') {
                newStatus = 'cancelled';
                newPaymentStatus = 'batal';
            }

            try {
                await PARFY.transactions.updateStatus(currentTxId, newStatus, newPaymentStatus);
                txModal.hide();
                Swal.fire('Berhasil!', 'Status transaksi berhasil diupdate!', 'success');
                await loadTransactions();
            } catch (error) {
                Swal.fire('Error!', error.message, 'error');
            }
        }
    </script>
</body>

</html>
