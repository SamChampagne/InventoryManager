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
 * @return array Tableau contenant toutes les données du dashboard
 */
function getDashboardData() {
    return [
        'stats' => getDashboardStats(),
        'low_stock' => getLowStockProducts(10, 10),
        'top_products' => getTopProducts(10, 30),
        'stock_by_warehouse' => getStockByWarehouse(),
        'transactions_by_day' => getTransactionsByDay(7)
    ];
}
?>
