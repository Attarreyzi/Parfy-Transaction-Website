<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PARFY.ID - Premium Perfume Store</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <link
        href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Poppins:wght@300;400;500;700&display=swap"
        rel="stylesheet">

    <style>
        body {
            background: radial-gradient(circle at center, #005c97 0%, #0f1029 100%);
            min-height: 100vh;
            font-family: 'Poppins', sans-serif;
            color: white;
            overflow-x: hidden;
        }

        /* --- NAVBAR --- */
        .navbar-custom {
            padding: 15px 0;
            background: rgba(0, 0, 0, 0.1);
            backdrop-filter: blur(10px);
            transition: 0.3s;
            z-index: 1000;
        }

        .navbar-brand img {
            height: 80px;
            width: auto;
            margin-right: 12px;
        }

        .navbar-brand span {
            font-family: 'Playfair Display', serif;
            font-size: 1.5rem;
            font-weight: bold;
            letter-spacing: 2px;
            color: white;
        }

        .nav-pill-container {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(5px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 50px;
            padding: 8px 30px;
            display: flex;
            gap: 20px;
        }

        .nav-link {
            color: white !important;
            font-weight: 500;
            font-size: 0.85rem;
            letter-spacing: 1px;
            transition: 0.3s;
            text-transform: uppercase;
        }

        .nav-link:hover {
            color: #b4dfff !important;
            text-shadow: 0 0 10px rgba(180, 223, 255, 0.5);
        }

        .login-btn {
            color: white;
            font-weight: 500;
            border: 1px solid white;
            padding: 6px 20px;
            border-radius: 30px;
            text-decoration: none;
            font-size: 0.85rem;
            transition: 0.3s;
        }

        .login-btn:hover {
            background: white;
            color: #005c97;
        }

        .register-btn {
            color: #005c97;
            background: white;
            font-weight: 600;
            padding: 6px 20px;
            border-radius: 30px;
            margin-left: 10px;
            text-decoration: none;
            font-size: 0.85rem;
            transition: 0.3s;
        }

        .register-btn:hover {
            opacity: 0.8;
        }

        .topbar i {
            font-size: 1.2rem;
            margin-left: 20px;
            cursor: pointer;
            color: white;
            transition: 0.3s;
        }

        .topbar i:hover {
            color: #b4dfff;
            transform: scale(1.1);
        }

        /* --- HERO SECTION --- */
        .hero-section {
            padding-top: 180px;
            padding-bottom: 10px;
            position: relative;
        }

        .hero-title {
            font-family: 'Poppins', sans-serif;
            font-weight: 700;
            font-size: 3.5rem;
            line-height: 1.1;
            text-transform: uppercase;
            margin-bottom: 50px;
            text-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
        }

        .hero-text-side {
            font-size: 0.9rem;
            line-height: 1.8;
            opacity: 0.9;
            max-width: 250px;
        }

        .hero-image-container img {
            max-width: 100%;
            height: auto;
            max-height: 450px;
            filter: drop-shadow(0 20px 40px rgba(0, 0, 0, 0.4));
            animation: float 4s ease-in-out infinite;
        }

        @keyframes float {
            0% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-15px);
            }

            100% {
                transform: translateY(0px);
            }
        }

        .btn-search {
            border: 1px solid rgba(255, 255, 255, 0.6);
            color: white;
            padding: 8px 30px;
            margin-top: 15px;
            background: transparent;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 2px;
            font-size: 0.9rem;
        }

        .btn-search:hover {
            background: white;
            color: #005c97;
            box-shadow: 0 0 15px rgba(255, 255, 255, 0.5);
        }

        /* Search Box & Live Results Dropdown */
        .search-input-group {
            display: none;
            align-items: center;
            background: rgba(255, 255, 255, 0.18);
            border: 1px solid rgba(255, 255, 255, 0.35);
            border-radius: 25px;
            padding: 5px 14px;
            backdrop-filter: blur(12px);
            transition: all 0.3s ease;
        }

        .search-input-group input {
            background: transparent;
            border: none;
            outline: none;
            color: white;
            font-size: 0.85rem;
            width: 200px;
        }

        .search-input-group input::placeholder {
            color: rgba(255, 255, 255, 0.65);
        }

        .search-results-dropdown {
            background: rgba(15, 16, 41, 0.98) !important;
            backdrop-filter: blur(15px);
            scrollbar-width: thin;
            scrollbar-color: rgba(255,255,255,0.3) transparent;
        }

        .search-results-dropdown::-webkit-scrollbar {
            width: 6px;
        }

        .search-results-dropdown::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.3);
            border-radius: 10px;
        }

        .search-result-item {
            display: flex;
            align-items: center;
            padding: 8px 10px;
            border-radius: 10px;
            text-decoration: none;
            color: white;
            transition: background 0.2s ease;
            cursor: pointer;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        }

        .search-result-item:hover {
            background: rgba(255, 255, 255, 0.15);
            color: #ffd700;
        }

        .search-result-img {
            width: 42px;
            height: 42px;
            border-radius: 8px;
            object-fit: cover;
            margin-right: 12px;
            background: #fff;
            padding: 2px;
        }

        .search-result-info {
            flex: 1;
            overflow: hidden;
        }

        .search-result-title {
            font-size: 0.85rem;
            font-weight: 600;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            margin-bottom: 2px;
        }

        .search-result-meta {
            font-size: 0.75rem;
            color: rgba(255, 255, 255, 0.6);
            display: flex;
            justify-content: space-between;
        }

        .search-result-price {
            color: #ffd700;
            font-weight: 600;
        }

        /* --- MENU SECTION (BEST NOTES) --- */
        .menu-section {
            margin-top: 20px;
            margin-bottom: 60px;
            text-align: center;
        }

        .section-title {
            font-family: 'Playfair Display', serif;
            margin-bottom: 50px;
            font-size: 2.5rem;
            position: relative;
            display: inline-block;
        }

        .section-title::after {
            content: '';
            display: block;
            width: 60px;
            height: 3px;
            background: #b4dfff;
            margin: 15px auto 0;
        }

        .category-item {
            text-align: center;
            cursor: pointer;
            padding: 10px;
            transition: 0.3s;
        }

        .img-circle-wrapper {
            width: 200px;
            height: 200px;
            margin: 0 auto 20px;
            border-radius: 50%;
            overflow: hidden;
            border: 3px solid rgba(255, 255, 255, 0.3);
            background: white;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.4);
            transition: all 0.4s ease;
        }

        .img-circle-wrapper img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .category-item:hover .img-circle-wrapper {
            transform: translateY(-15px);
            border-color: #b4dfff;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.5);
        }

        .category-title {
            font-family: 'Playfair Display', serif;
            font-weight: 600;
            font-size: 1.1rem;
            letter-spacing: 1px;
            margin-top: 15px;
        }

        /* --- PROMO SECTION --- */
        .promo-section {
            padding: 20px 0 60px 0;
        }

        .promo-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            margin-bottom: 30px;
            padding: 0 10px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            padding-bottom: 10px;
        }

        .promo-title {
            font-family: 'Poppins', sans-serif;
            font-weight: 700;
            font-size: 2rem;
            margin: 0;
        }

        .promo-link {
            color: white;
            text-decoration: none;
            font-size: 0.9rem;
            opacity: 0.8;
            transition: 0.3s;
        }

        .promo-link:hover {
            opacity: 1;
            color: #b4dfff;
        }

        .promo-item {
            text-align: center;
            margin-bottom: 20px;
            cursor: pointer;
        }

        .promo-img-wrap {
            width: 130px;
            height: 130px;
            margin: 0 auto 15px;
            border-radius: 50%;
            overflow: hidden;
            border: 3px solid rgba(255, 255, 255, 0.8);
            background: #fff;
            transition: transform 0.3s ease, border-color 0.3s ease;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
        }

        .promo-img-wrap img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .promo-name {
            font-size: 0.9rem;
            font-weight: 500;
            margin-top: 10px;
            letter-spacing: 0.5px;
        }

        .promo-item:hover .promo-img-wrap {
            transform: scale(1.1);
            border-color: #b4dfff;
        }

        /* Discount Badge for Promo */
        .promo-item {
            position: relative;
        }

        .discount-badge {
            position: absolute;
            top: 5px;
            right: 5px;
            background: linear-gradient(135deg, #ff416c, #ff4b2b);
            color: white;
            padding: 4px 10px;
            border-radius: 12px;
            font-size: 0.7rem;
            font-weight: bold;
            z-index: 10;
            box-shadow: 0 2px 8px rgba(255, 65, 108, 0.4);
        }

        .promo-price {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 2px;
            margin-top: 5px;
        }

        .promo-price .original {
            text-decoration: line-through;
            color: rgba(255, 255, 255, 0.5);
            font-size: 0.75rem;
        }

        .promo-price .discounted {
            color: #ffd700;
            font-weight: bold;
            font-size: 0.9rem;
        }


        /* --- NEW: KOLEKSI PARFUM SECTION --- */
        .collection-section {
            padding: 40px 0 100px 0;
        }

        .collection-header {
            font-family: 'Poppins', sans-serif;
            font-weight: 700;
            font-size: 2rem;
            text-transform: uppercase;
            border-bottom: 2px solid rgba(255, 255, 255, 0.8);
            padding-bottom: 10px;
            margin-bottom: 40px;
            text-align: left;
        }

        /* Desain Kartu Produk */
        .product-card {
            background: white;
            border-radius: 20px;
            padding: 15px;
            position: relative;
            transition: transform 0.3s;
            margin-bottom: 30px;
            color: #333;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .product-card:hover {
            transform: translateY(-5px);
        }

        /* Label HOT (Kiri Atas) */
        .badge-hot {
            position: absolute;
            top: 15px;
            left: 15px;
            background: #dcdcdc;
            color: #333;
            padding: 4px 10px;
            border-radius: 8px;
            font-size: 0.7rem;
            font-weight: bold;
            letter-spacing: 1px;
            z-index: 10;
        }

        /* Ikon Keranjang (Kanan Atas) */
        .icon-cart-card {
            position: absolute;
            top: 15px;
            right: 15px;
            background: #333;
            color: white;
            width: 30px;
            height: 30px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.9rem;
            cursor: pointer;
            z-index: 10;
        }

        /* Gambar Produk */
        .product-img-container {
            text-align: center;
            margin: 20px 0;
            height: 150px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .product-img {
            max-height: 140px;
            max-width: 100%;
            object-fit: contain;
        }

        /* Bar Nama Produk (Biru Muda) */
        .product-name-bar {
            background: #82c4e4;
            /* Warna biru muda sesuai gambar */
            border-radius: 15px;
            padding: 8px 15px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
            color: white;
        }

        .product-title {
            font-size: 0.8rem;
            font-weight: 600;
            margin: 0;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 80%;
        }

        .product-like {
            background: #d63384;
            /* Pink love */
            width: 24px;
            height: 24px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.7rem;
        }

        /* Footer Kartu (Tombol & Harga) */
        .card-footer-custom {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .btn-buy-now {
            background: #dcdcdc;
            color: #333;
            border: none;
            border-radius: 20px;
            padding: 5px 15px;
            font-size: 0.75rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 5px;
            text-decoration: none;
            transition: 0.3s;
        }

        .btn-buy-now:hover {
            background: #c0c0c0;
            color: #000;
        }

        .price-pill {
            background: white;
            border: 1px solid #ccc;
            border-radius: 20px;
            padding: 4px 12px;
            font-size: 0.8rem;
            font-weight: bold;
            color: #333;
        }

        /* Pagination */
        .pagination-custom .page-link {
            border-radius: 50%;
            width: 40px;
            height: 40px;
            margin: 0 5px;
            border: none;
            color: #333;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
        }

        .pagination-custom .page-item.active .page-link {
            background: white;
            color: #005c97;
        }

        .pagination-custom .page-item .page-link {
            background: rgba(255, 255, 255, 0.8);
        }

        /* Responsiveness */
        @media (max-width: 768px) {
            .hero-title {
                font-size: 2rem;
                margin-bottom: 30px;
            }

            .hero-text-side {
                margin: 0 auto 20px auto;
                text-align: center !important;
            }

            .hero-section {
                padding-top: 140px;
                text-align: center;
            }

            .promo-img-wrap {
                width: 100px;
                height: 100px;
            }

            .collection-header {
                font-size: 1.5rem;
                text-align: center;
            }
        }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>

    <!-- NAVBAR -->
    <nav class="navbar navbar-expand-lg navbar-custom fixed-top">
        <div class="container-fluid px-4 px-lg-5">
            <a class="navbar-brand d-flex align-items-center" href="#">
                <img src="/coding web IMK/parfy-php/assets/logo_parfum_bk.png" alt="Logo">
                <span>PARFY.ID</span>
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon" style="filter: invert(1);"></span>
            </button>

            <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
            <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
                <div class="nav-pill-container mt-3 mt-lg-0">
                    <a class="nav-link" href="#collection-section">PARFUME</a>
                    <a class="nav-link" href="#best-seller">BEST SELLER</a>
                    <a class="nav-link" href="#footer">ABOUT US</a>
                </div>
                <!-- Mobile Search Input -->
                <div class="d-lg-none my-3 px-3 w-100">
                    <div class="input-group">
                        <input type="text" class="form-control text-white" placeholder="Cari parfum, aroma..." id="mobileSearchInput" oninput="handleSearch(this.value)" onkeyup="handleSearchKey(event)" style="border-radius: 20px 0 0 20px; font-size: 0.85rem; background: rgba(255,255,255,0.15); border: 1px solid rgba(255,255,255,0.3);">
                        <button class="btn btn-outline-light" type="button" onclick="applySearchToCollection()" style="border-radius: 0 20px 20px 0;"><i class="bi bi-search"></i></button>
                    </div>
                </div>
            </div>

            <!-- SEARCH BUTTON -->
            <div class="d-flex align-items-center ms-auto">
                <div class="search-box-wrapper me-3 d-none d-lg-block" id="searchBoxWrapper" style="position: relative;">
                    <div class="search-input-group" id="searchInputGroup">
                        <i class="bi bi-search text-white-50 me-2" style="font-size: 0.9rem;"></i>
                        <input type="text" id="navbarSearchInput" placeholder="Cari parfum, aroma..." oninput="handleSearch(this.value)" onkeyup="handleSearchKey(event)">
                        <i class="bi bi-x-lg text-white-50" style="cursor: pointer; font-size: 0.8rem; margin-left: 8px;" onclick="closeSearch()"></i>
                    </div>
                    <i class="bi bi-search text-white" id="searchToggleBtn" title="Cari Parfum" onclick="toggleSearch()" style="cursor:pointer; font-size: 1.15rem;"></i>
                    
                    <!-- Live Search Dropdown Results -->
                    <div id="searchResultsDropdown" class="search-results-dropdown" style="display: none; position: absolute; top: calc(100% + 12px); right: 0; width: 340px; max-height: 400px; overflow-y: auto; border: 1px solid rgba(255, 255, 255, 0.2); border-radius: 15px; box-shadow: 0 10px 30px rgba(0,0,0,0.7); z-index: 1050; padding: 10px;">
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- HERO SECTION -->
    <section class="hero-section text-center">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12">
                    <h1 class="hero-title">
                        AROMA<br>KEANGGUNAN YANG<br>MENGINSPIRASI
                    </h1>
                </div>
            </div>
            <div class="row align-items-center justify-content-center">
                <div
                    class="col-md-3 text-md-end text-center mb-4 mb-md-0 d-flex justify-content-md-end justify-content-center">
                    <p class="hero-text-side">Menghadirkan Sentuhan Elegan dan Pesona Abadi dalam Setiap Tetes Parfum
                    </p>
                </div>
                <div class="col-md-5 text-center mb-4 mb-md-0">
                    <div class="hero-image-container">
                        <img src="/coding web IMK/parfy-php/assets/logotengah.png" alt="Hero Parfum">
                    </div>
                </div>
                <div
                    class="col-md-3 text-md-start text-center d-flex flex-column align-items-center align-items-md-start">
                    <p class="hero-text-side mb-2">Temukan Parfum favorit yang anda inginkan</p>
                </div>
            </div>
        </div>
    </section>

    <div class="container menu-section" id="best-seller">
        <h2 class="section-title">Best Notes Parfum</h2>
        <div class="row justify-content-center">
            <div class="col-12 col-md-4 category-item" onclick="window.location.href='/coding web IMK/parfy-php/kategori?notes=woody'"
                style="cursor:pointer;">
                <div class="img-circle-wrapper">
                    <img src="/coding web IMK/parfy-php/assets/oud.jpg" alt="Woody">
                </div>
                <div class="category-title">WOODY</div>
            </div>
            <div class="col-12 col-md-4 category-item" onclick="window.location.href='/coding web IMK/parfy-php/kategori?notes=sweet'"
                style="cursor:pointer;">
                <div class="img-circle-wrapper">
                    <img src="/coding web IMK/parfy-php/assets/vanilla.jpg" alt="Sweet">
                </div>
                <div class="category-title">SWEET & GOURMAND</div>
            </div>
            <div class="col-12 col-md-4 category-item" onclick="window.location.href='/coding web IMK/parfy-php/kategori?notes=fresh'"
                style="cursor:pointer;">
                <div class="img-circle-wrapper">
                    <img src="/coding web IMK/parfy-php/assets/fresh.jpg" alt="Fresh">
                </div>
                <div class="category-title">FRESH & AQUATIC</div>
            </div>
        </div>
    </div>

    <div class="container promo-section">
        <div class="promo-header">
            <h2 class="promo-title">🔥 Promo Spesial</h2>
            <a href="/coding web IMK/parfy-php/kategori?notes=promo" class="promo-link">lihat semua ></a>
        </div>
        <div class="row row-cols-2 row-cols-md-5 justify-content-center">
            <div class="col promo-item" style="cursor:pointer;"
                onclick="window.location.href='/coding web IMK/parfy-php/kategori?notes=promo'">
                <span class="discount-badge">-15%</span>
                <div class="promo-img-wrap"><img src="https://placehold.co/300x300/e91e63/white?text=Stilettos"
                        alt="Stilettos"></div>
                <div class="promo-name">Stilettos</div>
                <div class="promo-price">
                    <span class="original">Rp 200.000</span>
                    <span class="discounted">Rp 170.000</span>
                </div>
            </div>
            <div class="col promo-item" style="cursor:pointer;"
                onclick="window.location.href='/coding web IMK/parfy-php/kategori?notes=promo'">
                <span class="discount-badge">-20%</span>
                <div class="promo-img-wrap"><img src="https://placehold.co/300x300/ffb6c1/333?text=Baby+Love"
                        alt="Baby Love"></div>
                <div class="promo-name">Baby Love</div>
                <div class="promo-price">
                    <span class="original">Rp 169.000</span>
                    <span class="discounted">Rp 135.000</span>
                </div>
            </div>
            <div class="col promo-item" style="cursor:pointer;"
                onclick="window.location.href='/coding web IMK/parfy-php/kategori?notes=promo'">
                <span class="discount-badge">-12%</span>
                <div class="promo-img-wrap"><img src="https://placehold.co/300x300/8b0000/white?text=ORGSM" alt="ORGSM">
                </div>
                <div class="promo-name">HMNS ORGSM</div>
                <div class="promo-price">
                    <span class="original">Rp 398.000</span>
                    <span class="discounted">Rp 350.000</span>
                </div>
            </div>
            <div class="col promo-item" style="cursor:pointer;"
                onclick="window.location.href='/coding web IMK/parfy-php/kategori?notes=promo'">
                <span class="discount-badge">-17%</span>
                <div class="promo-img-wrap"><img src="https://placehold.co/300x300/d2691e/white?text=Moroccan"
                        alt="Moroccan Vanilla"></div>
                <div class="promo-name">Moroccan Vanilla</div>
                <div class="promo-price">
                    <span class="original">Rp 350.000</span>
                    <span class="discounted">Rp 290.000</span>
                </div>
            </div>
            <div class="col promo-item" style="cursor:pointer;"
                onclick="window.location.href='/coding web IMK/parfy-php/kategori?notes=promo'">
                <span class="discount-badge">-10%</span>
                <div class="promo-img-wrap"><img src="https://placehold.co/300x300/006400/white?text=Alpha" alt="Alpha">
                </div>
                <div class="promo-name">HMNS Alpha</div>
                <div class="promo-price">
                    <span class="original">Rp 341.000</span>
                    <span class="discounted">Rp 307.000</span>
                </div>
            </div>
        </div>
    </div>


    <!-- KOLEKSI PARFUM (Dynamic from API) -->
    <div class="container collection-section" id="collection-section">
        <h2 class="collection-header">KOLEKSI PARFUM</h2>

        <div class="row g-4" id="productsContainer">
            <!-- Products will be loaded from API -->
            <div class="col-12 text-center py-5">
                <div class="spinner-border text-light" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <p class="mt-3">Memuat produk...</p>
            </div>
        </div>

        <div class="d-flex justify-content-center mt-5">
            <nav aria-label="Page navigation">
                <ul class="pagination pagination-custom" id="paginationContainer">
                    <!-- Pagination will be generated dynamically -->
                </ul>
            </nav>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        let allProducts = [];
        let currentPage = 1;
        const productsPerPage = 8;

        // Format harga ke format Rupiah singkat
        function formatPrice(price) {
            if (price >= 1000000) {
                return 'Rp ' + (price / 1000000).toFixed(1) + 'M';
            } else if (price >= 1000) {
                return 'Rp ' + (price / 1000).toFixed(0) + 'K';
            }
            return 'Rp ' + price;
        }

        // Render product card
        function renderProductCard(product) {
            const image = Array.isArray(product.images) && product.images[0]
                ? product.images[0]
                : (product.image || '/foto/default.jpg');

            return `
            <div class="col-6 col-md-3">
                <div class="product-card" style="cursor: pointer;" onclick="window.location.href='/coding web IMK/parfy-php/detail-produk?id=${product.id}'">
                    ${product.sold > 50 ? '<span class="badge-hot">HOT</span>' : ''}
                    <div class="icon-cart-card" onclick="event.stopPropagation(); window.location.href='/coding web IMK/parfy-php/detail-produk?id=${product.id}'" title="Lihat & Beli">
                        <i class="bi bi-basket"></i>
                    </div>
                    
                    <div class="product-img-container">
                        <img src="${image}" class="product-img" alt="${product.name}" 
                             onerror="this.onerror=null; this.src='/coding web IMK/parfy-php/foto/default.jpg';">
                    </div>

                    <div class="product-name-bar">
                        <span class="product-title">${product.name}</span>
                        <div class="product-like"><i class="bi bi-heart-fill text-white"></i></div>
                    </div>

                    <div class="card-footer-custom">
                        <a href="/coding web IMK/parfy-php/detail-produk?id=${product.id}" class="btn-buy-now" onclick="event.stopPropagation(); window.location.href='/coding web IMK/parfy-php/detail-produk?id=${product.id}'">
                            Buy now <i class="bi bi-arrow-up-right"></i>
                        </a>
                        <span class="price-pill">${formatPrice(product.price)}</span>
                    </div>
                </div>
            </div>
        `;
        }

        // Function prompt login with SweetAlert modal
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

        // Render pagination
        function renderPagination(totalProducts) {
            const totalPages = Math.ceil(totalProducts / productsPerPage);
            const container = document.getElementById('paginationContainer');

            // Helper to create page link
            const createLink = (page, text = page, isActive = false, isDisabled = false) => `
                <li class="page-item ${isActive ? 'active' : ''} ${isDisabled ? 'disabled' : ''}">
                    <a class="page-link" href="#" ${isDisabled ? '' : `onclick="changePage(${page}); return false;"`}>${text}</a>
                </li>
            `;

            let html = '';

            // Previous Button
            html += createLink(currentPage - 1, '<i class="bi bi-arrow-left"></i>', false, currentPage === 1);

            // Page Numbers logic
            if (totalPages <= 7) {
                // Less than 7 pages, show all
                for (let i = 1; i <= totalPages; i++) {
                    html += createLink(i, i, currentPage === i);
                }
            } else {
                // More than 7 pages, use ellipsis
                if (currentPage <= 4) {
                    // Near start: 1 2 3 4 5 ... 20
                    for (let i = 1; i <= 5; i++) {
                        html += createLink(i, i, currentPage === i);
                    }
                    html += createLink(null, '...', false, true);
                    html += createLink(totalPages);
                } else if (currentPage >= totalPages - 3) {
                    // Near end: 1 ... 16 17 18 19 20
                    html += createLink(1);
                    html += createLink(null, '...', false, true);
                    for (let i = totalPages - 4; i <= totalPages; i++) {
                        html += createLink(i, i, currentPage === i);
                    }
                } else {
                    // Middle: 1 ... 4 5 6 ... 20
                    html += createLink(1);
                    html += createLink(null, '...', false, true);
                    for (let i = currentPage - 1; i <= currentPage + 1; i++) {
                        html += createLink(i, i, currentPage === i);
                    }
                    html += createLink(null, '...', false, true);
                    html += createLink(totalPages);
                }
            }

            // Next Button
            html += createLink(currentPage + 1, '<i class="bi bi-arrow-right"></i>', false, currentPage === totalPages);

            container.innerHTML = html;
        }

        // Change page
        function changePage(page) {
            const currentList = getFilteredProducts();
            const totalPages = Math.ceil(currentList.length / productsPerPage);
            if (page < 1 || page > totalPages) return;
            currentPage = page;
            displayProducts();
        }

        // Display products for current page
        function displayProducts() {
            const container = document.getElementById('productsContainer');
            const currentList = getFilteredProducts();
            const totalPages = Math.ceil(currentList.length / productsPerPage);
            const start = (currentPage - 1) * productsPerPage;
            const end = start + productsPerPage;
            const pageProducts = currentList.slice(start, end);

            // Update collection title with search count if searching
            const collectionHeader = document.querySelector('.collection-header');
            if (collectionHeader) {
                if (isSearching && searchQuery) {
                    collectionHeader.innerHTML = `HASIL PENCARIAN (${currentList.length})`;
                } else {
                    collectionHeader.innerHTML = `KOLEKSI PARFUM`;
                }
            }

            if (pageProducts.length === 0) {
                container.innerHTML = `
                <div class="col-12 text-center py-5">
                    <i class="bi bi-search fs-1 text-white-50"></i>
                    <p class="mt-3 fs-5">Tidak ada produk yang cocok dengan "${escapeHtml(searchQuery)}"</p>
                    <button class="btn btn-sm btn-outline-light mt-2" onclick="closeSearch()" style="border-radius: 20px; padding: 6px 20px;">Lihat Semua Produk</button>
                </div>
            `;
                renderPagination(0);
                return;
            }

            container.innerHTML = pageProducts.map(renderProductCard).join('');
            renderPagination(currentList.length);
        }

        // Search logic
        let searchTimeout = null;
        let isSearching = false;
        let searchQuery = '';

        function toggleSearch() {
            const inputGroup = document.getElementById('searchInputGroup');
            const toggleBtn = document.getElementById('searchToggleBtn');
            const searchInput = document.getElementById('navbarSearchInput');

            if (inputGroup.style.display === 'none' || inputGroup.style.display === '') {
                inputGroup.style.display = 'flex';
                toggleBtn.style.display = 'none';
                searchInput.focus();
            } else {
                closeSearch();
            }
        }

        function selectSearchProduct(productName) {
            const navbarInput = document.getElementById('navbarSearchInput');
            const mobileInput = document.getElementById('mobileSearchInput');
            if (navbarInput) navbarInput.value = productName;
            if (mobileInput) mobileInput.value = productName;

            searchQuery = productName.trim().toLowerCase();
            isSearching = true;
            currentPage = 1;
            displayProducts();

            const dropdown = document.getElementById('searchResultsDropdown');
            if (dropdown) dropdown.style.display = 'none';

            const collectionEl = document.getElementById('collection-section');
            if (collectionEl) {
                collectionEl.scrollIntoView({ behavior: 'smooth' });
            }
        }

        function applySearchToCollection() {
            const mobileInput = document.getElementById('mobileSearchInput');
            const navbarInput = document.getElementById('navbarSearchInput');
            const query = (navbarInput && navbarInput.value ? navbarInput.value : (mobileInput ? mobileInput.value : '')).trim();

            if (query) {
                searchQuery = query.toLowerCase();
                isSearching = true;
                currentPage = 1;
                displayProducts();
            }

            const dropdown = document.getElementById('searchResultsDropdown');
            if (dropdown) dropdown.style.display = 'none';

            const collectionEl = document.getElementById('collection-section');
            if (collectionEl) {
                collectionEl.scrollIntoView({ behavior: 'smooth' });
            }
        }

        function closeSearch() {
            const inputGroup = document.getElementById('searchInputGroup');
            const toggleBtn = document.getElementById('searchToggleBtn');
            const searchInput = document.getElementById('navbarSearchInput');
            const mobileInput = document.getElementById('mobileSearchInput');
            const dropdown = document.getElementById('searchResultsDropdown');

            if (inputGroup) inputGroup.style.display = 'none';
            if (toggleBtn) toggleBtn.style.display = 'inline-block';
            if (searchInput) searchInput.value = '';
            if (mobileInput) mobileInput.value = '';
            if (dropdown) dropdown.style.display = 'none';

            if (isSearching) {
                isSearching = false;
                searchQuery = '';
                currentPage = 1;
                displayProducts();
            }
        }

        function getFilteredProducts() {
            if (!isSearching || !searchQuery) {
                return allProducts;
            }
            return allProducts.filter(p => {
                const name = (p.name || '').toLowerCase();
                const brand = (p.brand || '').toLowerCase();
                const aroma = (p.aroma || '').toLowerCase();
                const category = (p.category || '').toLowerCase();
                return name.includes(searchQuery) || brand.includes(searchQuery) || aroma.includes(searchQuery) || category.includes(searchQuery);
            });
        }

        function handleSearch(query) {
            clearTimeout(searchTimeout);
            searchQuery = query.trim().toLowerCase();

            searchTimeout = setTimeout(() => {
                const dropdown = document.getElementById('searchResultsDropdown');

                if (!searchQuery) {
                    if (dropdown) dropdown.style.display = 'none';
                    isSearching = false;
                    currentPage = 1;
                    displayProducts();
                    return;
                }

                // Filter products
                const matches = getFilteredProducts();

                // Update dropdown
                if (dropdown) {
                    if (matches.length === 0) {
                        dropdown.innerHTML = `
                            <div class="text-center py-3 text-white-50" style="font-size: 0.85rem;">
                                <i class="bi bi-search me-1"></i> Tidak ada produk untuk "<strong>${escapeHtml(query)}</strong>"
                            </div>
                        `;
                    } else {
                        dropdown.innerHTML = `
                            <div style="font-size: 0.75rem; color: rgba(255,255,255,0.6); padding: 4px 8px; border-bottom: 1px solid rgba(255,255,255,0.1); margin-bottom: 6px;">
                                Ditemukan ${matches.length} produk (klik untuk tampilkan di koleksi):
                            </div>
                        ` + matches.slice(0, 5).map(p => {
                            const img = Array.isArray(p.images) && p.images[0] ? p.images[0] : (p.image || '/coding web IMK/parfy-php/foto/default.jpg');
                            return `
                                <div class="search-result-item" onclick="selectSearchProduct('${escapeHtml(p.name)}')">
                                    <img src="${img}" class="search-result-img" alt="${escapeHtml(p.name)}" onerror="this.src='/coding web IMK/parfy-php/foto/default.jpg'">
                                    <div class="search-result-info">
                                        <div class="search-result-title">${escapeHtml(p.name)}</div>
                                        <div class="search-result-meta">
                                            <span>${escapeHtml(p.brand || '-')}</span>
                                            <span class="search-result-price">${formatPrice(p.price)}</span>
                                        </div>
                                    </div>
                                </div>
                            `;
                        }).join('') + (matches.length > 5 ? `
                            <div class="text-center pt-2">
                                <a href="#collection-section" onclick="applySearchToCollection(); return false;" style="color: #82c4e4; font-size: 0.8rem; text-decoration: none; font-weight: 500;">
                                    Lihat semua ${matches.length} hasil di Koleksi Parfum &darr;
                                </a>
                            </div>
                        ` : '');
                    }
                    dropdown.style.display = 'block';
                }

                // Also live filter the collection
                isSearching = true;
                currentPage = 1;
                displayProducts();
            }, 250);
        }

        function handleSearchKey(event) {
            if (event.key === 'Enter') {
                applySearchToCollection();
            } else if (event.key === 'Escape') {
                closeSearch();
            }
        }

        function escapeHtml(str) {
            if (!str) return '';
            return str.replace(/[&<>"']/g, function(m) {
                return { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#039;' }[m];
            });
        }

        // Close search dropdown when clicking outside
        document.addEventListener('click', (e) => {
            const wrapper = document.getElementById('searchBoxWrapper');
            const dropdown = document.getElementById('searchResultsDropdown');
            if (wrapper && !wrapper.contains(e.target) && dropdown) {
                dropdown.style.display = 'none';
            }
        });

        // Fetch products from API
        async function fetchProducts() {
            try {
                const response = await fetch('/coding web IMK/parfy-php/api/products/index.php');
                const data = await response.json();

                // Handle different response formats
                allProducts = Array.isArray(data) ? data : (data.products || data.data || []);

                displayProducts();
            } catch (error) {
                console.error('Error fetching products:', error);
                document.getElementById('productsContainer').innerHTML = `
                    <div class="col-12 text-center py-5">
                        <p class="text-danger">Gagal memuat produk. Silakan coba lagi nanti.</p>
                    </div>
                `;
            }
        }

        // Initialize
        document.addEventListener('DOMContentLoaded', () => {
            fetchProducts();
        });


    </script>

    <!-- Footer -->
    <footer id="footer"
        style="background: linear-gradient(to top, #0a1628, #0f1029); padding: 60px 0 30px; margin-top: 80px;">
        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-4">
                    <div class="d-flex align-items-center mb-3">
                        <img src="/coding web IMK/parfy-php/assets/logo_parfum_bk.png" alt="Logo" style="height:60px; margin-right:15px;">
                        <span
                            style="font-family: 'Playfair Display', serif; font-size:1.5rem; font-weight:bold;">PARFY.ID</span>
                    </div>
                    <p style="opacity:0.8; font-size:0.9rem;">Toko parfum premium dengan koleksi wewangian terbaik dari
                        seluruh dunia. Temukan aroma yang mencerminkan kepribadianmu.</p>
                </div>
                <div class="col-md-2 mb-4">
                    <h5 style="margin-bottom:20px; font-weight:600;">Menu</h5>
                    <ul style="list-style:none; padding:0; opacity:0.8;">
                        <li style="margin-bottom:10px;"><a href="#collection-section"
                                style="color:white; text-decoration:none;">Parfum</a></li>
                        <li style="margin-bottom:10px;"><a href="/coding web IMK/parfy-php/login"
                                style="color:white; text-decoration:none;">Login</a></li>
                        <li style="margin-bottom:10px;"><a href="/coding web IMK/parfy-php/register"
                                style="color:white; text-decoration:none;">Register</a></li>
                    </ul>
                </div>
                <div class="col-md-3 mb-4">
                    <h5 style="margin-bottom:20px; font-weight:600;">Hubungi Kami</h5>
                    <p style="opacity:0.8; font-size:0.9rem;">
                        <i class="bi bi-envelope me-2"></i>support@parfy.id<br>
                        <i class="bi bi-telephone me-2"></i>+62 812-3456-7890<br>
                        <i class="bi bi-geo-alt me-2"></i>Jakarta, Indonesia
                    </p>
                    <div style="margin-top:20px;">
                        <a href="#" style="color:white; font-size:1.2rem; margin-right:15px;"><i
                                class="bi bi-instagram"></i></a>
                        <a href="#" style="color:white; font-size:1.2rem; margin-right:15px;"><i
                                class="bi bi-facebook"></i></a>
                        <a href="#" style="color:white; font-size:1.2rem;"><i class="bi bi-tiktok"></i></a>
                    </div>
                </div>
                <div class="col-md-3 mb-4">
                    <h5 style="margin-bottom:20px; font-weight:600;">Tentang</h5>
                    <p style="opacity:0.8; font-size:0.9rem;">PARFY.ID adalah toko parfum online yang menyediakan
                        berbagai pilihan wewangian berkualitas dengan harga terjangkau.</p>
                </div>
            </div>
            <hr style="border-color: rgba(255,255,255,0.2); margin: 30px 0;">
            <div class="text-center" style="opacity:0.6; font-size:0.85rem;">
                © 2024 PARFY.ID. All rights reserved.
            </div>
        </div>
    </footer>

    <!-- Customer Service Chat Widget -->
    <div id="cs-widget-container"
        style="position: fixed; bottom: 30px; right: 30px; z-index: 9999; font-family: 'Segoe UI', sans-serif;">
        <!-- Chat Button (FAB) -->
        <button id="cs-fab" onclick="promptLogin('menggunakan layanan Customer Service')" style="
        width: 60px; height: 60px; border-radius: 50%; 
        background: linear-gradient(135deg, #0d3256, #4b8bbf); 
        color: white; border: none; box-shadow: 0 4px 15px rgba(0,0,0,0.3); 
        cursor: pointer; display: flex; align-items: center; justify-content: center;
        transition: transform 0.3s;">
            <i class="bi bi-chat-dots-fill" style="font-size: 28px;"></i>
        </button>

        <!-- Chat Window -->
        <div id="cs-chat-window" style="
        display: none; position: absolute; bottom: 80px; right: 0; 
        width: 350px; height: 500px; background: white; 
        border-radius: 20px; box-shadow: 0 5px 25px rgba(0,0,0,0.2); 
        flex-direction: column; overflow: hidden; animation: slideUp 0.3s ease-out;">

            <!-- Header -->
            <div
                style="background: linear-gradient(135deg, #0d3256, #4b8bbf); padding: 15px 20px; color: white; display: flex; align-items: center; justify-content: space-between;">
                <div style="display: flex; align-items: center; gap: 10px;">
                    <div
                        style="width: 35px; height: 35px; background: rgba(255,255,255,0.2); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                        <i class="bi bi-robot" style="font-size: 20px;"></i>
                    </div>
                    <div>
                        <h5 style="margin: 0; font-size: 16px; font-weight: 600;">CS Parfy.id</h5>
                        <small style="opacity: 0.8; font-size: 12px;">Online (AI Assistant)</small>
                    </div>
                </div>
                <button onclick="toggleChat()"
                    style="background: none; border: none; color: white; font-size: 20px; cursor: pointer;">&times;</button>
            </div>

            <!-- Messages Area -->
            <div id="cs-messages"
                style="flex: 1; padding: 15px; overflow-y: auto; background: #f8f9fa; display: flex; flex-direction: column; gap: 10px;">
                <!-- Initial Message -->
                <div class="cs-message bot" style="align-self: flex-start; max-width: 80%;">
                    <div
                        style="background: white; color: #333; padding: 10px 15px; border-radius: 15px 15px 15px 0; box-shadow: 0 2px 5px rgba(0,0,0,0.05); font-size: 14px;">
                        Halo Kak! 👋 Ada yang bisa dibantu seputar parfum?
                    </div>
                </div>
            </div>

            <!-- Input Area -->
            <div
                style="padding: 15px; background: white; border-top: 1px solid #eee; display: flex; gap: 10px; align-items: center;">
                <input type="text" id="cs-input" placeholder="Tulis pesan..."
                    onkeydown="if(event.key === 'Enter') sendMessage()"
                    style="flex: 1; border: 1px solid #ddd; border-radius: 20px; padding: 10px 15px; outline: none; font-size: 14px;">
                <button onclick="sendMessage()" style="
                background: #0d3256; color: white; border: none; 
                width: 40px; height: 40px; border-radius: 50%; 
                display: flex; align-items: center; justify-content: center; 
                cursor: pointer; box-shadow: 0 2px 5px rgba(0,0,0,0.1);">
                    <i class="bi bi-send-fill" style="font-size: 16px;"></i>
                </button>
            </div>
        </div>
    </div>

    <style>
        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .cs-message.user {
            align-self: flex-end;
            max-width: 80%;
        }

        .cs-message.user div {
            background: #0d3256;
            color: white;
            padding: 10px 15px;
            border-radius: 15px 15px 0 15px;
            font-size: 14px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .cs-message.bot {
            align-self: flex-start;
            max-width: 80%;
        }

        .cs-message.bot div {
            background: white;
            color: #333;
            padding: 10px 15px;
            border-radius: 15px 15px 15px 0;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
            font-size: 14px;
            white-space: pre-wrap;
            /* Preserves newlines and spaces */
        }

        .typing-dot {
            display: inline-block;
            width: 6px;
            height: 6px;
            background: #aaa;
            border-radius: 50%;
            margin: 0 2px;
            animation: typing 1s infinite alternate;
        }

        @keyframes typing {
            from {
                opacity: 0.3;
            }

            to {
                opacity: 1;
            }
        }
    </style>

    <script>
        const chatWindow = document.getElementById('cs-chat-window');
        const fab = document.getElementById('cs-fab');
        let chatOpen = false;
        let chatHistory = [];

        function toggleChat() {
            chatOpen = !chatOpen;
            if (chatOpen) {
                chatWindow.style.display = 'flex';
                fab.style.transform = 'scale(0.9)';
                document.getElementById('cs-input').focus();
            } else {
                chatWindow.style.display = 'none';
                fab.style.transform = 'scale(1)';
            }
        }

        async function sendMessage() {
            const input = document.getElementById('cs-input');
            const message = input.value.trim();
            if (!message) return;

            addMessage('user', message);
            input.value = '';

            // Show typing indicator
            const typingId = addTypingIndicator();

            try {
                const context = chatHistory.slice(-5);
                const res = await fetch('/coding web IMK/parfy-php/api/chat', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ message: message, history: context })
                });

                const data = await res.json();
                removeMessage(typingId);

                if (data.reply) {
                    addMessage('bot', data.reply);
                } else {
                    addMessage('bot', 'Maaf, saya sedang mengalami gangguan.');
                }
            } catch (error) {
                removeMessage(typingId);
                addMessage('bot', 'Gagal terhubung ke server.');
                console.error(error);
            }
        }

        function addMessage(role, text) {
            const container = document.getElementById('cs-messages');
            const msgDiv = document.createElement('div');
            msgDiv.className = `cs-message ${role}`;
            msgDiv.innerHTML = `<div>${text}</div>`;
            container.appendChild(msgDiv);
            container.scrollTop = container.scrollHeight;
            chatHistory.push({ role: role, content: text });
        }

        function addTypingIndicator() {
            const container = document.getElementById('cs-messages');
            const id = 'typing-' + Date.now();
            const msgDiv = document.createElement('div');
            msgDiv.id = id;
            msgDiv.className = 'cs-message bot';
            msgDiv.innerHTML = `<div><span class="typing-dot"></span><span class="typing-dot" style="animation-delay:0.2s"></span><span class="typing-dot" style="animation-delay:0.4s"></span></div>`;
            container.appendChild(msgDiv);
            container.scrollTop = container.scrollHeight;
            return id;
        }

        function removeMessage(id) {
            const el = document.getElementById(id);
            if (el) el.remove();
        }
    </script>
</body>

</html>