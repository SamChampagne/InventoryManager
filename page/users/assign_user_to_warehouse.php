<!-- Page d'assignation d'employés aux entrepôts -->

<!-- Breadcrumb -->
<div class="custom-breadcrumb">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="?page=dashboard_home" style="color: white;"><i class="fas fa-home"></i> Accueil</a></li>
            <li class="breadcrumb-item"><a href="?page=employe" style="color: rgba(255,255,255,0.9);"><i class="fas fa-users"></i> Employés</a></li>
            <li class="breadcrumb-item active" aria-current="page"><i class="fas fa-link"></i> Assigner Employé</li>
        </ol>
    </nav>
</div>

<!-- En-tête de page -->
<div class="page-header">
    <h1><i class="fas fa-link text-info"></i> Assigner un Employé à un Entrepôt</h1>
    <p>Liez les employés à leurs entrepôts de travail pour une meilleure organisation</p>
</div>

<!-- Mini stats -->
<div class="row mb-4">
    <div class="col-md-4 col-sm-6">
        <div class="stat-mini-card blue">
            <h3><?= count($employees_to_assign) ?></h3>
            <p><i class="fas fa-users"></i> Employés disponibles</p>
        </div>
    </div>
    <div class="col-md-4 col-sm-6">
        <div class="stat-mini-card green">
            <h3><?= count($warehouses) ?></h3>
            <p><i class="fas fa-warehouse"></i> Entrepôts actifs</p>
        </div>
    </div>
    <div class="col-md-4 col-sm-6">
        <div class="stat-mini-card orange">
            <h3><?= count($employees_already_assigned) ?></h3>
            <p><i class="fas fa-check-circle"></i> Assignations actives</p>
        </div>
    </div>
</div>

<!-- Actions rapides -->
<div class="action-buttons mb-4">
    <a href="?page=employe" class="btn btn-outline-secondary btn-custom">
        <i class="fas fa-arrow-left"></i> Retour à la liste
    </a>
    <a href="?page=add_employe" class="btn btn-outline-success btn-custom">
        <i class="fas fa-user-plus"></i> Créer un Employé
    </a>
</div>

<!-- Affichage des erreurs -->
<?php if (!empty($errors)): ?>
    <div class="alert custom-alert custom-alert-danger">
        <h5><i class="fas fa-exclamation-circle"></i> Erreurs de validation</h5>
        <ul class="mb-0">
            <?php foreach ($errors as $error): ?>
                <li><?= htmlspecialchars($error) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<!-- Formulaire d'assignation -->
