<?php
use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../function/getAllProduct.php';
require_once __DIR__ . '/../config/dbConfig.php';

class GetAllProductTest extends TestCase
{
    protected $conn;

    // Configuration de la connexion à la base de données avant chaque test
    protected function setUp(): void
    {
        $db = new Database();
        $this->conn = $db->getConnection();

        // Réinitialise la table des produits pour le test
        $this->conn->query("DELETE * FROM products");

        // Ajoute 2 produits de test
        $this->conn->query("
            INSERT INTO products (name, description, type)
            VALUES 
                ('Produit A', 'Desc A', 'Type A'),
                ('Produit B', 'Desc B', 'Type B')
        ");
    }

    // Test pour vérifier que la fonction retourne un tableau
    public function testGetAllProductReturnsArray()
    {
        $result = getAllProduct();
        $this->assertIsArray($result, "Le résultat doit être un tableau");
    }

    // Test pour vérifier que le tableau contient les produits attendus
    public function testGetAllProductReturnsCorrectCount()
    {
        $result = getAllProduct();
        $this->assertCount(2, $result, "Il devrait y avoir exactement 2 produits");
    }
    // Test pour vérifier que les produits retournés contiennent les clés attendues
    public function testGetAllProductContainsExpectedProduct()
    {
        $result = getAllProduct();
        $this->assertEquals('Produit A', $result[0]['name'], "Le premier produit devrait être 'Produit A'");
        $this->assertEquals('Produit B', $result[1]['name'], "Le deuxième produit devrait être 'Produit B'");
    }
    // Ménage de la base de données après chaque test
    protected function tearDown(): void
    {
        // Nettoie après les tests
        $this->conn->query("DELETE FROM products");
        $this->conn->close();
    }
}
