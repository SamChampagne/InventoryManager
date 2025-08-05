<?php
require_once __DIR__ . '/../function/getAllHistoryTransaction.php';

// Récupérer toutes les transactions d'historique
$Liste_transaction_history = [];
$Liste_transaction_history = getAllHistoryTransaction();

?>