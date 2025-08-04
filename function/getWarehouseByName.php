<?php

require_once __DIR__ . '/../config/dbConfig.php';

/**
 * Récupère un entrepôt par son nom.
 *
 * @param string $name Le nom de l'entrepôt.
 * @return array|null Les données de l'entrepôt ou null si non trouvé.
 */
function getWarehouseByName($name) {
    $db = new Database();
    $conn = $db->getConnection();

    $stmt = $conn->prepare("SELECT * FROM warehouses WHERE name = ? LIMIT 1");
    $stmt->bind_param("s", $name);
    $stmt->execute();

    $result = $stmt->get_result();
    if ($result && $result->num_rows > 0) {
        return $result->fetch_assoc(); 
    }

    return null; 
}
