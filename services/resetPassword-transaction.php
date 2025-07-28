<?php
session_start();

include_once '../config/dbConfig.php';
include_once '../function/getUserByEmail.php';
include_once '../function/modifyPassword.php'; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $oldPassword = $_POST['ancien_mdp'] ?? '';
    $newPassword = $_POST['nouveau_mdp'] ?? '';

    // Vérifier si tous les champs sont remplis
    if (empty($email) || empty($oldPassword) || empty($newPassword)) {
        $_SESSION['error'] = "Tous les champs sont requis.";
        header('Location: ../page/reset-password.php'); 
        exit;
    }
    

    // Appeler la fonction
    $result = modifyPassword($email, $oldPassword, $newPassword);

    if ($result === true) {
        $_SESSION['success'] = "Mot de passe modifié avec succès.";
    } else {
        $_SESSION['error'] = $result;
    }

    header('Location: ../page/reset-password.php'); 
    exit;
}
?>
