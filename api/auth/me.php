<?php
/**
 * GET /api/auth/me.php
 * Get current user info
 */

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../config/jwt.php';

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    jsonResponse(['error' => 'Method not allowed'], 405);
}

$user = requireAuth();

$db = getDB();
$userId = $db->real_escape_string($user['id']);

// Get addresses
$addresses = [];
$addrResult = $db->query("SELECT * FROM user_addresses WHERE user_id = '$userId'");
if ($addrResult) {
    while ($row = $addrResult->fetch_assoc()) {
        $addresses[] = [
            'id' => $row['id'],
            'label' => $row['label'],
            'name' => $row['name'],
            'phone' => $row['phone'],
            'street' => $row['street'],
            'city' => $row['city'],
            'cityId' => $row['city_id'],
            'province' => $row['province'],
            'provinceId' => $row['province_id'],
            'postalCode' => $row['postal_code']
        ];
    }
}

jsonResponse([
    'id' => $user['id'],
    'name' => $user['name'],
    'email' => $user['email'],
    'role' => $user['role'],
    'phone' => $user['phone'],
    'gender' => $user['gender'],
    'birthDate' => $user['birth_date'],
    'addresses' => $addresses
]);
