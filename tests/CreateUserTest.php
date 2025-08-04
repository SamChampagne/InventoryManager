<?php
use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../function/createUser.php';

class CreateUserTest extends TestCase
{
    public function testCreateUserSuccess()
    {
        $result = createUser('testUser', 'test@example.com', 'password123', 'admin');
        $this->assertTrue($result, "La création de l'utilisateur devrait réussir avec des données valides");
    }

    public function testCreateUserFailure()
    {
        // On teste un cas d'échec : nom vide (ou email vide)
        $result = createUser(null, 'test@example.com', 'password123', 'admin');
        $this->assertFalse($result, "La création doit échouer si le nom d'utilisateur est vide");
    }
}
?>