<?php
/**
 * Récupère la liste des produits avec stock faible
 *
 * @param PDO $pdo Connexion à la base de données
 * @param int $threshold Seuil de stock faible (par défaut 10)
 * @param int $limit Nombre maximum de résultats (par défaut 10)
 * @return array Liste des produits avec stock faible
 */
function getLowStockProducts($pdo, $threshold = 10, $limit = 10) {
    try {
        $sql = "SELECT
                    p.id,
                    p.name as product_name,
                    p.type,
                    w.name as warehouse_name,
                    i.quantity
                FROM inventory i
                INNER JOIN products p ON i.product_id = p.id
                INNER JOIN warehouses w ON i.warehouse_id = w.id
                WHERE i.quantity > 0 AND i.quantity < :threshold
                ORDER BY i.quantity ASC
                LIMIT :limit";

        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':threshold', $threshold, PDO::PARAM_INT);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    } catch (PDOException $e) {
        error_log("Erreur getLowStockProducts: " . $e->getMessage());
        return [];
    }
}
?>
