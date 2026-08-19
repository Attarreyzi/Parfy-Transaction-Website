<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Produk | PARFY.ID</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
        <link
        href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        :root {
            --primary-bg: #0d3256;
            --secondary-bg: #f4f4f4;
            --text-color: #333;
            --accent-color: #82c4e4;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--secondary-bg);
            color: var(--text-color);
            padding-top: 80px;
        }

        /* Navbar (Consistent with Dashboard) */
        .navbar-custom {
            background: linear-gradient(to right, #0a1628, #0f1029);
            padding: 15px 0;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        }

        .navbar-brand img {
            width: 45px;
            margin-right: 12px;
            border-radius: 50%;
            border: 2px solid rgba(255, 255, 255, 0.2);
        }

        .navbar-brand span {
            font-family: 'Playfair Display', serif;
            font-size: 1.5rem;
            color: white;
            letter-spacing: 1px;
        }

        /* Detail Container */
        .detail-container {
            background: white;
            border-radius: 20px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            padding: 40px;
            margin-top: 30px;
            margin-bottom: 50px;
        }

        .product-image-box {
            background: #fff;
            border-radius: 20px;
            padding: 10px;
            text-align: center;
            position: relative;
            user-select: none;
        }

        .slider-wrapper {
            position: relative;
            overflow: hidden;
            border-radius: 18px;
            width: 100%;
            height: 380px;
            background: #f8fafc;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 16px rgba(0,0,0,0.06);
        }

        .slider-track {
            display: flex;
            transition: transform 0.4s cubic-bezier(0.25, 1, 0.5, 1);
            width: 100%;
            height: 100%;
        }

        .slider-slide {
            min-width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 15px;
        }

        .slider-slide img {
            max-width: 100%;
            max-height: 350px;
            object-fit: contain;
            border-radius: 12px;
            transition: transform 0.3s;
        }

        .slider-arrow {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            width: 44px;
            height: 44px;
            background: rgba(13, 50, 86, 0.82);
            color: white;
            border: none;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            z-index: 10;
            transition: all 0.25s ease;
            box-shadow: 0 4px 14px rgba(0,0,0,0.3);
            backdrop-filter: blur(5px);
            font-size: 1.2rem;
        }

        .slider-arrow:hover {
            background: #0d3256;
            transform: translateY(-50%) scale(1.12);
            box-shadow: 0 6px 18px rgba(0,0,0,0.4);
        }

        .slider-arrow.prev-arrow {
            left: 12px;
        }

        .slider-arrow.next-arrow {
            right: 12px;
        }

        .slider-counter {
            position: absolute;
            bottom: 12px;
            right: 12px;
            background: rgba(13, 50, 86, 0.75);
            color: white;
            font-size: 0.78rem;
            font-weight: 600;
            padding: 4px 12px;
            border-radius: 15px;
            letter-spacing: 0.5px;
            z-index: 10;
            backdrop-filter: blur(4px);
        }

        .thumbnail-gallery {
            display: flex;
            gap: 12px;
            justify-content: center;
            margin-top: 18px;
        }

        .thumb-item {
            width: 76px;
            height: 76px;
            border-radius: 14px;
            overflow: hidden;
            cursor: pointer;
            border: 2.5px solid transparent;
            background: #f1f5f9;
            transition: all 0.25s ease;
            padding: 3px;
        }

        .thumb-item img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            border-radius: 9px;
            background: #fff;
        }

        .thumb-item:hover {
            border-color: #93c5fd;
            transform: translateY(-2px);
        }

        .thumb-item.active {
            border-color: var(--primary-bg);
            box-shadow: 0 0 0 3px rgba(13, 50, 86, 0.25);
            transform: scale(1.06);
        }

        .product-info h1 {
            font-family: 'Playfair Display', serif;
            font-weight: 700;
            color: var(--primary-bg);
            margin-bottom: 10px;
            font-size: 2.2rem;
        }

        .price-tag {
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--primary-bg);
            margin-bottom: 20px;
        }

        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
            margin-bottom: 25px;
        }

        .info-item label {
            font-size: 0.85rem;
            color: #777;
            display: block;
            margin-bottom: 2px;
        }

        .info-item span {
            font-weight: 500;
            font-size: 1rem;
        }

        .description-box {
            margin-bottom: 30px;
            line-height: 1.6;
            color: #555;
        }

        .action-area {
            display: flex;
            gap: 15px;
            align-items: center;
            margin-top: 30px;
            flex-wrap: wrap;
        }

        .qty-input-group {
            display: flex;
            align-items: center;
            border: 1px solid #ddd;
            border-radius: 30px;
            overflow: hidden;
            height: 50px;
        }

        .qty-btn {
            background: white;
            border: none;
            width: 40px;
            height: 100%;
            font-size: 1.2rem;
            color: var(--primary-bg);
            cursor: pointer;
        }

        .qty-val {
            width: 50px;
            text-align: center;
            border: none;
            font-weight: 600;
            font-size: 1.1rem;
        }

        .btn-add-cart {
            background: white;
            color: var(--primary-bg);
            border: 2px solid var(--primary-bg);
            border-radius: 30px;
            padding: 12px 30px;
            font-weight: 600;
            font-size: 1rem;
            transition: 0.3s;
        }

        .btn-add-cart:hover {
            background: #f0f0f0;
        }

        .btn-buy-now {
            background: var(--primary-bg);
            color: white;
            border: none;
            border-radius: 30px;
            padding: 12px 40px;
            font-weight: 600;
            font-size: 1rem;
            box-shadow: 0 4px 10px rgba(13, 50, 86, 0.3);
            transition: 0.3s;
        }

        .btn-buy-now:hover {
            background: #0a2540;
            transform: translateY(-2px);
        }

        .back-link {
            text-decoration: none;
            color: #777;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 20px;
            font-weight: 500;
            transition: 0.3s;
        }

        .back-link:hover {
            color: var(--primary-bg);
            transform: translateX(-5px);
        }

        @media (max-width: 768px) {
            .product-image-box {
                margin-bottom: 30px;
            }

            .action-area {
                flex-direction: column;
                align-items: stretch;
            }

            .btn-add-cart,
            .btn-buy-now {
                width: 100%;
            }

            .qty-input-group {
                justify-content: center;
            }
        }
    </style>
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar navbar-custom fixed-top">
        <div class="container px-4">
            <a class="navbar-brand d-flex align-items-center" id="brandLogo" href="/coding web IMK/parfy-php/dashboard">
                <img src="/coding web IMK/parfy-php/assets/logo_parfum_bk.png" alt="Logo">
                <span>PARFY.ID</span>
            </a>
            <div class="d-flex align-items-center">
                <a href="/coding web IMK/parfy-php/keranjang" onclick="return handleCartClick(event)" style="color:white; font-size:1.5rem; position:relative;">
                    <i class="bi bi-cart"></i>
                    <span id="cart-count" class="badge bg-danger rounded-circle"
                        style="font-size:0.6rem; position:absolute; top:-5px; right:-8px; display:none;">0</span>
                </a>
            </div>
        </div>
    </nav>

    <div class="container">
        <a href="/coding web IMK/parfy-php/dashboard" class="back-link" id="navBackLink">
            <i class="bi bi-arrow-left"></i> Kembali ke Dashboard
        </a>

        <div class="detail-container">
            <div class="row">
                <!-- Left: Image Slider (Up to 3 images from Admin) -->
                <div class="col-lg-5">
                    <div class="product-image-box">
                        <div class="slider-wrapper" id="sliderWrapper">
                            <div class="slider-track" id="sliderTrack">
                                <div class="slider-slide">
                                    <img id="product-img" src="/coding web IMK/parfy-php/foto/default.jpg" alt="Produk">
                                </div>
                            </div>
                            <button class="slider-arrow prev-arrow" id="prevSlideBtn" onclick="slideImage(-1)" style="display:none;" title="Foto Sebelumnya">
                                <i class="bi bi-chevron-left"></i>
                            </button>
                            <button class="slider-arrow next-arrow" id="nextSlideBtn" onclick="slideImage(1)" style="display:none;" title="Foto Selanjutnya">
                                <i class="bi bi-chevron-right"></i>
                            </button>
                            <div class="slider-counter" id="sliderCounter" style="display:none;">1 / 1</div>
                        </div>

                        <!-- Thumbnail Gallery (Up to 3 images) -->
                        <div class="thumbnail-gallery" id="thumbnailGallery" style="display:none;"></div>
                    </div>
                </div>

                <!-- Right: Details -->
                <div class="col-lg-7">
                    <div class="product-info ps-lg-4">
                        <h1 id="product-name">Loading Produk...</h1>
                        <p class="text-muted mb-2" id="product-brand">Brand</p>

                        <div class="price-tag" id="product-price">Rp 0</div>

                        <div class="info-grid">
                            <div class="info-item">
                                <label>Kategori</label>
                                <span id="product-category">-</span>
                            </div>
                            <div class="info-item">
                                <label>Ukuran</label>
                                <span id="product-size">-</span>
                            </div>
                            <div class="info-item">
                                <label>Stok</label>
                                <span id="product-stock">-</span>
                            </div>
                            <div class="info-item">
                                <label>Terjual</label>
                                <span id="product-sold">-</span>
                            </div>
                        </div>

                        <div class="description-box">
                            <h5 style="font-weight:600; font-size:1.1rem; margin-bottom:10px;">Deskripsi & Aroma</h5>
                            <p id="product-desc">Memuat deskripsi...</p>
                        </div>

                        <div class="description-box" id="aroma-box">
                            <h5 style="font-weight:600; font-size:1.1rem; margin-bottom:10px;">Main Accords</h5>
                            <p id="product-aroma">-</p>
                        </div>

                        <hr>

                        <div class="action-area">
                            <div class="qty-input-group">
                                <button class="qty-btn" onclick="updateQty(-1)">-</button>
                                <input type="number" id="qty-val" class="qty-val" value="1" min="1" readonly>
                                <button class="qty-btn" onclick="updateQty(1)">+</button>
                            </div>

                            <button class="btn-add-cart" onclick="addToCart()">
                                <i class="bi bi-cart-plus me-2"></i> + Keranjang
                            </button>

                            <button class="btn-buy-now" onclick="buyNow()">
                                Beli Sekarang
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Customer Reviews Section -->
            <div class="card border-0 shadow-sm mt-4 p-4" style="border-radius: 16px; background: white;">
                <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
                    <div>
                        <h4 class="fw-bold mb-1" style="color: var(--primary-bg, #0d3256);">Ulasan Pembeli</h4>
                        <div id="reviewSummary" class="d-flex align-items-center gap-2">
                            <span class="text-warning fs-5"><i class="bi bi-star-fill"></i> <strong id="avgRating">0.0</strong> / 5.0</span>
                            <span class="text-muted" id="totalReviewCount">(0 Ulasan)</span>
                        </div>
                    </div>
                    <button class="btn btn-outline-primary fw-semibold" onclick="openReviewModal()" style="border-radius: 8px;">
                        <i class="bi bi-pencil-square me-1"></i> Tulis Ulasan
                    </button>
                </div>

                <div id="reviewsListContainer">
                    <div class="text-center py-4 text-muted">
                        <div class="spinner-border spinner-border-sm text-primary me-2"></div> Memuat ulasan...
                    </div>
                </div>
            </div>
        </div>
    <script src="/coding web IMK/parfy-php/js/api.js?v=2"></script>
    <!-- Review Modal -->
    <div id="reviewModal" style="display:none; position:fixed; z-index:1000; left:0; top:0; width:100%; height:100%; background:rgba(0,0,0,0.5); align-items:center; justify-content:center;">
      <div style="background:white; padding:30px; border-radius:15px; width:90%; max-width:400px; position:relative; box-shadow:0 5px 20px rgba(0,0,0,0.2);">
        <span onclick="closeReviewModal()" style="position:absolute; top:15px; right:20px; font-size:24px; cursor:pointer; color:#999;">&times;</span>
        <h3 style="margin-top:0;">Tulis Ulasan</h3>
        <p id="reviewProductName" style="font-weight:600;"></p>
        
        <div style="margin-bottom: 15px; text-align:center; font-size: 2.5rem; color: #ccc; cursor:pointer;" id="starRating">
           <span data-val="1">★</span><span data-val="2">★</span><span data-val="3">★</span><span data-val="4">★</span><span data-val="5">★</span>
        </div>
        <input type="hidden" id="reviewRating" value="5">

        <textarea id="reviewComment" rows="4" placeholder="Bagaimana kualitas produk ini?" style="width:100%; padding:10px; border-radius:8px; border:1px solid #ccc; margin-bottom:20px; box-sizing:border-box;"></textarea>
        
        <div style="display:flex; justify-content:end; gap:10px;">
          <button onclick="closeReviewModal()" style="padding:10px 20px; background:#ddd; border:none; border-radius:8px; cursor:pointer;">Batal</button>
          <button onclick="submitReview()" style="padding:10px 20px; background:var(--primary-bg); color:white; border:none; border-radius:8px; cursor:pointer;">Kirim Ulasan</button>
        </div>
      </div>
    </div>

