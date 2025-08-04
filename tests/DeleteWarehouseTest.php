<?php
use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../function/deleteWarehouses.php';
require_once __DIR__ . '/../function/createWarehouse.php'; // Doit exister
require_once __DIR__ . '/../function/getWarehouseByName.php'; // Doit exister

class DeleteWarehouseTest extends TestCase
{
    public function testDeleteWarehouseSuccess()
    {
        // Étape 1 : Créer un entrepôt temporaire
        $name = 'EntrepotTemp_' . uniqid();
        $location = 'TestVille';

        $creationResult = createWarehouse($name, $location);
        $this->assertTrue($creationResult, "La création de l'entrepôt devrait réussir");

        // Étape 2 : Récupérer l’ID
        $warehouse = getWarehouseByName($name);
        $this->assertNotEmpty($warehouse, "L'entrepôt créé devrait exister");
        $this->assertArrayHasKey('id', $warehouse);

        // Étape 3 : Supprimer
        $deleteResult = deleteWarehouses($warehouse['id']);
        $this->assertTrue($deleteResult, "La suppression de l'entrepôt devrait réussir");
    }

    public function testDeleteWarehouseFailure()
    {
        // Essayer de supprimer un ID inexistant
        $deleteResult = deleteWarehouses(-9999); // ID qui n'existe sûrement pas
        $this->assertFalse($deleteResult, "La suppression devrait échouer pour un ID inexistant");
    }
}
?>