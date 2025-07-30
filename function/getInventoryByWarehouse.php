<?php
require_once '../config/dbConfig.php';

function getInventoryByWarehouse($warehouse_id) {

    $db = new Database();
    $conn = $db->getConnection();

    $stmt = $conn->prepare("SELECT * FROM inventory WHERE warehouse_id = ?");
    if (!$stmt) {
        return []; // Return an empty array if statement preparation fails
    }

    $stmt->bind_param("i", $warehouse_id);

    if ($stmt->execute()) {
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC); // Return all inventory items as an associative array
    } else {
        return []; // Return an empty array on failure
    }
}