<?php
use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../function/deleteUsers.php';
require_once __DIR__ . '/../function/createUser.php'; 
require_once __DIR__ . '/../function/getUserByEmail.php'; 

class DeleteUserTest extends TestCase
{
    public function testDeleteUserSuccess()
    {
        // Étape 1 : Créer un utilisateur temporaire
        $email = 'tempuser_' . uniqid() . '@example.com';
        $password = 'password123';
        $role = 'admin';

        $creationResult = createUser('test', $email, $password, $role);
        $this->assertTrue($creationResult, "La création de l'utilisateur devrait réussir");

        // Étape 2 : Récupérer l’ID de l’utilisateur
        $user = getUserByEmail($email);
        $this->assertNotEmpty($user, "L'utilisateur créé devrait exister");
        $this->assertArrayHasKey('id', $user);

        // Étape 3 : Supprimer l’utilisateur
        $deleteResult = deleteUsers($user['id']);
        $this->assertTrue($deleteResult, "La suppression de l'utilisateur devrait réussir");
    }

    public function testDeleteUserFailure()
    {
        // Essayer de supprimer un ID inexistant
        $deleteResult = deleteUsers(-9999); // ID très probablement inexistant
        $this->assertFalse($deleteResult, "La suppression devrait échouer pour un ID inexistant");
    }
}
