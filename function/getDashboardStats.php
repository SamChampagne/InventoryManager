<?php
require_once __DIR__ . '/../config/dbConfig.php';

/**
 * Récupère les statistiques générales pour le dashboard
 *
 * @return array Tableau contenant les statistiques
 */
function getDashboardStats() {
    $db = new Database();
    $conn = $db->getConnection();

    $stats = [
        'total_products' => 0,
        'total_warehouses' => 0,
        'total_users' => 0,
        'total_stock' => 0,
        'low_stock_count' => 0,
        'out_of_stock_count' => 0,
        'today_transactions' => 0,
        'week_transactions' => 0
    ];

    // Nombre total de produits
    $result = $conn->query("SELECT COUNT(*) as total FROM products");
    if ($result) {
        $row = $result->fetch_assoc();
        $stats['total_products'] = $row['total'];
    }

    // Nombre total d'entrepôts
    $result = $conn->query("SELECT COUNT(*) as total FROM warehouses");
    if ($result) {
        $row = $result->fetch_assoc();
        $stats['total_warehouses'] = $row['total'];
    }

    // Nombre total d'utilisateurs
    $result = $conn->query("SELECT COUNT(*) as total FROM users");
    if ($result) {
        $row = $result->fetch_assoc();
        $stats['total_users'] = $row['total'];
    }

    // Quantité totale de stock (tous entrepôts confondus)
    $result = $conn->query("SELECT COALESCE(SUM(quantity), 0) as total FROM inventory");
    if ($result) {
        $row = $result->fetch_assoc();
        $stats['total_stock'] = $row['total'];
    }

    // Nombre de produits avec stock faible (< 10 unités)
    $result = $conn->query("SELECT COUNT(*) as total FROM inventory WHERE quantity > 0 AND quantity < 10");
    if ($result) {
        $row = $result->fetch_assoc();
        $stats['low_stock_count'] = $row['total'];
    }

    // Nombre de produits en rupture de stock
    $result = $conn->query("SELECT COUNT(*) as total FROM inventory WHERE quantity = 0");
    if ($result) {
        $row = $result->fetch_assoc();
        $stats['out_of_stock_count'] = $row['total'];
    }

    // Nombre de transactions aujourd'hui
    $result = $conn->query("SELECT COUNT(*) as total FROM transaction_history WHERE DATE(created_at) = CURDATE()");
    if ($result) {
        $row = $result->fetch_assoc();
        $stats['today_transactions'] = $row['total'];
    }

    // Nombre de transactions cette semaine
    $result = $conn->query("SELECT COUNT(*) as total FROM transaction_history WHERE YEARWEEK(created_at, 1) = YEARWEEK(CURDATE(), 1)");
    if ($result) {
        $row = $result->fetch_assoc();
        $stats['week_transactions'] = $row['total'];
    }

    return $stats;
}
?>
