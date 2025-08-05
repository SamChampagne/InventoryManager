<?php
require_once __DIR__ . '/../config/dbConfig.php'; 
function getProductById($id) {
    

    $db = new Database();
    $conn = $db->getConnection();

    $stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
    if (!$stmt) {
        return null; 
    }

    $stmt->bind_param("i", $id);
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result && $row = $result->fetch_assoc()) {
        // Retourne le tableau associatif du produit
        return $row; 
    }
    
    return null; 
}
