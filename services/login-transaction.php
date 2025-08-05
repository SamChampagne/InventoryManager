<?php

require_once __DIR__ . '/../config/dbConfig.php';
require_once __DIR__ . '/../function/getUserByEmail.php';

// Session pour la page de connexion
session_start();

// Vérification de la méthode de requête
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    $user = getUserByEmail($email);

    
    if (!$user) {
        $_SESSION['error'] = "Utilisateur non trouvé : $email";
        header('Location: ../index.php');
        exit;
    }

    // Vérifie le mot de passe
    if (password_verify($password, $user['password'])) {
        // Authentification réussie
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['name'];
        $_SESSION['user_email'] = $user['email'];
        $_SESSION['role'] = $user['role'];

        header('Location: ../page/dashboard.php');
        exit;
    } else {
        $_SESSION['error'] = "Mot de passe incorrect.";
        header('Location: ../index.php');
        exit;
    }
}



?>