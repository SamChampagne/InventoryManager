<!-- Page de création d'un nouvel employé -->

<!-- Breadcrumb -->
<div class="custom-breadcrumb">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="?page=dashboard_home" style="color: white;"><i class="fas fa-home"></i> Accueil</a></li>
            <li class="breadcrumb-item"><a href="?page=employe" style="color: rgba(255,255,255,0.9);"><i class="fas fa-users"></i> Employés</a></li>
            <li class="breadcrumb-item active" aria-current="page"><i class="fas fa-user-plus"></i> Créer Employé</li>
        </ol>
    </nav>
</div>

<!-- En-tête de page -->
<div class="page-header">
    <h1><i class="fas fa-user-plus text-success"></i> Créer un Nouvel Employé</h1>
    <p>Ajoutez un nouveau membre à votre équipe en remplissant le formulaire ci-dessous</p>
</div>

<!-- Actions rapides -->
<div class="action-buttons mb-4">
    <a href="?page=employe" class="btn btn-outline-secondary btn-custom">
        <i class="fas fa-arrow-left"></i> Retour à la liste
    </a>
    <a href="?page=assign_employe" class="btn btn-outline-info btn-custom">
        <i class="fas fa-building"></i> Assigner à un Entrepôt
    </a>
</div>

<!-- Affichage des erreurs -->
<?php if (!empty($_SESSION['errors_create_users']) && is_array($_SESSION['errors_create_users'])): ?>
    <div class="alert custom-alert custom-alert-danger">
        <h5><i class="fas fa-exclamation-circle"></i> Erreurs de validation</h5>
        <ul class="mb-0">
            <?php foreach ($_SESSION['errors_create_users'] as $error): ?>
                <li><?= htmlspecialchars($error) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<!-- Formulaire de création -->
<div class="enhanced-card">
    <div class="card-header bg-success text-white">
        <i class="fas fa-user-plus"></i> Informations du nouvel employé
    </div>
    <div class="card-body">
        <form method="POST" class="enhanced-form row g-3" novalidate>
            <input type="hidden" name="step" value="add">

            <div class="col-md-6">
                <label for="name" class="form-label">
                    <i class="fas fa-user"></i> Nom complet <span class="text-danger">*</span>
                </label>
                <input
                    type="text"
                    id="name"
                    name="name"
                    class="form-control"
                    required
                    placeholder="Ex: Jean Dupont"
                    value="<?= htmlspecialchars($_POST['name'] ?? '') ?>"
                >
                <small class="text-muted">Entrez le nom complet de l'employé</small>
            </div>

            <div class="col-md-6">
                <label for="email" class="form-label">
                    <i class="fas fa-envelope"></i> Adresse Email <span class="text-danger">*</span>
                </label>
                <input
                    type="email"
                    id="email"
                    name="email"
                    class="form-control"
                    required
                    placeholder="Ex: jean.dupont@example.com"
                    value="<?= htmlspecialchars($_POST['email'] ?? '') ?>"
                >
                <small class="text-muted">Adresse email professionnelle</small>
            </div>

            <div class="col-md-6">
                <label for="password" class="form-label">
                    <i class="fas fa-lock"></i> Mot de passe <span class="text-danger">*</span>
                </label>
                <input
                    type="password"
                    id="password"
                    name="password"
                    class="form-control"
                    required
                    minlength="6"
                    placeholder="Minimum 6 caractères"
                >
                <small class="text-muted">Le mot de passe doit contenir au moins 6 caractères</small>
            </div>

            <div class="col-md-6">
                <label for="role" class="form-label">
                    <i class="fas fa-user-tag"></i> Rôle <span class="text-danger">*</span>
                </label>
                <select id="role" name="role" class="form-select" required>
                    <option value="">-- Sélectionnez un rôle --</option>
                    <option value="employee" <?= (($_POST['role'] ?? '') === 'employee') ? 'selected' : '' ?>>
                        Employé
                    </option>
                    <option value="admin" <?= (($_POST['role'] ?? '') === 'admin') ? 'selected' : '' ?>>
                        Administrateur
                    </option>
                </select>
                <small class="text-muted">Les administrateurs ont tous les accès</small>
            </div>

            <div class="col-12">
                <hr class="my-3">
                <div class="alert custom-alert custom-alert-info">
                    <i class="fas fa-info-circle"></i>
                    <strong>Note importante :</strong> Après la création, vous pourrez assigner cet employé à un entrepôt depuis la section "Assigner Employé".
                </div>
            </div>

            <div class="col-12">
                <button type="submit" class="btn btn-success btn-lg">
                    <i class="fas fa-save"></i> Créer l'employé
                </button>
                <a href="?page=employe" class="btn btn-secondary btn-lg">
                    <i class="fas fa-times"></i> Annuler
                </a>
            </div>
        </form>
    </div>
</div>

<!-- Guide d'utilisation -->
<div class="enhanced-card mt-4">
    <div class="card-header bg-white">
        <h5 class="mb-0"><i class="fas fa-question-circle text-info"></i> Guide de création</h5>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-4">
                <div class="text-center">
                    <i class="fas fa-user-plus fa-3x text-success mb-3"></i>
                    <h6>1. Remplissez le formulaire</h6>
                    <p class="text-muted small">Entrez les informations de base de l'employé</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="text-center">
                    <i class="fas fa-check-circle fa-3x text-primary mb-3"></i>
                    <h6>2. Validez les informations</h6>
                    <p class="text-muted small">Assurez-vous que toutes les données sont correctes</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="text-center">
                    <i class="fas fa-building fa-3x text-info mb-3"></i>
                    <h6>3. Assignez à un entrepôt</h6>
                    <p class="text-muted small">Liez l'employé à son entrepôt de travail</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- SweetAlert messages -->
<?php if ($success_user): ?>
<script>
Swal.fire({
    icon: 'success',
    title: 'L\'employé a été créé avec succès',
    text: 'Vous pouvez maintenant l\'assigner à un entrepôt',
    showCancelButton: true,
    confirmButtonText: 'Assigner maintenant',
    cancelButtonText: 'Plus tard',
    confirmButtonColor: '#17a2b8',
    cancelButtonColor: '#6c757d'
}).then((result) => {
    if (result.isConfirmed) {
        window.location.href = '?page=assign_employe';
    } else {
        window.location.href = '?page=employe';
    }
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
