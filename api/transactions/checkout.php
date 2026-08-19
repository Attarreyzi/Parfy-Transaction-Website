<?php
/**
 * POST /api/transactions/checkout.php
 * Checkout from cart with shipping cost
 */

// FORCE JSON OUTPUT - Suppress all HTML errors
ini_set('display_errors', 0);
error_reporting(0);
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

// Custom error handler to return JSON
set_error_handler(function ($errno, $errstr, $errfile, $errline) {
    http_response_code(500);
    echo json_encode(['error' => "Error: $errstr"]);
    exit;
});

// Exception handler
set_exception_handler(function ($e) {
    http_response_code(500);
    echo json_encode(['error' => 'Exception: ' . $e->getMessage()]);
    exit;
});

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../config/jwt.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    jsonResponse(['error' => 'Method not allowed'], 405);
}

$user = requireAuth();
$db = getDB();
$userId = $db->real_escape_string($user['id']);

$data = getJsonBody();

$items = $data['items'] ?? [];
$paymentMethod = $data['paymentMethod'] ?? 'QRIS';
$shippingAddress = $data['shippingAddress'] ?? '';
$shippingCost = (int) ($data['shippingCost'] ?? 0);

if (empty($items)) {
    jsonResponse(['error' => 'Keranjang kosong.'], 400);
}

$total = 0;
$orderItems = [];

// Validate and calculate
foreach ($items as $item) {
    $productIdEsc = $db->real_escape_string($item['productId']);
    $quantity = (int) $item['quantity'];

    $productResult = $db->query("SELECT * FROM products WHERE id = '$productIdEsc'");
    if (!$productResult || $productResult->num_rows === 0) {
        jsonResponse(['error' => "Produk {$item['productId']} tidak ditemukan."], 400);
    }

    $product = $productResult->fetch_assoc();

    if ((int) $product['stock'] < $quantity) {
        jsonResponse(['error' => "Stok {$product['name']} tidak mencukupi."], 400);
    }

    $orderItems[] = [
        'productId' => $product['id'],
        'productName' => $product['name'],
        'quantity' => $quantity,
        'price' => (int) $product['price']
    ];

    $total += (int) $product['price'] * $quantity;

    // Reduce stock
    $newStock = (int) $product['stock'] - $quantity;
    $newSold = (int) $product['sold'] + $quantity;
    $db->query("UPDATE products SET stock = $newStock, sold = $newSold WHERE id = '$productIdEsc'");
}

// Add shipping cost
$total += $shippingCost;

// Create transaction
$transactionId = 'INV' . substr(time(), -6);
$userNameEsc = $db->real_escape_string($user['name']);
$paymentMethodEsc = $db->real_escape_string($paymentMethod);
$shippingAddressEsc = $db->real_escape_string($shippingAddress);

$sql = "INSERT INTO transactions (id, user_id, user_name, total, shipping_cost, status, payment_status, payment_method, shipping_address, created_at) 
        VALUES ('$transactionId', '$userId', '$userNameEsc', $total, $shippingCost, 'pending', 'pending', '$paymentMethodEsc', '$shippingAddressEsc', NOW())";

if (!$db->query($sql)) {
    jsonResponse(['error' => 'Gagal membuat pesanan: ' . $db->error], 500);
}

// Insert transaction items
foreach ($orderItems as $item) {
    $productIdEsc = $db->real_escape_string($item['productId']);
    $productNameEsc = $db->real_escape_string($item['productName']);
    $qty = $item['quantity'];
    $price = $item['price'];

    $db->query("INSERT INTO transaction_items (transaction_id, product_id, product_name, quantity, price) 
                VALUES ('$transactionId', '$productIdEsc', '$productNameEsc', $qty, $price)");
}

// Clear cart
$db->query("DELETE FROM carts WHERE user_id = '$userId'");

jsonResponse([
    'message' => 'Pesanan berhasil dibuat!',
    'transaction' => [
        'id' => $transactionId,
        'userId' => $userId,
        'userName' => $user['name'],
        'items' => $orderItems,
        'total' => $total,
        'shippingCost' => $shippingCost,
        'status' => 'pending',
        'paymentStatus' => 'lunas',
        'paymentMethod' => $paymentMethod,
        'shippingAddress' => $shippingAddress,
        'date' => date('c')
    ]
], 201);
