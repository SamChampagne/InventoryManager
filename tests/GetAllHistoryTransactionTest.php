<?php
use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../function/getAllHistoryTransaction.php';

class GetAllHistoryTransactionTest extends TestCase
{
    public function testGetAllHistoryTransactionReturnsArray()
    {
        $transactions = getAllHistoryTransaction();
        $this->assertIsArray($transactions, "La fonction doit retourner un tableau");
    }

    public function testGetAllHistoryTransactionKeysExist()
    {
        $transactions = getAllHistoryTransaction();

        if (!empty($transactions)) {
            $transaction = $transactions[0];

            $expectedKeys = [
                'id',
                'product_id',
                'warehouse_id_from',
                'warehouse_id_to',
                'user_id',
                'quantity',
                'created_at',
                'product_name',
                'warehouse_from_name',
                'warehouse_to_name',
                'user_name'
            ];

            foreach ($expectedKeys as $key) {
                $this->assertArrayHasKey($key, $transaction, "Clé attendue '$key' manquante dans la transaction.");
            }
        } else {
            $this->markTestSkipped("Aucune transaction présente dans la base, test ignoré.");
        }
    }

    public function testGetAllHistoryTransactionCount()
    {
        $transactions = getAllHistoryTransaction();
        $this->assertGreaterThanOrEqual(0, count($transactions), "Le tableau retourné doit contenir 0 ou plusieurs transactions.");
    }
}
