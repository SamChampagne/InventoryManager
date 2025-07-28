<?php
session_start();

include_once '../services/createUser-transaction.php';

// Empêcher le cache navigateur
header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1
header("Pragma: no-cache"); // HTTP 1.0
header("Expires: 0"); // Proxies

// Vérifie si utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    header('Location: ../index.php');
    exit;
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <title>Dashboard</title>
    <link rel="stylesheet" href="../css/dashboard.css" />
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
</head>
<body>

<nav>
    <div style="padding: 20px; font-size: 16px; font-weight: bold; color: #ecf0f1; border-bottom: 1px solid #7f8c8d;">
    Bienvenue, <?= htmlspecialchars($_SESSION['user_name']) ?>
    </div>

    <?php if ($_SESSION['role'] === 'admin'): ?>
        <!-- EMPLOYÉ -->
        <div class="menu-section">
            <div class="menu-toggle">Employé ▸</div>
            <div class="submenu">
                <a href="?page=employe" class="<?= ($_GET['page'] ?? '') === 'employe' ? 'active' : '' ?>">Liste Employés</a>
                <a href="?page=add_employe" class="<?= ($_GET['page'] ?? '') === 'add_employe' ? 'active' : '' ?>">Créer Employé</a>
                <a href="?page=assign_employe" class="<?= ($_GET['page'] ?? '') === 'assign_employe' ? 'active' : '' ?>">Assigner Employé</a>
            </div>
        </div>

        <!-- ENTREPÔT -->
        <div class="menu-section">
            <div class="menu-toggle">Entrepôt ▸</div>
            <div class="submenu">
                <a href="?page=add_warehouse" class="<?= ($_GET['page'] ?? '') === 'add_warehouse' ? 'active' : '' ?>">Créer Entrepôt</a>
            </div>
        </div>

        <!-- PRODUIT -->
        <div class="menu-section">
            <div class="menu-toggle">Produit ▸</div>
            <div class="submenu">
                <a href="?page=add_product" class="<?= ($_GET['page'] ?? '') === 'add_product' ? 'active' : '' ?>">Ajouter Produit</a>
            </div>
        </div>
    <?php endif; ?>

    <a href="./logout.php" style="margin-top:auto; color:#e74c3c; padding: 15px 20px; border-left:none;">Déconnexion</a>
</nav>


<main>
    
<?php
$page = $_GET['page'] ?? 'warehouse';

switch ($page) {
    case 'add_warehouse':
        if ($_SESSION['role'] !== 'admin') { echo "Accès refusé."; break; }
        echo "<h2>Créer un Entrepôt</h2>";
        // form ici
        break;

    case 'add_product':
        if ($_SESSION['role'] !== 'admin') { echo "Accès refusé."; break; }
        echo "<h2>Ajouter un Produit</h2>";
        // form ici
        break;

    case 'add_employe':
        if ($_SESSION['role'] !== 'admin') { echo "Accès refusé."; break; }
        echo "<h2>Créer un Employé</h2>";
        include_once './create_employe.php'; // Formulaire de création d'employé
        break;

    case 'assign_employe':
        if ($_SESSION['role'] !== 'admin') { echo "Accès refusé."; break; }
        echo "<h2>Assigner un Employé à un Entrepôt</h2>";
        // interface d’assignation
        break;

    case 'employe':
        echo "<h2>Liste des Employés</h2>";
        echo "<p>Liste des employés avec options de gestion et de modification.</p>";
        include_once './liste_User.php';
        break;

    case 'produit':
        echo "<h2>Section Produit</h2>";
        break;

    case 'warehouse':
    default:
        echo "<h2>Section Warehouse</h2>";
        break;
}
?>

</main>

</body>

<script>
    
document.querySelectorAll('.menu-toggle').forEach(toggle => {
    toggle.addEventListener('click', () => {
        const section = toggle.parentElement;
        section.classList.toggle('open');
    });
});

window.history.forward();
function noBack() {
    window.history.forward();
}
window.onload = noBack;
window.onpageshow = function(evt) {
    if (evt.persisted) noBack();
};
window.onunload = function() {};
</script>


</html>
