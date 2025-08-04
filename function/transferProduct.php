<?php 
require_once __DIR__ . '/../config/dbConfig.php';


function transferProduct($product_id, $target_warehouse_id, $quantity, $current_warehouse_id) {
    $db = new Database();
    $conn = $db->getConnection();

    // Début d'une transaction pour garantir l'intégrité
    $conn->begin_transaction();

    try {
        // 1. Retirer la quantité de l'entrepôt d'origine
        $stmt = $conn->prepare("UPDATE inventory SET quantity = quantity - ? WHERE warehouse_id = ? AND product_id = ?");
        $stmt->bind_param("iii", $quantity, $current_warehouse_id, $product_id);
        $stmt->execute();

        // 2. Supprimer l’entrée si quantité devient 0
        $stmt = $conn->prepare("DELETE FROM inventory WHERE warehouse_id = ? AND product_id = ? AND quantity <= 0");
        $stmt->bind_param("ii", $current_warehouse_id, $product_id);
        $stmt->execute();

        // 3. Vérifier si le produit existe déjà dans le warehouse de destination
        $stmt = $conn->prepare("SELECT quantity FROM inventory WHERE warehouse_id = ? AND product_id = ?");
        $stmt->bind_param("ii", $target_warehouse_id, $product_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // 4a. S’il existe, faire un UPDATE
            $stmt = $conn->prepare("UPDATE inventory SET quantity = quantity + ? WHERE warehouse_id = ? AND product_id = ?");
            $stmt->bind_param("iii", $quantity, $target_warehouse_id, $product_id);
            $stmt->execute();
        } else {
            // 4b. Sinon, faire un INSERT
            $stmt = $conn->prepare("INSERT INTO inventory (warehouse_id, product_id, quantity) VALUES (?, ?, ?)");
            $stmt->bind_param("iii", $target_warehouse_id, $product_id, $quantity);
            $stmt->execute();
        }

        // Tout s'est bien passé
        $conn->commit();
        return true;

    } catch (Exception $e) {
        $conn->rollback(); // Annuler la transaction en cas d'erreur
        return false; // Échec du transfert
    }
}
