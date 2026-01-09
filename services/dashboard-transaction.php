<?php
/**
 * Service pour récupérer toutes les données du dashboard
 */

require_once __DIR__ . '/../function/getDashboardStats.php';
require_once __DIR__ . '/../function/getLowStockProducts.php';
require_once __DIR__ . '/../function/getTopProducts.php';
require_once __DIR__ . '/../function/getStockByWarehouse.php';
require_once __DIR__ . '/../function/getTransactionsByDay.php';

/**
 * Récupère toutes les données nécessaires pour le dashboard
 *
 * @param PDO $pdo Connexion à la base de données
 * @return array Tableau contenant toutes les données du dashboard
 */
function getDashboardData($pdo) {
    return [
        'stats' => getDashboardStats($pdo),
        'low_stock' => getLowStockProducts($pdo, 10, 10),
        'top_products' => getTopProducts($pdo, 10, 30),
        'stock_by_warehouse' => getStockByWarehouse($pdo),
        'transactions_by_day' => getTransactionsByDay($pdo, 7)
    ];
}
?>
