<?php
require_once __DIR__ . '/../config/dbConfig.php';

/**
 * Récupère les produits les plus mouvementés
 *
 * @param int $limit Nombre de produits à retourner (par défaut 10)
 * @param int $days Nombre de jours à considérer (par défaut 30)
 * @return array Liste des produits les plus mouvementés
 */
function getTopProducts($limit = 10, $days = 30) {
    $db = new Database();
    $conn = $db->getConnection();

    $sql = "SELECT
                p.id,
                p.name as product_name,
                p.type,
                COUNT(th.id) as transaction_count,
                SUM(th.quantity) as total_quantity_moved
            FROM transaction_history th
            INNER JOIN products p ON th.product_id = p.id
            WHERE th.created_at >= DATE_SUB(CURDATE(), INTERVAL ? DAY)
            GROUP BY p.id, p.name, p.type
            ORDER BY transaction_count DESC
            LIMIT ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $days, $limit);

    if ($stmt->execute()) {
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    return [];
}
?>
