<?php 

require_once __DIR__ . '/../function/getAllUsers.php';
require_once __DIR__ . '/../function/deleteUsers.php';

$delete_user_alert = false;
$db = new Database();
$conn = $db->getConnection();

$editingUser = null;

// Étape 1 : afficher le formulaire d'édition
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['step']) && $_POST['step'] == 1) {
    $id = $_POST['id'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $editingUser = $result->fetch_assoc();
}

// Étape 2 : enregistrer les modifications
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['step']) && $_POST['step'] == 2) {
    $id = $_POST['id'];
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $role = $_POST['role'];

    $stmt = $conn->prepare("UPDATE users SET name = ?, email = ?, role = ? WHERE id = ?");
    $stmt->bind_param("sssi", $name, $email, $role, $id);
    $stmt->execute();
}

// Étape 3 : suppression de l'utilisateur
if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['step-user-delete']) && $_POST['step-user-delete'] == 'delete') {
    $id = $_POST['id'];
    deleteUsers($id);
    $delete_user_alert = true; 
}

$users = getAllUsers(); ?>