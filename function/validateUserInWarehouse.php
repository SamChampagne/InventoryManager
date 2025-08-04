<?php 
require_once __DIR__ . '/../config/dbConfig.php';

function validateUserInWarehouse($userId, $warehouseId) {


    $db = new Database();
    $conn = $db->getConnection();

    // Prepare the SQL statement to check if the user is assigned to the warehouse
    $stmt = $conn->prepare("SELECT * FROM employees WHERE user_id = ? AND warehouse_id = ?");
    $stmt->bind_param("ii", $userId, $warehouseId);

    if ($stmt->execute()) {
        $result = $stmt->get_result();
        return $result->num_rows > 0; // Return true if the user is assigned to the warehouse
    } else {
        return false; // Return false on failure
    }
}