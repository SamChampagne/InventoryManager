<?php

require_once '../function/createUser.php';

$errors = [];
$success_user = false;

$page = $_GET['page'] ?? 'home';

if ($page === 'add_employe' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $role = $_POST['role'] ?? 'employee';

    // Validation...
    if ($username === '') {
        $errors[] = "Le nom est obligatoire.";
    }
    if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Un email valide est obligatoire.";
    }
    if ($password === '' || strlen($password) < 6) {
        $errors[] = "Le mot de passe doit contenir au moins 6 caractères.";
    }
    if (!in_array($role, ['admin', 'employee'])) {
        $errors[] = "Rôle invalide.";
    }

    if (empty($errors)) {
        $created = createUser($username, $email, $password, $role);

        if ($created) {
            $_SESSION['createUserSuccess'] = true;
            header('Location: '.$_SERVER['PHP_SELF'].'?page=add_employe');
            exit();
        } else {
            $errors[] = "Erreur lors de la création de l'utilisateur (email peut-être déjà utilisé).";
        }
    }
}

$_SESSION['errors_create_users'] = $errors;

if (!empty($_SESSION['createUserSuccess'])) {
    $success_user = true;
    unset($_SESSION['createUserSuccess']);
}
?>