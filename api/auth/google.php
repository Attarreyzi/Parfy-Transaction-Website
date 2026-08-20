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
$name = trim($data['name'] ?? '');
$credential = $data['credential'] ?? '';

// Decode Google JWT Credential if passed directly
if (!empty($credential) && empty($email)) {
    $parts = explode('.', $credential);
    if (count($parts) === 3) {
        $payload = json_decode(base64_decode(str_replace(['-', '_'], ['+', '/'], $parts[1])), true);
        if ($payload && !empty($payload['email'])) {
            $email = trim($payload['email']);
            $name = trim($payload['name'] ?? explode('@', $email)[0]);
        }
    }
}

if (empty($email)) {
    jsonResponse(['error' => 'Email dari Google tidak ditemukan.'], 400);
}

if (empty($name)) {
    $name = explode('@', $email)[0];
}

$db = getDB();
$emailEscaped = $db->real_escape_string($email);

// Cek apakah user sudah terdaftar
$result = $db->query("SELECT id, name, email, role, phone FROM users WHERE email = '$emailEscaped'");

if ($result && $result->num_rows > 0) {
    // User ditemukan, langsung login
    $user = $result->fetch_assoc();
} else {
    // Buat akun baru jika belum terdaftar
    $userId = generateId('user');
    $nameEscaped = $db->real_escape_string($name);
    $defaultPassword = password_hash(bin2hex(random_bytes(10)), PASSWORD_BCRYPT);
    $role = 'user';

    $insertSql = "INSERT INTO users (id, name, email, password, role) 
                  VALUES ('$userId', '$nameEscaped', '$emailEscaped', '$defaultPassword', '$role')";

    if (!$db->query($insertSql)) {
        jsonResponse(['error' => 'Gagal membuat akun dengan Google.'], 500);
    }

    $user = [
        'id' => $userId,
        'name' => $name,
        'email' => $email,
        'role' => $role
    ];
}

// Generate token JWT PARFY
$token = createToken(['userId' => $user['id']]);

jsonResponse([
    'message' => 'Login Google berhasil!',
    'token' => $token,
    'user' => [
        'id' => $user['id'],
        'name' => $user['name'],
        'email' => $user['email'],
        'role' => $user['role']
    ]
]);
