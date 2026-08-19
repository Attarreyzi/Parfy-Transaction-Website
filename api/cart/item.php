<?php
/**
 * /api/cart/item.php
 * PUT: Update item quantity
 * DELETE: Remove item from cart
 */

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../config/jwt.php';

$user = requireAuth();
$db = getDB();
$userId = $db->real_escape_string($user['id']);

$productId = $_GET['productId'] ?? '';
if (empty($productId)) {
    jsonResponse(['error' => 'Product ID diperlukan.'], 400);
}

$productIdEsc = $db->real_escape_string($productId);

// PUT - Update quantity
if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    $data = getJsonBody();
    $quantity = (int) ($data['quantity'] ?? 1);

    if ($quantity < 1) {
        jsonResponse(['error' => 'Quantity minimal 1.'], 400);
    }

    // Check stock
    $productResult = $db->query("SELECT stock FROM products WHERE id = '$productIdEsc'");
    if (!$productResult || $productResult->num_rows === 0) {
        jsonResponse(['error' => 'Produk tidak ditemukan.'], 404);
    }

    $product = $productResult->fetch_assoc();
    if ((int) $product['stock'] < $quantity) {
        jsonResponse(['error' => 'Stok tidak mencukupi.'], 400);
    }

    // Check cart item exists
    $cartCheck = $db->query("SELECT * FROM carts WHERE user_id = '$userId' AND product_id = '$productIdEsc'");
    if (!$cartCheck || $cartCheck->num_rows === 0) {
        jsonResponse(['error' => 'Item tidak ditemukan di keranjang.'], 404);
    }

    $db->query("UPDATE carts SET quantity = $quantity WHERE user_id = '$userId' AND product_id = '$productIdEsc'");

    jsonResponse(['message' => 'Quantity berhasil diupdate!']);
}

// DELETE - Remove item
if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    $cartCheck = $db->query("SELECT * FROM carts WHERE user_id = '$userId' AND product_id = '$productIdEsc'");
    if (!$cartCheck || $cartCheck->num_rows === 0) {
        jsonResponse(['error' => 'Item tidak ditemukan di keranjang.'], 404);
    }

    $db->query("DELETE FROM carts WHERE user_id = '$userId' AND product_id = '$productIdEsc'");

    jsonResponse(['message' => 'Item berhasil dihapus dari keranjang!']);
}

jsonResponse(['error' => 'Method not allowed'], 405);
