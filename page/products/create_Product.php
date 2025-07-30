<body class="bg-light">

<div class="container py-4">
    <?php 
    if (!empty($_SESSION['errors_create_product']) && is_array($_SESSION['errors_create_product'])): ?>
        <div class="alert alert-danger">
            <ul>
                <?php foreach ($_SESSION['errors_create_product'] as $error): ?>
                    <li><?= htmlspecialchars($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>
    
    <?php if ($importProduct): ?>
    <div class="alert alert-info">
        Importation de produits depuis un fichier CSV. Exemple de fichier : <a href="products/exemple/produits_chimiques_100.csv" download target="_blank">example-products.csv</a>
    </div>

    <form action="" method="POST" enctype="multipart/form-data" id="uploadForm">
        <input type="hidden" name="step-import" value="2" />
        
        <div id="dropZone" 
             style="border: 2px dashed #ccc; padding: 40px; text-align: center; cursor: pointer;">
            Glisse-dépose ton fichier CSV ici<br>ou clique pour sélectionner un fichier.
            <input type="file" name="csvFile" id="fileInput" style="display:none;" accept=".csv" />
        </div>
        <br>
        <div class="col-12">
            <button type="submit" class="btn btn-primary">Importer</button>
            <button type="button" class="btn btn-secondary" onclick="window.location.href='?page=add_product'">Annuler</button>
        </div>
        <div id="fileInfo" style="margin-top: 15px; font-style: italic; color: #555;"></div>

    </form>


    <?php else :  ?>
    <div class="card mb-4">
        <div class="card-header bg-primary text-white">
            Créer un Nouveau Produit
        </div>

        <div class="card-body">
            <form method="POST" class="row g-3" novalidate>
                <input type="hidden" name="step" value="add">

                <div class="col-md-6">
                    <label for="name" class="form-label">Nom du produit</label>
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
                    <label for="type" class="form-label">Type</label>
                    <input
                        type="text"
                        id="type"
                        name="type"
                        class="form-control"
                        required
                        value="<?= htmlspecialchars($_POST['type'] ?? '') ?>"
                    >
                </div>

                <div class="col-12">
                    <label for="description" class="form-label">Description</label>
                    <textarea
                        id="description"
                        name="description"
                        class="form-control"
                        rows="3"
                        required
                    ><?= htmlspecialchars($_POST['description'] ?? '') ?></textarea>
                </div>

                <div class="col-12">
                    <button type="submit" class="btn btn-success">Créer le produit</button>
                    
                    <button type="button" class="btn btn-secondary" onclick="window.location.href='?page=add_product'">Annuler</button>
                </div>
            </form><br>
            <form method="post" enctype="multipart/form-data">
                <input type="hidden" name="step-import" value="import">
                <button type="submit" class="btn btn-primary" >importer</button>
            </form>
        </div>
    </div>
    <?php endif; ?>
</div>

<!-- SweetAlert messages -->
<?php if (!empty($success_product)): ?>
<script>
Swal.fire({
    icon: 'success',
    title: 'Produit créé avec succès.',
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
<script>
// Script pour la zone de dépôt de fichier
const dropZone = document.getElementById('dropZone');
const fileInput = document.getElementById('fileInput');

dropZone.addEventListener('click', () => fileInput.click());

dropZone.addEventListener('dragover', (e) => {
    e.preventDefault();
    dropZone.style.backgroundColor = '#eef';
    dropZone.style.borderColor = '#00f';
});

dropZone.addEventListener('dragleave', (e) => {
    e.preventDefault();
    dropZone.style.backgroundColor = '';
    dropZone.style.borderColor = '#ccc';
});

dropZone.addEventListener('drop', (e) => {
    e.preventDefault();
    dropZone.style.backgroundColor = '';
    dropZone.style.borderColor = '#ccc';

    if (e.dataTransfer.files.length) {
        fileInput.files = e.dataTransfer.files;
    }
});

const fileInfo = document.getElementById('fileInfo');

function updateFileInfo() {

    // Récupère le fichier et l'affiche dans la zone d'information
    if (fileInput.files.length > 0) {
        const file = fileInput.files[0];
        fileInfo.textContent = `Fichier sélectionné : ${file.name} (${Math.round(file.size / 1024)} Ko)`;
    } else {
        fileInfo.textContent = '';
    }
}

// Observe les changements du champ de fichier
fileInput.addEventListener('change', updateFileInfo);

// Et aussi dans drop event, pour que ça s'update au drag & drop
dropZone.addEventListener('drop', (e) => {
    e.preventDefault();
    dropZone.style.backgroundColor = '';
    dropZone.style.borderColor = '#ccc';

    if (e.dataTransfer.files.length) {
        fileInput.files = e.dataTransfer.files;
        updateFileInfo();
    }
});

    </script>
</body>
</html>
