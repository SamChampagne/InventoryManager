<body class="bg-light">

<div class="container py-4">
    <?php 
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
            Créer un Nouveau Produit
        </div>

        <div class="card-body">
            <form method="POST" class="row g-3" novalidate>
                <input type="hidden" name="step" value="add">

                <div class="col-md-6">
                    <label for="name" class="form-label">Nom du produit</label>
                    <input
                        type="text"
                        id="name"
                        name="name"
                        class="form-control"
                        required
                        value="<?= htmlspecialchars($_POST['name'] ?? '') ?>"
                    >
                </div>

                <div class="col-md-6">
                    <label for="type" class="form-label">Type</label>
                    <input
                        type="text"
                        id="type"
                        name="type"
                        class="form-control"
                        required
                        value="<?= htmlspecialchars($_POST['type'] ?? '') ?>"
                    >
                </div>

                <div class="col-12">
                    <label for="description" class="form-label">Description</label>
                    <textarea
                        id="description"
                        name="description"
                        class="form-control"
                        rows="3"
                        required
                    ><?= htmlspecialchars($_POST['description'] ?? '') ?></textarea>
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
<?php if (!empty($success_product)): ?>
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
