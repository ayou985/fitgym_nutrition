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
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="stylesheet" href="/public/style/style.css">
  <link rel="shortcut icon" href="/public/img/logo.png" type="image/x-icon">
</head>

<body>
  <nav class="navbar">
    <div class="navbar-container">
      <div class="logo">
        <a href="/"><img src="/public/img/logo.png" alt="Logo"></a>
      </div>

      <button class="mobile-menu-toggle" id="hamburger">
        <i class="fas fa-bars"></i>
      </button>
      <ul class="nav-links" id="mobileMenu">
        <li><a class="nav-link" href="/">Accueil</a></li>
        <li><a class="nav-link" href="/products">Produits</a></li>
        <li><a class="nav-link" href="/about">À propos</a></li>
        <li><a class="nav-link" href="/contact">Contact</a></li>
        
        
        <?php if (!isset($_SESSION['user'])) : ?>
            <li><a href="/register">S'inscrire</a></li>
        <?php else : ?>
            <li><a href="/logout">Se déconnecter</a></li>
        <?php endif; ?>       
        
        <?php if (isset($_SESSION['user'])): ?>
          <li class="nav-item">
            <a href="/profile" class="nav-link d-flex align-items-center gap-2" title="Mon Profil" style="padding: 0;">
              <img
                src="<?= !empty($_SESSION['user']['profile_image'])
                        ? '/public/uploads/' . htmlspecialchars($_SESSION['user']['profile_image'])
                        : '/public/img/profile-user.png' ?>"
                alt="Profil"
                style="height: 50px; width: 50px; border-radius: 50%; object-fit: cover; margin-top: -10px;">
              <span class="fw-semibold"><?= htmlspecialchars($_SESSION['user']['firstName'] ?? 'Profil') ?></span>
            </a>
          </li>
        <?php endif; ?>
    </ul>

      <ul class="nav-icons">
        <li>
          <form action="/products" method="GET" style="display: flex; align-items: center;" id="search-form">
            <input
              type="text"
              name="search"
              placeholder="Rechercher..."
              id="search-input"
              style="display: none; padding: 5px; border-radius: 5px;" />

            <button type="button" class="nav-icon" id="search-icon" style="all: unset; cursor: pointer;">
              <i class="fa-solid fa-search"></i>
            </button>

          </form>

        </li>
        <li><a class="nav-icon" href="/cart"><i class="fa-solid fa-cart-shopping"></i></a></li>

        <?php if (!isset($_SESSION['user'])) : ?>
          <li><a class="nav-icon" href="/register"><i class="fa-solid fa-user-plus"></i> S'inscrire</a></li>
          <li><a class="nav-icon" href="/login"><i class="fa-solid fa-user"></i> Se connecter</a></li>
        <?php else : ?>
          <?php
          $prenom = $_SESSION['user']['firstName'] ?? 'Utilisateur';
          $id_Role = $_SESSION['user']['id_Role'] ?? null;
          ?>
          <li><span class="nav-text">Bienvenue <?= htmlspecialchars($prenom); ?></span></li>

          <?php if ($id_Role == 1) : ?>
            <li><a class="nav-icon" href="/listUsers"><i class="fa-solid fa-chart-line"></i> Admin</a></li>
            <!-- Créer un article ici -->
            <li><a class="nav-icon" href="/createProduct"><i class="fa-solid fa-plus"></i> Créer un article</a></li>
          <?php endif; ?>

          <li><a class="nav-icon" href="/logout"><i class="fa-solid fa-sign-out-alt"></i> Se déconnecter</a></li>
        <?php endif; ?>
      </ul>
    </div>
  </nav>


  <script>
    const searchIcon = document.getElementById('search-icon');
    const searchInput = document.getElementById('search-input');
    const searchForm = document.getElementById('search-form');

    searchIcon.addEventListener('click', () => {
      if (searchInput.style.display === 'none') {
        searchInput.style.display = 'inline-block';
        searchInput.focus();
      } else if (searchInput.value !== '') {
        searchForm.submit();
      }
    });
  </script>


  <script>
    const toggle = document.getElementById('hamburger');
    const mobileMenu = document.getElementById('mobileMenu');


    toggle.addEventListener('click', () => {
      mobileMenu.classList.toggle('active');
    });
  </script>