<?php
/**
 * POST /api/auth/login.php
 * User login
 */

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

// Validation
if (empty($email) || empty($password)) {
    jsonResponse(['error' => 'Email dan password wajib diisi.'], 400);
}

$db = getDB();

// Find user
$emailEscaped = $db->real_escape_string($email);
$result = $db->query("SELECT id, name, email, password, role, phone FROM users WHERE email = '$emailEscaped'");

if (!$result || $result->num_rows === 0) {
    jsonResponse(['error' => 'Email atau password salah.'], 401);
}

$user = $result->fetch_assoc();

// Verify password
if (!password_verify($password, $user['password'])) {
    jsonResponse(['error' => 'Email atau password salah.'], 401);
}

// Generate token
$token = createToken(['userId' => $user['id']]);

jsonResponse([
    'message' => 'Login berhasil!',
    'token' => $token,
    'user' => [
        'id' => $user['id'],
        'name' => $user['name'],
        'email' => $user['email'],
        'role' => $user['role']
    ]
]);
