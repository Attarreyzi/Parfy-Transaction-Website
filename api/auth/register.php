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

$name = trim($data['name'] ?? '');
$email = trim($data['email'] ?? '');
$password = $data['password'] ?? '';
$phone = trim($data['phone'] ?? '');

// Validation
if (empty($name) || empty($email) || empty($password)) {
    jsonResponse(['error' => 'Nama, email, dan password wajib diisi.'], 400);
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    jsonResponse(['error' => 'Format email tidak valid.'], 400);
}

if (strlen($password) < 6) {
    jsonResponse(['error' => 'Password minimal 6 karakter.'], 400);
}

$db = getDB();

// Check if email exists
$emailEscaped = $db->real_escape_string($email);
$result = $db->query("SELECT id FROM users WHERE email = '$emailEscaped'");

if ($result && $result->num_rows > 0) {
    jsonResponse(['error' => 'Email sudah terdaftar.'], 400);
}

// Create user
$userId = generateId('user');
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);
$nameEscaped = $db->real_escape_string($name);
$phoneEscaped = $db->real_escape_string($phone);

$sql = "INSERT INTO users (id, name, email, password, role, phone, created_at) 
        VALUES ('$userId', '$nameEscaped', '$emailEscaped', '$hashedPassword', 'user', '$phoneEscaped', NOW())";

if (!$db->query($sql)) {
    jsonResponse(['error' => 'Gagal registrasi: ' . $db->error], 500);
}

// Generate token
$token = createToken(['userId' => $userId]);

jsonResponse([
    'message' => 'Registrasi berhasil!',
    'token' => $token,
    'user' => [
        'id' => $userId,
        'name' => $name,
        'email' => $email,
        'role' => 'user'
    ]
], 201);
