
<body class="bg-light">

<div class="container mt-5">

    <?php if (!empty($editingProduct)): ?>
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                Modifier le produit : <?= htmlspecialchars($editingProduct['name']) ?>
            </div>
            <div class="card-body">
                <form method="POST" class="row g-3">
                    <input type="hidden" name="step-p" value="2">
                    <input type="hidden" name="id" value="<?= htmlspecialchars($editingProduct['id']) ?>">

                    <div class="col-md-6">
                        <label class="form-label">Nom du produit</label>
                        <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($editingProduct['name']) ?>" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Description</label>
                        <input type="text" name="description" class="form-control" value="<?= htmlspecialchars($editingProduct['description']) ?>" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">type</label>
                        <input type="text" name="type" class="form-control" value="<?= htmlspecialchars($editingProduct['type']) ?>" required>
                    </div>
                    <div class="col-12">
                        <button type="submit" class="btn btn-success">Enregistrer</button>
                        <button type="button" class="btn btn-secondary" onclick="window.location.href = window.location.href;">Annuler</button>
                    </div>
                </form><br>
                <form method="POST" class="d-inline delete-product-form">
                    <input type="hidden" name="step-product-delete" value="delete">
                    <input type="hidden" name="id" value="<?= htmlspecialchars($editingProduct['id']) ?>">
                    <button type="submit" class="btn btn-danger">Supprimer</button>
                </form>
            </div>
        </div>
    <?php endif; ?>

    <?php if (empty($products)): ?>
        <div class="alert alert-warning">Aucun produit disponible pour le moment.</div>
    <?php else: ?>
        <table id="productTable" class="table table-bordered table-hover">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Nom</th>
                    <th>Description</th>
                    <th>Type</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($products as $product): ?>
                <tr>
                    <td><?= htmlspecialchars($product['id']) ?></td>
                    <td>
                        <form method="POST" style="display:inline;">
                            <input type="hidden" name="step-p" value="1">
                            <input type="hidden" name="id" value="<?= htmlspecialchars($product['id']) ?>">
                            <button type="submit" class="btn btn-link p-0 m-0 align-baseline text-decoration-none">
                                <?= htmlspecialchars($product['name']) ?>
                            </button>
                        </form>
                    </td>
                    <td><?= htmlspecialchars($product['description']) ?></td>
                    <td><?= htmlspecialchars($product['type']) ?></td>
                    
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>

</div>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<script>
    $(document).ready(function() {
        $('#productTable').DataTable();
    });
</script>
<!-- SweetAlert messages -->
<?php if ($delete_product_alert): ?>
<script>
Swal.fire({
    icon: 'success',
    title: 'Produit supprimé avec succès',
    toast: true,
    position: 'top-end',
    timer: 3000,
    timerProgressBar: true,
    showConfirmButton: false
});
</script>
<?php endif; ?>
<script>
const form = document.querySelector('.delete-product-form');
if (form) {
    form.addEventListener('submit', function(e) {
        e.preventDefault();

        Swal.fire({
            title: 'Êtes-vous sûr ?',
            text: "Cette action supprimera le produit de façon permanente.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Oui, supprimer',
            cancelButtonText: 'Annuler',
            heightAuto: false,
            backdrop: true,
            customClass: {
                popup: 'swal-popup-clean'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    });
}
</script>
</body>

