<?php 

require_once __DIR__ . '/../config/dbConfig.php';

/**
 * Crée un nouveau produit.
 *
 * @param string $productName Le nom du produit.
 * @param string $productDescription La description du produit.
 * @param string $productType Le type de produit.
 * @return bool True si le produit a été créé avec succès, sinon false.
 */
function createProduct($productName, $productDescription, $productType) {
    if (empty($productName) || empty($productType)) {
        return false;
    }
    $db = new Database();
    $conn = $db->getConnection();

    $stmt = $conn->prepare("INSERT INTO products (name, type, description) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $productName, $productType, $productDescription);

    if ($stmt->execute()) {
        return true; 
    } else {
        return false; 
    }
}