<?php
/**
 * Category & Promo Filter Page for PARFY.ID
 * Displays products filtered by scent notes or promo
 */

require_once __DIR__ . '/../config/database.php';

// Get the notes filter from URL parameter
$notesFilter = isset($_GET['notes']) ? trim($_GET['notes']) : '';
$promoParam = isset($_GET['promo']) ? trim($_GET['promo']) : '';

$isPromo = (strtolower($notesFilter) === 'promo' || !empty($promoParam));

// Map display names to search keywords
$categoryMap = [
    'woody' => ['Woody', 'Wood', 'Earthy', 'Cedar', 'Sandalwood'],
    'gourmand' => ['Gourmand', 'Sweet', 'Vanilla', 'Caramel', 'Warm'],
    'fresh' => ['Fresh', 'Aquatic', 'Citrus', 'Green', 'Clean']
];

// Get display title
$categoryTitles = [
    'woody' => 'WOODY',
    'gourmand' => 'SWEET & GOURMAND',
    'fresh' => 'FRESH & AQUATIC',
    'promo' => 'PROMO SPESIAL'
];

if ($isPromo) {
    $pageTitle = 'PROMO SPESIAL';
} else {
    $pageTitle = $categoryTitles[strtolower($notesFilter)] ?? strtoupper($notesFilter);
}

// Promo discounts data for promo items (with short names & images)
$promoDiscounts = [
    'PRD001' => [
        'short_name' => 'Stilettos',
        'discount' => '-15%',
        'original' => 'Rp 200.000',
        'image' => 'https://placehold.co/300x300/e91e63/white?text=Stilettos'
    ],
    'PRD002' => [
        'short_name' => 'Baby Love',
        'discount' => '-20%',
        'original' => 'Rp 169.000',
        'image' => 'https://placehold.co/300x300/ffb6c1/333?text=Baby+Love'
    ],
    'PRD011' => [
        'short_name' => 'HMNS ORGSM',
        'discount' => '-12%',
        'original' => 'Rp 398.000',
        'image' => 'https://placehold.co/300x300/8b0000/white?text=ORGSM'
    ],
    'PRD008' => [
        'short_name' => 'Moroccan Vanilla',
        'discount' => '-17%',
        'original' => 'Rp 350.000',
        'image' => 'https://placehold.co/300x300/d2691e/white?text=Moroccan'
    ],
    'PRD014' => [
        'short_name' => 'HMNS Alpha',
        'discount' => '-10%',
        'original' => 'Rp 341.000',
        'image' => 'https://placehold.co/300x300/006400/white?text=Alpha'
    ],
    'PRD003' => [
        'short_name' => 'Blossom',
        'discount' => '-10%',
        'original' => 'Rp 155.000',
        'image' => 'https://placehold.co/300x300/ff69b4/white?text=Blossom'
    ],
    'PRD004' => [
        'short_name' => 'Pink Beach',
        'discount' => '-10%',
        'original' => 'Rp 155.000',
        'image' => 'https://placehold.co/300x300/ff7f50/white?text=Pink+Beach'
    ],
    'PRD007' => [
        'short_name' => 'Sparkling Rosé',
        'discount' => '-15%',
        'original' => 'Rp 330.000',
        'image' => 'https://placehold.co/300x300/c71585/white?text=Sparkling+Rose'
    ],
    'PRD012' => [
        'short_name' => 'HMNS EOS',
        'discount' => '-10%',
        'original' => 'Rp 410.000',
        'image' => 'https://placehold.co/300x300/ff8c00/white?text=EOS'
    ],
    'PRD016' => [
        'short_name' => 'Darker ORGSM',
        'discount' => '-10%',
        'original' => 'Rp 405.000',
        'image' => 'https://placehold.co/300x300/4b0082/white?text=Darker+ORGSM'
    ]
];

$products = [];
$db = getDB();

