<?php require_once __DIR__ . '/../config/database.php'; ?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Parfy.ID Admin - Produk</title>

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

        .btn-custom {
            background: rgba(255, 255, 255, 0.2);
            color: white;
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        .btn-custom:hover {
            background: rgba(255, 255, 255, 0.35);
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

        .btn-action {
            background: none;
            border: none;
            color: white;
            padding: 5px 10px;
        }

        .btn-action:hover {
            color: #ddd;
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
            <img src="<?php echo url('/assets/'); ?>logo_parfum_bk.png" alt="Logo">
            <h4>PARFY.ID</h4>
        </div>

        <a href="<?php echo url('/admin/dashboard'); ?>" class="menu-item">
            <i class="bi bi-grid"></i> Dashboard
        </a>

        <a href="<?php echo url('/admin/produk'); ?>" class="menu-item active">
            <i class="bi bi-box-seam"></i> Produk
        </a>

        <a href="<?php echo url('/admin/stok'); ?>" class="menu-item">
            <i class="bi bi-clipboard-check"></i> Stok
        </a>

        <a href="<?php echo url('/admin/transaksi'); ?>" class="menu-item">
            <i class="bi bi-receipt"></i> Transaksi
        </a>

        <a href="<?php echo url('/admin/user'); ?>" class="menu-item">
            <i class="bi bi-person"></i> User
        </a>

        <!-- VOUCHER DIHAPUS -->

        <a href="<?php echo url('/admin/review'); ?>" class="menu-item">
            <i class="bi bi-star"></i> Review
        </a>

        <a href="<?php echo url('/admin/analysis'); ?>" class="menu-item">
            <i class="bi bi-graph-up"></i> Analysis
        </a>
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

        <div id="content-area">
            <div class="d-flex justify-content-between align-items-center">
                <h3>Produk</h3>

                <!-- TOMBOL KEMBALI -->
                <a href="<?php echo url('/admin/dashboard'); ?>" class="btn btn-back">
                    <i class="bi bi-arrow-left-circle me-2"></i> Kembali ke Dashboard
                </a>
            </div>

            <p class="text-white-50">Kelola semua produk di toko Anda.</p>

            <div class="d-flex justify-content-end mb-3">
                <button class="btn btn-custom" onclick="showAddModal()"><i class="bi bi-plus-circle me-2"></i> Tambah
                    Produk</button>
            </div>

            <div class="table-responsive">
                <table class="table table-custom align-middle">
                    <thead>
                        <tr>
                            <th style="width: 90px">Gambar</th>
                            <th>Nama Produk</th>
                            <th>Brand</th>
                            <th>Kategori</th>
                            <th>Harga</th>
                            <th>Stok</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="productsTable">
                        <!-- Data akan dimuat dari API -->
                    </tbody>
                </table>
            </div>

        </div>

    </div>

    <!-- Modal Tambah/Edit Produk -->
    <div class="modal fade" id="productModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content" style="background: rgba(30,30,60,0.95); color: white;">
                <div class="modal-header border-0">
                    <h5 class="modal-title" id="modalTitle">Tambah Produk</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="productForm">
                        <input type="hidden" id="productId">
                        <div class="row">
                            <div class="col-md-8 mb-3">
                                <label class="form-label">Nama Produk</label>
                                <input type="text" class="form-control bg-dark text-white border-secondary"
                                    id="productName" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Brand</label>
                                <select class="form-select bg-dark text-white border-secondary" id="productBrand"
                                    required>
                                    <option value="">Pilih Brand</option>
                                    <option value="Mykonos">Mykonos</option>
                                    <option value="HMNS">HMNS</option>
                                    <option value="Carl & Claire">Carl & Claire</option>
                                    <option value="SAFF & Co">SAFF & Co</option>
                                    <option value="Bali Surfers">Bali Surfers</option>
                                    <option value="Onix Fragrance">Onix Fragrance</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Kategori</label>
                                <select class="form-select bg-dark text-white border-secondary" id="productCategory"
                                    required>
                                    <option value="">Pilih Kategori</option>
                                    <option value="Pria">Pria</option>
                                    <option value="Wanita">Wanita</option>
                                    <option value="Unisex">Unisex</option>
                                </select>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Harga (Rp)</label>
                                <input type="number" class="form-control bg-dark text-white border-secondary"
                                    id="productPrice" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Stok</label>
                                <input type="number" class="form-control bg-dark text-white border-secondary"
                                    id="productStock" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Ukuran</label>
                                <input type="text" class="form-control bg-dark text-white border-secondary"
                                    id="productSize" placeholder="50ml">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Scent Category</label>
                                <select class="form-select bg-dark text-white border-secondary"
                                    id="productScentCategory">
                                    <option value="">Pilih Kategori Aroma</option>
                                    <option value="Woody">Woody</option>
                                    <option value="Sweet & Gourmand">Sweet & Gourmand</option>
                                    <option value="Fresh & Aquatic">Fresh & Aquatic</option>
                                    <option value="Floral">Floral</option>
                                    <option value="Musky">Musky</option>
                                    <option value="Spicy">Spicy</option>
                                    <option value="Oriental">Oriental</option>
                                </select>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Aroma</label>
                                <input type="text" class="form-control bg-dark text-white border-secondary"
                                    id="productAroma" placeholder="Vanilla, Musk, Woody">
                            </div>
                        </div>
                        <!-- Gambar 1 -->
                        <div class="row align-items-end">
                            <div class="col-md-5 mb-3">
                                <label class="form-label">Gambar 1 (URL)</label>
                                <input type="text" class="form-control bg-dark text-white border-secondary"
                                    id="productImage1" placeholder="https://... atau /foto/..."
                                    onchange="previewImage(1)">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">atau Upload File</label>
                                <input type="file" class="form-control bg-dark text-white border-secondary"
                                    id="productFile1" accept="image/*" onchange="handleFileUpload(1)">
                            </div>
                            <div class="col-md-3 mb-3 text-center">
                                <label class="form-label">Preview</label>
                                <div id="imagePreview1"
                                    style="width: 70px; height: 70px; border: 1px dashed #666; border-radius: 8px; display: flex; align-items: center; justify-content: center; margin: auto; overflow: hidden;">
                                    <i class="bi bi-image text-secondary fs-4"></i>
                                </div>
                            </div>
                        </div>
                        <!-- Gambar 2 -->
                        <div class="row align-items-end">
                            <div class="col-md-5 mb-3">
                                <label class="form-label">Gambar 2 (URL)</label>
                                <input type="text" class="form-control bg-dark text-white border-secondary"
                                    id="productImage2" placeholder="https://... atau /foto/..."
                                    onchange="previewImage(2)">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">atau Upload File</label>
                                <input type="file" class="form-control bg-dark text-white border-secondary"
                                    id="productFile2" accept="image/*" onchange="handleFileUpload(2)">
                            </div>
                            <div class="col-md-3 mb-3 text-center">
                                <label class="form-label">Preview</label>
                                <div id="imagePreview2"
                                    style="width: 70px; height: 70px; border: 1px dashed #666; border-radius: 8px; display: flex; align-items: center; justify-content: center; margin: auto; overflow: hidden;">
                                    <i class="bi bi-image text-secondary fs-4"></i>
                                </div>
                            </div>
                        </div>
                        <!-- Gambar 3 -->
                        <div class="row align-items-end">
                            <div class="col-md-5 mb-3">
                                <label class="form-label">Gambar 3 (URL)</label>
                                <input type="text" class="form-control bg-dark text-white border-secondary"
                                    id="productImage3" placeholder="https://... atau /foto/..."
                                    onchange="previewImage(3)">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">atau Upload File</label>
                                <input type="file" class="form-control bg-dark text-white border-secondary"
                                    id="productFile3" accept="image/*" onchange="handleFileUpload(3)">
                            </div>
                            <div class="col-md-3 mb-3 text-center">
                                <label class="form-label">Preview</label>
                                <div id="imagePreview3"
                                    style="width: 70px; height: 70px; border: 1px dashed #666; border-radius: 8px; display: flex; align-items: center; justify-content: center; margin: auto; overflow: hidden;">
                                    <i class="bi bi-image text-secondary fs-4"></i>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Deskripsi</label>
                            <textarea class="form-control bg-dark text-white border-secondary" id="productDescription"
                                rows="3"></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary" onclick="saveProduct()">Simpan</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo url('/js/api.js'); ?>"></script>
    <script>
        let productModal;
        let editingId = null;
        let uploadedFiles = { 1: null, 2: null, 3: null };

        document.addEventListener('DOMContentLoaded', async () => {
            const user = PARFY.getUser();
            if (!user || user.role !== 'admin') {
                window.location.href = '/coding web IMK/parfy-php/admin/login.php';
                return;
            }

            productModal = new bootstrap.Modal(document.getElementById('productModal'));
            await loadProducts();
        });

        async function loadProducts() {
            try {
                const products = await PARFY.products.getAll();
                const tbody = document.getElementById('productsTable');

                tbody.innerHTML = products.map(p => {
                    // Support both single image and array of images
                    const firstImage = Array.isArray(p.images) ? p.images[0] : p.image;
                    return `
                    <tr>
                        <td>
                            <img src="${firstImage || '/coding web IMK/parfy-php/foto/default.jpg'}" alt="${p.name}" 
                                 style="width: 80px; height: 80px; object-fit: cover; border-radius: 6px;"
                                 onerror="this.onerror=null; this.src='<?php echo url('/assets/default.jpg'); ?>';">
                        </td>
                        <td>${p.name}</td>
                        <td><span class="badge bg-info">${p.brand || '-'}</span></td>
                        <td><span class="badge bg-secondary">${p.category}</span></td>
                        <td>${PARFY.formatRupiah(p.price)}</td>
                        <td><span class="badge ${p.stock < 10 ? 'bg-danger' : 'bg-success'}">${p.stock}</span></td>
                        <td>
                            <button class="btn-action text-warning" onclick="editProduct('${p.id}')" title="Edit">
                                <i class="bi bi-pencil-square"></i>
                            </button>
                            <button class="btn-action text-danger" onclick="deleteProduct('${p.id}')" title="Hapus">
                                <i class="bi bi-trash"></i>
                            </button>
                        </td>
                    </tr>`;
                }).join('');
            } catch (error) {
                console.error('Error loading products:', error);
            }
        }

        function showAddModal() {
            editingId = null;
            uploadedFiles = { 1: null, 2: null, 3: null };
            document.getElementById('modalTitle').textContent = 'Tambah Produk Baru';
            document.getElementById('productForm').reset();
            // Reset all previews
            for (let i = 1; i <= 3; i++) {
                document.getElementById(`imagePreview${i}`).innerHTML = '<i class="bi bi-image text-secondary fs-4"></i>';
                document.getElementById(`productImage${i}`).value = '';
                document.getElementById(`productFile${i}`).value = '';
            }
            productModal.show();
        }

        function previewImage(num) {
            const url = document.getElementById(`productImage${num}`).value;
            const preview = document.getElementById(`imagePreview${num}`);
            if (url) {
                preview.innerHTML = `<img src="${url}" style="width: 100%; height: 100%; object-fit: cover;" onerror="this.parentElement.innerHTML='<i class=\\'bi bi-x-circle text-danger fs-4\\'></i>'">`;
                // Clear file input if URL is entered
                document.getElementById(`productFile${num}`).value = '';
                uploadedFiles[num] = null;
            } else {
                preview.innerHTML = '<i class="bi bi-image text-secondary fs-4"></i>';
            }
        }

        function handleFileUpload(num) {
            const fileInput = document.getElementById(`productFile${num}`);
            const preview = document.getElementById(`imagePreview${num}`);
            const file = fileInput.files[0];

            if (file) {
                uploadedFiles[num] = file;
                const reader = new FileReader();
                reader.onload = function (e) {
                    preview.innerHTML = `<img src="${e.target.result}" style="width: 100%; height: 100%; object-fit: cover;">`;
                    // Clear URL input if file is uploaded
                    document.getElementById(`productImage${num}`).value = '';
                };
                reader.readAsDataURL(file);
            }
        }

        async function uploadFile(file) {
            const formData = new FormData();
            formData.append('image', file);

            const token = localStorage.getItem('parfy_token');
            const response = await fetch('/coding web IMK/parfy-php/api/products/upload', {
                method: 'POST',
                headers: { 'Authorization': `Bearer ${token}` },
                body: formData
            });

            if (!response.ok) throw new Error('Upload gagal');
            const result = await response.json();
            return result.url;
        }

        async function editProduct(id) {
            try {
                const product = await PARFY.products.getById(id);
                editingId = id;
                uploadedFiles = { 1: null, 2: null, 3: null };

                document.getElementById('modalTitle').textContent = 'Edit Produk';
                document.getElementById('productId').value = product.id;
                document.getElementById('productName').value = product.name;
                document.getElementById('productBrand').value = product.brand || '';
                document.getElementById('productCategory').value = product.category;
                document.getElementById('productPrice').value = product.price;
                document.getElementById('productStock').value = product.stock;
                document.getElementById('productSize').value = product.size || '';
                document.getElementById('productScentCategory').value = product.scent_category || '';
                document.getElementById('productAroma').value = product.aroma || '';
                document.getElementById('productDescription').value = product.description || '';

                // Handle images - support both old single image and new array format
                const images = product.images || [product.image || '', '', ''];
                for (let i = 1; i <= 3; i++) {
                    const imgUrl = images[i - 1] || '';
                    document.getElementById(`productImage${i}`).value = imgUrl;
                    document.getElementById(`productFile${i}`).value = '';
                    previewImage(i);
                }

                productModal.show();
            } catch (error) {
                Swal.fire('Error!', error.message, 'error');
            }
        }

        async function saveProduct() {
            // Collect images from URLs and uploads
            const images = [];

            for (let i = 1; i <= 3; i++) {
                const urlInput = document.getElementById(`productImage${i}`).value.trim();
                const fileUploaded = uploadedFiles[i];

                if (fileUploaded) {
                    // Upload file and get URL
                    try {
                        const uploadedUrl = await uploadFile(fileUploaded);
                        images.push(uploadedUrl);
                    } catch (e) {
                        console.error(`Error uploading image ${i}:`, e);
                        Swal.fire('Error!', `Gagal upload gambar ${i}`, 'error');
                        return;
                    }
                } else if (urlInput) {
                    images.push(urlInput);
                }
            }

            // Debug: Log collected images
            console.log('Collected images:', images);

            const data = {
                name: document.getElementById('productName').value,
                brand: document.getElementById('productBrand').value,
                category: document.getElementById('productCategory').value,
                price: parseInt(document.getElementById('productPrice').value),
                stock: parseInt(document.getElementById('productStock').value),
                size: document.getElementById('productSize').value,
                scent_category: document.getElementById('productScentCategory').value,
                aroma: document.getElementById('productAroma').value,
                images: images, // Array of image URLs
                image: images.length > 0 ? images[0] : '', // Keep first image for backward compatibility
                description: document.getElementById('productDescription').value
            };

            // Debug: Log data being sent
            console.log('Sending product data:', data);

            if (!data.name || !data.category || !data.price) {
                Swal.fire('Peringatan', 'Nama, Kategori, dan Harga wajib diisi!', 'warning');
                return;
            }

            try {
                if (editingId) {
                    await PARFY.products.update(editingId, data);
                    Swal.fire('Berhasil!', 'Produk berhasil diupdate!', 'success');
                } else {
                    await PARFY.products.create(data);
                    Swal.fire('Berhasil!', 'Produk berhasil ditambahkan!', 'success');
                }
                productModal.hide();
                await loadProducts();
            } catch (error) {
                Swal.fire('Error!', error.message, 'error');
            }
        }

        async function deleteProduct(id) {
            const result = await Swal.fire({
                title: 'Yakin ingin menghapus?',
                text: "Produk yang dihapus tidak bisa dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            });

            if (result.isConfirmed) {
                try {
                    await PARFY.products.delete(id);
                    Swal.fire('Berhasil!', 'Produk berhasil dihapus!', 'success');
                    await loadProducts();
                } catch (error) {
                    Swal.fire('Error!', error.message, 'error');
                }
            }
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
