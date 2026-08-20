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

// Ambil data
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $result = $db->query("SELECT id, name, email, role, phone, gender, birth_date FROM users WHERE id = '$userId'");

    if (!$result || $result->num_rows === 0) {
        jsonResponse(['error' => 'User tidak ditemukan.'], 404);
    }

    $userData = $result->fetch_assoc();

    jsonResponse([
        'id' => $userData['id'],
        'name' => $userData['name'],
        'email' => $userData['email'],
        'role' => $userData['role'],
        'phone' => $userData['phone'],
        'gender' => $userData['gender'],
        'birthDate' => $userData['birth_date']
    ]);
}

// Update data
if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    $data = getJsonBody();
    $updates = [];

    if (isset($data['name'])) {
        $nameEsc = $db->real_escape_string(trim($data['name']));
        $updates[] = "name = '$nameEsc'";
    }

    if (isset($data['phone'])) {
        $phoneEsc = $db->real_escape_string(trim($data['phone']));
        $updates[] = "phone = '$phoneEsc'";
    }

    if (isset($data['gender'])) {
        $genderEsc = $db->real_escape_string($data['gender']);
        $updates[] = "gender = '$genderEsc'";
    }

    if (isset($data['birthDate'])) {
        $birthDateEsc = $db->real_escape_string($data['birthDate']);
        $updates[] = "birth_date = '$birthDateEsc'";
    }

    if (isset($data['password']) && !empty($data['password'])) {
        $hashedPassword = password_hash($data['password'], PASSWORD_DEFAULT);
        $updates[] = "password = '$hashedPassword'";
    }

    if (empty($updates)) {
        jsonResponse(['error' => 'Tidak ada data yang diupdate.'], 400);
    }

    $updateStr = implode(', ', $updates);
    $db->query("UPDATE users SET $updateStr WHERE id = '$userId'");

    jsonResponse(['message' => 'Profil berhasil diupdate!']);
}

jsonResponse(['error' => 'Method not allowed'], 405);
