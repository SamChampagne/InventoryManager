<?php

require_once __DIR__ . '/../function/addTransactionHistory.php';

use PHPUnit\Framework\TestCase;

class AddTransactionHistoryTest extends TestCase
{
    /**
     * Test avec des données valides dans la base de données → devrait retourner true
     */
    public function testAddTransactionHistorySuccess()
    {
        // Arrange
        $userId = 1;
        $productId = 999;        
        $warehouseFrom = 1;
        $warehouseTo = 2;
        $operationType = 'move'; 
        $quantity = 5;

        // Act
        $result = addTransactionHistory($userId, $productId, $warehouseFrom, $warehouseTo, $operationType, $quantity);

        // Assert
        $this->assertTrue($result, "L'ajout d'une transaction valide devrait retourner true.");
    }

    /**
     * Test avec une valeur invalide → devrait retourner false
     */
    public function testAddTransactionHistoryFailure()
    {
        
        $userId = 1;
        $productId = null;       
        $warehouseFrom = 1;
        $warehouseTo = 2;
        $operationType = 'move';
        $quantity = 5;

        $result = addTransactionHistory($userId, $productId, $warehouseFrom, $warehouseTo, $operationType, $quantity);

        $this->assertFalse($result, "Une valeur invalide devrait retourner false.");
    }
}
