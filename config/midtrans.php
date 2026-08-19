<?php
/**
 * Midtrans Payment Gateway Configuration
 * Documentation: https://docs.midtrans.com
 */

// Sandbox/Production Mode
// User confirmed Sandbox environment in Midtrans Dashboard
define('MIDTRANS_IS_PRODUCTION', false); // Sandbox mode

// API Keys from Midtrans Dashboard
define('MIDTRANS_MERCHANT_ID', 'M185138293');
define('MIDTRANS_CLIENT_KEY', 'YOUR_MIDTRANS_CLIENT_KEY');
define('MIDTRANS_SERVER_KEY', 'YOUR_MIDTRANS_SERVER_KEY');

// API URLs
define('MIDTRANS_SNAP_URL', MIDTRANS_IS_PRODUCTION
    ? 'https://app.midtrans.com/snap/snap.js'
    : 'https://app.sandbox.midtrans.com/snap/snap.js');

define('MIDTRANS_API_URL', MIDTRANS_IS_PRODUCTION
    ? 'https://api.midtrans.com/v2'
    : 'https://api.sandbox.midtrans.com/v2');

/**
 * Create Snap Token for payment popup
 * @param array $transactionDetails Transaction data
 * @return array Response with token or error
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
        return ['error' => 'Connection error: ' . $error];
    }

    $result = json_decode($response, true);

    if ($httpCode !== 201 && $httpCode !== 200) {
        return ['error' => $result['error_messages'][0] ?? 'Failed to create payment'];
    }

    return $result;
}

/**
 * Verify notification signature from Midtrans
 * @param string $orderId Order ID
 * @param string $statusCode Status code
 * @param string $grossAmount Gross amount
 * @param string $signatureKey Signature from notification
 * @return bool Is signature valid
 */
function verifySignature(string $orderId, string $statusCode, string $grossAmount, string $signatureKey): bool
{
    $expectedSignature = hash('sha512', $orderId . $statusCode . $grossAmount . MIDTRANS_SERVER_KEY);
    return $signatureKey === $expectedSignature;
}
