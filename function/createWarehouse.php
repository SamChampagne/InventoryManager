<?php 

require_once '../config/dbConfig.php';

/**
* Crée un nouvel entrepôt.
*
* @param string $name Le nom de l'entrepôt.
* @param string $location L'emplacement de l'entrepôt.
* @return bool True si l'entrepôt a été créé avec succès, sinon false.
*/

function createWarehouse($name, $location) {
    $db = new Database();
    $conn = $db->getConnection();

    // 1. Créer l'entrepôt
    $stmt = $conn->prepare("INSERT INTO warehouses (name, location) VALUES (?, ?)");
    $stmt->bind_param("ss", $name, $location);

    if ($stmt->execute()) {
        $warehouseId = $conn->insert_id;

        // 2. Créer l'inventaire associé
        $stmt2 = $conn->prepare("INSERT INTO inventory (warehouse_id) VALUES (?)");
        $stmt2->bind_param("i", $warehouseId);

        if ($stmt2->execute()) {
            return $warehouseId; // succès
        } else {
            // rollback si inventaire échoue (optionnel si pas de transaction)
            return false;
        }
    } else {
        return false;
    }
}
