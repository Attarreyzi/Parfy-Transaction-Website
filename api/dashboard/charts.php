<?php
/**
 * GET /api/dashboard/charts.php
 * Dashboard chart data (admin only)
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

// 1. Monthly Sales Data (Last 6 Months)
// We generate the last 6 months in PHP to ensure we have zeros for months with no sales
$monthlySales = [];
for ($i = 5; $i >= 0; $i--) {
    $monthName = date('M Y', strtotime("-$i months"));
    $monthlySales[$monthName] = [
        'month' => $monthName,
        'revenue' => 0,
        'orders' => 0
    ];
}

// Query transactions from the last 6 months
$sixMonthsAgo = date('Y-m-01', strtotime('-5 months'));
$sqlSales = "SELECT 
                DATE_FORMAT(created_at, '%b %Y') as month_name, 
                SUM(total) as total_revenue, 
                COUNT(id) as total_orders 
             FROM transactions 
             WHERE status != 'batal' AND created_at >= '$sixMonthsAgo'
             GROUP BY DATE_FORMAT(created_at, '%b %Y'), DATE_FORMAT(created_at, '%Y-%m')
             ORDER BY DATE_FORMAT(created_at, '%Y-%m') ASC";

$resultSales = $db->query($sqlSales);
if ($resultSales) {
    while ($row = $resultSales->fetch_assoc()) {
        $mName = $row['month_name'];
        if (isset($monthlySales[$mName])) {
            $monthlySales[$mName]['revenue'] = (int) $row['total_revenue'];
            $monthlySales[$mName]['orders'] = (int) $row['total_orders'];
        }
    }
}

// 2. Category Performance (Products sold per category)
$sqlCategory = "SELECT category, COALESCE(SUM(sold), 0) as total_sold FROM products GROUP BY category";
$resultCategory = $db->query($sqlCategory);
$categorySales = [];
if ($resultCategory) {
    while ($row = $resultCategory->fetch_assoc()) {
        $categorySales[] = [
            'category' => $row['category'] ? $row['category'] : 'Uncategorized',
            'sold' => (int) $row['total_sold']
        ];
    }
}

// 3. Status Orders Breakdown
$sqlStatus = "SELECT status, COUNT(id) as count FROM transactions GROUP BY status";
$resultStatus = $db->query($sqlStatus);
$orderStatus = [];
if ($resultStatus) {
    while ($row = $resultStatus->fetch_assoc()) {
        $orderStatus[] = [
            'status' => $row['status'],
            'count' => (int) $row['count']
        ];
    }
}

jsonResponse([
    'monthlySales' => array_values($monthlySales),
    'categorySales' => $categorySales,
    'orderStatus' => $orderStatus
]);
