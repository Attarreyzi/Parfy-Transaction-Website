<?php
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
require_once __DIR__ . '/../../config/midtrans.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    jsonResponse(['error' => 'Method not allowed'], 405);
}

$user = requireAuth();
$db = getDB();
$data = getJsonBody();

$transactionId = $data['transactionId'] ?? null;

if (!$transactionId) {
    jsonResponse(['error' => 'Transaction ID diperlukan'], 400);
}

// Get transaction from database
$transactionId = $db->real_escape_string($transactionId);
$result = $db->query("SELECT * FROM transactions WHERE id = '$transactionId' AND user_id = '{$user['id']}'");

if (!$result || $result->num_rows === 0) {
    jsonResponse(['error' => 'Transaksi tidak ditemukan'], 404);
}

$transaction = $result->fetch_assoc();

// Check if already paid
if ($transaction['payment_status'] === 'paid') {
    jsonResponse(['error' => 'Transaksi sudah dibayar'], 400);
}

// Get transaction items
$itemsResult = $db->query("SELECT * FROM transaction_items WHERE transaction_id = '$transactionId'");
$items = [];
while ($item = $itemsResult->fetch_assoc()) {
    $items[] = [
        'id' => $item['product_id'],
        'name' => $item['product_name'],
        'price' => (int) $item['price'],
        'quantity' => (int) $item['quantity']
    ];
}

// Add shipping cost as item if exists
if ((int) $transaction['shipping_cost'] > 0) {
    $items[] = [
        'id' => 'SHIPPING',
        'name' => 'Ongkos Kirim',
        'price' => (int) $transaction['shipping_cost'],
        'quantity' => 1
    ];
}

// Prepare Midtrans transaction details
$transactionDetails = [
    'transaction_details' => [
        'order_id' => $transactionId . '-' . time(), // Unique order ID
        'gross_amount' => (int) $transaction['total']
    ],
    'item_details' => $items,
    'customer_details' => [
        'first_name' => $transaction['user_name'],
        'email' => $user['email'] ?? 'customer@parfy.id',
        'phone' => $user['phone'] ?? ''
    ],
    'callbacks' => [
        'finish' => '/pesanan'
    ]
];

// Create Snap Token
$snapResponse = createSnapToken($transactionDetails);

if (isset($snapResponse['error'])) {
    jsonResponse(['error' => $snapResponse['error']], 500);
}

// Save snap token to transaction (optional, ignore if column doesn't exist)
$snapToken = $db->real_escape_string($snapResponse['token']);
@$db->query("UPDATE transactions SET snap_token = '$snapToken' WHERE id = '$transactionId'");

jsonResponse([
    'token' => $snapResponse['token'],
    'redirect_url' => $snapResponse['redirect_url'] ?? null,
    'clientKey' => MIDTRANS_CLIENT_KEY
]);
