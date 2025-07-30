
<div class="container mt-4">

    <form method="POST" class="mb-4">
        <label for="warehouse" class="form-label">Choisir un entrepôt :</label>
        <input type="hidden" name="step" value="select_inventory">
        <select name="warehouse_id" id="warehouse" class="form-select" ">
            <option value="">-- Sélectionner --</option>
            <?php foreach ($warehouse_assign_to_user as $wh): ?>
                <option value="<?= $wh['warehouse_id'] ?>"
                    <?= ($selectedWarehouse && $selectedWarehouse['warehouse_id'] == $wh['warehouse_id']) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($wh['warehouse_name']) ?>
                </option>
            <?php endforeach; ?>
        </select><br>
        <div class="col-12">
            <button type="submit" class="btn btn-success">Afficher l'entrepôt</button>
        </div>
    </form>
    
    <?php if ($selectedWarehouse): ?>
        <h3>Inventaire pour : <?= htmlspecialchars($selectedWarehouse['warehouse_name']) ?></h3>

        <?php if (!empty($inventory)): ?>
            <table id="inventoryTable" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>Produit</th>
                        <th>Description</th>
                        <th>Quantité</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($inventory as $item): ?>
                        <tr>
                            <td><?= htmlspecialchars($item['warehouse_id']) ?></td>
                            <td><?= htmlspecialchars($item['product_id']) ?></td>
                            <td><?= (int)$item['quantity'] ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <div class="alert alert-info">Aucun produit en inventaire pour cet entrepôt.</div>
        <?php endif; ?>

    <?php elseif (isset($_GET['warehouse_id']) && $_GET['warehouse_id'] !== ''): ?>
        <div class="alert alert-warning">Entrepôt non trouvé ou non assigné à votre compte.</div>
    <?php endif; ?>

</div>

<!-- Ajoute ces scripts une seule fois dans ton layout/dashboard global -->
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<script>
    $(document).ready(function() {
        $('#inventoryTable').DataTable({
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/fr-FR.json'
            }
        });
    });
</script>
