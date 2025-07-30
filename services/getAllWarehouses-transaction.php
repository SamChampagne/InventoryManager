<?php

include_once '../function/getAllWarehouse.php';
include_once '../function/deleteWarehouses.php';
$delete_warehouse_alert = false;
$db = new Database();
$conn = $db->getConnection();

$editingWarehouse = null;

// Étape 2 : Mise à jour des données
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['step-w']) && $_POST['step-w'] == 2) {
    $id = (int)$_POST['id'];
    $name = trim($_POST['name']);
    $address = trim($_POST['address']);

    $stmt = $conn->prepare("UPDATE warehouses SET name = ?, location = ? WHERE id = ?");
    $stmt->bind_param("ssi", $name, $address, $id);
    $stmt->execute();
}

// Étape 1 : Chargement des données à modifier
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['step-w']) && $_POST['step-w'] == 1) {
    $id = (int)$_POST['id'];

    $stmt = $conn->prepare("SELECT * FROM warehouses WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $editingWarehouse = $result->fetch_assoc();
}

if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['step-warehouse-delete']) && $_POST['step-warehouse-delete'] == 'delete') {
    $id = $_POST['id'];
    deleteWarehouses($id);
    $delete_warehouse_alert = true; // Indicate that the warehouse was deleted successfully
}
$warehouses = getAllWarehouses();

?>