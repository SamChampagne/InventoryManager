<body class="bg-light">

<div class="container py-4">
    <?php 
    if (!empty($_SESSION['errors_create_warehouses']) && is_array($_SESSION['errors_create_warehouses'])): ?>
            <div class="alert alert-danger">
                <ul>
                    <?php foreach ($_SESSION['errors_create_warehouses'] as $error): ?>
                        <li><?= htmlspecialchars($error) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <?php unset($_SESSION['errors_create_warehouses']); ?>
    <?php endif; ?>
    <div class="card mb-4">
        <div class="card-header bg-primary text-white">
            Créer un Nouvel Entrepôt
        </div>
        <div class="card-body">
            <form method="POST" class="row g-3" novalidate>
                <input type="hidden" name="step" value="add">

                <div class="col-md-6">
                    <label for="name" class="form-label">Nom de l'entrepôt</label>
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
                    <label for="address" class="form-label">Adresse</label>
                    <input
                        type="text"
                        id="address"
                        name="address"
                        class="form-control"
                        required
                        value="<?= htmlspecialchars($_POST['address'] ?? '') ?>"
                    >
                </div>

                <div class="col-12">
                    <button type="submit" class="btn btn-success">Créer l'entrepôt</button>
                    <button type="button" class="btn btn-secondary" onclick="window.location.href='?page=add_warehouse'">Annuler</button>

                </div>
            </form>
        </div>
    </div>
</div>



<?php if (!empty($success) && $success): ?>
<script>
Swal.fire({
    icon: 'success',
    title: 'L\'entrepôt a été créé avec succès.',
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
    html: <?= json_encode(implode('<br>', array_map('htmlspecialchars', $errors))) ?>,
    toast: true,
    position: 'top-end',
    confirmButtonText: 'Corriger',
    timer: 3000
});
</script>
<?php endif; ?>

</body>
</html>
