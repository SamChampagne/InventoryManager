<?php

require_once '../function/createProduct.php'; 

$errors = [];
$success_product = false;

$page = $_GET['page'] ?? 'home';

if ($page === 'add_product' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $type = trim($_POST['type'] ?? '');
    $description = trim($_POST['description'] ?? '');

    // Validation
    if ($name === '') {
        $errors[] = "Le nom du produit est obligatoire.";
    }
    if ($type === '') {
        $errors[] = "Le type du produit est obligatoire.";
    }
    if ($description === '') {
        $errors[] = "La description est obligatoire.";
    }

    // Si pas d'erreur, insertion
    if (empty($errors)) {
        $created = createProduct($name, $description, $type);

        if ($created) {
            $_SESSION['createProductSuccess'] = true;
            header('Location: '.$_SERVER['PHP_SELF'].'?page=add_product');
            exit();
        } else {
            $errors[] = "Erreur lors de la création du produit (nom peut-être déjà utilisé).";
        }
    }
}

$_SESSION['errors_create_product'] = $errors;

if (!empty($_SESSION['createProductSuccess'])) {
    $success_product = true;
    unset($_SESSION['createProductSuccess']);
}
?>
