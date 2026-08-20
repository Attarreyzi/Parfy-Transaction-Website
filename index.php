<?php
/**
 * Main Router for PARFY.ID PHP
 * Handles URL routing similar to Express.js
 */

require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/config/jwt.php';

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Remove /parfy-php and any parent folders from the URI
$uri = preg_replace('#^.*/parfy-php#i', '', $uri);

// Normalize URI
if ($uri === '' || $uri === '/index.php' || $uri === '/index.html') {
    $uri = '/';
}

// API routes
if (preg_match('#^/api/#', $uri)) {
    $cleanUri = preg_replace('#\?.*$#', '', $uri);
    $apiPath = __DIR__ . $cleanUri;

    if (is_dir($apiPath)) {
        $apiPath .= '/index.php';
    } elseif (!str_ends_with($cleanUri, '.php')) {
        if (file_exists($apiPath . '.php')) {
            $apiPath .= '.php';
        } elseif (preg_match('#^/api/reviews/([^/]+)$#', $cleanUri, $m)) {
            $_GET['id'] = $m[1];
            $apiPath = __DIR__ . '/api/reviews/index.php';
        } elseif (preg_match('#^/api/products/([^/]+)$#', $cleanUri, $m)) {
            $_GET['id'] = $m[1];
            $apiPath = __DIR__ . '/api/products/detail.php';
        } elseif (preg_match('#^/api/cart/([^/]+)$#', $cleanUri, $m)) {
            $_GET['productId'] = $m[1];
            $apiPath = __DIR__ . '/api/cart/item.php';
        } elseif (preg_match('#^/api/transactions/([^/]+)/cancel$#', $cleanUri, $m)) {
            $_GET['id'] = $m[1];
            $apiPath = __DIR__ . '/api/transactions/cancel.php';
        } elseif (preg_match('#^/api/transactions/([^/]+)$#', $cleanUri, $m)) {
            $_GET['id'] = $m[1];
            $apiPath = __DIR__ . '/api/transactions/detail.php';
        }
    }

    if (file_exists($apiPath) && !is_dir($apiPath)) {
        require $apiPath;
        exit;
    }

    jsonResponse(['error' => 'API endpoint not found'], 404);
}

// Page routes
$routes = [
    '/' => '/pages/logout.php',
    '/index.php' => '/pages/logout.php',
    '/login' => '/pages/login.php',
    '/login.html' => '/pages/login.php',
    '/register' => '/pages/regis.php',
    '/register.html' => '/pages/regis.php',
    '/regis.html' => '/pages/regis.php',
    '/dashboard' => '/pages/dashboard.php',
    '/dashboard.html' => '/pages/dashboard.php',
    '/user-dashboard' => '/pages/dashboard.php',
    '/promo' => '/pages/kategori.php',
    '/detail-produk' => '/pages/detail-produk.php',
    '/detail-produk.html' => '/pages/detail-produk.php',
    '/detail-produk.php' => '/pages/detail-produk.php',
    '/keranjang' => '/pages/hlmnkeranjang.php',
    '/hlmnkeranjang.html' => '/pages/hlmnkeranjang.php',
    '/akun' => '/pages/hlmnakun.php',
    '/hlmnakun.html' => '/pages/hlmnakun.php',
    '/pesanan' => '/pages/hlmnPesanan.php',
    '/hlmnPesanan.html' => '/pages/hlmnPesanan.php',
    '/alamat' => '/pages/hlmnAlamat.php',
    '/hlmnAlamat.html' => '/pages/hlmnAlamat.php',
    '/kategori' => '/pages/kategori.php',
    '/forgot-password' => '/forgot_password/lupa_password.php',
    '/lupa-password' => '/forgot_password/lupa_password.php',
    '/verify-otp' => '/forgot_password/verify_otp.php',
    '/reset-password' => '/forgot_password/reset_password.php'
];


if (isset($routes[$uri])) {
    $file = __DIR__ . $routes[$uri];
    if (file_exists($file)) {
        require $file;
        exit;
    }
}

// Static files (assets, js, foto)
if (preg_match('#^/(assets|js|foto)/#', $uri)) {
    $filePath = __DIR__ . $uri;
    if (file_exists($filePath) && is_file($filePath)) {
        // Get MIME type
        $ext = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));
        $mimeTypes = [
            'jpg' => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'png' => 'image/png',
            'gif' => 'image/gif',
            'svg' => 'image/svg+xml',
            'webp' => 'image/webp',
            'css' => 'text/css',
            'js' => 'application/javascript',
            'json' => 'application/json',
            'woff' => 'font/woff',
            'woff2' => 'font/woff2',
            'ttf' => 'font/ttf',
            'ico' => 'image/x-icon'
        ];
        $mimeType = $mimeTypes[$ext] ?? 'application/octet-stream';

        header('Content-Type: ' . $mimeType);
        header('Content-Length: ' . filesize($filePath));
        readfile($filePath);
        exit;
    }
    // File not found in static directories
    http_response_code(404);
    echo "File not found";
    exit;
}


// Check if it's a direct PHP file request
$directFile = __DIR__ . $uri;
if (file_exists($directFile) && str_ends_with(strtolower($directFile), '.php')) {
    // Prevent infinite recursion if the file is index.php itself
    if (realpath($directFile) !== realpath(__FILE__)) {
        require $directFile;
        exit;
    }
}

// 404 for everything else
http_response_code(404);
echo "<h1>404 - Page Not Found</h1>";
