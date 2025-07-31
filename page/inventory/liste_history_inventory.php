<body>
    <br>
    <table class="table table-bordered table-hover">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Produit</th>
                <th>Depuis</th>
                <th>Vers</th>
                <th>Type</th>
                <th>Quantité</th>
                <th>Fait par</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($Liste_transaction_history as $transaction): ?>
                <tr>
                    <td><?= htmlspecialchars($transaction['id']) ?></td>
                    <td><?= htmlspecialchars($transaction['product_name'] ?? 'Inconnu') ?></td>
                    <td><?= htmlspecialchars($transaction['warehouse_from_name'] ?? '—') ?></td>
                    <td><?= htmlspecialchars($transaction['warehouse_to_name'] ?? '—') ?></td>
                    <td><?= htmlspecialchars($transaction['operation_type']) ?></td>
                    <td><?= htmlspecialchars($transaction['quantity']) ?></td>
                    <td><?= htmlspecialchars($transaction['user_name'] ?? 'Automatique') ?></td>
                    <td><?= htmlspecialchars($transaction['created_at']) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>