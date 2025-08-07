<?php
use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../function/getAllEmployeAssignToWarehouses.php';

class GetAllEmployeAssignToWarehousesTest extends TestCase
{
    // Test pour vérifier que la fonction retourne un tableau
    public function testReturnsArray()
    {
        $employes = getAllEmployeAssignToWarehouses();
        $this->assertIsArray($employes, "La fonction doit retourner un tableau");
    }
    // Test pour vérifier que le tableau n'est pas vide
    public function testKeysInFirstResult()
    {
        $employes = getAllEmployeAssignToWarehouses();

        if (!empty($employes)) {
            $employe = $employes[0];

            $expectedKeys = [
                'id',
                'user_id',
                'user_name',
                'warehouse_id',
                'warehouse_name'
            ];

            foreach ($expectedKeys as $key) {
                $this->assertArrayHasKey($key, $employe, "Clé attendue '$key' manquante dans l'entrée retournée.");
            }
        } else {
            $this->markTestSkipped("Aucun employé assigné trouvé dans la base de données, test ignoré.");
        }
    }
    // Test pour vérifier que le nombre d'assignations est supérieur ou égal à zéro
    public function testCountIsZeroOrMore()
    {
        $employes = getAllEmployeAssignToWarehouses();
        $this->assertGreaterThanOrEqual(0, count($employes), "Le tableau retourné doit contenir 0 ou plusieurs assignations.");
    }
}
