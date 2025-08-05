<?php
require_once __DIR__ . '/../config/dbConfig.php';

/**
 * Récupère les informations d'un entrepôt donné par son ID.
 *
 * @param int $warehouse_id ID de l'entrepôt à récupérer.
 * @return array|null Retourne un tableau associatif des données de l'entrepôt si trouvé, sinon null.
 */
function getWarehouseById($warehouse_id) {


    $db = new Database();
    $conn = $db->getConnection();

    $stmt = $conn->prepare("SELECT * FROM warehouses WHERE id = ?");
    if (!$stmt) {
        return null; 
    }

    $stmt->bind_param("i", $warehouse_id);

    // Retourne le tableau associatif de l'entrepôt
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        return $result->fetch_assoc(); 
    } else {
        return null; 
    }
}