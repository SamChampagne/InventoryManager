<?php
 require_once __DIR__ . '/../config/dbConfig.php'; // Chargement de la classe Database

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
        return $row; 
    }

    return null; // Aucun produit trouvé
}
