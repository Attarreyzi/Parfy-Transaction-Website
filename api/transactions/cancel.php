<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

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

$transactionId = $_GET['id'] ?? '';
if (empty($transactionId)) {
    jsonResponse(['error' => 'Transaction ID diperlukan.'], 400);
}

$transactionIdEsc = $db->real_escape_string($transactionId);

// Get transaction
$result = $db->query("SELECT * FROM transactions WHERE id = '$transactionIdEsc'");
if (!$result || $result->num_rows === 0) {
    jsonResponse(['error' => 'Transaksi tidak ditemukan.'], 404);
}

$transaction = $result->fetch_assoc();

// Check ownership
if ($transaction['user_id'] !== $user['id'] && $user['role'] !== 'admin') {
    jsonResponse(['error' => 'Tidak memiliki akses.'], 403);
}

// Only pending can be cancelled
if ($transaction['status'] !== 'pending') {
    jsonResponse(['error' => 'Pesanan tidak dapat dibatalkan karena sudah diproses.'], 400);
}

$data = getJsonBody();
$reason = $data['reason'] ?? 'Dibatalkan oleh pengguna';
$reasonEsc = $db->real_escape_string($reason);

// Restore stock
$itemsResult = $db->query("SELECT * FROM transaction_items WHERE transaction_id = '$transactionIdEsc'");
if ($itemsResult) {
    while ($item = $itemsResult->fetch_assoc()) {
        $productIdEsc = $db->real_escape_string($item['product_id']);
        $quantity = (int) $item['quantity'];

        $db->query("UPDATE products SET stock = stock + $quantity, sold = sold - $quantity WHERE id = '$productIdEsc'");
    }
}

// Update transaction status
$db->query("UPDATE transactions SET status = 'cancelled', cancel_reason = '$reasonEsc', cancelled_at = NOW() WHERE id = '$transactionIdEsc'");

jsonResponse([
    'message' => 'Pesanan berhasil dibatalkan.',
    'transaction' => [
        'id' => $transactionId,
        'status' => 'cancelled',
        'cancelReason' => $reason
    ]
]);
