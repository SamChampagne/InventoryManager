<?php
/**
 * Dashboard - Page principale de l'application
 *
 * Cette application est structurée comme une Single Page Application (SPA) en PHP.
 * Toute la logique de navigation, d’affichage et de traitement des données est gérée
 * à partir de ce seul fichier PHP principal.
 *
 * Les différentes sections (produits, entrepôts, employés, historique, etc.)
 * sont affichées dynamiquement dans la même page en fonction de la valeur
 * des variables $_GET['page'] et $_POST['step'].
 *
 * Aucune autre page HTML n’est appelée directement. Les actions utilisateurs
 * (affichage, ajout, modification, suppression) déclenchent des changements d’état
 * côté serveur, puis le bon contenu est généré et affiché dans cette même page.
 *
 */

session_start();

/** Déclaration des services pour chaque page que j'utilise */ 
require_once __DIR__ . '/../config/dbConfig.php';
require_once __DIR__ . '/../services/createUser-transaction.php';
require_once __DIR__ . '/../services/getAllUser-transaction.php';
require_once __DIR__ . '/../services/getAllWarehouses-transaction.php';
require_once __DIR__ . '/../services/createWarehouses-transaction.php';
require_once __DIR__ . '/../services/getAllProduct-transaction.php';
require_once __DIR__ . '/../services/createProduct-transaction.php';
require_once __DIR__ . '/../services/assignUserToWarehouses-transaction.php';
require_once __DIR__ . '/../services/listeInventoryToUser-transaction.php';
require_once __DIR__ . '/../services/createProductInInventory-transaction.php';
require_once __DIR__ . '/../services/listeHistoryInventory-transaction.php';


