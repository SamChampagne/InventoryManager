<?php 

require_once __DIR__ . '/../config/dbConfig.php';

/**
 * Récupère tous les entrepôts.
 *
 * @return array Un tableau associatif contenant tous les entrepôts.
 */
function getAllWarehouses() {
    
    $db = new Database();
    $conn = $db->getConnection();

    $stmt = $conn->prepare("SELECT * FROM warehouses");
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC); 
    } else {
        return []; 
    }
}