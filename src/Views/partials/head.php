<?php
if (session_status() == PHP_SESSION_NONE) session_start();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>FitGym Nutrition</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://kit.fontawesome.com/f5a1d28d53.js" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="/public/style/style.css">
  <link rel="shortcut icon" href="/public/img/logo.png" type="image/x-icon">
</head>

<body>
  <nav class="navbar">
    <div class="navbar-container">
      <div class="logo">
        <a href="/"><img src="/public/img/logo.png" alt="Logo"></a>
      </div>
      <ul class="nav-links">
        <li><a class="nav-link" href="/">Accueil</a></li>
        <li><a class="nav-link" href="/products">Produits</a></li>
        <li><a class="nav-link" href="/about">À propos</a></li>
        <li><a class="nav-link" href="/contact">Contact</a></li>
      </ul>
      <ul class="nav-icons">
        <li><a class="nav-icon" href="/search"><i class="fa-solid fa-search"></i></a></li>
        <li><a class="nav-icon" href="/cart"><i class="fa-solid fa-cart-shopping"></i></a></li>

        <?php if (!isset($_SESSION['user'])) : ?>
          <li><a class="nav-icon" href="/register"><i class="fa-solid fa-user-plus"></i> S'inscrire</a></li>
          <li><a class="nav-icon" href="/login"><i class="fa-solid fa-user"></i> Se connecter</a></li>
        <?php else : ?>
          <?php
          $prenom = $_SESSION['user']['firstName'] ?? 'Utilisateur';
          $idRole = $_SESSION['user']['idRole'] ?? null;
          ?>
          <li><span class="nav-text">Bienvenue <?= htmlspecialchars($prenom); ?></span></li>
          <?php if ($idRole == 1) : ?>
            <li><a class="nav-icon" href="/admin"><i class="fa-solid fa-chart-line"></i> Admin</a></li>
          <?php endif; ?>
          <li><a class="nav-icon" href="/logout"><i class="fa-solid fa-sign-out-alt"></i> Se déconnecter</a></li>
        <?php endif; ?>
      </ul>
    </div>
  </nav>

  <?php if (isset($_SESSION['user']) && $idRole == 1) : ?>
    <nav class="admin-menu">
      <ul class="nav-icons">
        <li><a class="nav-icon" href="/createProduct"><i class="fa-solid fa-plus"></i> Créer un article</a></li>
      </ul>
    </nav>
  <?php endif; ?>
</body>
</html>
