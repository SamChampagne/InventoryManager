<?php
/**
 * Page d'accueil du Dashboard avec statistiques et graphiques
 */

require_once __DIR__ . '/../services/dashboard-transaction.php';

// Récupération des données du dashboard
$dashboardData = getDashboardData($pdo);
$stats = $dashboardData['stats'];
$lowStockProducts = $dashboardData['low_stock'];
$topProducts = $dashboardData['top_products'];
$stockByWarehouse = $dashboardData['stock_by_warehouse'];
$transactionsByDay = $dashboardData['transactions_by_day'];

// Préparation des données pour les graphiques Chart.js
$warehouseLabels = array_map(function($w) { return $w['warehouse_name']; }, $stockByWarehouse);
$warehouseData = array_map(function($w) { return $w['total_quantity']; }, $stockByWarehouse);

$transactionDates = array_map(function($t) { return date('d/m', strtotime($t['transaction_date'])); }, $transactionsByDay);
$transactionCounts = array_map(function($t) { return $t['transaction_count']; }, $transactionsByDay);
$ajoutCounts = array_map(function($t) { return $t['ajout_count']; }, $transactionsByDay);
$transfertCounts = array_map(function($t) { return $t['transfert_count']; }, $transactionsByDay);
?>

<!-- Chart.js CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>

