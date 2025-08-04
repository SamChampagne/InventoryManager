<?php

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../function/addProductToInventory.php';


use PHPUnit\Framework\TestCase;
class AddProductToInventoryTest extends TestCase {

    /**
     * Test avec des valeurs valides → doit réussir
     */
    public function testAddProductToInventorySuccess() {

        // Arranger les valeurs pour une valeur dans la bd
        $productId = 999;
        $warehouseId = 1;
        $quantity = 10;

        // Act
        $result = addProductToInventory($productId, $warehouseId, $quantity);

        // Assert
        $this->assertTrue($result, "L'ajout du produit avec des données valides aurait dû réussir.");

        
    }

    /**
     * Test avec des valeurs invalides → doit échouer
     */
    public function testAddProductToInventoryFailure() {
        // Arrange
        $productId = null; // valeur invalide
        $warehouseId = 1;
        $quantity = 10;

        // Act
        $result = addProductToInventory($productId, $warehouseId, $quantity);

        // Assert
        $this->assertFalse($result, "L'ajout du produit avec une valeur nulle aurait dû échouer.");
    }

    
}