// Vérifie si utilisateur est connecté, le fait une fois, car on reste sur du single page qui est la dashboard.
if (!isset($_SESSION['user_id'])) {
    header('Location: ../index.php');
    exit;
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <title>Dashboard - admin</title>
    <link rel="stylesheet" href="../css/dashboard.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
</head>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<body>

<nav class="sidebar" style="max-height: 100vh; overflow-y: auto;">

    <div style="padding: 20px; font-size: 12px; font-weight: bold; color: #ecf0f1; border-bottom: 1px solid #7f8c8d;">
        <a href="?page=information" style="text-decoration: none;">
        Bienvenue, <?= htmlspecialchars($_SESSION['user_name']) ?>
        </a>
    </div>
    

    <?php if ($_SESSION['role'] === 'admin'): ?>
        <!-- EMPLOYÉ -->
        <div class="menu-section">
            <div class="menu-toggle">Employé ▸</div>
            <div class="submenu">
                <a href="?page=employe" class="<?= ($_GET['page'] ?? '') === 'employe' ? 'active' : '' ?>">Liste Employé</a>
                <a href="?page=add_employe" class="<?= ($_GET['page'] ?? '') === 'add_employe' ? 'active' : '' ?>">Créer Employé</a>
                <a href="?page=assign_employe" class="<?= ($_GET['page'] ?? '') === 'assign_employe' ? 'active' : '' ?>">Assigner Employé</a>
            </div>
        </div>

        <!-- ENTREPÔT -->
        <div class="menu-section">
            <div class="menu-toggle">Entrepôt ▸</div>
            <div class="submenu">
                <!-- LISTER ENTREPÔTS -->
                <a href="?page=liste_warehouse" class="<?= ($_GET['page'] ?? '') === 'liste_warehouse' ? 'active' : '' ?>">Lister Entrepôt</a>
                <a href="?page=add_warehouse" class="<?= ($_GET['page'] ?? '') === 'add_warehouse' ? 'active' : '' ?>">Créer Entrepôt</a>
            </div>
        </div>

        <!-- PRODUIT -->
        <div class="menu-section">
            <div class="menu-toggle">Produit ▸</div>
            <div class="submenu">
                <!-- LISTER PRODUITS -->
                <a href="?page=liste_product" class="<?= ($_GET['page'] ?? '') === 'liste_product' ? 'active' : '' ?>">Lister Produit</a>
                <a href="?page=add_product" class="<?= ($_GET['page'] ?? '') === 'add_product' ? 'active' : '' ?>">Ajouter Produit</a>
            </div>
        </div>
        <!-- Inventaire -->
        <div class="menu-section">
            <div class="menu-toggle">Inventaire ▸</div>
            <div class="submenu">
                <!-- LISTER PRODUITS -->
                <a href="?page=inventaire_warehouse" class="<?= ($_GET['page'] ?? '') === 'inventaire_warehouse' ? 'active' : '' ?>">Inventaire/Entrepôt</a>
                <a href="?page=add_to_inventory" class="<?= ($_GET['page'] ?? '') === 'add_to_inventory' ? 'active' : '' ?>">Ajouter dans un inventaire</a>
                <a href="?page=historique_inventaire" class="<?= ($_GET['page'] ?? '') === 'historique_inventaire' ? 'active' : '' ?>">Historique d'inventaire</a>
            </div>
        </div>
    <?php endif; ?>

    <!-- Liste pour les employés -->
    <?php if($_SESSION['role'] === 'employee'): ?>
        <div class="menu-section">
            <div class="menu-toggle">Inventaire ▸</div>
            <div class="submenu">
                <!-- LISTER PRODUITS -->
                <a href="?page=inventaire_warehouse" class="<?= ($_GET['page'] ?? '') === 'inventaire_warehouse' ? 'active' : '' ?>">Inventaire/Entrepôt</a>
                <a href="?page=add_to_inventory" class="<?= ($_GET['page'] ?? '') === 'add_to_inventory' ? 'active' : '' ?>">Ajouter dans un inventaire</a>
            </div>
        </div>
    <?php endif; ?>

    <a href="./logout.php" style="margin-top:auto; color:#e74c3c; padding: 15px 20px; border-left:none;">Déconnexion</a>
</nav>


<main>
    
<?php
// Page par défaut
$page = $_GET['page'] ?? 'information';

/* * Gestion des pages
 * Chaque case du switch correspond à une page différente de l'application.
 * Le contenu de chaque page est inclus dynamiquement en fonction de la valeur de $_GET['page'].
 */
switch ($page) {
    case 'add_warehouse':
        if ($_SESSION['role'] !== 'admin') { echo "Accès refusé."; break; }
        echo "<h2>Créer un Entrepôt</h2>";
        require_once __DIR__ . '/./warehouses/create_Warehouses.php'; // Formulaire de création d'entrepôt
        break;

    case 'add_product':
        if ($_SESSION['role'] !== 'admin') { echo "Accès refusé."; break; }
        echo "<h2>Ajouter un Produit</h2>";
        require_once __DIR__ . '/./products/create_Product.php'; // Formulaire de création de produit
        break;

    case 'add_employe':
        if ($_SESSION['role'] !== 'admin') { echo "Accès refusé."; break; }
        echo "<h2>Créer un Employé</h2>";
        require_once __DIR__ . '/./users/create_employe.php'; // Formulaire de création d'employé
        break;

    case 'assign_employe':
        if ($_SESSION['role'] !== 'admin') { echo "Accès refusé."; break; }
        echo "<h2>Assigner un Employé à un Entrepôt</h2>";
        require_once __DIR__ . '/./users/assign_user_to_warehouse.php'; // Formulaire d'assignation d'employé
        break;

    case 'employe':
        echo "<h2>Liste des Employés</h2>";
        echo "<p>Liste des employés avec options de gestion et de modification.</p>";
        require_once __DIR__ . '/./users/liste_User.php'; // Liste des employés
        break;
    case 'liste_product':
    if ($_SESSION['role'] !== 'admin') { echo "Accès refusé."; break; }
        echo "<h2>Liste des Produits/Matières</h2>";
        require_once __DIR__ . '/./products/liste_Product.php'; // Liste des produits
        break;

    case 'liste_warehouse':
        if ($_SESSION['role'] !== 'admin') { echo "Accès refusé."; break; }
        echo "<h2>Liste des Entrepôts</h2>";
        require_once __DIR__ . '/./warehouses/liste_Warehouses.php'; // Liste des entrepôts
        break;
    case 'information':
        echo "<h2>Informations</h2>";
        require_once __DIR__ . '/./information.php'; // Page d'informations générales
        break;
    case 'inventaire_warehouse':
        echo "<h2>Inventaire des Entrepôts</h2>";
        require_once __DIR__ . '/./inventory/liste_inventory_to_user.php'; // Liste des inventaires accessible à l'utilisateur
        break;
    case 'add_to_inventory':
        echo "<h2>Ajouter un Produit à l'Inventaire</h2>";
        require_once __DIR__ . '/./inventory/create_product_in_inventory.php'; // Formulaire pour ajouter un produit à l'inventaire
        break;  
    case 'historique_inventaire':
        echo "<h2>Historique des inventaires/transactions</h2>";
        require_once __DIR__ . '/./inventory/liste_history_inventory.php'; // Liste de l'historique des transactions d'inventaire
        break;  
}
?>
</main>
</body>

<script>
// Gestion du menu latéral
document.querySelectorAll('.menu-toggle').forEach(toggle => {
    toggle.addEventListener('click', () => {
        const section = toggle.parentElement;
        section.classList.toggle('open');
    });
});

// Empêche l'utilisateur de revenir en arrière dans l'historique du navigateur
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
