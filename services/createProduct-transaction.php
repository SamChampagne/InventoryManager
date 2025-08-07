<?php

require_once __DIR__ . '/../function/createProduct.php'; 

$errors = [];
$success_product = false;
$importProduct = false;
$page = $_GET['page'] ?? 'home';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['step-import']) && $_POST['step-import'] === '2') {

    // Gestion de l'import CSV
    if (isset($_FILES['csvFile']) && $_FILES['csvFile']['error'] === UPLOAD_ERR_OK) {
        $fileTmp = $_FILES['csvFile']['tmp_name'];
        $fileName = $_FILES['csvFile']['name'];

        // Vérification extension
        $ext = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        if ($ext !== 'csv') {
            $errors[] = "Le fichier doit être au format CSV.";
        } else {
            // ouverture du fichier
            $handle = fopen($fileTmp, 'r');
            if (!$handle) {
                $errors[] = "Impossible d'ouvrir le fichier.";
            } else {
                $lineNumber = 0;
                $insertCount = 0;
                while (($data = fgetcsv($handle, 1000, ",")) !== false) { 
                    $lineNumber++;

                    // la première ligne est l'en-tête
                    // récupère la première ligne pour vérifier les colonnes
                    if ($lineNumber == 1) {
                        $header = array_map('strtolower', $data);

                        if (in_array('name', $header) && in_array('type', $header) && in_array('description', $header)) {
                            continue; 
                        }
                    }

                    // Normalement $data est un tableau des colonnes
                    // Exemple pour 3 colonnes : name,type,description
                    if (count($data) < 3) {
                        $errors[] = "Ligne $lineNumber invalide (colonnes manquantes).";
                        continue;
                    }

                    $name = trim($data[0]);
                    $type = trim($data[1]);
                    $description = trim($data[2]);

                    // Validation simple si les champs sont vides
                    if ($name === '' || $type === '' || $description === '') {
                        $errors[] = "Ligne $lineNumber contient des champs vides obligatoires.";
                        continue;
                    }

                    // Insert produit
                    $created = createProduct($name, $description, $type);
                    if (!$created) {
                        $errors[] = "Erreur insertion ligne $lineNumber : produit non créé (peut-être déjà existant).";
                    } else {
                        $insertCount++;
                    }
                }
                fclose($handle);

                if ($insertCount > 0) {
                    $success_product = true;
                    $_SESSION['createProductSuccess'] = true;
                    $_SESSION['success_message'] = "$insertCount produit(s) importé(s) avec succès.";
                } else {
                    if (empty($errors)) {
                        $errors[] = "Aucun produit importé.";
                    }
                }
            }
        }
    } else {
        $errors[] = "Aucun fichier reçu ou erreur d'upload.";
    }
}
if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['step-import']) && $_POST['step-import'] === 'import') {

    $importProduct = true;

}
    // Si pas d'erreur, insertion
if ($page === 'add_product' && $_SERVER['REQUEST_METHOD'] === 'POST' && !isset($_POST['step-import'])) {

    $name = trim($_POST['name'] ?? '');
    $type = trim($_POST['type'] ?? '');
    $description = trim($_POST['description'] ?? '');

    // Validation
    if ($name === '') {
        $errors[] = "Le nom du produit est obligatoire.";
    }
    if ($type === '') {
        $errors[] = "Le type du produit est obligatoire.";
    }
    if ($description === '') {
        $errors[] = "La description est obligatoire.";
    }

    // Si pas d'erreur, insertion
    if (empty($errors)) {
        $created = createProduct($name, $description, $type);

        if ($created) {
            $_SESSION['createProductSuccess'] = true;
            header('Location: '.$_SERVER['PHP_SELF'].'?page=add_product');
            exit();
        } else {
            $errors[] = "Erreur lors de la création du produit (nom peut-être déjà utilisé).";
        }
    }
}

$_SESSION['errors_create_product'] = $errors;

if (!empty($_SESSION['createProductSuccess'])) {
    $success_product = true;
    unset($_SESSION['createProductSuccess']);
}
?>
