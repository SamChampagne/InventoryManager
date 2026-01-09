<?php
/**
 * Récupère les statistiques générales pour le dashboard
 *
 * @param PDO $pdo Connexion à la base de données
 * @return array Tableau contenant les statistiques
 */
function getDashboardStats($pdo) {
    try {
        $stats = [];

        // Nombre total de produits
        $stmt = $pdo->query("SELECT COUNT(*) as total FROM products");
        $stats['total_products'] = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

        // Nombre total d'entrepôts
        $stmt = $pdo->query("SELECT COUNT(*) as total FROM warehouses");
        $stats['total_warehouses'] = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

        // Nombre total d'utilisateurs
        $stmt = $pdo->query("SELECT COUNT(*) as total FROM users");
        $stats['total_users'] = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

        // Quantité totale de stock (tous entrepôts confondus)
        $stmt = $pdo->query("SELECT COALESCE(SUM(quantity), 0) as total FROM inventory");
        $stats['total_stock'] = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

        // Nombre de produits avec stock faible (< 10 unités)
        $stmt = $pdo->query("SELECT COUNT(*) as total FROM inventory WHERE quantity > 0 AND quantity < 10");
        $stats['low_stock_count'] = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

        // Nombre de produits en rupture de stock
        $stmt = $pdo->query("SELECT COUNT(*) as total FROM inventory WHERE quantity = 0");
        $stats['out_of_stock_count'] = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

        // Nombre de transactions aujourd'hui
        $stmt = $pdo->query("SELECT COUNT(*) as total FROM transaction_history WHERE DATE(created_at) = CURDATE()");
        $stats['today_transactions'] = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

        // Nombre de transactions cette semaine
        $stmt = $pdo->query("SELECT COUNT(*) as total FROM transaction_history WHERE YEARWEEK(created_at, 1) = YEARWEEK(CURDATE(), 1)");
        $stats['week_transactions'] = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

        return $stats;

    } catch (PDOException $e) {
        error_log("Erreur getDashboardStats: " . $e->getMessage());
        return [
            'total_products' => 0,
            'total_warehouses' => 0,
            'total_users' => 0,
            'total_stock' => 0,
            'low_stock_count' => 0,
            'out_of_stock_count' => 0,
            'today_transactions' => 0,
            'week_transactions' => 0
        ];
    }
}
?>