<div class="enhanced-card mb-4">
    <div class="card-header bg-info text-white">
        <i class="fas fa-link"></i> Nouvelle Assignation
    </div>
    <div class="card-body">
        <form method="POST" class="enhanced-form row g-3">
            <div class="col-md-6">
                <label for="user_id" class="form-label">
                    <i class="fas fa-user"></i> Employé <span class="text-danger">*</span>
                </label>
                <select name="user_id" id="user_id" class="form-select" required>
                    <option value="">-- Sélectionnez un employé --</option>
                    <?php foreach ($employees_to_assign as $emp): ?>
                        <option value="<?= $emp['id'] ?>" <?= ($_POST['user_id'] ?? '') == $emp['id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($emp['name']) ?> (<?= htmlspecialchars($emp['email']) ?>)
                        </option>
                    <?php endforeach; ?>
                </select>
                <small class="text-muted">Seuls les employés non assignés sont affichés</small>
            </div>

            <div class="col-md-6">
                <label for="warehouse_id" class="form-label">
                    <i class="fas fa-warehouse"></i> Entrepôt <span class="text-danger">*</span>
                </label>
                <select name="warehouse_id" id="warehouse_id" class="form-select" required>
                    <option value="">-- Sélectionnez un entrepôt --</option>
                    <?php foreach ($warehouses as $wh): ?>
                        <option value="<?= $wh['id'] ?>" <?= ($_POST['warehouse_id'] ?? '') == $wh['id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($wh['name']) ?>
                            <?php if (!empty($wh['location'])): ?>
                                - <?= htmlspecialchars($wh['location']) ?>
                            <?php endif; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <small class="text-muted">Choisissez l'entrepôt de travail</small>
            </div>

            <?php if (empty($employees_to_assign)): ?>
                <div class="col-12">
                    <div class="alert custom-alert custom-alert-warning">
                        <i class="fas fa-exclamation-triangle"></i>
                        <strong>Aucun employé disponible :</strong> Tous les employés sont déjà assignés à un entrepôt, ou aucun employé n'existe.
                        <a href="?page=add_employe" class="alert-link">Créer un nouvel employé</a>
                    </div>
                </div>
            <?php elseif (empty($warehouses)): ?>
                <div class="col-12">
                    <div class="alert custom-alert custom-alert-warning">
                        <i class="fas fa-exclamation-triangle"></i>
                        <strong>Aucun entrepôt disponible :</strong> Vous devez d'abord créer un entrepôt.
                        <a href="?page=add_warehouse" class="alert-link">Créer un entrepôt</a>
                    </div>
                </div>
            <?php endif; ?>

            <div class="col-12">
                <button type="submit" class="btn btn-info btn-lg text-white" <?= (empty($employees_to_assign) || empty($warehouses)) ? 'disabled' : '' ?>>
                    <i class="fas fa-link"></i> Assigner
                </button>
                <a href="?page=employe" class="btn btn-secondary btn-lg">
                    <i class="fas fa-times"></i> Annuler
                </a>
            </div>
        </form>
    </div>
</div>

<!-- Tableau des assignations existantes -->
<div class="enhanced-card">
    <div class="card-header bg-white">
        <h5 class="mb-0"><i class="fas fa-list"></i> Assignations Existantes</h5>
    </div>
    <div class="card-body">
        <?php if (empty($employees_already_assigned)): ?>
            <div class="empty-state">
                <div class="empty-state-icon">
                    <i class="fas fa-inbox"></i>
                </div>
                <h3>Aucune assignation</h3>
                <p>Il n'y a aucun employé assigné à un entrepôt pour le moment.</p>
                <a href="?page=add_employe" class="btn btn-primary">
                    <i class="fas fa-user-plus"></i> Créer un employé
                </a>
            </div>
        <?php else: ?>
            <div class="table-responsive">
                <table id="employees_already_assign_Table" class="table enhanced-table table-hover">
                    <thead>
                        <tr>
                            <th><i class="fas fa-hashtag"></i> ID</th>
                            <th><i class="fas fa-user"></i> Employé</th>
                            <th><i class="fas fa-warehouse"></i> Entrepôt</th>
                            <th><i class="fas fa-envelope"></i> Email</th>
                            <th><i class="fas fa-user-tag"></i> Rôle</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($employees_already_assigned as $user): ?>
                        <tr>
                            <td><span class="badge bg-secondary"><?= htmlspecialchars($user['id']) ?></span></td>
                            <td>
                                <div class="icon-text">
                                    <i class="fas fa-user-tie text-info"></i>
                                    <strong><?= htmlspecialchars($user['user_name']) ?></strong>
                                </div>
                            </td>
                            <td>
                                <div class="icon-text">
                                    <i class="fas fa-warehouse text-primary"></i>
                                    <?= htmlspecialchars($user['warehouse_name']) ?>
                                </div>
                            </td>
                            <td>
                                <?php if (!empty($user['user_email'])): ?>
                                    <a href="mailto:<?= htmlspecialchars($user['user_email']) ?>">
                                        <?= htmlspecialchars($user['user_email']) ?>
                                    </a>
                                <?php else: ?>
                                    <span class="text-muted">-</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if (!empty($user['role'])): ?>
                                    <?php if ($user['role'] === 'admin'): ?>
                                        <span class="badge bg-primary custom-badge">
                                            <i class="fas fa-shield-alt"></i> Admin
                                        </span>
                                    <?php else: ?>
                                        <span class="badge bg-info custom-badge">
                                            <i class="fas fa-user"></i> Employé
                                        </span>
                                    <?php endif; ?>
                                <?php else: ?>
                                    <span class="text-muted">-</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<script>
  $(document).ready(function() {
    $('#employees_already_assign_Table').DataTable({
        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/fr-FR.json'
        },
        order: [[0, 'desc']],
        pageLength: 25
    });
  });
</script>

<!-- SweetAlert messages -->
<?php if ($success): ?>
<script>
Swal.fire({
    icon: 'success',
    title: 'Assignation réussie',
    text: 'L\'employé a été assigné à l\'entrepôt',
    toast: true,
    position: 'top-end',
    timer: 3000,
    timerProgressBar: true,
    showConfirmButton: false
});
</script>
<?php endif; ?>
