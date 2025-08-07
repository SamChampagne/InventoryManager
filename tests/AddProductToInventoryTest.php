<?php

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../function/addProductToInventory.php';


use PHPUnit\Framework\TestCase;

class AddProductToInventoryTest extends TestCase {

    
    // Test avec des valeurs valides → doit réussir
    
    public function testAddProductToInventorySuccess() {

        $productId = 999;
        $warehouseId = 1;
        $quantity = 10;

        $result = addProductToInventory($productId, $warehouseId, $quantity);

        $this->assertTrue($result, "L'ajout du produit avec des données valides aurait dû réussir.");

        
    }

    
    // Test avec des valeurs invalides → doit échouer
    public function testAddProductToInventoryFailure() {

        $productId = null; 
        $warehouseId = 1;
        $quantity = 10;

        $result = addProductToInventory($productId, $warehouseId, $quantity);

        $this->assertFalse($result, "L'ajout du produit avec une valeur nulle aurait dû échouer.");
    }

    
}
