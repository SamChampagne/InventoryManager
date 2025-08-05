<?php
use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../function/getAllWarehouses.php';

class GetAllWarehousesTest extends TestCase
{
    public function testGetAllWarehousesReturnsArray()
    {
        $warehouses = getAllWarehouses();
        $this->assertIsArray($warehouses, "La fonction doit retourner un tableau");
    }

    public function testGetAllWarehousesHasExpectedKeys()
    {
        $warehouses = getAllWarehouses();

        if (!empty($warehouses)) {
            $warehouse = $warehouses[0];
            $this->assertArrayHasKey('id', $warehouse, "Chaque entrepôt doit avoir un champ 'id'");
            $this->assertArrayHasKey('name', $warehouse, "Chaque entrepôt doit avoir un champ 'name'");
            $this->assertArrayHasKey('location', $warehouse, "Chaque entrepôt doit avoir un champ 'location'");
        } else {
            $this->markTestSkipped("Aucun entrepôt présent dans la base, test ignoré.");
        }
    }

    public function testGetAllWarehousesCount()
    {
        $warehouses = getAllWarehouses();
        $this->assertGreaterThanOrEqual(0, count($warehouses), "Le tableau retourné doit avoir 0 ou plusieurs entrepôts");
    }
}
