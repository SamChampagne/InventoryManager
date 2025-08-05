<?php
require_once __DIR__ . '/../config/dbConfig.php';

/**
 * Récupère un utilisateur par son ID.
 *
 * @param int $id L'ID de l'utilisateur.
 * @return array|null Tableau associatif des données utilisateur ou null si non trouvé.
 */
function getUserById($id) {
    $db = new Database();
    $conn = $db->getConnection();

    $stmt = $conn->prepare("SELECT * FROM users WHERE id = ? LIMIT 1");
    
    if (!$stmt) {
        return null;
    }

    $stmt->bind_param("i", $id);
    $stmt->execute();

    $result = $stmt->get_result();

    // Retourne le tableau associatif de l'utilisateur
    if ($result && $result->num_rows > 0) {
        return $result->fetch_assoc();
    }

    return null;
}
?>