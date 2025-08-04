<?php
require_once __DIR__ . '/../config/dbConfig.php';

function getWarehouseById($warehouse_id) {


    $db = new Database();
    $conn = $db->getConnection();

    $stmt = $conn->prepare("SELECT * FROM warehouses WHERE id = ?");
    if (!$stmt) {
        return null; // Return null if statement preparation fails
    }

    $stmt->bind_param("i", $warehouse_id);

    if ($stmt->execute()) {
        $result = $stmt->get_result();
        return $result->fetch_assoc(); // Return the warehouse as an associative array
    } else {
        return null; // Return null on failure
    }
}