<?php
/**
 * /api/cart/index.php
 * GET: Get user's cart
 * POST: Add item to cart
 * DELETE: Clear cart
 */

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, DELETE, OPTIONS');
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

// GET - Get cart
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $sql = "SELECT c.*, p.id as product_id, p.name, p.price, p.image, p.stock 
            FROM carts c 
            JOIN products p ON c.product_id = p.id 
            WHERE c.user_id = '$userId'";

    $result = $db->query($sql);
    $items = [];
    $total = 0;

    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $subtotal = (int) $row['price'] * (int) $row['quantity'];
            $total += $subtotal;

            $items[] = [
                'productId' => $row['product_id'],
                'quantity' => (int) $row['quantity'],
                'product' => [
                    'id' => $row['product_id'],
                    'name' => $row['name'],
                    'price' => (int) $row['price'],
                    'image' => $row['image'],
                    'stock' => (int) $row['stock']
                ]
            ];
        }
    }

    jsonResponse([
        'items' => $items,
        'total' => $total,
        'itemCount' => count($items)
    ]);
}

// POST - Add to cart
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = getJsonBody();

    $productId = $data['productId'] ?? $data['product_id'] ?? '';
    $quantity = (int) ($data['quantity'] ?? 1);

    if (empty($productId)) {
        jsonResponse(['error' => 'Product ID wajib diisi.'], 400);
    }

    if ($quantity < 1)
        $quantity = 1;

    $productIdEsc = $db->real_escape_string($productId);

    // Check product exists and stock
    $result = $db->query("SELECT * FROM products WHERE id = '$productIdEsc'");
    if (!$result || $result->num_rows === 0) {
        jsonResponse(['error' => 'Produk tidak ditemukan.'], 404);
    }

    $product = $result->fetch_assoc();

    if ((int) $product['stock'] < $quantity) {
        jsonResponse(['error' => 'Stok tidak mencukupi.'], 400);
    }

    // Check if already in cart
    $cartCheck = $db->query("SELECT * FROM carts WHERE user_id = '$userId' AND product_id = '$productIdEsc'");

    if ($cartCheck && $cartCheck->num_rows > 0) {
        // Update quantity
        $existing = $cartCheck->fetch_assoc();
        $newQty = (int) $existing['quantity'] + $quantity;
        $db->query("UPDATE carts SET quantity = $newQty WHERE user_id = '$userId' AND product_id = '$productIdEsc'");
    } else {
        // Insert new
        $db->query("INSERT INTO carts (user_id, product_id, quantity) VALUES ('$userId', '$productIdEsc', $quantity)");
    }

    jsonResponse([
        'message' => 'Berhasil ditambahkan ke keranjang!'
    ]);
}

// DELETE - Clear cart
if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    $db->query("DELETE FROM carts WHERE user_id = '$userId'");

    jsonResponse(['message' => 'Keranjang berhasil dikosongkan!']);
}

jsonResponse(['error' => 'Method not allowed'], 405);





