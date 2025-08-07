<?php
use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../function/createProduct.php';
require_once __DIR__ . '/../function/deleteProduct.php';
require_once __DIR__ . '/../function/getProductByName.php';

class DeleteProductTest extends TestCase
{
    public function testCreateAndDeleteProduct()
    {
        // Étape 1 : Créer le produit
        $productName = 'ProduitTemp_' . uniqid();
        $description = 'Test produit temporaire';
        $type = 'TempTest';

        $createResult = createProduct($productName, $description, $type);
        $this->assertTrue($createResult, "La création du produit devrait réussir");

        $productId = getProductByName($productName);

        $this->assertNotNull($productId['id'], "L'ID du produit créé ne devrait pas être null");

        // Étape 3 : Supprimer le produit
        $deleteResult = deleteProduct($productId['id']);
        $this->assertTrue($deleteResult, "La suppression du produit devrait réussir");

    }
    public function testDeleteNonExistentProduct()
    {
        // On tente de supprimer un produit qui n'existe pas
        $fakeId = -9999; 
        $deleteResult = deleteProduct($fakeId);

        $this->assertFalse($deleteResult, "La suppression d'un produit inexistant devrait échouer");
    }
}
