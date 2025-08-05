<?php 
require_once __DIR__ . '/../config/dbConfig.php';
require_once __DIR__ . '/../function/getWarehouseById.php';

/**
 * Supprime un entrepôt par son ID.
 *
 * @param int $id L'ID de l'entrepôt à supprimer.
 * @return bool True si la suppression a réussi, sinon false.
 */
function deleteWarehouses($id) {
    
    $warehouse = getWarehouseById($id);
    if (!$warehouse) {
        return false; 
    }
    $db = new Database();
    $conn = $db->getConnection();

    // Préparer la requête de suppression
    $stmt = $conn->prepare("DELETE FROM warehouses WHERE id = ?");
    $stmt->bind_param("i", $id);

    // Exécuter la requête
    if ($stmt->execute()) {
        return true; 
    } else {
        return false; 
    }
}
