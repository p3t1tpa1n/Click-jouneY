<?php
// Le fichier init.php est déjà chargé dans index.php, nous n'avons pas besoin de le charger à nouveau
// require_once __DIR__ . '/../../includes/init.php';

// Détermine la page active
$currentPage = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="<?= isset($pageDescription) ? $pageDescription : 'Click Journey vous propose des voyages authentiques et inoubliables sur la mythique Route 66.' ?>">
  <title><?= $title ?? 'Click Journey - Voyages sur mesure' ?></title>
  
  <!-- CSS -->
  <link rel="stylesheet" href="<?= BASE_URL ?>/css/style.css">
  <link rel="stylesheet" href="<?= BASE_URL ?>/css/mobile.css">
  
  <!-- Favicon -->
  <link rel="icon" type="image/png" href="<?= BASE_URL ?>/img/favicon.png">
  
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  
  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
  
  <!-- JavaScript -->
  <script src="<?= BASE_URL ?>/js/main.js" defer></script>
  <script src="<?= BASE_URL ?>/js/mobile-nav.js" defer></script>
  
  <style>
    .logo img {
      max-width: 80px;
      height: auto;
    }
    .user-profile-icon {
      width: 35px;
      height: 35px;
      border-radius: 50%;
      overflow: hidden;
      display: inline-block;
      margin-right: 8px;
      vertical-align: middle;
      border: 2px solid var(--blanc-casse);
    }
    .user-profile-icon img {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }
    .user-menu-toggle {
      display: flex;
      align-items: center;
      background: none;
      border: none;
      color: var(--blanc-casse);
      cursor: pointer;
    }
  </style>
</head>
<body>
  <div class="overlay"></div>

  <header class="main-header">
    <div class="container header-content">
      <a href="<?= BASE_URL ?>/" class="logo">
        <img src="<?= BASE_URL ?>/img/logo.png" alt="Click Journey Logo">
      </a>
      
      <button class="mobile-menu-toggle" aria-label="Toggle mobile menu">
        <span class="bar"></span>
        <span class="bar"></span>
        <span class="bar"></span>
      </button>
      
      <div class="nav-container">
        <nav class="main-nav">
          <ul class="nav-menu">
            <li><a href="<?= BASE_URL ?>/" class="<?= $route === 'home' ? 'active' : '' ?>">Accueil</a></li>
            <li><a href="<?= BASE_URL ?>/trips" class="<?= $route === 'trips' ? 'active' : '' ?>">Voyages</a></li>
            <li><a href="<?= BASE_URL ?>/about" class="<?= $route === 'about' ? 'active' : '' ?>">À propos</a></li>
            <li><a href="<?= BASE_URL ?>/contact" class="<?= $route === 'contact' ? 'active' : '' ?>">Contact</a></li>
          </ul>
        </nav>
        
        <div class="auth-buttons">
          <?php if (isset($_SESSION['user'])): ?>
            <div class="user-menu-container">
              <button class="user-menu-button" aria-expanded="false">
                <div class="user-profile-icon">
                  <img src="<?= BASE_URL ?>/img/avatars/<?= $_SESSION['user']['avatar'] ?? 'default.png' ?>" alt="Profile">
                </div>
                <span class="username"><?= $_SESSION['user']['first_name'] ?></span>
                <i class="fas fa-chevron-down"></i>
              </button>
              <ul class="user-dropdown">
                <li><a href="<?= BASE_URL ?>/profile"><i class="fas fa-user"></i> Mon profil</a></li>
                <li><a href="<?= BASE_URL ?>/bookings"><i class="fas fa-suitcase"></i> Mes réservations</a></li>
                <?php if ($_SESSION['user']['role'] === 'admin'): ?>
                  <li><a href="<?= BASE_URL ?>/admin"><i class="fas fa-cog"></i> Administration</a></li>
                <?php endif; ?>
                <li><a href="<?= BASE_URL ?>/logout"><i class="fas fa-sign-out-alt"></i> Déconnexion</a></li>
              </ul>
            </div>
          <?php else: ?>
            <a href="<?= BASE_URL ?>/login" class="btn btn-outline">Connexion</a>
            <a href="<?= BASE_URL ?>/register" class="btn btn-primary">Inscription</a>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </header>

  <div class="mobile-menu-overlay"></div>

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
</body>
</html> 