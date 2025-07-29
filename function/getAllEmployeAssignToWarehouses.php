<?php 

function getAllEmployeAssignToWarehouses() {
    require_once '../config/dbConfig.php';

    $db = new Database();
    $conn = $db->getConnection();

    $stmt = $conn->prepare("
        SELECT 
            e.id, 
            u.id AS user_id, 
            u.name AS user_name, 
            w.id AS warehouse_id, 
            w.name AS warehouse_name
        FROM employees e
        JOIN users u ON e.user_id = u.id
        JOIN warehouses w ON e.warehouse_id = w.id
    ");
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC); // Return all employees assigned to warehouses as an associative array
    } else {
        return []; // Return an empty array on failure
    }
}