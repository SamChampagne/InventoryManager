<?php 
require_once './config/dbConfig.php';

session_start();
    
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Connexion - Inventory Manager</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="./css/index.css">
</head>
<body class="d-flex align-items-center justify-content-center" style="height: 100vh;">

  <div class="card shadow-sm p-4" style="width: 100%; max-width: 400px;">
    <h2 class="text-center mb-4"> Connexion - Inventory Manager</h2>
    <?php if (isset($_SESSION['error'])): ?>
      <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fermer"></button>
      </div>
    <?php endif; ?>

    <form method="POST" action="./services/login-transaction.php">
      <div class="mb-3">
        <label for="email" class="form-label">Adresse e-mail</label>
        <input type="email" class="form-control" id="email" name="email" required
               placeholder="ex. utilisateur@example.com"
               oninvalid="this.setCustomValidity('Veuillez entrer votre adresse e-mail.')"
               oninput="this.setCustomValidity('')">
      </div>

      <div class="mb-3">
        <label for="password" class="form-label">Mot de passe</label>
        <input type="password" class="form-control" id="password" name="password" required
               placeholder="Votre mot de passe"
               oninvalid="this.setCustomValidity('Le mot de passe est obligatoire.')"
               oninput="this.setCustomValidity('')">
        <div class="mt-2 text-end">
          <a href="./page/reset-password.php" class="small text-decoration-none text-primary">Mot de passe oublié ?</a>
        </div>
      </div>

      <button type="submit" class="btn btn-primary w-100">Se connecter</button>
    </form>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