<style>
.stat-card {
    border-radius: 10px;
    padding: 20px;
    color: white;
    margin-bottom: 20px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    transition: transform 0.2s;
}
.stat-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
}
.stat-card h3 {
    font-size: 2.5rem;
    font-weight: bold;
    margin-bottom: 5px;
}
.stat-card p {
    font-size: 0.9rem;
    margin: 0;
    opacity: 0.9;
}
.stat-card.primary { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
.stat-card.success { background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); }
.stat-card.info { background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); }
.stat-card.warning { background: linear-gradient(135deg, #fa709a 0%, #fee140 100%); }
.stat-card.danger { background: linear-gradient(135deg, #ff6b6b 0%, #ee5a6f 100%); }
.stat-card.dark { background: linear-gradient(135deg, #868f96 0%, #596164 100%); }

.chart-container {
    position: relative;
    height: 300px;
    margin-bottom: 30px;
}

.alert-stock {
    border-left: 4px solid #dc3545;
}
</style>

<div class="container-fluid">

    <!-- Titre principal -->
    <div class="row mb-4">
        <div class="col-12">
            <h1 class="display-5">📊 Tableau de bord</h1>
            <p class="text-muted">Vue d'ensemble de votre inventaire et activités</p>
        </div>
    </div>

    <!-- Cartes de statistiques -->
    <div class="row">
        <div class="col-md-3 col-sm-6">
            <div class="stat-card primary">
                <h3><?= number_format($stats['total_products']) ?></h3>
                <p>Produits enregistrés</p>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="stat-card info">
                <h3><?= number_format($stats['total_warehouses']) ?></h3>
                <p>Entrepôts actifs</p>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="stat-card success">
                <h3><?= number_format($stats['total_stock']) ?></h3>
                <p>Unités en stock</p>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="stat-card dark">
                <h3><?= number_format($stats['total_users']) ?></h3>
                <p>Utilisateurs</p>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-3 col-sm-6">
            <div class="stat-card warning">
                <h3><?= number_format($stats['low_stock_count']) ?></h3>
                <p>⚠️ Produits en stock faible</p>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="stat-card danger">
                <h3><?= number_format($stats['out_of_stock_count']) ?></h3>
                <p>❌ Produits en rupture</p>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="stat-card info">
                <h3><?= number_format($stats['today_transactions']) ?></h3>
                <p>Transactions aujourd'hui</p>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="stat-card success">
                <h3><?= number_format($stats['week_transactions']) ?></h3>
                <p>Transactions cette semaine</p>
            </div>
        </div>
    </div>

    <!-- Graphiques -->
    <div class="row mt-4">
        <!-- Graphique des transactions -->
        <div class="col-lg-6 col-md-12">
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0">📈 Transactions des 7 derniers jours</h5>
                </div>
                <div class="card-body">
                    <div class="chart-container">
                        <canvas id="transactionsChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Graphique du stock par entrepôt -->
        <div class="col-lg-6 col-md-12">
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0">🏢 Stock par entrepôt</h5>
                </div>
                <div class="card-body">
                    <div class="chart-container">
                        <canvas id="warehouseChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Alertes et Top produits -->
    <div class="row mt-4">
        <!-- Alertes de stock faible -->
        <div class="col-lg-6 col-md-12">
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0">⚠️ Alertes de stock faible</h5>
                </div>
                <div class="card-body" style="max-height: 400px; overflow-y: auto;">
                    <?php if (empty($lowStockProducts)): ?>
                        <div class="alert alert-success">
                            ✅ Aucun produit en stock faible
                        </div>
                    <?php else: ?>
                        <div class="list-group">
                            <?php foreach ($lowStockProducts as $product): ?>
                                <div class="list-group-item alert-stock">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h6 class="mb-1"><?= htmlspecialchars($product['product_name']) ?></h6>
                                        <small class="text-danger">
                                            <strong><?= $product['quantity'] ?> unités</strong>
                                        </small>
                                    </div>
                                    <p class="mb-1">
                                        <small class="text-muted">
                                            📍 <?= htmlspecialchars($product['warehouse_name']) ?>
                                            <?php if ($product['type']): ?>
                                                | Type: <?= htmlspecialchars($product['type']) ?>
                                            <?php endif; ?>
                                        </small>
                                    </p>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Top produits les plus mouvementés -->
        <div class="col-lg-6 col-md-12">
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0">🔥 Top 10 produits mouvementés (30 jours)</h5>
                </div>
                <div class="card-body" style="max-height: 400px; overflow-y: auto;">
                    <?php if (empty($topProducts)): ?>
                        <div class="alert alert-info">
                            ℹ️ Aucune transaction récente
                        </div>
                    <?php else: ?>
                        <div class="list-group">
                            <?php foreach ($topProducts as $index => $product): ?>
                                <div class="list-group-item">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h6 class="mb-1">
                                            <span class="badge bg-primary">#<?= $index + 1 ?></span>
                                            <?= htmlspecialchars($product['product_name']) ?>
                                        </h6>
                                        <small class="text-primary">
                                            <strong><?= $product['transaction_count'] ?> transactions</strong>
                                        </small>
                                    </div>
                                    <p class="mb-1">
                                        <small class="text-muted">
                                            <?php if ($product['type']): ?>
                                                Type: <?= htmlspecialchars($product['type']) ?> |
                                            <?php endif; ?>
                                            Total déplacé: <?= number_format($product['total_quantity_moved']) ?> unités
                                        </small>
                                    </p>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Tableau des entrepôts -->
    <div class="row mt-4 mb-5">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0">📦 Vue d'ensemble des entrepôts</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Entrepôt</th>
                                    <th>Localisation</th>
                                    <th>Produits différents</th>
                                    <th>Stock total</th>
                                    <th>Statut</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($stockByWarehouse as $warehouse): ?>
                                    <tr>
                                        <td><strong><?= htmlspecialchars($warehouse['warehouse_name']) ?></strong></td>
                                        <td><?= htmlspecialchars($warehouse['location'] ?? 'Non spécifié') ?></td>
                                        <td><?= number_format($warehouse['product_count']) ?></td>
                                        <td><strong><?= number_format($warehouse['total_quantity']) ?></strong> unités</td>
                                        <td>
                                            <?php if ($warehouse['total_quantity'] > 0): ?>
                                                <span class="badge bg-success">Actif</span>
                                            <?php else: ?>
                                                <span class="badge bg-secondary">Vide</span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<script>
// Configuration Chart.js
Chart.defaults.font.family = 'Arial, sans-serif';

// Graphique des transactions par jour
const ctxTransactions = document.getElementById('transactionsChart');
if (ctxTransactions) {
    new Chart(ctxTransactions, {
        type: 'line',
        data: {
            labels: <?= json_encode($transactionDates) ?>,
            datasets: [
                {
                    label: 'Total transactions',
                    data: <?= json_encode($transactionCounts) ?>,
                    borderColor: 'rgb(75, 192, 192)',
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    tension: 0.4,
                    fill: true
                },
                {
                    label: 'Ajouts',
                    data: <?= json_encode($ajoutCounts) ?>,
                    borderColor: 'rgb(54, 162, 235)',
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    tension: 0.4
                },
                {
                    label: 'Transferts',
                    data: <?= json_encode($transfertCounts) ?>,
                    borderColor: 'rgb(255, 159, 64)',
                    backgroundColor: 'rgba(255, 159, 64, 0.2)',
                    tension: 0.4
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'top',
                },
                title: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            }
        }
    });
}

// Graphique du stock par entrepôt
const ctxWarehouse = document.getElementById('warehouseChart');
if (ctxWarehouse) {
    new Chart(ctxWarehouse, {
        type: 'bar',
        data: {
            labels: <?= json_encode($warehouseLabels) ?>,
            datasets: [{
                label: 'Stock total',
                data: <?= json_encode($warehouseData) ?>,
                backgroundColor: [
                    'rgba(255, 99, 132, 0.7)',
                    'rgba(54, 162, 235, 0.7)',
                    'rgba(255, 206, 86, 0.7)',
                    'rgba(75, 192, 192, 0.7)',
                    'rgba(153, 102, 255, 0.7)',
                    'rgba(255, 159, 64, 0.7)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)'
                ],
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
}
</script>
