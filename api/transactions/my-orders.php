<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../config/jwt.php';

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    jsonResponse(['error' => 'Method not allowed'], 405);
}

$user = requireAuth();
$db = getDB();
$userId = $db->real_escape_string($user['id']);

$sql = "SELECT * FROM transactions WHERE user_id = '$userId' ORDER BY created_at DESC";
$result = $db->query($sql);
$transactions = [];

if ($result) {
    while ($transaction = $result->fetch_assoc()) {
        $transactionId = $db->real_escape_string($transaction['id']);

        // Get items with product details
        $itemsSql = "SELECT ti.*, p.image, p.brand, p.category 
                     FROM transaction_items ti 
                     LEFT JOIN products p ON ti.product_id = p.id 
                     WHERE ti.transaction_id = '$transactionId'";
        $itemsResult = $db->query($itemsSql);
        $items = [];

        if ($itemsResult) {
            while ($item = $itemsResult->fetch_assoc()) {
                $items[] = [
                    'productId' => $item['product_id'],
                    'productName' => $item['product_name'],
                    'quantity' => (int) $item['quantity'],
                    'price' => (int) $item['price'],
                    'product' => [
                        'id' => $item['product_id'],
                        'name' => $item['product_name'],
                        'image' => $item['image'] ?? '/foto/default.jpg',
                        'brand' => $item['brand'],
                        'category' => $item['category']
                    ]
                ];
            }
        }

        $transactions[] = [
            'id' => $transaction['id'],
            'userId' => $transaction['user_id'],
            'userName' => $transaction['user_name'],
            'items' => $items,
            'total' => (int) $transaction['total'],
            'shippingCost' => (int) $transaction['shipping_cost'],
            'status' => $transaction['status'],
            'paymentStatus' => $transaction['payment_status'],
            'paymentMethod' => $transaction['payment_method'],
            'shippingAddress' => $transaction['shipping_address'],
            'cancelReason' => $transaction['cancel_reason'],
            'snapToken' => $transaction['snap_token'] ?? null,
            'midtransTransactionId' => $transaction['midtrans_transaction_id'] ?? null,
            'createdAt' => $transaction['created_at'],
            'date' => $transaction['created_at']
        ];
    }
}

jsonResponse($transactions);
