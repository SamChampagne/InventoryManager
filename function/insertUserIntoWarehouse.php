<?php
require_once __DIR__ . '/../config/dbConfig.php';

function insertUserIntoWarehouse($user_id, $warehouse_id) {


    $db = new Database();
    $conn = $db->getConnection();

    // Préparer la requête d'insertion
    $stmt = $conn->prepare("INSERT INTO employees (user_id, warehouse_id) VALUES (?, ?)");
    $stmt->bind_param("ii", $user_id, $warehouse_id);

    // Exécuter la requête
    if ($stmt->execute()) {
        return true; // Insertion réussie
    } else {
        return false; // Échec de l'insertion
    }
}