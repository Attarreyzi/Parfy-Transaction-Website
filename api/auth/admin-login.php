<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../config/jwt.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    jsonResponse(['error' => 'Method not allowed'], 405);
}

$data = getJsonBody();

$email = trim($data['email'] ?? '');
$password = $data['password'] ?? '';

if (empty($email) || empty($password)) {
    jsonResponse(['error' => 'Email dan password wajib diisi.'], 400);
}

$db = getDB();
$emailEscaped = $db->real_escape_string($email);

$result = $db->query("SELECT id, name, email, password, role, phone FROM users WHERE email = '$emailEscaped'");

if (!$result || $result->num_rows === 0) {
    jsonResponse(['error' => 'Kredensial Admin tidak valid.'], 401);
}

$user = $result->fetch_assoc();

if (!password_verify($password, $user['password'])) {
    jsonResponse(['error' => 'Kredensial Admin tidak valid.'], 401);
}

// Validasi role khusus Admin
if ($user['role'] !== 'admin') {
    jsonResponse(['error' => 'Akses ditolak. Akun ini tidak memiliki hak akses Administrator.'], 403);
}

$token = createToken(['userId' => $user['id']]);

jsonResponse([
    'message' => 'Login Admin berhasil!',
    'token' => $token,
    'user' => [
        'id' => $user['id'],
        'name' => $user['name'],
        'email' => $user['email'],
        'role' => $user['role']
    ]
]);
