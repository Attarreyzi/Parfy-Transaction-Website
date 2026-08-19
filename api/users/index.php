<?php
/**
 * /api/users/index.php
 * GET: List all users (admin only)
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

$user = requireAdmin();
$db = getDB();

$result = $db->query("SELECT id, name, email, role, phone, gender, birth_date, created_at FROM users ORDER BY created_at DESC");
$users = [];

if ($result) {
    while ($row = $result->fetch_assoc()) {
        $userId = $db->real_escape_string($row['id']);

        // Get addresses
        $addrResult = $db->query("SELECT * FROM user_addresses WHERE user_id = '$userId'");
        $addresses = [];
        if ($addrResult) {
            while ($addr = $addrResult->fetch_assoc()) {
                $addresses[] = [
                    'label' => $addr['label'],
                    'name' => $addr['name'],
                    'phone' => $addr['phone'],
                    'street' => $addr['street'],
                    'city' => $addr['city'],
                    'province' => $addr['province'],
                    'postalCode' => $addr['postal_code']
                ];
            }
        }

        $users[] = [
            'id' => $row['id'],
            'name' => $row['name'],
            'email' => $row['email'],
            'role' => $row['role'],
            'phone' => $row['phone'],
            'gender' => $row['gender'],
            'birthDate' => $row['birth_date'],
            'addresses' => $addresses,
            'createdAt' => $row['created_at']
        ];
    }
}

jsonResponse($users);