if ($isPromo) {
    $promoIds = array_keys($promoDiscounts);
    $escapedIds = "'" . implode("','", $promoIds) . "'";
    $sql = "SELECT * FROM products WHERE id IN ($escapedIds) ORDER BY FIELD(id, $escapedIds)";
    $result = $db->query($sql);
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $products[] = $row;
        }
    }
} elseif ($notesFilter) {
    $keywords = $categoryMap[strtolower($notesFilter)] ?? [$notesFilter];

    $conditions = [];
    foreach ($keywords as $keyword) {
        $escaped = $db->real_escape_string($keyword);
        $conditions[] = "aroma LIKE '%$escaped%'";
    }

    $whereClause = implode(' OR ', $conditions);
    $sql = "SELECT * FROM products WHERE $whereClause ORDER BY sold DESC";
    $result = $db->query($sql);

    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $products[] = $row;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($pageTitle); ?> | PARFY.ID</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <link
        href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background: radial-gradient(circle at center, #005c97 0%, #0f1029 100%);
            min-height: 100vh;
            color: white;
        }

        /* Navbar */
        .navbar-custom {
            background: rgba(15, 16, 41, 0.95);
            backdrop-filter: blur(10px);
            padding: 15px 0;
        }

        .navbar-custom .navbar-brand img {
            height: 50px;
            margin-right: 10px;
        }

        .navbar-custom .navbar-brand span {
            font-family: 'Playfair Display', serif;
            font-weight: 700;
            font-size: 1.5rem;
            color: white;
        }

        .back-btn {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.3);
            color: white;
            padding: 8px 20px;
            border-radius: 25px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: 0.3s;
        }

        .back-btn:hover {
            background: rgba(255, 255, 255, 0.2);
            color: white;
        }

        /* Page Header */
        .page-header {
            padding: 120px 0 40px;
            text-align: center;
        }

        .page-header h1 {
            font-family: 'Playfair Display', serif;
            font-size: 3rem;
            font-weight: 700;
            margin-bottom: 10px;
        }

        .page-header p {
            opacity: 0.85;
            font-size: 1.1rem;
        }

        /* Product Grid */
        .products-section {
            padding: 20px 0 100px;
        }

        /* ================= PROMO CIRCULAR CARDS (Matches Screenshot) ================= */
        .promo-item {
            text-align: center;
            margin-bottom: 40px;
            cursor: pointer;
            position: relative;
        }

        .promo-circle-card {
            position: relative;
            display: inline-block;
            width: 100%;
            max-width: 200px;
        }

        .promo-img-wrap {
            width: 150px;
            height: 150px;
            margin: 0 auto 15px;
            border-radius: 50%;
            overflow: hidden;
            border: 3.5px solid rgba(255, 255, 255, 0.95);
            background: #fff;
            transition: transform 0.3s ease, border-color 0.3s ease, box-shadow 0.3s ease;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.4);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .promo-img-wrap img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .promo-item:hover .promo-img-wrap {
            transform: scale(1.1);
            border-color: #b4dfff;
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.55), 0 0 18px rgba(180, 223, 255, 0.4);
        }

        .discount-badge {
            position: absolute;
            top: 2px;
            right: calc(50% - 80px);
            background: linear-gradient(135deg, #ff416c, #ff4b2b);
            color: white;
            padding: 5px 12px;
            border-radius: 14px;
            font-size: 0.8rem;
            font-weight: 700;
            z-index: 10;
            box-shadow: 0 3px 12px rgba(255, 65, 108, 0.6);
        }

        .promo-name {
            font-size: 1.05rem;
            font-weight: 600;
            margin-top: 8px;
            color: #ffffff;
            letter-spacing: 0.3px;
        }

        .promo-price {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 2px;
            margin-top: 4px;
        }

        .promo-price .original {
            text-decoration: line-through;
            color: rgba(255, 255, 255, 0.55);
            font-size: 0.85rem;
        }

        .promo-price .discounted {
            color: #ffd700;
            font-weight: 700;
            font-size: 1.1rem;
        }

        /* ================= STANDARD CATEGORY CARDS ================= */
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

        .product-name-bar {
            background: #82c4e4;
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
            width: 24px;
            height: 24px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.7rem;
        }

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

        .empty-state {
            text-align: center;
            padding: 60px 20px;
        }

        .empty-state i {
            font-size: 4rem;
            opacity: 0.5;
            margin-bottom: 20px;
        }

        @media (max-width: 768px) {
            .page-header h1 {
                font-size: 2.2rem;
            }
            .promo-img-wrap {
                width: 120px;
                height: 120px;
            }
            .discount-badge {
                right: calc(50% - 65px);
                font-size: 0.7rem;
                padding: 3px 8px;
            }
            .promo-name {
                font-size: 0.9rem;
            }
            .promo-price .discounted {
                font-size: 0.95rem;
            }
        }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar navbar-custom fixed-top">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="#" onclick="goToHome(); return false;">
                <img src="<?php echo url('/assets/'); ?>logo_parfum_bk.png" alt="Logo">
                <span>PARFY.ID</span>
            </a>
            <div class="d-flex align-items-center gap-3">
                <a href="#" onclick="goBack(); return false;" class="back-btn">
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>
                <a href="<?php echo url('/keranjang'); ?>" id="cartLink"
                    style="color:white; font-size:1.5rem; position:relative; display:none;">
                    <i class="bi bi-cart"></i>
                    <span id="cart-count" class="badge bg-danger rounded-circle"
                        style="font-size:0.6rem; position:absolute; top:-5px; right:-8px; display:none;">0</span>
                </a>
            </div>
        </div>
    </nav>

    <!-- Page Header -->
    <section class="page-header">
        <div class="container">
            <h1><?php echo htmlspecialchars($pageTitle); ?></h1>
            <p><?php echo $isPromo ? 'Koleksi parfum pilihan dengan potongan harga & penawaran promo spesial' : 'Koleksi parfum dengan aroma ' . htmlspecialchars(strtolower($pageTitle)); ?></p>
        </div>
    </section>

    <!-- Products Section -->
    <section class="products-section">
        <div class="container">
            <?php if (empty($products)): ?>
                <div class="empty-state">
                    <i class="bi bi-box-seam"></i>
                    <h3>Belum Ada Produk</h3>
                    <p>Produk dengan kategori ini belum tersedia.</p>
                    <a href="<?php echo url('/'); ?>" class="back-btn mt-3">
                        <i class="bi bi-house"></i> Kembali ke Beranda
                    </a>
                </div>
            <?php elseif ($isPromo): ?>
                <!-- PROMO CIRCULAR VIEW (Matching Screenshot) -->
                <div class="row row-cols-2 row-cols-sm-3 row-cols-md-4 row-cols-lg-5 g-4 justify-content-center">
                    <?php foreach ($products as $product):
                        $pInfo = $promoDiscounts[$product['id']] ?? null;
                        $shortName = $pInfo['short_name'] ?? $product['name'];
                        $discount = $pInfo['discount'] ?? '-10%';
                        $originalPrice = $pInfo['original'] ?? ('Rp ' . number_format((int)$product['price'] * 1.15, 0, ',', '.'));
                        $discountedPrice = 'Rp ' . number_format((int)$product['price'], 0, ',', '.');

                        // Image
                        $imageRaw = $product['image'] ?? '';
                        $images = json_decode($imageRaw, true);
                        if (is_array($images) && !empty($images)) {
                            $image = $images[0];
                        } elseif (!empty($pInfo['image'])) {
                            $image = $pInfo['image'];
                        } elseif (!empty($imageRaw) && !json_decode($imageRaw)) {
                            $image = $imageRaw;
                        } else {
                            $image = '/foto/default.jpg';
                        }
                    ?>
                        <div class="col promo-item" style="cursor:pointer;"
                            onclick="promptLogin('melihat promo <?php echo htmlspecialchars(addslashes($shortName)); ?>')">
                            <div class="promo-circle-card">
                                <span class="discount-badge"><?php echo $discount; ?></span>
                                <div class="promo-img-wrap">
                                    <img src="<?php echo htmlspecialchars($image); ?>"
                                        alt="<?php echo htmlspecialchars($shortName); ?>"
                                        onerror="this.onerror=null; this.src='<?php echo url('/assets/default.jpg'); ?>'">
                                </div>
                                <div class="promo-name"><?php echo htmlspecialchars($shortName); ?></div>
                                <div class="promo-price">
                                    <span class="original"><?php echo $originalPrice; ?></span>
                                    <span class="discounted"><?php echo $discountedPrice; ?></span>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

            <?php else: ?>
                <!-- STANDARD CATEGORY VIEW -->
                <div class="row g-4">
                    <?php foreach ($products as $product):
                        $imageRaw = $product['image'] ?? '';
                        $images = json_decode($imageRaw, true);
                        if (is_array($images) && !empty($images)) {
                            $image = $images[0];
                        } elseif (!empty($imageRaw) && !json_decode($imageRaw)) {
                            $image = $imageRaw;
                        } else {
                            $image = '/foto/default.jpg';
                        }

                        $price = $product['price'];
                        $priceDisplay = $price >= 1000000
                            ? 'Rp ' . number_format($price / 1000000, 1) . 'M'
                            : ($price >= 1000 ? 'Rp ' . number_format($price / 1000, 0) . 'K' : 'Rp ' . $price);
                        ?>
                        <div class="col-6 col-md-3">
                            <div class="product-card" style="cursor: pointer;"
                                onclick="promptLogin('melihat detail <?php echo htmlspecialchars(addslashes($product['name'])); ?>')">
                                <?php if ($product['sold'] > 50): ?>
                                    <span class="badge-hot">HOT</span>
                                <?php endif; ?>
                                <div class="icon-cart-card"
                                    onclick="event.stopPropagation(); promptLogin('menambahkan produk ke keranjang')"
                                    title="Tambah ke keranjang">
                                    <i class="bi bi-basket"></i>
                                </div>

                                <div class="product-img-container">
                                    <img src="<?php echo htmlspecialchars($image); ?>" class="product-img"
                                        alt="<?php echo htmlspecialchars($product['name']); ?>"
                                        onerror="this.onerror=null; this.src='<?php echo url('/assets/default.jpg'); ?>'">
                                </div>

                                <div class="product-name-bar">
                                    <span class="product-title"><?php echo htmlspecialchars($product['name']); ?></span>
                                    <div class="product-like"><i class="bi bi-heart-fill text-white"></i></div>
                                </div>

                                <div class="card-footer-custom">
                                    <a href="#" class="btn-buy-now"
                                        onclick="event.stopPropagation(); promptLogin('membeli produk ini')">
                                        Buy now <i class="bi bi-arrow-up-right"></i>
                                    </a>
                                    <span class="price-pill"><?php echo $priceDisplay; ?></span>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo url('/js/api.js'); ?>"></script>
    <script>
        // Check if user is logged in for cart actions
        function isLoggedIn() {
            return typeof PARFY !== 'undefined' && PARFY.auth && PARFY.auth.isLoggedIn() && PARFY.getUser() !== null;
        }

        function handleProductClick(productId, productName) {
            if (!isLoggedIn()) {
                promptLogin(`melihat detail produk ${productName}`);
                return false;
            }
            window.location.href = `/coding web IMK/parfy-php/detail-produk?id=${productId}`;
        }

        // Smart navigation - respect login state
        function goToHome() {
            if (isLoggedIn()) {
                window.location.href = BASE_PATH + '/dashboard';
            } else {
                window.location.href = BASE_PATH + '/';
            }
        }

        function goBack() {
            if (document.referrer && document.referrer.includes(window.location.host)) {
                history.back();
            } else {
                goToHome();
            }
        }

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
                    window.location.href = BASE_PATH + '/login';
                }
            });
        }

        // On page load - show cart if logged in
        document.addEventListener('DOMContentLoaded', async function () {
            if (isLoggedIn()) {
                document.getElementById('cartLink').style.display = 'inline-block';
                try {
                    const cart = await PARFY.cart.get();
                    if (cart && cart.items && cart.items.length > 0) {
                        const countEl = document.getElementById('cart-count');
                        countEl.textContent = cart.items.length;
                        countEl.style.display = 'flex';
                    }
                } catch (e) {
                    console.log('Cart load error:', e);
                }
            }
        });

        async function addToCart(productId) {
            if (!isLoggedIn()) {
                promptLogin('menambahkan produk ke keranjang');
                return;
            }

            try {
                await PARFY.cart.add(productId, 1);
                Swal.fire('Berhasil!', 'Produk berhasil ditambahkan ke keranjang!', 'success');
            } catch (error) {
                Swal.fire('Error!', error.message, 'error');
            }
        }

        async function buyNow(productId) {
            if (!isLoggedIn()) {
                promptLogin('membeli produk ini');
                return;
            }

            try {
                await PARFY.cart.add(productId, 1);
                window.location.href = BASE_PATH + '/keranjang';
            } catch (error) {
                Swal.fire('Error!', error.message, 'error');
            }
        }
    </script>

</body>

</html>