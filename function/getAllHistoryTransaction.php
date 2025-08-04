<?php
require_once __DIR__ . '/../config/dbConfig.php';


/**
 * Récupère toutes les transactions de l'historique.
 *
 * @return array Un tableau associatif contenant toutes les transactions.
 */
function getAllHistoryTransaction() {
    

    $db = new Database();
    $conn = $db->getConnection();

    // Préparer la requête pour récupérer toutes les transactions
    $stmt = $conn->prepare("
    SELECT th.*, 
       p.name AS product_name,
       w1.name AS warehouse_from_name,
       w2.name AS warehouse_to_name,
       u.name AS user_name
            FROM transaction_history th
            LEFT JOIN products p ON th.product_id = p.id
            LEFT JOIN warehouses w1 ON th.warehouse_id_from = w1.id
            LEFT JOIN warehouses w2 ON th.warehouse_id_to = w2.id
            LEFT JOIN users u ON th.user_id = u.id
            ORDER BY th.created_at DESC
    ");
    
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC); // Retourne toutes les transactions sous forme de tableau associatif
    } else {
        return []; // Retourne un tableau vide en cas d'échec
    }
}   