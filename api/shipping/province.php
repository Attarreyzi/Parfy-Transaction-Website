<?php
/**
 * GET /api/shipping/province
 * Returns list of Indonesian provinces using BinderByte API
 */

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

require_once __DIR__ . '/../../config/binderbyte.php';

$url = BINDERBYTE_BASE_URL . "/wilayah/provinsi?api_key=" . BINDERBYTE_API_KEY;

$ch = curl_init();
curl_setopt_array($ch, [
    CURLOPT_URL => $url,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_TIMEOUT => 60,
    CURLOPT_CONNECTTIMEOUT => 30,
    CURLOPT_SSL_VERIFYPEER => false,
    CURLOPT_SSL_VERIFYHOST => false,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_USERAGENT => 'Mozilla/5.0'
]);

$response = curl_exec($ch);
$error = curl_error($ch);
curl_close($ch);

if ($error) {
    echo json_encode([
        'success' => false,
        'error' => 'Connection Error: ' . $error,
        'provinces' => []
    ]);
    exit;
}

$data = json_decode($response, true);

// BinderByte response: {"code":"200","messages":"Success","value":[...]}
if (isset($data['code']) && $data['code'] == '200' && isset($data['value'])) {
    $provinces = [];
    foreach ($data['value'] as $prov) {
        $provinces[] = [
            'id' => $prov['id'],
            'name' => $prov['name']
        ];
    }
    echo json_encode([
        'success' => true,
        'provinces' => $provinces
    ]);
} else {
    echo json_encode([
        'success' => false,
        'error' => $data['messages'] ?? 'Failed to load provinces',
        'provinces' => []
    ]);
}
