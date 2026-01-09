<?php
require_once __DIR__ . '/../config/dbConfig.php';

/**
 * Récupère la liste des produits avec stock faible
 *
 * @param int $threshold Seuil de stock faible (par défaut 10)
 * @param int $limit Nombre maximum de résultats (par défaut 10)
 * @return array Liste des produits avec stock faible
 */
function getLowStockProducts($threshold = 10, $limit = 10) {
    $db = new Database();
    $conn = $db->getConnection();

    $sql = "SELECT
                p.id,
                p.name as product_name,
                p.type,
                w.name as warehouse_name,
                i.quantity
            FROM inventory i
            INNER JOIN products p ON i.product_id = p.id
            INNER JOIN warehouses w ON i.warehouse_id = w.id
            WHERE i.quantity > 0 AND i.quantity < ?
            ORDER BY i.quantity ASC
            LIMIT ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $threshold, $limit);

    if ($stmt->execute()) {
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    return [];
}
?>
