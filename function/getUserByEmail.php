<?php
require_once __DIR__ . '/../config/dbConfig.php';

/**
 * Récupère un utilisateur par son email.
 *
 * @param string $email L'email de l'utilisateur à rechercher.
 * @return array|null Les données de l'utilisateur ou null si non trouvé.
 */
function getUserByEmail($email) {

    $db = new Database();
    $conn = $db->getConnection();

    $stmt = $conn->prepare("SELECT id, name, email, password, role, created_at FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    // Retourne le tableau associatif de l'utilisateur
    if ($result->num_rows > 0) {
        return $result->fetch_assoc();
    } 
    return null;
}
