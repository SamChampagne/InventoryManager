<!-- Page de création d'un nouvel employé -->
<body class="bg-light">

<div class="container py-4">
    <?php 
    // Affichage des erreurs de création d'employé
    if (!empty($_SESSION['errors_create_users']) && is_array($_SESSION['errors_create_users'])): ?>
            <div class="alert alert-danger">
                <ul>
                    <?php foreach ($_SESSION['errors_create_users'] as $error): ?>
                        <li><?= htmlspecialchars($error) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>
    <div class="card mb-4">
        
        <div class="card-header bg-primary text-white">
            Créer un Nouvel Employé
        </div>
        
        <div class="card-body">
            <form method="POST" class="row g-3" novalidate>
                <input type="hidden" name="step" value="add">

                <div class="col-md-4">
                    <label for="name" class="form-label">Nom complet</label>
                    <input
                        type="text"
                        id="name"
                        name="name"
                        class="form-control"
                        required
                        value="<?= htmlspecialchars($_POST['name'] ?? '') ?>"
                    >
                </div>

                <div class="col-md-4">
                    <label for="email" class="form-label">Adresse Email</label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        class="form-control"
                        required
                        value="<?= htmlspecialchars($_POST['email'] ?? '') ?>"
                    >
                </div>

                <div class="col-md-4">
                    <label for="password" class="form-label">Mot de passe</label>
                    <input
                        type="password"
                        id="password"
                        name="password"
                        class="form-control"
                        required
                        minlength="6"
                    >
                </div>

                <div class="col-md-4">
                    <label for="role" class="form-label">Rôle</label>
                    <select
                        id="role"
                        name="role"
                        class="form-select"
                        required
                    >
                        <option value="employee" <?= (($_POST['role'] ?? '') === 'employee') ? 'selected' : '' ?>>Employé</option>
                        <option value="admin" <?= (($_POST['role'] ?? '') === 'admin') ? 'selected' : '' ?>>Admin</option>
                    </select>
                </div>

                <div class="col-12">
                    <button type="submit" class="btn btn-success">Créer l'employé</button>
                    <button type="button" class="btn btn-secondary" onclick="window.history.back()">Annuler</button>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- SweetAlert messages -->
<?php if ($success_user): ?>

<script>
    
Swal.fire({
    icon: 'success',
    title: 'L\'employé a été créé avec succès.',
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
