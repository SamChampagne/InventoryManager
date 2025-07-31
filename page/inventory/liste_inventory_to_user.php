
<div class="container mt-4">

    <?php 
    if (!empty($_SESSION['errors_transfer']) && is_array($_SESSION['errors_transfer'])): ?>
        <div class="alert alert-danger">
            <ul>
                <?php foreach ($_SESSION['errors_transfer'] as $error): ?>
                    <li><?= htmlspecialchars($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>
    <?php if ($show_transfer_form): ?>
        <div class="card mb-4">
            <div class="card-header bg-warning text-dark">
                Transférer le produit : <?= htmlspecialchars($transfer_product_name) ?>
            </div>
            <div class="card-body">
                <form method="POST" class="row g-3">
                    <input type="hidden" name="step-transfer" value="2">
                    <input type="hidden" name="product_quantity" value="<?= htmlspecialchars($transfer_max_quantity) ?>">
                    <input type="hidden" name="product_name" value="<?= htmlspecialchars($transfer_product_name) ?>">
                    <input type="hidden" name="current_warehouse" value="<?= htmlspecialchars($transfer_current_warehouse_id) ?>">
                    <input type="hidden" name="product_id" value="<?= htmlspecialchars($transfer_product_id) ?>">

                    <div class="col-md-6">
                        <label class="form-label">Produit</label>
                        <input type="text" class="form-control" value="<?= htmlspecialchars($transfer_product_name) ?>" disabled>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Entrepôt de destination</label>
                        <select name="target_warehouse_id" class="form-select" required>
                            <option value="">-- Choisir un entrepôt --</option>
                            <?php foreach ($warehouses as $warehouse): ?>
                                <option value="<?= $warehouse['id'] ?>">
                                    <?= htmlspecialchars($warehouse['name']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Quantité à transférer/ Maximum est de <?= $transfer_max_quantity ?> :</label>
                        <input type="number" name="quantity" class="form-control" min="1" max="<?= $transfer_max_quantity ?>" required>
                    </div>

                    <div class="col-12">
                        <button type="submit" class="btn btn-primary">Transférer</button>
                        <button type="button" class="btn btn-secondary" onclick="window.location.href = window.location.href;">Annuler</button>
                    </div>
                </form>
            </div>
        </div>
    <?php return; endif; ?>
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
                            <td>
                                <form method="POST" style="display:inline;">
                                    <input type="hidden" name="step-transfer" value="1">
                                    <input type="hidden" name="id" value="<?= $item['id'] ?>">
                                    <input type="hidden" name="product_id" value="<?= $item['product_id'] ?>">
                                    <input type="hidden" name="product_name" value="<?= $item['product_name'] ?>">
                                    <input type="hidden" name='product_quantity' value="<?= $item['quantity'] ?>">
                                    <input type="hidden" name='current_warehouse' value="<?= $selectedWarehouse['warehouse_id'] ?>">
                                    <button type="submit" class="btn btn-link p-0 m-0 align-baseline text-decoration-none">
                                        <?= htmlspecialchars($item['product_name']) ?>
                                    </button>
                                </form>
                            </td>
                            <td><?= htmlspecialchars($item['product_description']) ?></td>
                            <td><?= $item['quantity'] ?></td>
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

<?php if (!empty($success_transfer)): ?>
<script>
Swal.fire({
    icon: 'success',
    title: 'transfer réussi avec succès.',
    toast: true,
    position: 'top-end',
    timer: 3000,
    timerProgressBar: true,
    showConfirmButton: false
});
</script>
<?php elseif (!empty($errors)): ?>
<script>
Swal.fire({
    icon: 'error',
    title: 'Erreur',
    html: <?= json_encode(implode('<br>', array_map('htmlspecialchars', $errors))) ?>,
    confirmButtonText: 'Corriger'
});
</script>

<?php endif; ?>