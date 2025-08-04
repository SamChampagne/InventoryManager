<?php
require_once __DIR__ . '/../config/dbConfig.php';


/**
 * Ajoute un produit à l'inventaire.
 *
 * @param int $productId L'ID du produit à ajouter.
 * @param int $warehouseId L'ID de l'entrepôt où le produit sera ajouté.
 * @param int $quantity La quantité du produit à ajouter.
 * @return bool Retourne true en cas de succès, false en cas d'échec.
 */
function addProductToInventory($productId, $warehouseId, $quantity) {

    if(empty($productId) || empty($warehouseId) || empty($quantity)) {
        return false; 
    }

    $db = new Database();
    $conn = $db->getConnection();

    // Prepare the SQL statement to insert the product into the inventory
    $stmt = $conn->prepare("INSERT INTO inventory (product_id, warehouse_id, quantity) VALUES (?, ?, ?)");
    $stmt->bind_param("iii", $productId, $warehouseId, $quantity);

    // Execute the statement and check for success
    if ($stmt->execute()) {
        return true; // Return true on success
    } else {
        return false; // Return false on failure
    }
}