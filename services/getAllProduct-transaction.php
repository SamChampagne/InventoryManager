<?php

require_once __DIR__ . '/../function/getAllProduct.php';
require_once __DIR__ . '/../function/deleteProduct.php';

$delete_product_alert = false;
$db = new Database();
$conn = $db->getConnection();

$editingProduct = null;

// Étape 1 : Chargement des données à modifier
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['step-p']) && $_POST['step-p'] == 1) {
    $id = $_POST['id'];

    $stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $editingProduct = $result->fetch_assoc();
}

// Étape 2 : Mise à jour des données du produit
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['step-p']) && $_POST['step-p'] == 2) {
    $id = $_POST['id'];
    $name = trim($_POST['name']);
    $description = trim($_POST['description']);
    $type = $_POST['type'];
    
    $stmt = $conn->prepare("UPDATE products SET name = ?, description = ?, type = ? WHERE id = ?");
    $stmt->bind_param("sssi", $name, $description, $type, $id);
    $stmt->execute();
}

// Étape 3 : Suppression du produit
if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['step-product-delete']) && $_POST['step-product-delete'] == 'delete') {
    $id = $_POST['id'];
    deleteProduct($id);
    $delete_product_alert = true; // Indicate that the product was deleted successfully
}
// Récupérer tous les produits pour affichage
$products = getAllProduct();

?>
