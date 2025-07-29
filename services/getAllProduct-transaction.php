<?php

include_once '../function/getAllProduct.php';

$db = new Database();
$conn = $db->getConnection();

$editingProduct = null;

// Étape 2 : Mise à jour des données du produit
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['step-p']) && $_POST['step-p'] == 2) {
    $id = (int)$_POST['id'];
    $name = trim($_POST['name']);
    $description = trim($_POST['description']);
    $type = (float)$_POST['type'];
    
    $stmt = $conn->prepare("UPDATE products SET name = ?, description = ?, type = ? WHERE id = ?");
    $stmt->bind_param("ssdii", $name, $description, $type, $id);
    $stmt->execute();
}

// Étape 1 : Chargement des données à modifier
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['step-p']) && $_POST['step-p'] == 1) {
    $id = (int)$_POST['id'];

    $stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $editingProduct = $result->fetch_assoc();
}

// Récupérer tous les produits pour affichage
$products = getAllProduct();

?>
