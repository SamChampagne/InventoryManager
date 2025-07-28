<?php
require_once '../config/dbConfig.php';
session_start();

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


function getUserByEmail($email) {
    $db = new Database();
    $conn = $db->getConnection();

    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    if (!$stmt) {
        return ;
    }

    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    return $result->fetch_assoc(); 
}
?>