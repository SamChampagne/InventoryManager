<?php
require_once __DIR__ . '/../config/dbConfig.php';

/**
 * Récupère le stock total par entrepôt
 *
 * @return array Liste des entrepôts avec leur stock total
 */
function getStockByWarehouse() {
    $db = new Database();
    $conn = $db->getConnection();

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

    $result = $conn->query($sql);

    if ($result) {
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    return [];
}
?>
