<?php
/**
 * Récupère les produits les plus mouvementés
 *
 * @param PDO $pdo Connexion à la base de données
 * @param int $limit Nombre de produits à retourner (par défaut 10)
 * @param int $days Nombre de jours à considérer (par défaut 30)
 * @return array Liste des produits les plus mouvementés
 */
function getTopProducts($pdo, $limit = 10, $days = 30) {
    try {
        $sql = "SELECT
                    p.id,
                    p.name as product_name,
                    p.type,
                    COUNT(th.id) as transaction_count,
                    SUM(th.quantity) as total_quantity_moved
                FROM transaction_history th
                INNER JOIN products p ON th.product_id = p.id
                WHERE th.created_at >= DATE_SUB(CURDATE(), INTERVAL :days DAY)
                GROUP BY p.id, p.name, p.type
                ORDER BY transaction_count DESC
                LIMIT :limit";

        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':days', $days, PDO::PARAM_INT);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    } catch (PDOException $e) {
        error_log("Erreur getTopProducts: " . $e->getMessage());
        return [];
    }
}
?>
