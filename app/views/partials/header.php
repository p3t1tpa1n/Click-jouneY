<?php
// Le fichier init.php est déjà chargé dans index.php, nous n'avons pas besoin de le charger à nouveau
// require_once __DIR__ . '/../../includes/init.php';

// Détermine la page active
$currentPage = basename($_SERVER['PHP_SELF']);

// S'assurer que la variable $route est définie
if (!isset($route)) {
    $route = $_GET['route'] ?? 'home';
}
?>
<!DOCTYPE html>
<html lang="fr" class="theme-light">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="<?= isset($pageDescription) ? $pageDescription : 'Click Journey vous propose des voyages authentiques et inoubliables sur la mythique Route 66.' ?>">
  <title><?= isset($title) ? htmlspecialchars($title) . ' - Click-jouneY' : 'Click-jouneY - Aventures sur la Route 66' ?></title>
  
  <!-- Favicon -->
  <link rel="icon" href="<?= BASE_URL ?>/public/assets/images/favicon.ico">
  
  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
  
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  
  <!-- Bootstrap Icons -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
  
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
  
  <!-- Custom CSS -->
  <link rel="stylesheet" href="<?= BASE_URL ?>/public/assets/css/global.css">
  <link rel="stylesheet" href="<?= BASE_URL ?>/public/assets/css/style.css">
  
  <!-- Mobile Navigation CSS -->
  <link rel="stylesheet" href="<?= BASE_URL ?>/public/assets/css/mobile.css">
  
  <!-- Thèmes -->
  <link rel="stylesheet" href="<?= BASE_URL ?>/public/assets/css/theme-light.css" id="theme-light">
  <link rel="stylesheet" href="<?= BASE_URL ?>/public/assets/css/theme-dark.css" id="theme-dark" disabled>
  <link rel="stylesheet" href="<?= BASE_URL ?>/public/assets/css/theme-accessible.css" id="theme-accessible" disabled>
  
  <!-- Scripts -->
  <script src="<?= BASE_URL ?>/public/assets/js/theme-switcher.js" defer></script>
  <script src="<?= BASE_URL ?>/public/assets/js/mobile-nav.js" defer></script>
  <script src="<?= BASE_URL ?>/public/assets/js/main.js" defer></script>
  <script src="<?= BASE_URL ?>/public/assets/js/form-validation.js" defer></script>
  <script src="<?= BASE_URL ?>/public/assets/js/profile-editor.js" defer></script>
  <script src="<?= BASE_URL ?>/public/assets/js/admin-delay.js" defer></script>
  <script src="<?= BASE_URL ?>/public/assets/js/trip-sorter.js" defer></script>
  <script src="<?= BASE_URL ?>/public/assets/js/trip-price-calculator.js" defer></script>
