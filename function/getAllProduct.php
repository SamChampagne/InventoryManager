<?php 
require_once '../config/dbConfig.php';
/**
 * Récupère tous les produits.
 *
 * @return array Un tableau associatif contenant tous les produits.
 */
function getAllProduct() {
    

    $db = new Database();
    $conn = $db->getConnection();

    $stmt = $conn->prepare("SELECT * FROM products");
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC); // Return all products as an associative array
    } else {
        return []; // Return an empty array on failure
    }
}