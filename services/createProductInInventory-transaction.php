<?php

include_once '../function/addProductToInventory.php';

$errors = [];
$success_product_inventory = false;

$page = $_GET['page'] ?? 'home';

if ($page === 'add_to_inventory' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_id = $_POST['product_id'] ?? '';
    $warehouse_id = $_POST['warehouse_id'] ?? '';
    $quantity = $_POST['quantity'] ?? '';

    // Validation
    if ($product_id === '' || !is_numeric($product_id)) {
        $errors[] = "Produit invalide.";
    }
    if ($warehouse_id === '' || !is_numeric($warehouse_id)) {
        $errors[] = "Entrepôt invalide.";
    }
    if ($quantity === '' || !is_numeric($quantity) || $quantity < 1) {
        $errors[] = "Quantité invalide.";
    }
    
    // Insertion
    if (empty($errors)) {
        $added = addProductToInventory($product_id,$warehouse_id, $quantity);

        if ($added) {
            $_SESSION['createProductInInventory'] = true;
            header('Location: ' . $_SERVER['PHP_SELF'] . '?page=add_to_inventory');
            exit();
        } else {
            $errors[] = "Erreur lors de l'ajout du produit à l'inventaire.";
        }
    }
}

$_SESSION['errors_create_inventory'] = $errors;

if (!empty($_SESSION['createProductInInventory'])) {
    $success_product_inventory = true;
    unset($_SESSION['createProductInInventory']);
}
?>
