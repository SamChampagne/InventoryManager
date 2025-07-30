<?php
include_once '../function/getWarehouseAssignToUser.php';
include_once '../function/getInventoryByWarehouse.php';

$warehouse_assign_to_user = getWarehouseAssignToUser($_SESSION['user_id']);

$selectedWarehouse = null;
$inventory = [];

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
?>
