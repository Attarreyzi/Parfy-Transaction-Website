<?php
/**
 * Database Configuration for PARFY.ID
 * Uses environment variables for production, with fallbacks for local dev
 */

// Production: set these in Azure App Service > Configuration
// Local dev: uses default XAMPP values
define('DB_HOST', getenv('DB_HOST') ?: 'localhost');
define('DB_USER', getenv('DB_USER') ?: 'root');
define('DB_PASS', getenv('DB_PASS') ?: '');
define('DB_NAME', getenv('DB_NAME') ?: 'parfy_db');


/**
 * Get database connection
 * @return mysqli
 */
function getDB(): mysqli
{
    static $conn = null;

    if ($conn === null) {
        $conn = mysqli_init();

        // Azure requires SSL, setup SSL if on Azure (detected by env var)
        if (getenv('DB_HOST')) {
            $conn->options(MYSQLI_OPT_CONNECT_TIMEOUT, 30);
            $conn->ssl_set(NULL, NULL, NULL, NULL, NULL);
        }

        // Use real_connect for better control (and SSL support)
        // Azure: port 3306, use SSL flag
        $sslFlag = getenv('DB_HOST') ? MYSQLI_CLIENT_SSL : 0;
        if (!@$conn->real_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME, 3306, null, $sslFlag)) {
            http_response_code(500);
            // Log error for admin, show generic for user
            error_log('DB Connection Error: ' . $conn->connect_error);
            die(json_encode(['error' => 'Database connection failed. Check server logs.']));
        }

        $conn->set_charset('utf8mb4');
    }

    return $conn;
}

/**
 * JSON Response helper
 */
function jsonResponse($data, int $statusCode = 200): void
{
    http_response_code($statusCode);
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($data, JSON_UNESCAPED_UNICODE);
    exit;
}

/**
 * Get JSON body from request
 */
function getJsonBody(): array
{
    $json = file_get_contents('php://input');
    return json_decode($json, true) ?? [];
}

/**
 * Generate unique ID
 */
function generateId(string $prefix = 'user'): string
{
    return $prefix . '-' . substr(bin2hex(random_bytes(4)), 0, 8);
}
