<?php
/**
 * POST /api/payment/notification.php
 * Handle Midtrans payment notification (webhook)
 * 
 * Set this URL in Midtrans Dashboard > Settings > Configuration > Payment Notification URL
 * Example: https://yourdomain.com/api/payment/notification.php
 */

header('Content-Type: application/json');

require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../config/midtrans.php';

// Get notification data
$json = file_get_contents('php://input');
$notification = json_decode($json, true);

if (!$notification) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid notification data']);
    exit;
}

// Extract notification data
$orderId = $notification['order_id'] ?? '';
$transactionStatus = $notification['transaction_status'] ?? '';
$fraudStatus = $notification['fraud_status'] ?? 'accept';
$statusCode = $notification['status_code'] ?? '';
$grossAmount = $notification['gross_amount'] ?? '';
$signatureKey = $notification['signature_key'] ?? '';

// Log notification for debugging
error_log("Midtrans Notification: " . $json);

// Verify signature
if (!verifySignature($orderId, $statusCode, $grossAmount, $signatureKey)) {
    error_log("Invalid signature for order: $orderId");
    http_response_code(403);
    echo json_encode(['error' => 'Invalid signature']);
    exit;
}

// Extract original transaction ID (we added timestamp suffix when creating)
$transactionIdParts = explode('-', $orderId);
array_pop($transactionIdParts); // Remove timestamp
$transactionId = implode('-', $transactionIdParts);

$db = getDB();
$transactionId = $db->real_escape_string($transactionId);

// Determine payment status based on transaction status
$paymentStatus = 'pending';
$orderStatus = 'pending';

if ($transactionStatus === 'capture' || $transactionStatus === 'settlement') {
    if ($fraudStatus === 'accept') {
        $paymentStatus = 'paid';
        $orderStatus = 'processing'; // Auto update to processing when paid
    }
} elseif ($transactionStatus === 'pending') {
    $paymentStatus = 'pending';
} elseif ($transactionStatus === 'deny' || $transactionStatus === 'expire' || $transactionStatus === 'cancel') {
    $paymentStatus = 'failed';
    $orderStatus = 'cancelled';
}

// Update transaction in database
$paymentMethod = $db->real_escape_string($notification['payment_type'] ?? 'midtrans');
$midtransId = $db->real_escape_string($notification['transaction_id'] ?? '');

$sql = "UPDATE transactions SET 
        payment_status = '$paymentStatus',
        status = '$orderStatus',
        payment_method = '$paymentMethod',
        midtrans_transaction_id = '$midtransId',
        updated_at = NOW()
        WHERE id = '$transactionId'";

if ($db->query($sql)) {
    error_log("Transaction $transactionId updated: payment=$paymentStatus, status=$orderStatus");
    http_response_code(200);
    echo json_encode(['status' => 'OK']);
} else {
    error_log("Failed to update transaction $transactionId: " . $db->error);
    http_response_code(500);
    echo json_encode(['error' => 'Failed to update transaction']);
}