</head>
<body class="theme-light">
  <nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm">
    <div class="container">
      <a class="navbar-brand" href="<?= BASE_URL ?>/">
        <img src="<?= BASE_URL ?>/public/assets/images/logo.png" alt="Click-Journey" height="40">
      </a>
      <!-- Bouton pour navigation Bootstrap (desktop) -->
      <button class="navbar-toggler d-none d-lg-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent" aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <!-- Bouton pour menu mobile (personnalisé) -->
      <button class="mobile-menu-toggle d-lg-none" aria-label="Menu mobile">
        <span></span>
        <span></span>
        <span></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item"><a class="nav-link <?= $route==='home'?'active':'' ?>" href="<?= BASE_URL ?>/">Accueil</a></li>
          <li class="nav-item"><a class="nav-link <?= $route==='trips'?'active':'' ?>" href="<?= BASE_URL ?>/trips">Voyages</a></li>
          <li class="nav-item"><a class="nav-link <?= $route==='about'?'active':'' ?>" href="<?= BASE_URL ?>/about">À propos</a></li>
          <li class="nav-item"><a class="nav-link <?= $route==='contact'?'active':'' ?>" href="<?= BASE_URL ?>/contact">Contact</a></li>
        </ul>
        <div class="d-flex align-items-center">
          <button id="theme-switcher" class="btn btn-outline-secondary me-2" aria-label="Changer de thème">
            <i class="fas fa-moon"></i>
          </button>
          <?php if (isset($_SESSION['user'])): ?>
            <div class="dropdown me-2">
              <button class="btn btn-outline-primary dropdown-toggle" type="button" id="userMenu" data-bs-toggle="dropdown" aria-expanded="false">
                <img src="<?= BASE_URL ?>/public/assets/images/avatars/<?= $_SESSION['user']['profile_image'] ?? 'default.jpg' ?>" class="rounded-circle" height="30" alt="Avatar">
                <?= htmlspecialchars($_SESSION['user']['firstname'] ?? $_SESSION['user']['login']) ?>
              </button>
              <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userMenu">
                <li><a class="dropdown-item" href="<?= BASE_URL ?>/profile">Mon profil</a></li>
                <li><a class="dropdown-item" href="<?= BASE_URL ?>/cart">Mon panier</a></li>
                <li><a class="dropdown-item" href="<?= BASE_URL ?>/history">Historique des voyages</a></li>
                <li><hr class="dropdown-divider"></li>
                <?php if (isset($_SESSION['user']['role']) && $_SESSION['user']['role'] === 'admin'): ?>
                <li><a class="dropdown-item" href="<?= BASE_URL ?>/admin">Administration</a></li>
                <li><hr class="dropdown-divider"></li>
                <?php endif; ?>
                <li><a class="dropdown-item" href="<?= BASE_URL ?>/logout">Déconnexion</a></li>
              </ul>
            </div>
          <?php else: ?>
            <a href="<?= BASE_URL ?>/login" class="btn btn-outline-primary me-2">Connexion</a>
            <a href="<?= BASE_URL ?>/register" class="btn btn-primary">Inscription</a>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </nav>

  <!-- Menu Mobile -->
  <div class="mobile-menu-overlay"></div>
  <div class="mobile-nav">
    <div class="mobile-nav-header">
      <a href="<?= BASE_URL ?>/" class="mobile-logo">
        <img src="<?= BASE_URL ?>/public/assets/images/logo.png" alt="Click-Journey" height="40">
      </a>
      <button class="mobile-nav-close" aria-label="Fermer le menu"></button>
    </div>
    <div class="mobile-nav-content">
      <ul class="mobile-menu">
        <li><a class="<?= $route==='home'?'active':'' ?>" href="<?= BASE_URL ?>/">Accueil</a></li>
        <li><a class="<?= $route==='trips'?'active':'' ?>" href="<?= BASE_URL ?>/trips">Voyages</a></li>
        <li><a class="<?= $route==='about'?'active':'' ?>" href="<?= BASE_URL ?>/about">À propos</a></li>
        <li><a class="<?= $route==='contact'?'active':'' ?>" href="<?= BASE_URL ?>/contact">Contact</a></li>
      </ul>
      
      <div class="mobile-auth">
        <?php if (isset($_SESSION['user'])): ?>
          <div class="user-info">
            <img src="<?= BASE_URL ?>/public/assets/images/avatars/<?= $_SESSION['user']['profile_image'] ?? 'default.jpg' ?>" class="rounded-circle" height="30" alt="Avatar">
            <?= htmlspecialchars($_SESSION['user']['firstname'] ?? $_SESSION['user']['login']) ?>
          </div>
          <div class="auth-buttons">
            <a href="<?= BASE_URL ?>/profile" class="btn btn-outline-primary">Mon profil</a>
            <a href="<?= BASE_URL ?>/cart" class="btn btn-outline-primary">Mon panier</a>
            <a href="<?= BASE_URL ?>/history" class="btn btn-outline-primary">Historique des voyages</a>
            <?php if (isset($_SESSION['user']['role']) && $_SESSION['user']['role'] === 'admin'): ?>
              <a href="<?= BASE_URL ?>/admin" class="btn btn-outline-primary">Administration</a>
            <?php endif; ?>
            <a href="<?= BASE_URL ?>/logout" class="btn btn-primary">Déconnexion</a>
          </div>
        <?php else: ?>
          <div class="auth-buttons">
            <a href="<?= BASE_URL ?>/login" class="btn btn-outline-primary">Connexion</a>
            <a href="<?= BASE_URL ?>/register" class="btn btn-primary">Inscription</a>
          </div>
        <?php endif; ?>
        
        <div class="mobile-theme-switcher mt-4">
          <button id="mobile-theme-switcher" class="btn btn-outline-secondary w-100" aria-label="Changer de thème">
            <i class="fas fa-moon me-2"></i> Changer de thème
          </button>
        </div>
      </div>
    </div>
  </div>

  <main>
    <div class="container">
      <?php if (isset($_SESSION['alerts']) && !empty($_SESSION['alerts'])): ?>
        <?php foreach ($_SESSION['alerts'] as $alert): ?>
          <div class="alert alert-<?= $alert['type'] ?>">
            <div class="alert-content">
              <div class="alert-icon">
                <?php if ($alert['type'] === 'success'): ?>
                  <i class="fas fa-check-circle"></i>
                <?php elseif ($alert['type'] === 'error'): ?>
                  <i class="fas fa-exclamation-circle"></i>
                <?php elseif ($alert['type'] === 'info'): ?>
                  <i class="fas fa-info-circle"></i>
                <?php elseif ($alert['type'] === 'warning'): ?>
                  <i class="fas fa-exclamation-triangle"></i>
                <?php endif; ?>
              </div>
              <div class="alert-message"><?= $alert['message'] ?></div>
            </div>
            <button class="close-btn" aria-label="Close">
              <i class="fas fa-times"></i>
            </button>
          </div>
        <?php endforeach; ?>
        <?php unset($_SESSION['alerts']); ?>
      <?php endif; ?>

      <!-- LE CONTENU DE LA PAGE SERA INSÉRÉ ICI -->
    </div>
  </main>
  <!-- Bootstrap JS (nécessaire pour les dropdowns) -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</body>
</html> 