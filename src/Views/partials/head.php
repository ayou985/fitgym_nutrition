<?php
// Démarrage de la session si elle n'est pas déjà active
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// La variable magique pour corriger les chemins (Local vs En ligne)
$baseUrl = ($_SERVER['SERVER_NAME'] === 'localhost' || $_SERVER['SERVER_NAME'] === '127.0.0.1') ? '/fitgym_nutrition-main' : '';

// Préparation de l'avatar utilisateur
$userAvatar = $baseUrl . '/public/img/profile-user.png'; // Image par défaut
if (isset($_SESSION['user']) && !empty($_SESSION['user']['profile_image'])) {
    $userAvatar = $baseUrl . '/public/uploads/' . htmlspecialchars($_SESSION['user']['profile_image']);
}
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
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  
  <link rel="stylesheet" href="<?= $baseUrl ?>/public/style/style.css">
  <link rel="shortcut icon" href="<?= $baseUrl ?>/public/img/logo.png" type="image/x-icon">
</head>

<body>
  <nav class="navbar">
    <div class="navbar-container">
      <div class="logo">
        <a href="<?= $baseUrl ?>/"><img src="<?= $baseUrl ?>/public/img/logo.png" alt="Logo"></a>
      </div>

      <button class="mobile-menu-toggle" id="hamburger">
        <i class="fas fa-bars"></i>
      </button>
      
      <ul class="nav-links" id="mobileMenu">
        <li><a class="nav-link" href="<?= $baseUrl ?>/">Accueil</a></li>
        <li><a class="nav-link" href="<?= $baseUrl ?>/products">Produits</a></li>
        <li><a class="nav-link" href="<?= $baseUrl ?>/about">À propos</a></li>
        <li><a class="nav-link" href="<?= $baseUrl ?>/contact">Contact</a></li>
        
        <?php if (isset($_SESSION['user'])): ?>
          <li class="nav-item">
            <a href="<?= $baseUrl ?>/profile" class="nav-link d-flex align-items-center gap-2" title="Mon Profil" style="padding: 0 10px;">
              <img src="<?= $userAvatar ?>" alt="Profil" 
                   style="height: 40px; width: 40px; border-radius: 50%; object-fit: cover; border: 2px solid #ddd;">
              <span class="fw-semibold"><?= htmlspecialchars($_SESSION['user']['username'] ?? 'Mon Profil') ?></span>
            </a>
          </li>
          <li class="mobile-only"><a href="<?= $baseUrl ?>/logout">Se déconnecter</a></li>
        <?php else : ?>
            <li class="mobile-only"><a href="<?= $baseUrl ?>/register">S'inscrire</a></li>
            <li class="mobile-only"><a href="<?= $baseUrl ?>/login">Se connecter</a></li>
        <?php endif; ?>      
    </ul>

      <ul class="nav-icons">
        <li>
          <form action="<?= $baseUrl ?>/products" method="GET" id="search-form">
            <input type="text" name="search" placeholder="Rechercher..." id="search-input" style="display:none;" />
            <button type="button" id="search-icon">
              <i class="fa-solid fa-search"></i>
            </button>
          </form>
        </li>
        
        <li><a class="nav-icon" href="<?= $baseUrl ?>/cart"><i class="fa-solid fa-cart-shopping"></i></a></li>

        <?php if (!isset($_SESSION['user'])) : ?>
          <li><a class="nav-icon" href="<?= $baseUrl ?>/register"><i class="fa-solid fa-user-plus"></i> S'inscrire</a></li>
          <li><a class="nav-icon" href="<?= $baseUrl ?>/login"><i class="fa-solid fa-user"></i> Connexion</a></li>
        <?php else : ?>
          <?php
          $id_Role = $_SESSION['user']['id_Role'] ?? null;
          ?>

          <?php if ($id_Role == 1) : ?>
            <li><a class="nav-icon" href="<?= $baseUrl ?>/admin"><i class="fa-solid fa-user-shield"></i> Admin</a></li>
            <li><a class="nav-icon" href="<?= $baseUrl ?>/createProduct"><i class="fa-solid fa-plus-circle"></i> Produit</a></li>
          <?php endif; ?>

          <li><a class="nav-icon" href="<?= $baseUrl ?>/logout" title="Déconnexion"><i class="fa-solid fa-power-off"></i></a></li>
        <?php endif; ?>
      </ul>
    </div>
  </nav>

  <script>
    const searchIcon = document.getElementById('search-icon');
    const searchInput = document.getElementById('search-input');
    const searchForm = document.getElementById('search-form');

    searchIcon.addEventListener('click', () => {
      if (searchInput.style.display === 'none' || searchInput.style.display === '') {
        searchInput.style.display = 'block';
        searchInput.focus();
      } else if (searchInput.value !== '') {
        searchForm.submit();
      } else {
        searchInput.style.display = 'none';
      }
    });

    const toggle = document.getElementById('hamburger');
    const mobileMenu = document.getElementById('mobileMenu');

    toggle.addEventListener('click', () => {
      mobileMenu.classList.toggle('active');
    });
  </script>