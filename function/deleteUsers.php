<?php 
require_once '../config/dbConfig.php';
/**
 * Supprime un utilisateur par son ID.
 *
 * @param int $id L'ID de l'utilisateur à supprimer.
 * @return bool True si la suppression a réussi, sinon false.
 */
function deleteUsers($id) {

    $db = new Database();
    $conn = $db->getConnection();

    // Préparer la requête de suppression
    
    $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
    $stmt->bind_param("i", $id);

    // Exécuter la requête
    if ($stmt->execute()) {
        return true; // Suppression réussie
    } else {
        return false; // Échec de la suppression
    }
}