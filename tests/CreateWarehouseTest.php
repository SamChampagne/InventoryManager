<?php
use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../function/createWarehouse.php';

class CreateWarehouseTest extends TestCase
{
    public function testCreateWarehouseSuccess()
    {
        // Test avec des données valides => devrait retourner true
        $result = createWarehouse('Entrepôt Test', 'Paris');
        $this->assertTrue($result, "La création de l'entrepôt devrait réussir avec des données valides");
    }

    public function testCreateWarehouseFailure()
    {
        // Test avec un nom vide => doit retourner false
        $result = createWarehouse(null, 'Paris');
        $this->assertFalse($result, "La création doit échouer si le nom est vide");
    }
}
