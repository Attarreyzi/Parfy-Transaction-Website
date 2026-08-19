<?php
/**
 * GET /api/dashboard/index.php
 * Dashboard statistics (admin only)
 */

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../config/jwt.php';

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    jsonResponse(['error' => 'Method not allowed'], 405);
}

$user = requireAdmin();
$db = getDB();

// Total users
$usersResult = $db->query("SELECT COUNT(*) as count FROM users WHERE role = 'user'");
$totalUsers = $usersResult->fetch_assoc()['count'];

// Total products
$productsResult = $db->query("SELECT COUNT(*) as count FROM products");
$totalProducts = $productsResult->fetch_assoc()['count'];

// Total transactions
$transactionsResult = $db->query("SELECT COUNT(*) as count FROM transactions");
$totalTransactions = $transactionsResult->fetch_assoc()['count'];

// Total revenue (completed orders)
$revenueResult = $db->query("SELECT COALESCE(SUM(total), 0) as total FROM transactions WHERE status NOT IN ('cancelled')");
$totalRevenue = (int) $revenueResult->fetch_assoc()['total'];

// Pending orders
$pendingResult = $db->query("SELECT COUNT(*) as count FROM transactions WHERE status = 'pending'");
$pendingOrders = $pendingResult->fetch_assoc()['count'];

// Out of stock & Low stock products
$outOfStockResult = $db->query("SELECT COUNT(*) as count FROM products WHERE stock = 0");
$outOfStock = (int) $outOfStockResult->fetch_assoc()['count'];

$lowStockResult = $db->query("SELECT COUNT(*) as count FROM products WHERE stock > 0 AND stock < 10");
$lowStock = (int) $lowStockResult->fetch_assoc()['count'];

// Recent transactions (last 5)
$recentResult = $db->query("SELECT id, user_name, total, status, created_at FROM transactions ORDER BY created_at DESC LIMIT 5");
$recentTransactions = [];
if ($recentResult) {
    while ($row = $recentResult->fetch_assoc()) {
        $recentTransactions[] = [
            'id' => $row['id'],
            'userName' => $row['user_name'],
            'total' => (int) $row['total'],
            'status' => $row['status'],
            'date' => $row['created_at']
        ];
    }
}

// Top selling products
$topProductsResult = $db->query("SELECT id, name, sold FROM products ORDER BY sold DESC LIMIT 5");
$topProducts = [];
if ($topProductsResult) {
    while ($row = $topProductsResult->fetch_assoc()) {
        $topProducts[] = [
            'id' => $row['id'],
            'name' => $row['name'],
            'sold' => (int) $row['sold']
        ];
    }
}

// Recent reviews
$reviewsResult = $db->query("SELECT r.*, u.name as user_name FROM reviews r JOIN users u ON r.user_id = u.id ORDER BY r.created_at DESC LIMIT 5");
$recentReviews = [];
if ($reviewsResult) {
    while ($row = $reviewsResult->fetch_assoc()) {
        $recentReviews[] = [
            'id' => (int) $row['id'],
            'userName' => $row['user_name'],
            'rating' => (int) $row['rating'],
            'comment' => $row['comment']
        ];
    }
}

jsonResponse([
    'totalUsers' => (int) $totalUsers,
    'totalProducts' => (int) $totalProducts,
    'totalTransactions' => (int) $totalTransactions,
    'totalRevenue' => $totalRevenue,
    'pendingOrders' => (int) $pendingOrders,
    'lowStock' => (int) $lowStock,
    'outOfStock' => (int) $outOfStock,
    'recentTransactions' => $recentTransactions,
    'topProducts' => $topProducts,
    'recentReviews' => $recentReviews
]);
