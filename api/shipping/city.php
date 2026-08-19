<?php
/**
 * GET /api/shipping/city?province=PROVINCE_ID
 * Returns list of cities/kabupaten using BinderByte API
 */

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

require_once __DIR__ . '/../../config/binderbyte.php';

$provinceId = $_GET['province'] ?? '';

if (empty($provinceId)) {
    echo json_encode([
        'success' => false,
        'error' => 'Province ID required',
        'cities' => []
    ]);
    exit;
}

$url = BINDERBYTE_BASE_URL . "/wilayah/kabupaten?api_key=" . BINDERBYTE_API_KEY . "&id_provinsi=" . urlencode($provinceId);

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
        'cities' => []
    ]);
    exit;
}

$data = json_decode($response, true);

// BinderByte response: {"code":"200","messages":"Success","value":[...]}
if (isset($data['code']) && $data['code'] == '200' && isset($data['value'])) {
    $cities = [];
    foreach ($data['value'] as $city) {
        $cities[] = [
            'id' => $city['id'],
            'name' => $city['name'],
            'type' => ''
        ];
    }
    echo json_encode([
        'success' => true,
        'cities' => $cities
    ]);
} else {
    echo json_encode([
        'success' => false,
        'error' => $data['messages'] ?? 'Failed to load cities',
        'cities' => []
    ]);
}
