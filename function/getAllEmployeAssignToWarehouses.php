<?php 
require_once __DIR__ . '/../config/dbConfig.php';
/**
 * Récupère la liste de tous les employés avec leurs informations utilisateur et l'entrepôt auquel ils sont assignés.
 *
 * @return array Retourne un tableau associatif contenant la liste des employés avec leurs utilisateurs et entrepôts.
 *               Retourne un tableau vide en cas d’échec de la requête.
 */
function getAllEmployeAssignToWarehouses() {
    

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
        // Retourne toutes les transactions sous forme de tableau associatif
        return $result->fetch_all(MYSQLI_ASSOC); 
    } else {
        return [];
    }
}