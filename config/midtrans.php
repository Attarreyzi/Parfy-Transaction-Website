<?php
/**
 * Konfigurasi Payment Gateway Midtrans
 */

// Mode Sandbox / Production
define('MIDTRANS_IS_PRODUCTION', false);

// Kunci API Midtrans
define('MIDTRANS_MERCHANT_ID', 'M185138293');
define('MIDTRANS_CLIENT_KEY', 'YOUR_MIDTRANS_CLIENT_KEY');
define('MIDTRANS_SERVER_KEY', 'YOUR_MIDTRANS_SERVER_KEY');

// URL API Midtrans
define('MIDTRANS_SNAP_URL', MIDTRANS_IS_PRODUCTION
    ? 'https://app.midtrans.com/snap/snap.js'
    : 'https://app.sandbox.midtrans.com/snap/snap.js');

define('MIDTRANS_API_URL', MIDTRANS_IS_PRODUCTION
    ? 'https://api.midtrans.com/v2'
    : 'https://api.sandbox.midtrans.com/v2');

/**
 * Membuat Snap Token transaksi pembayaran
 */
function createSnapToken(array $transactionDetails): array
{
    $url = (MIDTRANS_IS_PRODUCTION
        ? 'https://app.midtrans.com'
        : 'https://app.sandbox.midtrans.com') . '/snap/v1/transactions';

    $ch = curl_init();
    curl_setopt_array($ch, [
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => json_encode($transactionDetails),
        CURLOPT_HTTPHEADER => [
            'Content-Type: application/json',
            'Accept: application/json',
            'Authorization: Basic ' . base64_encode(MIDTRANS_SERVER_KEY . ':')
        ],
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_SSL_VERIFYHOST => 0,
        CURLOPT_TIMEOUT => 30
    ]);

    $response = curl_exec($ch);
    $error = curl_error($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($error) {
        return ['error' => 'Gagal koneksi: ' . $error];
    }

    $result = json_decode($response, true);

    if ($httpCode !== 201 && $httpCode !== 200) {
        return ['error' => $result['error_messages'][0] ?? 'Gagal membuat transaksi'];
    }

    return $result;
}

/**
 * Verifikasi signature notifikasi dari Midtrans
 */
function verifySignature(string $orderId, string $statusCode, string $grossAmount, string $signatureKey): bool
{
    $expectedSignature = hash('sha512', $orderId . $statusCode . $grossAmount . MIDTRANS_SERVER_KEY);
    return $signatureKey === $expectedSignature;
}

