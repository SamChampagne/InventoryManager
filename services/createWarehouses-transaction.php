<?php

require_once __DIR__ . '/../function/createWarehouse.php'; 

$errors = [];
$success_warehouse = false;

$page = $_GET['page'] ?? 'home';

if ($page === 'add_warehouse' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $address = trim($_POST['address'] ?? '');

    // Validation
    if ($name === '') {
        $errors[] = "Le nom de l'entrepôt est obligatoire.";
    }
    if ($address === '') {
        $errors[] = "L'adresse de l'entrepôt est obligatoire.";
    }

    if (empty($errors)) {
        // Appelle la fonction qui insère en base
        $created = createWarehouse($name, $address);

        if ($created) {
            $_SESSION['createWarehouseSuccess'] = true;
            header('Location: '.$_SERVER['PHP_SELF'].'?page=add_warehouse');
            exit();
        } else {
            $errors[] = "Erreur lors de la création de l'entrepôt (peut-être un doublon).";
        }
    }
}
$_SESSION['errors_create_warehouses'] = $errors;
if (!empty($_SESSION['createWarehouseSuccess'])) {
    $success_warehouse = true;
    unset($_SESSION['createWarehouseSuccess']);
}
