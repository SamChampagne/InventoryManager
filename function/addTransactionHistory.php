<?php

require_once __DIR__ . '/../config/dbConfig.php';


/**
 * Ajoute une entrée dans l'historique des transactions.
 *
 * Résumé :
 * Ce fichier définit la fonction addTransactionHistory qui ajoute une entrée dans la table
 * transaction_history de la base de données. Elle prend en paramètres l’ID de l’utilisateur,
 * l’ID du produit, les IDs des entrepôts source et destination, le type d’opération et la quantité.
 * La fonction prépare et exécute une requête SQL d’insertion avec ces valeurs, en ajoutant la date
 * et l’heure courantes (NOW()). En cas de succès, elle retourne true, sinon elle logue l’erreur
 * et retourne false.
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
