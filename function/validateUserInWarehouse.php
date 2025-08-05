<?php 
require_once __DIR__ . '/../config/dbConfig.php';

/**
 * Vérifie si un utilisateur est bien assigné à un entrepôt donné.
 *
 * @param int $userId      ID de l'utilisateur à vérifier.
 * @param int $warehouseId ID de l'entrepôt à vérifier.
 * @return bool            true si l'utilisateur est assigné à l'entrepôt, false sinon ou en cas d'erreur.
 */
function validateUserInWarehouse($userId, $warehouseId) {
    $db = new Database();
    $conn = $db->getConnection();

    
    $stmt = $conn->prepare("SELECT * FROM employees WHERE user_id = ? AND warehouse_id = ?");
    $stmt->bind_param("ii", $userId, $warehouseId);
    
    if (!$stmt->execute()) {
        return false;
    } 
    
    $result = $stmt->get_result();
    return $result->num_rows > 0; 
}