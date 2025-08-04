<?php 

require_once __DIR__ . '/../config/dbConfig.php';


/**
 * Crée un nouvel utilisateur.
 *
 * @param string $username Le nom d'utilisateur.
 * @param string $password Le mot de passe de l'utilisateur.
 * @param string $role Le rôle de l'utilisateur (par exemple, 'admin', 'user').
 * @return bool True si l'utilisateur a été créé avec succès, sinon false.
 */
function createUser($username,$email, $password, $role) {
   
    if(empty($username) || empty($email) || empty($password) || empty($role)) {
        return false;
    }
    
    $db = new Database();
    $conn = $db->getConnection();

    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO users (name,email, password, role) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $username, $email, $hashedPassword, $role);

    if ($stmt->execute()) {
        return true; 
    } else {
        return false; 
    }
}