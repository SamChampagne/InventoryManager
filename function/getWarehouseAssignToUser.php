<?php

require_once __DIR__ . '/../config/dbConfig.php';

/**
 * Récupère les entrepôts (avec nom) assignés à un utilisateur spécifique.
 *
 * @param int $user_id L'ID de l'utilisateur.
 * @return array Un tableau associatif des entrepôts assignés à l'utilisateur.
 */
function getWarehouseAssignToUser($user_id) {
    $db = new Database();
    $conn = $db->getConnection();

    $sql = "
        SELECT w.id AS warehouse_id, w.name AS warehouse_name, w.location
        FROM employees e
        INNER JOIN warehouses w ON e.warehouse_id = w.id
        WHERE e.user_id = ?
    ";

    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        return [];
    }

    $stmt->bind_param("i", $user_id);
    
    // Retourne le tableau associatif des entrepôts associés
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    } else {
        return [];
    }
}
