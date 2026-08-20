<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, PUT, OPTIONS');
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

$transactionId = $_GET['id'] ?? '';
if (empty($transactionId)) {
    jsonResponse(['error' => 'Transaction ID diperlukan.'], 400);
}

$transactionIdEsc = $db->real_escape_string($transactionId);

// Ambil data
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $result = $db->query("SELECT * FROM transactions WHERE id = '$transactionIdEsc'");

    if (!$result || $result->num_rows === 0) {
        jsonResponse(['error' => 'Transaksi tidak ditemukan.'], 404);
    }

    $transaction = $result->fetch_assoc();

    // Check access
    if ($user['role'] !== 'admin' && $transaction['user_id'] !== $user['id']) {
        jsonResponse(['error' => 'Akses ditolak.'], 403);
    }

    // Get items
    $itemsResult = $db->query("SELECT * FROM transaction_items WHERE transaction_id = '$transactionIdEsc'");
    $items = [];
    if ($itemsResult) {
        while ($row = $itemsResult->fetch_assoc()) {
            $items[] = [
                'productId' => $row['product_id'],
                'productName' => $row['product_name'],
                'quantity' => (int) $row['quantity'],
                'price' => (int) $row['price']
            ];
        }
    }

    jsonResponse([
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
        'date' => $transaction['created_at']
    ]);
}

// Update data
if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    if ($user['role'] !== 'admin') {
        jsonResponse(['error' => 'Hanya admin yang bisa update status.'], 403);
    }

    $result = $db->query("SELECT * FROM transactions WHERE id = '$transactionIdEsc'");
    if (!$result || $result->num_rows === 0) {
        jsonResponse(['error' => 'Transaksi tidak ditemukan.'], 404);
    }

    $data = getJsonBody();
    $updates = [];

    if (isset($data['status'])) {
        $statusEsc = $db->real_escape_string($data['status']);
        $updates[] = "status = '$statusEsc'";
    }

    if (isset($data['paymentStatus'])) {
        $paymentStatusEsc = $db->real_escape_string($data['paymentStatus']);
        $updates[] = "payment_status = '$paymentStatusEsc'";
    }

    if (empty($updates)) {
        jsonResponse(['error' => 'Tidak ada data yang diupdate.'], 400);
    }

    $updateStr = implode(', ', $updates);
    $db->query("UPDATE transactions SET $updateStr WHERE id = '$transactionIdEsc'");

    jsonResponse(['message' => 'Status transaksi berhasil diupdate!']);
}

jsonResponse(['error' => 'Method not allowed'], 405);
