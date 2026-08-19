<?php
/**
 * POST /api/auth/logout.php
 * Logout (client-side token removal)
 */

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

require_once __DIR__ . '/../../config/database.php';

jsonResponse(['message' => 'Logout berhasil. Silakan hapus token di client.']);
