<?php 

include '../function/deleteProduct.php';
use PHPUnit\Framework\TestCase;

class testphp extends TestCase {
    public function testDeleteProduct() {
        // Arrange
        $id = 1; // ID du produit à supprimer
        $expected = true; // Suppression réussie attendue

        // Act
        $result = deleteProduct($id);

        // Assert
        $this->assertEquals($expected, $result);
    }
}