<script>
        let currentProduct = null;
        const urlParams = new URLSearchParams(window.location.search);
        const productId = urlParams.get('id');

        // SweetAlert prompt login helper
        function promptLogin(actionText = 'mengakses fitur ini') {
            Swal.fire({
                title: 'Perlu Login!',
                text: `Silakan login terlebih dahulu untuk ${actionText}.`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#005c97',
                cancelButtonColor: '#6c757d',
                confirmButtonText: '<i class="bi bi-box-arrow-in-right me-1"></i> Login Sekarang',
                cancelButtonText: 'Batal',
                background: '#ffffff'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = '/coding web IMK/parfy-php/login';
                }
            });
        }

        function handleCartClick(event) {
            if (!PARFY.getUser()) {
                if (event) event.preventDefault();
                promptLogin('melihat keranjang belanja');
                return false;
            }
            return true;
        }

        document.addEventListener('DOMContentLoaded', () => {
            const user = PARFY.getUser();
            const brandLogo = document.getElementById('brandLogo');
            const navBackLink = document.getElementById('navBackLink');

            if (!user) {
                if (brandLogo) brandLogo.href = '/coding web IMK/parfy-php/';
                if (navBackLink) {
                    navBackLink.href = '/coding web IMK/parfy-php/';
                    navBackLink.innerHTML = '<i class="bi bi-arrow-left"></i> Kembali ke Beranda';
                }
            } else {
                loadCartCount();
            }

            if (productId) {
                loadProductDetail(productId);
            } else {
                Swal.fire('Info', 'Produk tidak ditemukan!', 'info');
                window.location.href = user ? '/coding web IMK/parfy-php/dashboard' : '/coding web IMK/parfy-php/';
            }
        });

        async function loadProductDetail(id) {
            try {
                const product = await PARFY.products.getById(id);
                currentProduct = product;
                renderProduct(product);
                loadReviews(id);
            } catch (error) {
                console.error('Error:', error);
                const user = PARFY.getUser();
                document.querySelector('.detail-container').innerHTML = `
                    <div class="text-center py-5">
                        <h3>Produk tidak ditemukan</h3><p>${error.message}</p>
                        <a href="${user ? '/coding web IMK/parfy-php/dashboard' : '/coding web IMK/parfy-php/'}" class="btn btn-primary mt-3">Kembali</a>
                    </div>
                `;
            }
        }

        let currentImageIndex = 0;
        let productImagesList = [];

        function renderProductImages(images) {
            if (!Array.isArray(images) || images.length === 0) {
                const single = currentProduct && currentProduct.image ? currentProduct.image : '/coding web IMK/parfy-php/foto/default.jpg';
                images = [single];
            }
            // Limit to max 3 images matching admin capability
            productImagesList = images.slice(0, 3);
            currentImageIndex = 0;

            const track = document.getElementById('sliderTrack');
            const prevBtn = document.getElementById('prevSlideBtn');
            const nextBtn = document.getElementById('nextSlideBtn');
            const counter = document.getElementById('sliderCounter');
            const thumbGallery = document.getElementById('thumbnailGallery');

            if (!track) return;

            track.innerHTML = productImagesList.map((img, idx) => `
                <div class="slider-slide">
                    <img src="${img}" alt="${currentProduct ? escapeHtml(currentProduct.name) : 'Produk'} - Foto ${idx + 1}" onerror="this.src='/coding web IMK/parfy-php/foto/default.jpg'">
                </div>
            `).join('');

            if (productImagesList.length > 1) {
                if (prevBtn) prevBtn.style.display = 'flex';
                if (nextBtn) nextBtn.style.display = 'flex';
                if (counter) counter.style.display = 'block';
                if (thumbGallery) {
                    thumbGallery.style.display = 'flex';
                    thumbGallery.innerHTML = productImagesList.map((img, idx) => `
                        <div class="thumb-item ${idx === 0 ? 'active' : ''}" onclick="goToSlide(${idx})">
                            <img src="${img}" alt="Thumbnail ${idx + 1}" onerror="this.src='/coding web IMK/parfy-php/foto/default.jpg'">
                        </div>
                    `).join('');
                }
            } else {
                if (prevBtn) prevBtn.style.display = 'none';
                if (nextBtn) nextBtn.style.display = 'none';
                if (counter) counter.style.display = 'none';
                if (thumbGallery) thumbGallery.style.display = 'none';
            }

            updateSliderPosition();
            setupSliderSwipe();
        }

        function slideImage(direction) {
            if (productImagesList.length <= 1) return;
            currentImageIndex += direction;
            if (currentImageIndex < 0) {
                currentImageIndex = productImagesList.length - 1;
            } else if (currentImageIndex >= productImagesList.length) {
                currentImageIndex = 0;
            }
            updateSliderPosition();
        }

        function goToSlide(index) {
            if (index < 0 || index >= productImagesList.length) return;
            currentImageIndex = index;
            updateSliderPosition();
        }

        function updateSliderPosition() {
            const track = document.getElementById('sliderTrack');
            if (track) {
                track.style.transform = `translateX(-${currentImageIndex * 100}%)`;
            }

            const counter = document.getElementById('sliderCounter');
            if (counter && productImagesList.length > 1) {
                counter.textContent = `${currentImageIndex + 1} / ${productImagesList.length}`;
            }

            const thumbs = document.querySelectorAll('.thumb-item');
            thumbs.forEach((thumb, idx) => {
                if (idx === currentImageIndex) {
                    thumb.classList.add('active');
                } else {
                    thumb.classList.remove('active');
                }
            });
        }

        let isSwipeBound = false;
        function setupSliderSwipe() {
            if (isSwipeBound) return;
            const sliderWrapper = document.getElementById('sliderWrapper');
            if (!sliderWrapper) return;

            let touchStartX = 0;
            let touchEndX = 0;

            sliderWrapper.addEventListener('touchstart', e => {
                touchStartX = e.changedTouches[0].screenX;
            }, { passive: true });

            sliderWrapper.addEventListener('touchend', e => {
                touchEndX = e.changedTouches[0].screenX;
                if (touchStartX - touchEndX > 40) {
                    slideImage(1); // Swipe left -> Next
                } else if (touchEndX - touchStartX > 40) {
                    slideImage(-1); // Swipe right -> Prev
                }
            }, { passive: true });

            isSwipeBound = true;
        }

        function escapeHtml(str) {
            if (!str) return '';
            return str.replace(/[&<>"']/g, function(m) {
                return { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#039;' }[m];
            });
        }

        function renderProduct(p) {
            document.title = `${p.name} | PARFY.ID`;

            // Render up to 3 images in slider
            const imgs = Array.isArray(p.images) && p.images.length > 0 
                ? p.images 
                : (p.image ? [p.image] : []);
            renderProductImages(imgs);

            document.getElementById('product-name').textContent = p.name;
            document.getElementById('product-brand').textContent = p.brand || '-';
            document.getElementById('product-price').textContent = PARFY.formatRupiah(p.price);

            document.getElementById('product-category').textContent = p.category || '-';
            document.getElementById('product-size').textContent = p.size || '-';
            document.getElementById('product-stock').textContent = p.stock > 0 ? `${p.stock} item` : 'Habis';
            document.getElementById('product-sold').textContent = `${p.sold || 0} terjual`;

            document.getElementById('product-desc').textContent = p.description || 'Tidak ada deskripsi.';
            document.getElementById('product-aroma').textContent = p.aroma || '-';

            // Check stock for buttons
            if (p.stock <= 0) {
                document.querySelector('.action-area').innerHTML = '<div class="alert alert-danger w-100">Stok Habis</div>';
            }
        }

        function updateQty(change) {
            const input = document.getElementById('qty-val');
            let val = parseInt(input.value) + change;
            if (val < 1) val = 1;
            if (currentProduct && val > currentProduct.stock) {
                alert(`Stok hanya tinggal ${currentProduct.stock}`);
                val = currentProduct.stock;
            }
            input.value = val;
        }

        
        async function addToCart() {
            if (!currentProduct) return false;
            
            if (!PARFY.auth.isLoggedIn() || !PARFY.getUser()) {
                promptLogin('menambahkan produk ke keranjang belanja');
                return false;
            }

            const btn = document.querySelector('.btn-add-cart');
            const originalHTML = btn.innerHTML;
            btn.innerHTML = '<span class="spinner-border spinner-border-sm"></span> Loading...';
            btn.disabled = true;

            const qty = parseInt(document.getElementById('qty-val').value);

            try {
                await PARFY.cart.add(currentProduct.id, qty);
                Swal.fire('Berhasil!', 'Berhasil masuk keranjang!', 'success');
                loadCartCount();
                btn.innerHTML = originalHTML;
                btn.disabled = false;
                return true;
            } catch (error) {
                btn.innerHTML = originalHTML;
                btn.disabled = false;
                if (error.message.toLowerCase().includes('login') || error.message.toLowerCase().includes('unauthorized') || error.message.toLowerCase().includes('token')) {
                    promptLogin('menambahkan produk ke keranjang belanja');
                } else {
                    Swal.fire('Error!', 'Gagal: ' + error.message, 'error');
                }
                return false;
            }
        }

        async function buyNow() {
            if (!currentProduct) return;

            if (!PARFY.auth.isLoggedIn() || !PARFY.getUser()) {
                promptLogin('melakukan pembelian produk ini');
                return;
            }

            const btn = document.querySelector('.btn-buy-now');
            const originalHTML = btn.innerHTML;
            btn.innerHTML = '<span class="spinner-border spinner-border-sm"></span> Loading...';
            btn.disabled = true;
            
            const qty = parseInt(document.getElementById('qty-val').value);
            try {
                await PARFY.cart.add(currentProduct.id, qty);
                window.location.href = '/coding web IMK/parfy-php/keranjang';
            } catch (error) {
                if (error.message.includes('login') || error.message.includes('unauthorized')) {
                    promptLogin('melakukan pembelian produk ini');
                } else {
                    Swal.fire('Error!', error.message, 'error');
                }
                btn.innerHTML = originalHTML;
                btn.disabled = false;
            }
        }

        async function loadCartCount() {
            if (!PARFY.auth.isLoggedIn()) return;
            try {
                const cart = await PARFY.cart.get();
                const count = cart.items ? cart.items.reduce((sum, item) => sum + item.quantity, 0) : 0;
                const badge = document.getElementById('cart-count');
                if (count > 0) {
                    badge.textContent = count;
                    badge.style.display = 'block';
                }
            } catch (e) {
                console.log('Cart fetch error', e);
            }
        }

        function openReviewModal() {
            if (!currentProduct) return;
            if (!PARFY.auth.isLoggedIn() || !PARFY.getUser()) {
                promptLogin('menulis ulasan untuk produk ini');
                return;
            }
            document.getElementById('reviewProductName').textContent = currentProduct.name;
            document.getElementById('reviewModal').style.display = 'flex';
            setStars(5);
            document.getElementById('reviewComment').value = '';
        }

        function closeReviewModal() {
            document.getElementById('reviewModal').style.display = 'none';
        }

        document.querySelectorAll('#starRating span').forEach(star => {
            star.addEventListener('click', function() {
                const val = this.getAttribute('data-val');
                setStars(val);
            });
        });

        function setStars(rating) {
            document.getElementById('reviewRating').value = rating;
            document.querySelectorAll('#starRating span').forEach(star => {
                if (parseInt(star.getAttribute('data-val')) <= parseInt(rating)) {
                    star.style.color = '#ffc107';
                } else {
                    star.style.color = '#ccc';
                }
            });
        }

        
        async function submitReview() {
            if (!currentProduct) return;

            if (!PARFY.auth.isLoggedIn() || !PARFY.getUser()) {
                closeReviewModal();
                promptLogin('mengirim ulasan produk');
                return;
            }

            const rating = parseInt(document.getElementById('reviewRating').value);
            const comment = document.getElementById('reviewComment').value.trim();

            if (!comment) {
                Swal.fire('Info', 'Mohon isi komentar ulasan Anda.', 'info');
                return;
            }

            Swal.fire({
                title: 'Mengirim Ulasan...',
                text: 'Mohon tunggu sebentar',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            try {
                await PARFY.reviews.create(currentProduct.id, '', rating, comment);
                Swal.fire('Berhasil!', 'Terima kasih atas ulasan Anda!', 'success');
                closeReviewModal();
                // Force reload of reviews by fetching again
                await loadReviews(currentProduct.id); 
            } catch (error) {
                if (error.message.toLowerCase().includes('login') || error.message.toLowerCase().includes('unauthorized') || error.message.toLowerCase().includes('token')) {
                    promptLogin('mengirim ulasan produk');
                } else {
                    Swal.fire('Error!', 'Gagal mengirim ulasan: ' + error.message, 'error');
                }
            }
        }

        async function loadReviews(prodId) {
            const container = document.getElementById('reviewsListContainer');
            if (!container) return;
            try {
                const reviews = await PARFY.reviews.getByProduct(prodId);
                const avgEl = document.getElementById('avgRating');
                const countEl = document.getElementById('totalReviewCount');
                
                if (!reviews || reviews.length === 0) {
                    if (avgEl) avgEl.textContent = '0.0';
                    if (countEl) countEl.textContent = '(0 Ulasan)';
                    container.innerHTML = `
                        <div class="text-center py-4 text-muted">
                            <i class="bi bi-chat-square-heart fs-1 d-block mb-2 text-secondary opacity-50"></i>
                            <p class="mb-0">Belum ada ulasan untuk produk ini. Jadilah yang pertama memberikan ulasan!</p>
                        </div>
                    `;
                    return;
                }
                
                const avg = (reviews.reduce((acc, r) => acc + (parseInt(r.rating) || 5), 0) / reviews.length).toFixed(1);
                if (avgEl) avgEl.textContent = avg;
                if (countEl) countEl.textContent = `(${reviews.length} Ulasan)`;
                
                container.innerHTML = reviews.map(r => {
                    const stars = Array(5).fill(0).map((_, idx) => 
                        `<i class="bi bi-star-fill ${idx < r.rating ? 'text-warning' : 'text-secondary opacity-25'}"></i>`
                    ).join('');
                    
                    return `
                        <div class="border-bottom py-3">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <div class="d-flex align-items-center gap-2">
                                    <div style="width: 38px; height: 38px; border-radius: 50%; background: #e9ecef; display: flex; align-items: center; justify-content: center; font-weight: bold; color: #495057;">
                                        ${(r.userName || 'U').charAt(0).toUpperCase()}
                                    </div>
                                    <div>
                                        <strong class="d-block text-dark">${r.userName || 'Pembeli'}</strong>
                                        <div style="font-size: 0.85rem;">${stars}</div>
                                    </div>
                                </div>
                                <small class="text-muted">${r.createdAt ? PARFY.formatDate(r.createdAt) : ''}</small>
                            </div>
                            <p class="mb-0 mt-2 text-secondary" style="font-size: 0.95rem; line-height: 1.5;">${r.comment || ''}</p>
                        </div>
                    `;
                }).join('');
            } catch (err) {
                console.error('Error loading reviews:', err);
                container.innerHTML = `<div class="text-center py-3 text-muted">Gagal memuat ulasan.</div>`;
            }
        }

    </script>


    
    </div>

</body>

</html>


