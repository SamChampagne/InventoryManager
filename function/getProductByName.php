<?php
 require_once __DIR__ . '/../config/dbConfig.php'; 
/**
 * Recherche un produit dans la base par son nom exact.
 *
 * @param string $name Nom exact du produit à rechercher.
 * @return array|null Retourne un tableau associatif du produit si trouvé, sinon null.
 */
function getProductByName($name) {

    $db = new Database();
    $conn = $db->getConnection();

    $stmt = $conn->prepare("SELECT * FROM products WHERE name = ?");
    if (!$stmt) {
        return null;
    }

    $stmt->bind_param("i", $name);
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result && $row = $result->fetch_assoc()) {
        // Retourne le tableau associatif du produit
        return $row; 
    }

    return null;
}
