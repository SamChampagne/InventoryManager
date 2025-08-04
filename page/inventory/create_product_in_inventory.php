<body class="bg-light">

<div class="container py-4">
    <?php 
    // Affiche les erreurs de validation si elles existent dans le service
    if (!empty($_SESSION['errors_create_product']) && is_array($_SESSION['errors_create_product'])): ?>
        <div class="alert alert-danger">
            <ul>
                <?php foreach ($_SESSION['errors_create_product'] as $error): ?>
                    <li><?= htmlspecialchars($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <div class="card mb-4">
        <div class="card-header bg-primary text-white">
            Ajouter un nouveau produit à l'inventaire
        </div>

        <div class="card-body">
            <form method="POST" class="row g-3" novalidate>
                <input type="hidden" name="step-add-in-inventory" value="add">
                
                <div class="col-md-6">
                    <label for="warehouse_id" class="form-label">Nom de l'entrepôt</label>
                    <select id="warehouse_id" name="warehouse_id" class="form-select" required>
                        <option value="">-- Sélectionner un entrepôt --</option>
                        <?php foreach ($warehouse_assign_to_user as $wh): ?>
                            <option value="<?= $wh['warehouse_id'] ?>"
                                <?= ($selectedWarehouse && $selectedWarehouse['warehouse_id'] == $wh['warehouse_id']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($wh['warehouse_name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="col-md-6">
                    <label for="product_id" class="form-label">Nom du produit</label>
                    <select id="product_id" name="product_id" class="form-select" required>
                        <option value="">-- Sélectionner un produit --</option>
                        <?php foreach ($products as $product): ?>
                            <option value="<?= $product['id'] ?>" <?= (isset($_POST['product_id']) && $_POST['product_id'] == $product['id']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($product['name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="col-12">
                    <label for="quantity" class="form-label">Quantité</label>
                    <input
                        type="number"
                        id="quantity"
                        name="quantity"
                        class="form-control"
                        required
                        min="1"
                        value="<?= htmlspecialchars($_POST['quantity'] ?? '') ?>"
                    >
                </div>

                <div class="col-12">
                    <button type="submit" class="btn btn-success">Créer le produit</button>
                    <button type="button" class="btn btn-secondary" onclick="window.history.back()">Annuler</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- SweetAlert messages -->
<?php if (!empty($success_product_inventory)): ?>
<script>
Swal.fire({
    icon: 'success',
    title: 'Produit créé avec succès.',
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
</body>
</html>
