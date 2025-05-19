<?php
/**
 * Component: Navigation mobile
 * 
 * Navigation qui apparaît en version mobile
 */
?>
<!-- Overlay pour le menu mobile -->
<div class="mobile-menu-overlay" id="mobile-menu-overlay"></div>

<div class="container">
    <div class="header-content">
        <a href="index.php" class="logo">
            <img src="assets/img/logo.png" alt="Click Journey" height="40">
        </a>
        
        <!-- Bouton menu mobile -->
        <button class="mobile-menu-toggle" id="mobile-menu-toggle" aria-label="Menu">
            <span></span>
            <span></span>
            <span></span>
        </button>

        <nav class="main-nav">
            <ul class="navbar-nav" id="navbar-nav">
                <?php foreach ($routes as $route => $label): ?>
                    <li>
                        <a href="index.php<?= $route ? '?route='.$route : '' ?>" 
                           class="nav-link <?= $current_route === $route ? 'active' : '' ?>">
                            <?= $label ?>
                        </a>
                    </li>
                <?php endforeach; ?>
                
                <!-- Version mobile: boutons d'authentification dans le menu -->
                <li class="mobile-auth-container">
                    <div class="auth-buttons">
                        <?php if (isset($_SESSION['user'])): ?>
                            <div class="user-menu">
                                <button class="btn btn-outline mobile-user-btn" id="mobile-user-toggle">
                                    <i class="fas fa-user"></i> <?= $_SESSION['user']['firstname'] ?>
                                </button>
                                <ul class="user-dropdown" id="mobile-user-dropdown">
                                    <li><a href="index.php?route=profile"><i class="fas fa-user-circle"></i> Mon profil</a></li>
                                    <li><a href="index.php?route=bookings"><i class="fas fa-list"></i> Mes réservations</a></li>
                                    <li><a href="index.php?route=favorites"><i class="fas fa-heart"></i> Mes favoris</a></li>
                                    <li><a href="index.php?route=auth/logout"><i class="fas fa-sign-out-alt"></i> Déconnexion</a></li>
                                </ul>
                            </div>
                        <?php else: ?>
                            <a href="index.php?route=auth/login" class="btn btn-outline">Connexion</a>
                            <a href="index.php?route=auth/register" class="btn btn-primary">Inscription</a>
                        <?php endif; ?>
                    </div>
                </li>
            </ul>
        </nav>

        <!-- Version desktop: boutons d'authentification hors du menu -->
        <div class="auth-buttons desktop-auth">
            <?php if (isset($_SESSION['user'])): ?>
                <div class="user-menu">
                    <button class="btn btn-outline" id="user-menu-toggle">
                        <i class="fas fa-user"></i> <?= $_SESSION['user']['firstname'] ?>
                    </button>
                    <ul class="user-dropdown" id="user-dropdown">
                        <li><a href="index.php?route=profile"><i class="fas fa-user-circle"></i> Mon profil</a></li>
                        <li><a href="index.php?route=bookings"><i class="fas fa-list"></i> Mes réservations</a></li>
                        <li><a href="index.php?route=favorites"><i class="fas fa-heart"></i> Mes favoris</a></li>
                        <li><a href="index.php?route=auth/logout"><i class="fas fa-sign-out-alt"></i> Déconnexion</a></li>
                    </ul>
                </div>
            <?php else: ?>
                <a href="index.php?route=auth/login" class="btn btn-outline">Connexion</a>
                <a href="index.php?route=auth/register" class="btn btn-primary">Inscription</a>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Le JavaScript de navigation est maintenant dans mobile-nav.js --> 