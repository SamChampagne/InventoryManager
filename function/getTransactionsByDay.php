<?php
/**
 * Récupère les transactions par jour pour les graphiques
 *
 * @param PDO $pdo Connexion à la base de données
 * @param int $days Nombre de jours à afficher (par défaut 7)
 * @return array Tableau avec les dates et le nombre de transactions
 */
function getTransactionsByDay($pdo, $days = 7) {
    try {
        $sql = "SELECT
                    DATE(created_at) as transaction_date,
                    COUNT(*) as transaction_count,
                    SUM(CASE WHEN operation_type = 'ajout' THEN 1 ELSE 0 END) as ajout_count,
                    SUM(CASE WHEN operation_type = 'transfert' THEN 1 ELSE 0 END) as transfert_count,
                    SUM(CASE WHEN operation_type = 'suppression' THEN 1 ELSE 0 END) as suppression_count,
                    SUM(CASE WHEN operation_type = 'modification' THEN 1 ELSE 0 END) as modification_count
                FROM transaction_history
                WHERE created_at >= DATE_SUB(CURDATE(), INTERVAL :days DAY)
                GROUP BY DATE(created_at)
                ORDER BY transaction_date ASC";

        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':days', $days, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    } catch (PDOException $e) {
        error_log("Erreur getTransactionsByDay: " . $e->getMessage());
        return [];
    }
}
?>
