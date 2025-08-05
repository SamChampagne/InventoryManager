<?php
require_once __DIR__ . '/../config/dbConfig.php';

/**
 * Récupère tous les utilisateurs.
 *
 * @return array Un tableau associatif contenant tous les utilisateurs.
 */
function getAllUsers() {
    

    $db = new Database();
    $conn = $db->getConnection();

    $stmt = $conn->prepare("SELECT * FROM users");
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC); 
    } else {
        return []; 
    }
}