<!-- Page qui liste les utilisateurs et permet de modifier les informations -->

<!-- Breadcrumb -->
<div class="custom-breadcrumb">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="?page=dashboard_home" style="color: white;"><i class="fas fa-home"></i> Accueil</a></li>
            <li class="breadcrumb-item active" aria-current="page"><i class="fas fa-users"></i> Gestion des Employés</li>
        </ol>
    </nav>
</div>

<!-- En-tête de page -->
<div class="page-header">
    <h1><i class="fas fa-users text-primary"></i> Liste des Employés</h1>
    <p>Consultez, modifiez et gérez tous les employés de votre organisation</p>
</div>

<!-- Mini stats -->
<div class="row mb-4">
    <div class="col-md-3 col-sm-6">
        <div class="stat-mini-card blue">
            <h3><?= count($users) ?></h3>
            <p><i class="fas fa-users"></i> Total Employés</p>
        </div>
    </div>
    <div class="col-md-3 col-sm-6">
        <div class="stat-mini-card green">
            <h3><?= count(array_filter($users, fn($u) => $u['role'] === 'admin')) ?></h3>
            <p><i class="fas fa-user-shield"></i> Administrateurs</p>
        </div>
    </div>
    <div class="col-md-3 col-sm-6">
        <div class="stat-mini-card orange">
            <h3><?= count(array_filter($users, fn($u) => $u['role'] === 'employee')) ?></h3>
            <p><i class="fas fa-user-tie"></i> Employés</p>
        </div>
    </div>
    <div class="col-md-3 col-sm-6">
        <div class="stat-mini-card purple">
            <h3><?= count($users) > 0 ? date('d/m/Y') : '-' ?></h3>
            <p><i class="fas fa-calendar"></i> Dernière MAJ</p>
        </div>
    </div>
</div>

<!-- Actions rapides -->
<div class="action-buttons mb-4">
    <a href="?page=add_employe" class="btn btn-primary btn-custom">
        <i class="fas fa-user-plus"></i> Nouvel Employé
    </a>
    <a href="?page=assign_employe" class="btn btn-info btn-custom text-white">
        <i class="fas fa-building"></i> Assigner à un Entrepôt
    </a>
</div>

<!-- Formulaire d'édition (si un utilisateur est en cours de modification) -->
<?php if ($editingUser): ?>
    <div class="enhanced-card mb-4">
        <div class="card-header bg-primary text-white">
            <i class="fas fa-edit"></i> Modifier l'employé : <strong><?= htmlspecialchars($editingUser['name']) ?></strong>
        </div>
        <div class="card-body">
            <form method="POST" class="enhanced-form row g-3">
                <input type="hidden" name="step" value="2">
                <input type="hidden" name="id" value="<?= htmlspecialchars($editingUser['id']) ?>">

                <div class="col-md-4">
                    <label class="form-label"><i class="fas fa-user"></i> Nom</label>
                    <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($editingUser['name']) ?>" required>
                </div>

                <div class="col-md-4">
                    <label class="form-label"><i class="fas fa-envelope"></i> Email</label>
                    <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($editingUser['email']) ?>" required>
                </div>

                <div class="col-md-4">
                    <label class="form-label"><i class="fas fa-user-tag"></i> Rôle</label>
                    <select name="role" class="form-select">
                        <option value="admin" <?= $editingUser['role'] === 'admin' ? 'selected' : '' ?>>
                            Administrateur
                        </option>
                        <option value="employee" <?= $editingUser['role'] === 'employee' ? 'selected' : '' ?>>
                            Employé
                        </option>
                    </select>
                </div>

                <div class="col-12">
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-save"></i> Enregistrer
                    </button>
                    <button type="button" class="btn btn-secondary" onclick="window.location.href = '?page=employe';">
                        <i class="fas fa-times"></i> Annuler
                    </button>
                </div>
            </form>

            <hr class="my-4">

            <form method="POST" class="d-inline delete-user-form">
                <input type="hidden" name="step-user-delete" value="delete">
                <input type="hidden" name="id" value="<?= htmlspecialchars($editingUser['id']) ?>">
                <button type="submit" class="btn btn-danger">
                    <i class="fas fa-trash-alt"></i> Supprimer cet employé
                </button>
            </form>
        </div>
    </div>
<?php endif; ?>

<!-- Tableau des employés -->
<div class="enhanced-card">
    <div class="card-header bg-white">
        <h5 class="mb-0"><i class="fas fa-table"></i> Tous les Employés</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table id="userTable" class="table enhanced-table table-hover">
                <thead>
                    <tr>
                        <th><i class="fas fa-hashtag"></i> ID</th>
                        <th><i class="fas fa-user"></i> Nom</th>
                        <th><i class="fas fa-envelope"></i> Email</th>
                        <th><i class="fas fa-user-tag"></i> Rôle</th>
                        <th><i class="fas fa-cog"></i> Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user): ?>
                    <tr>
                        <td><span class="badge bg-secondary"><?= htmlspecialchars($user['id']) ?></span></td>
                        <td>
                            <div class="icon-text">
                                <?php if ($user['role'] === 'admin'): ?>
                                    <i class="fas fa-user-shield text-primary"></i>
                                <?php else: ?>
                                    <i class="fas fa-user-tie text-info"></i>
                                <?php endif; ?>
                                <strong><?= htmlspecialchars($user['name']) ?></strong>
                            </div>
                        </td>
                        <td><a href="mailto:<?= htmlspecialchars($user['email']) ?>"><?= htmlspecialchars($user['email']) ?></a></td>
                        <td>
                            <?php if ($user['role'] === 'admin'): ?>
                                <span class="badge bg-primary custom-badge">
                                    <i class="fas fa-shield-alt"></i> Administrateur
                                </span>
                            <?php else: ?>
                                <span class="badge bg-info custom-badge">
                                    <i class="fas fa-user"></i> Employé
                                </span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <form method="POST" style="display:inline;">
                                <input type="hidden" name="step" value="1">
                                <input type="hidden" name="id" value="<?= htmlspecialchars($user['id']) ?>">
                                <button type="submit" class="btn btn-sm btn-outline-primary" title="Modifier">
                                    <i class="fas fa-edit"></i> Modifier
                                </button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

<!-- DataTables Initialization -->
<script>
  $(document).ready(function() {
    $('#userTable').DataTable({
        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/fr-FR.json'
        },
        order: [[0, 'desc']],
        pageLength: 25
    });
  });
</script>

<!-- SweetAlert messages -->
<?php if ($delete_user_alert): ?>
<script>
Swal.fire({
    icon: 'success',
    title: 'Utilisateur supprimé avec succès',
    toast: true,
    position: 'top-end',
    timer: 3000,
    timerProgressBar: true,
    showConfirmButton: false
});
</script>
<?php endif; ?>

<script>
// Gestion de la confirmation de suppression d'un utilisateur
const form = document.querySelector('.delete-user-form');
if (form) {
    form.addEventListener('submit', function(e) {
        e.preventDefault();

        Swal.fire({
            title: 'Êtes-vous sûr ?',
            text: "Cette action supprimera l'utilisateur de façon permanente.",
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
