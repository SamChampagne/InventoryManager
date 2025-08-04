<?php
use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../function/createProduct.php';

class CreateProductTest extends TestCase
{
    public function testCreateProductSuccess()
    {
        // Appelle la fonction avec des données valides
        $result = createProduct('ProduitTest', 'Description test', 'TypeTest');
        $this->assertTrue($result, "La création du produit devrait réussir et retourner true");
    }

    public function testCreateProductFailure()
    {
        // Pour simuler un échec, on peut par exemple forcer un type trop long (dépend du schéma)
        // Ou alors on peut essayer un mock (plus compliqué). Ici on teste avec un argument null (qui peut échouer).

        $result = createProduct(null, 'Description test', 'TypeTest');
        $this->assertFalse($result, "La création du produit avec un nom null doit retourner false");
    }
}
