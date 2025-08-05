<?php 

require_once __DIR__ . '/../config/dbConfig.php';

/**
* Crée un nouvel entrepôt.
*
* @param string $name Le nom de l'entrepôt.
* @param string $location L'emplacement de l'entrepôt.
* @return bool True si l'entrepôt a été créé avec succès, sinon false.
*/
function createWarehouse($name, $location) {
    if(empty($name) || empty($location)) {
        return false; 
    }
    $db = new Database();
    $conn = $db->getConnection();

    // 1. Créer l'entrepôt
    $stmt = $conn->prepare("INSERT INTO warehouses (name, location) VALUES (?, ?)");
    $stmt->bind_param("ss", $name, $location);

    if ($stmt->execute()) {

        // Pas besoin de créer une entrée dans l'inventaire ici
        return true;;
    } else {
        return false;
    }
}

