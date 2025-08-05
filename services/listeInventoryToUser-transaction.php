<?php
require_once __DIR__ . '/../function/getWarehouseAssignToUser.php';
require_once __DIR__ . '/../function/getInventoryByWarehouse.php';
require_once __DIR__ . '/../function/transferProduct.php';
require_once __DIR__ . '/../function/addTransactionHistory.php';

// Initialisation des variables
$warehouse_assign_to_user = getWarehouseAssignToUser($_SESSION['user_id']);
$show_transfer_form = false;
$transfer_product_id = null;
$transfer_product_name ='';
$transfer_max_quantity = 0;
$transfer_is_max_quantity = false;
$transfer_current_warehouse_id = null;
$selectedWarehouse = null;
$success_transfer = false;
$inventory = [];
$errors_transfer = [];
$selectedId = null;

// Étape 1 : Sélection de l'entrepôt
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['step']) && $_POST['step'] === 'select_inventory') {
    if (isset($_POST['warehouse_id']) && $_POST['warehouse_id'] !== '') {
        $selectedId = intval($_POST['warehouse_id']);
        foreach ($warehouse_assign_to_user as $wh) {
            if ($wh['warehouse_id'] == $selectedId) {
                $selectedWarehouse = $wh;
                $inventory = getInventoryByWarehouse($selectedId);
                break;
            }
        }
    }
}

// Étape 2 : Sélection du produit à transférer
if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['step-transfer']) && $_POST['step-transfer'] == 1) {

    $transfer_product_id = $_POST['product_id'];
    $transfer_product_name = $_POST['product_name'] ?? '';
    $transfer_max_quantity = $_POST['product_quantity'] ?? 0;
    $transfer_current_warehouse_id = $_POST['current_warehouse'] ?? null;
    $show_transfer_form = true;
}

// Étape 3 : Transfert du produit
if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['step-transfer']) && $_POST['step-transfer'] == 2) {
    
    // Récupération des données du formulaire
    $warehouse_to_transfer = $_POST['target_warehouse_id'];
    $quantity_enter = intval($_POST['quantity'] ?? 0);
    $transfer_max_quantity = intval($_POST['product_quantity'] ?? 0);
    $transfer_product_id = $_POST['product_id'] ?? null;
    $transfer_product_name = $_POST['product_name'] ?? '';
    $transfer_current_warehouse_id = $_POST['current_warehouse'] ?? null;

    if($quantity_enter > $transfer_max_quantity){
        $show_transfer_form = true;
        $errors_transfer[] = "La quantité entrée est plus grande que la quantité disponible dans l'inventaire.";
    } elseif($quantity_enter == $transfer_max_quantity){
        $transfer_is_max_quantity = true;
    }

    
        // Logique de transfert
        $transfered = transferProduct($transfer_product_id, $warehouse_to_transfer, $quantity_enter, $transfer_current_warehouse_id);
        if ($transfered) {
            addTransactionHistory(
                $_SESSION['user_id'],
                $transfer_product_id,
                $transfer_current_warehouse_id,
                $warehouse_to_transfer,
                'transfert',
                $quantity_enter);

            $_SESSION['transferSuccess'] = true;
            $_SESSION['success_message'] = "Transfert de $quantity_enter produit(s) vers l'entrepôt avec succès.";
            header('Location: '.$_SERVER['PHP_SELF'].'?page=inventaire_warehouse');
            exit;
        } else {
            $errors_transfer[] = "Erreur lors du transfert du produit.";
        }
    
}

// Les variables pour l'affichage

$_SESSION['errors_transfer'] = $errors_transfer;

if (!empty($_SESSION['transferSuccess'])) {
    $success_transfer = true;
    unset($_SESSION['transferSuccess']);
}
?>
