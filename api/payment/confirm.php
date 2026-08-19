<?php
/**
 * POST /api/payment/confirm.php
 * Confirm payment success from client Snap popup
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

$user = requireAuth();
$db = getDB();

$data = getJsonBody();
$transactionId = $db->real_escape_string($data['transaction_id'] ?? '');

if (empty($transactionId)) {
    jsonResponse(['error' => 'Transaction ID is required'], 400);
}

$midtransId = '';
$paymentType = 'midtrans';

if (!empty($data['midtrans_result'])) {
    $res = $data['midtrans_result'];
    $midtransId = $db->real_escape_string($res['transaction_id'] ?? '');
    $paymentType = $db->real_escape_string($res['payment_type'] ?? 'midtrans');
}

$userId = $db->real_escape_string($user['id']);

// Update transaction to paid and processing
$sql = "UPDATE transactions SET 
        payment_status = 'lunas',
        status = 'processing',
        payment_method = '$paymentType',
        midtrans_transaction_id = '$midtransId'
        WHERE id = '$transactionId' AND (user_id = '$userId' OR '$userId' = 'admin')";

if ($db->query($sql)) {
    jsonResponse(['success' => true, 'message' => 'Status pesanan berhasil diperbarui']);
} else {
    jsonResponse(['error' => $db->error], 500);
}
