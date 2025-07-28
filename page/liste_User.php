<?php
require_once '../config/dbConfig.php';
require_once '../function/getAllUsers.php';

$db = new Database();
$conn = $db->getConnection();

$editingUser = null;

// Étape 2 : enregistrer les modifications
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['step']) && $_POST['step'] == 2) {
    $id = (int)$_POST['id'];
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $role = $_POST['role'];

    $stmt = $conn->prepare("UPDATE users SET name = ?, email = ?, role = ? WHERE id = ?");
    $stmt->bind_param("sssi", $name, $email, $role, $id);
    $stmt->execute();
}

// Étape 1 : afficher le formulaire d'édition
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['step']) && $_POST['step'] == 1) {
    $id = (int)$_POST['id'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $editingUser = $result->fetch_assoc();
}

$users = getAllUsers();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des utilisateurs</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
</head>
<body class="bg-light">

<div class="container mt-5">
    <?php if ($editingUser): ?>
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                Modifier l'utilisateur : <?= htmlspecialchars($editingUser['name']) ?>
            </div>
            <div class="card-body">
                <form method="POST" class="row g-3">
                    <input type="hidden" name="step" value="2">
                    <input type="hidden" name="id" value="<?= htmlspecialchars($editingUser['id']) ?>">
                    
                    <div class="col-md-4">
                        <label class="form-label">Nom</label>
                        <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($editingUser['name']) ?>" required>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($editingUser['email']) ?>" required>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Rôle</label>
                        <select name="role" class="form-select">
                            <option value="admin" <?= $editingUser['role'] === 'admin' ? 'selected' : '' ?>>Admin</option>
                            <option value="employee" <?= $editingUser['role'] === 'employee' ? 'selected' : '' ?>>Employé</option>
                        </select>
                    </div>

                    <div class="col-12">
                        <button type="submit" class="btn btn-success">Enregistrer</button>
                        <button type="button" class="btn btn-secondary" onclick="window.location.href = window.location.href;">Annuler</button>
                    </div>
                </form>
            </div>
        </div>
    <?php endif; ?>

    <table class="table table-bordered table-hover">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Email</th>
                <th>Rôle</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user): ?>
            <tr>
                <td><?= htmlspecialchars($user['id']) ?></td>
                <td>
                    <form method="POST" style="display:inline;">
                        <input type="hidden" name="step" value="1">
                        <input type="hidden" name="id" value="<?= htmlspecialchars($user['id']) ?>">
                        <button type="submit" class="btn btn-link p-0 m-0 align-baseline text-decoration-none">
                            <?= htmlspecialchars($user['name']) ?>
                        </button>
                    </form>
                </td>
                <td><?= htmlspecialchars($user['email']) ?></td>
                <td><?= htmlspecialchars($user['role']) ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

</body>
<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- jQuery + DataTables JS -->
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

<script>
  $(document).ready(function() {
    $('#userTable').DataTable();
  });
</script>
</html>
