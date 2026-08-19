<?php
/**
 * /api/users/addresses.php
 * GET: Get user addresses
 * POST: Add new address
 * PUT: Update address
 * DELETE: Delete address
 */

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
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

// GET - List addresses
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $result = $db->query("SELECT * FROM user_addresses WHERE user_id = '$userId'");
    $addresses = [];

    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $addresses[] = [
                'id' => (int) $row['id'],
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

    jsonResponse($addresses);
}

// POST - Add address
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = getJsonBody();

    $label = $db->real_escape_string($data['label'] ?? '');
    $name = $db->real_escape_string($data['name'] ?? '');
    $phone = $db->real_escape_string($data['phone'] ?? '');
    $street = $db->real_escape_string($data['street'] ?? '');
    $city = $db->real_escape_string($data['city'] ?? '');
    $cityId = $db->real_escape_string($data['cityId'] ?? '');
    $province = $db->real_escape_string($data['province'] ?? '');
    $provinceId = $db->real_escape_string($data['provinceId'] ?? '');
    $postalCode = $db->real_escape_string($data['postalCode'] ?? '');

    // Check if phone number is already registered
    if (!empty($phone)) {
        $phoneCheck = $db->query("SELECT id FROM user_addresses WHERE user_id = '$userId' AND phone = '$phone'");
        if ($phoneCheck && $phoneCheck->num_rows > 0) {
            jsonResponse(['error' => 'Nomor telepon ini sudah terdaftar pada alamat Anda.'], 400);
        }
    }

    // Check if recipient name is already registered
    if (!empty($name)) {
        $nameCheck = $db->query("SELECT id FROM user_addresses WHERE user_id = '$userId' AND LOWER(name) = LOWER('$name')");
        if ($nameCheck && $nameCheck->num_rows > 0) {
            jsonResponse(['error' => 'Nama penerima ini sudah terdaftar pada alamat Anda. Silakan gunakan nama lain.'], 400);
        }
    }

    $sql = "INSERT INTO user_addresses (user_id, label, name, phone, street, city, city_id, province, province_id, postal_code) 
            VALUES ('$userId', '$label', '$name', '$phone', '$street', '$city', '$cityId', '$province', '$provinceId', '$postalCode')";

    if (!$db->query($sql)) {
        jsonResponse(['error' => 'Gagal menambah alamat: ' . $db->error], 500);
    }

    jsonResponse([
        'message' => 'Alamat berhasil ditambahkan!',
        'addressId' => $db->insert_id
    ], 201);
}

// PUT - Update address
if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    $addressId = (int) ($_GET['id'] ?? 0);
    if ($addressId <= 0) {
        jsonResponse(['error' => 'Address ID diperlukan.'], 400);
    }

    // Check ownership
    $addrCheck = $db->query("SELECT * FROM user_addresses WHERE id = $addressId AND user_id = '$userId'");
    if (!$addrCheck || $addrCheck->num_rows === 0) {
        jsonResponse(['error' => 'Alamat tidak ditemukan.'], 404);
    }

    $data = getJsonBody();
    $updates = [];

    // Check if phone number is already used in another address of the user
    if (!empty($data['phone'])) {
        $newPhone = $db->real_escape_string($data['phone']);
        $phoneCheck = $db->query("SELECT id FROM user_addresses WHERE user_id = '$userId' AND phone = '$newPhone' AND id != $addressId");
        if ($phoneCheck && $phoneCheck->num_rows > 0) {
            jsonResponse(['error' => 'Nomor telepon ini sudah terdaftar pada alamat Anda yang lain.'], 400);
        }
    }

    // Check if recipient name is already used in another address of the user
    if (!empty($data['name'])) {
        $newName = $db->real_escape_string($data['name']);
        $nameCheck = $db->query("SELECT id FROM user_addresses WHERE user_id = '$userId' AND LOWER(name) = LOWER('$newName') AND id != $addressId");
        if ($nameCheck && $nameCheck->num_rows > 0) {
            jsonResponse(['error' => 'Nama penerima ini sudah terdaftar pada alamat Anda yang lain.'], 400);
        }
    }

    if (isset($data['label']))
        $updates[] = "label = '" . $db->real_escape_string($data['label']) . "'";
    if (isset($data['name']))
        $updates[] = "name = '" . $db->real_escape_string($data['name']) . "'";
    if (isset($data['phone']))
        $updates[] = "phone = '" . $db->real_escape_string($data['phone']) . "'";
    if (isset($data['street']))
        $updates[] = "street = '" . $db->real_escape_string($data['street']) . "'";
    if (isset($data['city']))
        $updates[] = "city = '" . $db->real_escape_string($data['city']) . "'";
    if (isset($data['cityId']))
        $updates[] = "city_id = '" . $db->real_escape_string($data['cityId']) . "'";
    if (isset($data['province']))
        $updates[] = "province = '" . $db->real_escape_string($data['province']) . "'";
    if (isset($data['provinceId']))
        $updates[] = "province_id = '" . $db->real_escape_string($data['provinceId']) . "'";
    if (isset($data['postalCode']))
        $updates[] = "postal_code = '" . $db->real_escape_string($data['postalCode']) . "'";

    if (empty($updates)) {
        jsonResponse(['error' => 'Tidak ada data yang diupdate.'], 400);
    }

    $updateStr = implode(', ', $updates);
    $db->query("UPDATE user_addresses SET $updateStr WHERE id = $addressId");

    jsonResponse(['message' => 'Alamat berhasil diupdate!']);
}

// DELETE - Delete address
if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    $addressId = (int) ($_GET['id'] ?? 0);
    if ($addressId <= 0) {
        jsonResponse(['error' => 'Address ID diperlukan.'], 400);
    }

    // Check ownership
    $addrCheck = $db->query("SELECT * FROM user_addresses WHERE id = $addressId AND user_id = '$userId'");
    if (!$addrCheck || $addrCheck->num_rows === 0) {
        jsonResponse(['error' => 'Alamat tidak ditemukan.'], 404);
    }

    $db->query("DELETE FROM user_addresses WHERE id = $addressId");

    jsonResponse(['message' => 'Alamat berhasil dihapus!']);
}

jsonResponse(['error' => 'Method not allowed'], 405);
