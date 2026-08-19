<?php
/**
 * /api/transactions/index.php
 * GET: List transactions
 * POST: Create new transaction
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

$user = requireAuth();
$db = getDB();
$userId = $db->real_escape_string($user['id']);

// GET - List transactions
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $whereClause = $user['role'] === 'admin' ? "1=1" : "t.user_id = '$userId'";

    $sql = "SELECT * FROM transactions t WHERE $whereClause ORDER BY t.created_at DESC";
    $result = $db->query($sql);
    $transactions = [];

    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $transactionId = $db->real_escape_string($row['id']);

            // Fetch items separately for MySQL 5.x compatibility
            $itemsSql = "SELECT product_id, product_name, quantity, price FROM transaction_items WHERE transaction_id = '$transactionId'";
            $itemsResult = $db->query($itemsSql);
            $items = [];

            if ($itemsResult) {
                while ($item = $itemsResult->fetch_assoc()) {
                    $items[] = [
                        'productId' => $item['product_id'],
                        'productName' => $item['product_name'],
                        'quantity' => (int) $item['quantity'],
                        'price' => (int) $item['price']
                    ];
                }
            }

            $transactions[] = [
                'id' => $row['id'],
                'userId' => $row['user_id'],
                'userName' => $row['user_name'],
                'items' => $items,
                'total' => (int) $row['total'],
                'shippingCost' => (int) $row['shipping_cost'],
                'status' => $row['status'],
                'paymentStatus' => $row['payment_status'],
                'paymentMethod' => $row['payment_method'],
                'shippingAddress' => $row['shipping_address'],
                'cancelReason' => $row['cancel_reason'],
                'date' => $row['created_at']
            ];
        }
    }

    jsonResponse($transactions);
}


// POST - Create transaction
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = getJsonBody();

    $items = $data['items'] ?? [];
    $shippingAddress = $data['shippingAddress'] ?? '';

    if (empty($items)) {
        jsonResponse(['error' => 'Keranjang kosong.'], 400);
    }

    if (empty($shippingAddress)) {
        jsonResponse(['error' => 'Alamat pengiriman wajib diisi.'], 400);
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

    // Create transaction
    $transactionId = 'INV' . substr(time(), -6);
    $userNameEsc = $db->real_escape_string($user['name']);
    $shippingAddressEsc = $db->real_escape_string($shippingAddress);

    $sql = "INSERT INTO transactions (id, user_id, user_name, total, status, payment_status, shipping_address, created_at) 
            VALUES ('$transactionId', '$userId', '$userNameEsc', $total, 'pending', 'pending', '$shippingAddressEsc', NOW())";

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
            'status' => 'pending',
            'paymentStatus' => 'pending',
            'shippingAddress' => $shippingAddress,
            'date' => date('c')
        ]
    ], 201);
}

jsonResponse(['error' => 'Method not allowed'], 405);
