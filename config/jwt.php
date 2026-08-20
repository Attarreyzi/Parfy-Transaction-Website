<?php
/**
 * Pengelolaan JWT (JSON Web Token) PARFY.ID
 */

define('JWT_SECRET', getenv('JWT_SECRET') ?: 'parfy_secret_key_2024_very_secure');
define('JWT_EXPIRY', 60 * 60 * 24 * 7);

/**
 * Buat token JWT
 */
function createToken(array $payload): string
{
    $header = base64_encode(json_encode(['typ' => 'JWT', 'alg' => 'HS256']));

    $payload['iat'] = time();
    $payload['exp'] = time() + JWT_EXPIRY;
    $payloadEncoded = base64_encode(json_encode($payload));

    $signature = hash_hmac('sha256', "$header.$payloadEncoded", JWT_SECRET, true);
    $signatureEncoded = base64_encode($signature);

    return "$header.$payloadEncoded.$signatureEncoded";
}

/**
 * Verifikasi token JWT
 */
function verifyToken(string $token): ?array
{
    $parts = explode('.', $token);
    if (count($parts) !== 3)
        return null;

    [$header, $payload, $signature] = $parts;

    $expectedSignature = base64_encode(hash_hmac('sha256', "$header.$payload", JWT_SECRET, true));
    if (!hash_equals($expectedSignature, $signature))
        return null;

    $data = json_decode(base64_decode($payload), true);
    if (!$data)
        return null;

    if (isset($data['exp']) && $data['exp'] < time())
        return null;

    return $data;
}

/**
 * Ambil data user yang sedang login dari header Authorization
 */
function getCurrentUser(): ?array
{
    $authHeader = '';
    if (function_exists('getallheaders')) {
        $headers = getallheaders();
        $authHeader = $headers['Authorization'] ?? $headers['authorization'] ?? '';
    }
    if (empty($authHeader)) {
        $authHeader = $_SERVER['HTTP_AUTHORIZATION'] ?? $_SERVER['REDIRECT_HTTP_AUTHORIZATION'] ?? '';
    }

    require_once __DIR__ . '/database.php';
    $db = getDB();

    if (preg_match('/Bearer\s+(.+)$/i', $authHeader, $matches)) {
        $token = $matches[1];
        $payload = verifyToken($token);
        if ($payload && !empty($payload['userId'] ?? $payload['id'] ?? '')) {
            $userIdRaw = $payload['userId'] ?? $payload['id'];
            $userId = $db->real_escape_string($userIdRaw);
            $result = $db->query("SELECT id, name, email, role, phone, gender, birth_date FROM users WHERE id = '$userId'");
            if ($result && $result->num_rows > 0) {
                return $result->fetch_assoc();
            }
        }
    }

    // Default Guest User for 100% Guest Shopping
    $guestResult = $db->query("SELECT id, name, email, role, phone, gender, birth_date FROM users WHERE id = 'USR-GUEST'");
    if ($guestResult && $guestResult->num_rows > 0) {
        return $guestResult->fetch_assoc();
    }

    return [
        'id' => 'USR-GUEST',
        'name' => 'Pembeli',
        'email' => 'pembeli@parfy.id',
        'role' => 'user'
    ];
}

/**
 * Validasi otentikasi user (selalu sukses dengan session pembeli/guest)
 */
function requireAuth(): array
{
    $user = getCurrentUser();
    return $user;
}

/**
 * Validasi otorisasi admin
 */
function requireAdmin(): array
{
    $user = requireAuth();
    if ($user['role'] !== 'admin') {
        jsonResponse(['error' => 'Akses ditolak. Hanya admin yang diperbolehkan.'], 403);
    }
    return $user;
}

