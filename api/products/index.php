<?php
/**
 * /api/products/index.php
 * GET: List all products with filters
 * POST: Add new product (admin only)
 */

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../config/jwt.php';

$db = getDB();

// GET - List products
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $category = $_GET['category'] ?? '';
    $search = $_GET['search'] ?? '';
    $sort = $_GET['sort'] ?? '';

    $sql = "SELECT * FROM products WHERE 1=1";

    if (!empty($category)) {
        $categoryEscaped = $db->real_escape_string($category);
        $sql .= " AND LOWER(category) = LOWER('$categoryEscaped')";
    }

    if (!empty($search)) {
        $searchEscaped = $db->real_escape_string($search);
        $sql .= " AND (name LIKE '%$searchEscaped%' OR brand LIKE '%$searchEscaped%' OR aroma LIKE '%$searchEscaped%')";
    }

    switch ($sort) {
        case 'price_asc':
            $sql .= " ORDER BY price ASC";
            break;
        case 'price_desc':
            $sql .= " ORDER BY price DESC";
            break;
        case 'newest':
            $sql .= " ORDER BY created_at DESC";
            break;
        case 'bestseller':
            $sql .= " ORDER BY sold DESC";
            break;
        default:
            $sql .= " ORDER BY id ASC";
    }

    $result = $db->query($sql);
    $products = [];

    if ($result) {
        while ($row = $result->fetch_assoc()) {
            // Decode images JSON or use legacy single image
            $images = [];
            if (!empty($row['image'])) {
                $decoded = json_decode($row['image'], true);
                if (is_array($decoded)) {
                    $images = $decoded;
                } else {
                    $images = [$row['image']];
                }
            }

            $products[] = [
                'id' => $row['id'],
                'name' => $row['name'],
                'brand' => $row['brand'],
                'category' => $row['category'],
                'price' => (int) $row['price'],
                'stock' => (int) $row['stock'],
                'size' => $row['size'],
                'aroma' => $row['aroma'],
                'description' => $row['description'],
                'image' => $images[0] ?? '', // First image for backward compatibility
                'images' => $images, // All images as array
                'scent_category' => $row['scent_category'] ?? '',
                'sold' => (int) $row['sold'],
                'createdAt' => $row['created_at']
            ];
        }
    }

    jsonResponse($products);
}

// POST - Add product (admin only)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = requireAdmin();

    $data = getJsonBody();

    $name = trim($data['name'] ?? '');
    $brand = trim($data['brand'] ?? '');
    $category = $data['category'] ?? 'Unisex';
    $price = (int) ($data['price'] ?? 0);
    $stock = (int) ($data['stock'] ?? 0);
    $size = $data['size'] ?? '';
    $scent_category = $data['scent_category'] ?? '';
    $aroma = $data['aroma'] ?? '';
    $description = $data['description'] ?? '';
    // Handle images - accept array or single string
    $imagesArray = [];
    if (isset($data['images']) && is_array($data['images'])) {
        $imagesArray = array_filter($data['images']); // Remove empty values
    } elseif (!empty($data['image'])) {
        $imagesArray = [$data['image']];
    }
    $imageJson = json_encode($imagesArray);

    // Generate product ID based on MAX id to prevent duplicate entry
    $maxResult = $db->query("SELECT MAX(CAST(SUBSTRING(id, 4) AS UNSIGNED)) as max_id FROM products");
    $count = ($maxResult->fetch_assoc()['max_id'] ?? 0) + 1;
    $productId = 'PRD' . str_pad($count, 3, '0', STR_PAD_LEFT);

    // Escape values
    $nameEsc = $db->real_escape_string($name);
    $brandEsc = $db->real_escape_string($brand);
    $categoryEsc = $db->real_escape_string($category);
    $sizeEsc = $db->real_escape_string($size);
    $scentCategoryEsc = $db->real_escape_string($scent_category);
    $aromaEsc = $db->real_escape_string($aroma);
    $descEsc = $db->real_escape_string($description);
    $imageEsc = $db->real_escape_string($imageJson);

    if (empty($name) || empty($category) || $price <= 0) {
        jsonResponse(['error' => 'Nama, kategori, dan harga wajib diisi.'], 400);
    }

    $sql = "INSERT INTO products (id, name, brand, category, price, stock, size, scent_category, aroma, description, image, sold, created_at) 
            VALUES ('$productId', '$nameEsc', '$brandEsc', '$categoryEsc', $price, $stock, '$sizeEsc', '$scentCategoryEsc', '$aromaEsc', '$descEsc', '$imageEsc', 0, NOW())";

    if (!$db->query($sql)) {
        jsonResponse(['error' => 'Gagal menambah produk: ' . $db->error], 500);
    }

    jsonResponse([
        'message' => 'Produk berhasil ditambahkan!',
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
            'image' => $imagesArray[0] ?? '',
            'images' => $imagesArray,
            'sold' => 0
        ]
    ], 201);
}

jsonResponse(['error' => 'Method not allowed'], 405);
