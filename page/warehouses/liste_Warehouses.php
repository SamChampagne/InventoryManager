
<body class="bg-light">

<div class="container mt-5">

    <?php if ($editingWarehouse): ?>
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                Modifier l'entrepôt : <?= htmlspecialchars($editingWarehouse['name']) ?>
            </div>
            <div class="card-body">
                <form method="POST" class="row g-3">
                    <input type="hidden" name="step-w" value="2">
                    <input type="hidden" name="id" value="<?= htmlspecialchars($editingWarehouse['id']) ?>">

                    <div class="col-md-6">
                        <label class="form-label">Nom</label>
                        <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($editingWarehouse['name']) ?>" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Adresse</label>
                        <input type="text" name="address" class="form-control" value="<?= htmlspecialchars($editingWarehouse['location']) ?>" required>
                    </div>

                    <div class="col-12">
                        <button type="submit" class="btn btn-success">Enregistrer</button>
                        <button type="button" class="btn btn-secondary" onclick="window.location.href = window.location.href;">Annuler</button>
                    </div>
                </form>
            </div>
        </div>
    <?php endif; ?>

<?php if (empty($warehouses)): ?>
    <div class="alert alert-warning">Aucune donnée disponible pour le moment.</div>
<?php else: ?>
    <table id="warehouseTable" class="table table-bordered table-hover">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Adresse</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($warehouses as $warehouse): ?>
            <tr>
                <td><?= htmlspecialchars($warehouse['id']) ?></td>
                <td>
                    <form method="POST" style="display:inline;">
                        <input type="hidden" name="step-w" value="1">
                        <input type="hidden" name="id" value="<?= htmlspecialchars($warehouse['id']) ?>">
                        <button type="submit" class="btn btn-link p-0 m-0 align-baseline text-decoration-none">
                            <?= htmlspecialchars($warehouse['name']) ?>
                        </button>
                    </form>
                </td>
                <td><?= htmlspecialchars($warehouse['location']) ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>


</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

<script>
    $(document).ready(function() {
    $('#warehouseTable').DataTable();
    });
</script>

</body>

