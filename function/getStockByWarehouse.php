<?php
/**
 * Récupère le stock total par entrepôt
 *
 * @param PDO $pdo Connexion à la base de données
 * @return array Liste des entrepôts avec leur stock total
 */
function getStockByWarehouse($pdo) {
    try {
        $sql = "SELECT
                    w.id,
                    w.name as warehouse_name,
                    w.location,
                    COALESCE(SUM(i.quantity), 0) as total_quantity,
                    COUNT(DISTINCT i.product_id) as product_count
                FROM warehouses w
                LEFT JOIN inventory i ON w.id = i.warehouse_id
                GROUP BY w.id, w.name, w.location
                ORDER BY total_quantity DESC";

        $stmt = $pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    } catch (PDOException $e) {
        error_log("Erreur getStockByWarehouse: " . $e->getMessage());
        return [];
    }
}
?>
