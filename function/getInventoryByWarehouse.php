<?php
require_once __DIR__ . '/../config/dbConfig.php';

/**
 * Récupère l'inventaire complet d'un entrepôt donné.
 *
 * @param int $warehouse_id ID de l'entrepôt dont on veut récupérer l'inventaire.
 * @return array Retourne un tableau associatif contenant la liste des produits et quantités en stock pour l'entrepôt.
 *               Retourne un tableau vide en cas d'erreur de préparation ou d'exécution de la requête.
 */
function getInventoryByWarehouse($warehouse_id) {
    $db = new Database();
    $conn = $db->getConnection();

    $sql = "
        SELECT 
            inventory.id,
            inventory.quantity,
            products.id AS product_id,
            products.name AS product_name,
            products.description AS product_description,
            warehouses.name AS warehouse_name
        FROM inventory
        INNER JOIN products ON inventory.product_id = products.id
        INNER JOIN warehouses ON inventory.warehouse_id = warehouses.id
        WHERE inventory.warehouse_id = ?
    ";

    // Préparer la requête SQL 
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        return []; 
    }

    // Liaison du paramètre
    $stmt->bind_param("i", $warehouse_id);

    // Exécution
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    } 
    
    return [];
}
