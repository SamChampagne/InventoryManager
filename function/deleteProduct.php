<?php
require_once __DIR__ . '/../config/dbConfig.php';
require_once __DIR__ . '/../function/getProductById.php';
/**
 * Supprime un produit par son ID.
 *
 * @param int $id L'ID du produit à supprimer.
 * @return bool True si la suppression a réussi, sinon false.
 */
function deleteProduct($id) {
    
    $product = getProductById($id);
    if (!$product) {
        return false; // Le produit n'existe pas
    }

    $db = new Database();
    $conn = $db->getConnection();

    // Préparer la requête de suppression
    $stmt = $conn->prepare("DELETE FROM products WHERE id = ?");
    $stmt->bind_param("i", $id);

    // Exécuter la requête
    if ($stmt->execute()) {
        return true; 
    } else {
        return false; 
    }
}