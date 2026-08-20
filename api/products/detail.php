<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');


if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../config/jwt.php';

$db = getDB();

$productId = $_GET['id'] ?? '';
if (empty($productId)) {
    jsonResponse(['error' => 'Product ID diperlukan.'], 400);
}

$productIdEsc = $db->real_escape_string($productId);

// Ambil data
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $result = $db->query("SELECT * FROM products WHERE id = '$productIdEsc'");

    if (!$result || $result->num_rows === 0) {
        jsonResponse(['error' => 'Produk tidak ditemukan.'], 404);
    }

    $row = $result->fetch_assoc();

    // Decode images JSON or use legacy single image
    $rawImages = [];
    if (!empty($row['image'])) {
        $decoded = json_decode($row['image'], true);
        if (is_array($decoded)) {
            $rawImages = $decoded;
        } else {
            $rawImages = [$row['image']];
        }
    }
    $images = array_map('fixImageUrl', array_filter($rawImages));
    if (empty($images)) {
        $images = [fixImageUrl('/assets/default.jpg')];
    }

    jsonResponse([
        'id' => $row['id'],
        'name' => $row['name'],
        'brand' => $row['brand'],
        'category' => $row['category'],
        'price' => (int) $row['price'],
        'stock' => (int) $row['stock'],
        'size' => $row['size'],
        'aroma' => $row['aroma'],
        'description' => $row['description'],
        'image' => $images[0], // First image for backward compatibility
        'images' => $images, // All images as array
        'scent_category' => $row['scent_category'] ?? '',
        'sold' => (int) $row['sold'],
        'createdAt' => $row['created_at']
    ]);
}

// Update data
if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    $user = requireAdmin();

    // Check product exists
    $result = $db->query("SELECT * FROM products WHERE id = '$productIdEsc'");
    if (!$result || $result->num_rows === 0) {
        jsonResponse(['error' => 'Produk tidak ditemukan.'], 404);
    }

    $existing = $result->fetch_assoc();
    $data = getJsonBody();

    $name = isset($data['name']) ? $db->real_escape_string(trim($data['name'])) : $existing['name'];
    $brand = isset($data['brand']) ? $db->real_escape_string(trim($data['brand'])) : $existing['brand'];
    $category = isset($data['category']) ? $db->real_escape_string($data['category']) : $existing['category'];
    $price = isset($data['price']) ? (int) $data['price'] : $existing['price'];
    $stock = isset($data['stock']) ? (int) $data['stock'] : $existing['stock'];
    $size = isset($data['size']) ? $db->real_escape_string($data['size']) : $existing['size'];
    $scent_category = isset($data['scent_category']) ? $db->real_escape_string($data['scent_category']) : ($existing['scent_category'] ?? '');
    $aroma = isset($data['aroma']) ? $db->real_escape_string($data['aroma']) : $existing['aroma'];
    $description = isset($data['description']) ? $db->real_escape_string($data['description']) : $existing['description'];

    // Handle images - accept array or single string
    $imageJson = $existing['image']; // Keep existing by default
    if (isset($data['images']) && is_array($data['images'])) {
        $imagesArray = array_filter($data['images']); // Remove empty values
        $imageJson = json_encode($imagesArray);
    } elseif (isset($data['image']) && !empty($data['image'])) {
        $imageJson = json_encode([$data['image']]);
    }
    $image = $db->real_escape_string($imageJson);

    $sql = "UPDATE products SET 
            name = '$name',
            brand = '$brand',
            category = '$category',
            price = $price,
            stock = $stock,
            size = '$size',
            scent_category = '$scent_category',
            aroma = '$aroma',
            description = '$description',
            image = '$image'
            WHERE id = '$productIdEsc'";

    if (!$db->query($sql)) {
        jsonResponse(['error' => 'Gagal update produk: ' . $db->error], 500);
    }

    jsonResponse([
        'message' => 'Produk berhasil diupdate!',
        'product' => [
            'id' => $productId,
            'name' => $name,
            'brand' => $brand,
            'category' => $category,
            'price' => $price,
            'stock' => $stock,
            'size' => $size,
            'scent_category' => $scent_category,
            'aroma' => $aroma,
            'description' => $description,
            'image' => json_decode($imageJson, true)[0] ?? '',
            'images' => json_decode($imageJson, true) ?? []
        ]
    ]);
}

// Hapus data
if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    $user = requireAdmin();

    $result = $db->query("SELECT * FROM products WHERE id = '$productIdEsc'");
    if (!$result || $result->num_rows === 0) {
        jsonResponse(['error' => 'Produk tidak ditemukan.'], 404);
    }

    $product = $result->fetch_assoc();

    if (!$db->query("DELETE FROM products WHERE id = '$productIdEsc'")) {
        jsonResponse(['error' => 'Gagal hapus produk: ' . $db->error], 500);
    }

    jsonResponse([
        'message' => 'Produk berhasil dihapus!',
        'product' => $product
    ]);
}

jsonResponse(['error' => 'Method not allowed'], 405);
