<?php
require_once __DIR__ . '/../config/dbConfig.php';

/**
 * Récupère les transactions par jour pour les graphiques
 *
 * @param int $days Nombre de jours à afficher (par défaut 7)
 * @return array Tableau avec les dates et le nombre de transactions
 */
function getTransactionsByDay($days = 7) {
    $db = new Database();
    $conn = $db->getConnection();

    $sql = "SELECT
                DATE(created_at) as transaction_date,
                COUNT(*) as transaction_count,
                SUM(CASE WHEN operation_type = 'ajout' THEN 1 ELSE 0 END) as ajout_count,
                SUM(CASE WHEN operation_type = 'transfert' THEN 1 ELSE 0 END) as transfert_count,
                SUM(CASE WHEN operation_type = 'suppression' THEN 1 ELSE 0 END) as suppression_count,
                SUM(CASE WHEN operation_type = 'modification' THEN 1 ELSE 0 END) as modification_count
            FROM transaction_history
            WHERE created_at >= DATE_SUB(CURDATE(), INTERVAL ? DAY)
            GROUP BY DATE(created_at)
            ORDER BY transaction_date ASC";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $days);

    if ($stmt->execute()) {
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    return [];
}
?>
