<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

// Support both POST JSON and GET params
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
} else {
    $input = $_GET;
}

$courier = strtolower($input['courier'] ?? 'jne');
$destination = $input['destination'] ?? '';

if (empty($destination)) {
    echo json_encode([
        'success' => false,
        'error' => 'Destination required',
        'costs' => []
    ]);
    exit;
}

// Static shipping costs based on courier
$costs = [
    'jne' => [
        ['service' => 'REG', 'description' => 'Regular', 'cost' => 25000, 'etd' => '2-3 hari'],
        ['service' => 'YES', 'description' => 'Yakin Esok Sampai', 'cost' => 45000, 'etd' => '1 hari'],
        ['service' => 'OKE', 'description' => 'Ongkos Kirim Ekonomis', 'cost' => 20000, 'etd' => '3-5 hari']
    ],
    'pos' => [
        ['service' => 'Pos Reguler', 'description' => 'Layanan Reguler', 'cost' => 18000, 'etd' => '4-6 hari'],
        ['service' => 'Pos Express', 'description' => 'Layanan Express', 'cost' => 35000, 'etd' => '1-2 hari']
    ],
    'tiki' => [
        ['service' => 'REG', 'description' => 'Regular Service', 'cost' => 23000, 'etd' => '3-4 hari'],
        ['service' => 'ONS', 'description' => 'Over Night Service', 'cost' => 40000, 'etd' => '1 hari'],
        ['service' => 'ECO', 'description' => 'Economy Service', 'cost' => 19000, 'etd' => '4-6 hari']
    ]
];

if (isset($costs[$courier])) {
    echo json_encode([
        'success' => true,
        'courier' => strtoupper($courier),
        'costs' => $costs[$courier]
    ]);
} else {
    echo json_encode([
        'success' => false,
        'error' => 'Courier not supported',
        'costs' => []
    ]);
}
