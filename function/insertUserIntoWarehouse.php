<?php
require_once __DIR__ . '/../config/dbConfig.php';
/**
 * Associe un utilisateur à un entrepôt en insérant une entrée dans la table employees.
 *
 * @param int $user_id      ID de l'utilisateur à assigner.
 * @param int $warehouse_id ID de l'entrepôt auquel l'utilisateur est assigné.
 * @return bool             Retourne true si l'insertion réussit, sinon false.
 */
function insertUserIntoWarehouse($user_id, $warehouse_id)
{

    $db = new Database();
    $conn = $db->getConnection();

    // Préparer la requête d'insertion
    $stmt = $conn->prepare("INSERT INTO employees (user_id, warehouse_id) VALUES (?, ?)");
    $stmt->bind_param("ii", $user_id, $warehouse_id);

    // Exécuter la requête
    return $stmt->execute();
}
