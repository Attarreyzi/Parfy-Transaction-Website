<?php
/**
 * JWT Helper for PARFY.ID
 * Simple JWT implementation for PHP 8.2
 */

// Production: set JWT_SECRET in Azure App Service > Configuration
define('JWT_SECRET', getenv('JWT_SECRET') ?: 'parfy_secret_key_2024_very_secure');
define('JWT_EXPIRY', 60 * 60 * 24 * 7); // 7 days


/**
 * Create JWT token
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
 * Verify and decode JWT token
 */
function verifyToken(string $token): ?array
{
    $parts = explode('.', $token);
    if (count($parts) !== 3)
        return null;

    [$header, $payload, $signature] = $parts;

    // Verify signature
    $expectedSignature = base64_encode(hash_hmac('sha256', "$header.$payload", JWT_SECRET, true));
    if (!hash_equals($expectedSignature, $signature))
        return null;

    // Decode payload
    $data = json_decode(base64_decode($payload), true);
    if (!$data)
        return null;

    // Check expiry
    if (isset($data['exp']) && $data['exp'] < time())
        return null;

    return $data;
}

/**
 * Get current user from Authorization header
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

    if (!preg_match('/Bearer\s+(.+)$/i', $authHeader, $matches)) {
        return null;
    }

    $token = $matches[1];
    $payload = verifyToken($token);

    $userIdRaw = $payload['userId'] ?? $payload['id'] ?? '';
    if (!$payload || empty($userIdRaw))
        return null;

    // Get user from database
    require_once __DIR__ . '/database.php';
    $db = getDB();
    $userId = $db->real_escape_string($userIdRaw);

    $result = $db->query("SELECT id, name, email, role, phone, gender, birth_date FROM users WHERE id = '$userId'");

    if ($result && $result->num_rows > 0) {
        return $result->fetch_assoc();
    }

    return null;
}

/**
 * Require authentication middleware
 */
function requireAuth(): array
{
    $user = getCurrentUser();
    if (!$user) {
        jsonResponse(['error' => 'Unauthorized. Token tidak valid atau sudah expired.'], 401);
    }
    return $user;
}

/**
 * Require admin role
 */
function requireAdmin(): array
{
    $user = requireAuth();
    if ($user['role'] !== 'admin') {
        jsonResponse(['error' => 'Forbidden. Hanya admin yang bisa mengakses.'], 403);
    }
    return $user;
}
