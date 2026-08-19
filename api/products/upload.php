<?php
/**
 * POST /api/products/upload.php
 * Upload product image (admin only) with auto-compression to WebP
 */

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../config/jwt.php';
require_once __DIR__ . '/../../config/image.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    jsonResponse(['error' => 'Method not allowed'], 405);
}

$user = requireAdmin();

if (!isset($_FILES['image'])) {
    jsonResponse(['error' => 'Tidak ada file yang diupload.'], 400);
}

$file = $_FILES['image'];
$allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'image/webp'];
$maxSize = 10 * 1024 * 1024; // 10MB (will be compressed anyway)

// Validate file type
if (!in_array($file['type'], $allowedTypes)) {
    jsonResponse(['error' => 'Hanya file gambar yang diizinkan! (jpeg, jpg, png, gif, webp)'], 400);
}

// Validate file size
if ($file['size'] > $maxSize) {
    jsonResponse(['error' => 'Ukuran file maksimal 10MB!'], 400);
}

// Create upload directory if not exists
$uploadDir = __DIR__ . '/../../foto/products/';
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0755, true);
}

// Generate unique filename (always .webp after compression)
$filename = time() . '-' . bin2hex(random_bytes(4)) . '.webp';
$targetPath = $uploadDir . $filename;

// Compress and convert to WebP (or JPEG fallback)
$success = compressProductCard($file['tmp_name'], $targetPath);

if (!$success) {
    jsonResponse(['error' => 'Gagal memproses gambar. Pastikan file adalah gambar yang valid. Cek apakah GD library terinstall.'], 500);
}

// Check which file was actually created (WebP or JPEG fallback)
$actualPath = $targetPath;
$actualFilename = $filename;
if (!file_exists($targetPath)) {
    // Try JPEG fallback path
    $jpegPath = preg_replace('/\.webp$/i', '.jpg', $targetPath);
    if (file_exists($jpegPath)) {
        $actualPath = $jpegPath;
        $actualFilename = preg_replace('/\.webp$/i', '.jpg', $filename);
    }
}

// Get file size info
$originalSize = $file['size'];
$compressedSize = filesize($actualPath);
$savedPercent = round((1 - $compressedSize / $originalSize) * 100, 1);

$url = '/foto/products/' . $actualFilename;

jsonResponse([
    'message' => 'Upload berhasil!',
    'url' => $url,
    'filename' => $actualFilename,
    'originalSize' => $originalSize,
    'compressedSize' => $compressedSize,
    'savedPercent' => $savedPercent
]);

