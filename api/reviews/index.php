<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../config/jwt.php';

$db = getDB();

// GET - List reviews
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $productId = $_GET['productId'] ?? '';

    $sql = "SELECT r.*, u.name as user_name, p.name as product_name 
            FROM reviews r 
            JOIN users u ON r.user_id = u.id 
            JOIN products p ON r.product_id = p.id";

    if (!empty($productId)) {
        $productIdEsc = $db->real_escape_string($productId);
        $sql .= " WHERE r.product_id = '$productIdEsc'";
    }

    $sql .= " ORDER BY r.created_at DESC";

    $result = $db->query($sql);
    $reviews = [];

    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $reviews[] = [
                'id' => (int) $row['id'],
                'userId' => $row['user_id'],
                'userName' => $row['user_name'],
                'productId' => $row['product_id'],
                'productName' => $row['product_name'],
                'rating' => (int) $row['rating'],
                'comment' => $row['comment'],
                'createdAt' => $row['created_at']
            ];
        }
    }

    jsonResponse($reviews);
}

// Proses data
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = requireAuth();

    $data = getJsonBody();

    $productId = $data['productId'] ?? $data['product_id'] ?? '';
    $rating = (int) ($data['rating'] ?? 0);
    $comment = $data['comment'] ?? '';

    if (empty($productId)) {
        jsonResponse(['error' => 'Product ID wajib diisi.'], 400);
    }

    if ($rating < 1 || $rating > 5) {
        jsonResponse(['error' => 'Rating harus antara 1-5.'], 400);
    }

    $productIdEsc = $db->real_escape_string($productId);
    $userId = $db->real_escape_string($user['id']);
    $commentEsc = $db->real_escape_string($comment);

    // Check product exists
    $productCheck = $db->query("SELECT id FROM products WHERE id = '$productIdEsc'");
    if (!$productCheck || $productCheck->num_rows === 0) {
        jsonResponse(['error' => 'Produk tidak ditemukan.'], 404);
    }

    $sql = "INSERT INTO reviews (user_id, product_id, rating, comment, created_at) 
            VALUES ('$userId', '$productIdEsc', $rating, '$commentEsc', NOW())";

    if (!$db->query($sql)) {
        jsonResponse(['error' => 'Gagal menambah review: ' . $db->error], 500);
    }

    jsonResponse([
        'message' => 'Review berhasil ditambahkan!',
        'reviewId' => $db->insert_id
    ], 201);
}

// Hapus data
if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    $user = requireAuth();

    $id = $_GET['id'] ?? '';
    if (empty($id)) {
        $data = getJsonBody();
        $id = $data['id'] ?? '';
    }

    if (empty($id)) {
        jsonResponse(['error' => 'Review ID wajib diisi.'], 400);
    }

    $idEsc = (int) $id;
    $userId = $db->real_escape_string($user['id']);

    // Admin can delete any review, regular user can only delete their own review
    $where = ($user['role'] ?? '') === 'admin' ? "id = $idEsc" : "id = $idEsc AND user_id = '$userId'";
    $sql = "DELETE FROM reviews WHERE $where";

    if ($db->query($sql)) {
        if ($db->affected_rows > 0) {
            jsonResponse(['message' => 'Review berhasil dihapus.']);
        } else {
            jsonResponse(['error' => 'Review tidak ditemukan atau Anda tidak memiliki izin.'], 404);
        }
    } else {
        jsonResponse(['error' => 'Gagal menghapus review: ' . $db->error], 500);
    }
}

jsonResponse(['error' => 'Method not allowed'], 405);

