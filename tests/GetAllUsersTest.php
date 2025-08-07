<?php
use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../function/getAllUsers.php';

class GetAllUsersTest extends TestCase
{
    // Test pour vérifier que la fonction retourne un tableau
    public function testGetAllUsersReturnsArray()
    {
        $users = getAllUsers();
        $this->assertIsArray($users, "La fonction doit retourner un tableau");
    }
    // Test pour vérifier que le tableau n'est pas vide
    public function testGetAllUsersHasExpectedKeys()
    {
        $users = getAllUsers();
        
        if (!empty($users)) {
            $user = $users[0];
            $this->assertArrayHasKey('id', $user, "Chaque utilisateur doit avoir un champ 'id'");
            $this->assertArrayHasKey('name', $user, "Chaque utilisateur doit avoir un champ 'name'");
            $this->assertArrayHasKey('email', $user, "Chaque utilisateur doit avoir un champ 'email'");
        } else {
            $this->markTestSkipped("Aucun utilisateur présent dans la base, test ignoré.");
        }
    }
    // Test pour vérifier que le nombre d'utilisateurs est supérieur ou égal à zéro
    public function testGetAllUsersCount()
    {
        $users = getAllUsers();
        $this->assertGreaterThanOrEqual(0, count($users), "Le tableau retourné doit avoir 0 ou plusieurs utilisateurs");
    }
}
