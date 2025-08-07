<body class="bg-light">

<div class="container py-4">

    <?php if (!empty($errors)): ?>
        <div class="alert alert-danger">
            <ul>
                <?php foreach ($errors as $error): ?>
                    <li><?= htmlspecialchars($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form method="POST" class="row g-3">
        <div class="col-md-6">
            <label for="user_id" class="form-label">Employé</label>
            <select name="user_id" id="user_id" class="form-select" required>
                <option value="">-- Sélectionnez un employé --</option>
                <?php foreach ($employees_to_assign as $emp): ?>
                    <option value="<?= $emp['id'] ?>" <?= ($_POST['user_id'] ?? '') == $emp['id'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($emp['name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="col-md-6">
            <label for="warehouse_id" class="form-label">Entrepôt</label>
            <select name="warehouse_id" id="warehouse_id" class="form-select" required>
                <option value="">-- Sélectionnez un entrepôt --</option>
                <?php foreach ($warehouses as $wh): ?>
                    <option value="<?= $wh['id'] ?>" <?= ($_POST['warehouse_id'] ?? '') == $wh['id'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($wh['name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="col-12">
            <button type="submit" class="btn btn-primary">Assigner</button>
             <button type="button" class="btn btn-secondary" onclick="window.location.href='?page=assign_employe'">Annuler</button>
        </div>
    </form>
    <br><br>
    <?php if (empty($employees_already_assigned)): ?>
        <div class="alert alert-warning">Aucun lien entre un employée et un entrepôt disponible pour le moment.</div>
    <?php else: ?>
    <table id="employees_already_assign_Table" class="table table-bordered table-hover">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Nom employée</th>
                <th>Warehouse</th>
                
            </tr>
        </thead>
        <tbody>
        <?php if (empty($employees_already_assigned)): ?>
            <tr>
                <td colspan="4" class="text-center text-muted">Aucun employé assigné à un entrepôt.</td>
            </tr>
        <?php else: ?>
            <?php foreach ($employees_already_assigned as $user): ?>
            <tr>
                <td><?= htmlspecialchars($user['id']) ?></td>
                <td>   
                    <?= htmlspecialchars($user['user_name']) ?>    
                </td>
                <td><?= htmlspecialchars($user['warehouse_name']) ?></td>
                
            </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </tbody>
    </table>
    <?php endif; ?>
</div>

<?php if ($success): ?>
<script>
Swal.fire({
    icon: 'success',
    title: 'Assignation réussie',
    toast: true,
    position: 'top-end',
    timer: 2000,
    showConfirmButton: false
})
</script>

<?php endif; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<script>
  $(document).ready(function() {
    $('#employees_already_assign_Table').DataTable(); 
  });
</script>
</body>
</html>
