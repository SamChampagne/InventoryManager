<?php
require_once '../config/dbConfig.php';
/**
 * Supprime un produit par son ID.
 *
 * @param int $id L'ID du produit à supprimer.
 * @return bool True si la suppression a réussi, sinon false.
 */
function deleteProduct($id) {
    

    $db = new Database();
    $conn = $db->getConnection();

    // Préparer la requête de suppression
    $stmt = $conn->prepare("DELETE FROM products WHERE id = ?");
    $stmt->bind_param("i", $id);

    // Exécuter la requête
    if ($stmt->execute()) {
        return true; // Suppression réussie
    } else {
        return false; // Échec de la suppression
    }
}