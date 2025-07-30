<?php

include_once '../function/getAllUsers.php';
include_once '../function/getAllWarehouse.php';
include_once '../function/getAllEmployeAssignToWarehouses.php';
include_once '../function/validateUserInWarehouse.php';
include_once '../function/insertUserIntoWarehouse.php';
// Récupérer tous les employés
$employees_to_assign = getAllUsers();

$employees_already_assigned = getAllEmployeAssignToWarehouses();

// Récupérer tous les entrepôts
$warehouses = getAllWarehouses();

// Gérer le POST
$success = false;
$errors = [];


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_POST['user_id'] ?? '';
    $warehouse_id = $_POST['warehouse_id'] ?? '';

    if (!$user_id || !$warehouse_id) {
        $errors[] = "Veuillez sélectionner un employé et un entrepôt.";
    } else {
        // Vérifie si l'association existe déjà
        $stmt = validateUserInWarehouse($user_id, $warehouse_id);
        
        if ($stmt) {
            $errors[] = "Cet employé est déjà lié à cet entrepôt.";
        } else {
        // Insère l'association
            if (insertUserIntoWarehouse($user_id, $warehouse_id)) {
                $_SESSION['assignSuccess'] = true;
                header('Location: '.$_SERVER['PHP_SELF'].'?page=assign_employe');
                exit();
            } else {
                $errors[] = "Erreur lors de l'assignation.";
            }
        }
    }
}
if (!empty($_SESSION['assignSuccess'])) {
    $success = true;
    unset($_SESSION['assignSuccess']);
}
?>