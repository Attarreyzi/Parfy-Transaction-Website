<?php
/**
 * Konfigurasi Basis Data PARFY.ID
 */

define('DB_HOST', getenv('DB_HOST') ?: '127.0.0.1');
define('DB_USER', getenv('DB_USER') ?: 'root');
define('DB_PASS', getenv('DB_PASS') ?: '');
define('DB_NAME', getenv('DB_NAME') ?: 'parfy_db');

/**
 * Koneksi ke basis data
 */
function getDB(): mysqli
{
    static $conn = null;

    if ($conn === null || !@$conn->ping()) {
        $conn = mysqli_init();

        $sslFlag = getenv('DB_HOST') ? MYSQLI_CLIENT_SSL : 0;
        if (getenv('DB_HOST')) {
            $conn->options(MYSQLI_OPT_CONNECT_TIMEOUT, 30);
            $conn->ssl_set(NULL, NULL, NULL, NULL, NULL);
        }

        if (!@$conn->real_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME, 3306, null, $sslFlag)) {
            http_response_code(500);
            error_log('DB Connection Error: ' . $conn->connect_error);
            die(json_encode(['error' => 'Koneksi basis data gagal.']));
        }

        $conn->set_charset('utf8mb4');
    }

    return $conn;
}

/**
 * Response JSON
 */
function jsonResponse($data, int $statusCode = 200): void
{
    http_response_code($statusCode);
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($data, JSON_UNESCAPED_UNICODE);
    exit;
}

/**
 * Ambil body JSON dari request
 */
function getJsonBody(): array
{
    $json = file_get_contents('php://input');
    return json_decode($json, true) ?? [];
}

/**
 * Generate ID unik
 */
function generateId(string $prefix = 'user'): string
{
    return $prefix . '-' . substr(bin2hex(random_bytes(4)), 0, 8);
}

/**
 * Base URL helper untuk path relatif
 */
function url(string $path = ''): string
{
    $scriptName = $_SERVER['SCRIPT_NAME'] ?? '';
    $base = preg_replace('#/(pages|api|forgot_password|admin)/.*$|/index\.php$#i', '', $scriptName);
    $base = rtrim($base, '/');
    $path = '/' . ltrim($path, '/');
    return $base . $path;
}

/**
 * Fix Image URL Helper
 */
function fixImageUrl(?string $url): string
{
    if (empty($url)) {
        return url('/assets/default.jpg');
    }
    if (str_starts_with($url, 'http://') || str_starts_with($url, 'https://') || str_starts_with($url, 'data:')) {
        return $url;
    }
    return url($url);
}


