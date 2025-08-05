<?php

require_once __DIR__ . '/../config/dbConfig.php';


/**
 * Ajoute une entrée dans l'historique des transactions.
 *
 * @param int $userId           ID de l'utilisateur effectuant la transaction.
 * @param int $productId        ID du produit concerné (doit être non vide).
 * @param int $warehouseFrom    ID de l'entrepôt source (peut être null ou 0).
 * @param int $warehouseTo      ID de l'entrepôt destination (peut être null ou 0).
 * @param string $operationType Type d'opération (ex: "ajout", "retrait", "transfert").
 * @param int $quantity         Quantité impliquée dans la transaction.
 *
 * @return bool                 Retourne true si l'insertion dans la base réussit, sinon false.
 *                             Retourne false également si $productId est vide.
 */
function addTransactionHistory($userId, $productId, $warehouseFrom, $warehouseTo, $operationType, $quantity) {

    if(empty($productId)){
        return false;
    }

    $db = new Database();
    $conn = $db->getConnection();

    $stmt = $conn->prepare("
        INSERT INTO transaction_history (
            user_id, product_id, warehouse_id_from, warehouse_id_to, operation_type, quantity, created_at
        ) VALUES (?, ?, ?, ?, ?, ?, NOW())
    ");

    // Types : i = int, s = string
    $stmt->bind_param(
        "iiiisi", 
        $userId, 
        $productId, 
        $warehouseFrom, 
        $warehouseTo, 
        $operationType, 
        $quantity
    );

    if ($stmt->execute()) {
        return true;
    } else {
        error_log("Erreur historique transaction: " . $stmt->error);
        return false;
    }
}
