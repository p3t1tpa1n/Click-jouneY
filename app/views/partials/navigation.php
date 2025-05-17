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

<script>
    // Script pour le menu mobile
    document.addEventListener('DOMContentLoaded', function() {
        const mobileMenuToggle = document.getElementById('mobile-menu-toggle');
        const navbar = document.getElementById('navbar-nav');
        const overlay = document.getElementById('mobile-menu-overlay');
        const body = document.body;
        
        // Toggle menu mobile
        if (mobileMenuToggle && navbar && overlay) {
            mobileMenuToggle.addEventListener('click', function() {
                navbar.classList.toggle('active');
                mobileMenuToggle.classList.toggle('active');
                overlay.classList.toggle('active');
                body.classList.toggle('no-scroll');
            });
            
            // Ferme le menu quand on clique sur l'overlay
            overlay.addEventListener('click', function() {
                navbar.classList.remove('active');
                mobileMenuToggle.classList.remove('active');
                overlay.classList.remove('active');
                body.classList.remove('no-scroll');
            });
            
            // Ferme le menu quand on clique sur un lien
            const navLinks = navbar.querySelectorAll('.nav-link');
            navLinks.forEach(link => {
                link.addEventListener('click', function() {
                    navbar.classList.remove('active');
                    mobileMenuToggle.classList.remove('active');
                    overlay.classList.remove('active');
                    body.classList.remove('no-scroll');
                });
            });
        }
        
        // Script pour le menu utilisateur dropdown (desktop)
        const userMenuToggle = document.getElementById('user-menu-toggle');
        const userDropdown = document.getElementById('user-dropdown');
        
        if (userMenuToggle && userDropdown) {
            userMenuToggle.addEventListener('click', function(e) {
                e.preventDefault();
                userDropdown.classList.toggle('active');
            });
            
            // Ferme le menu quand on clique ailleurs
            document.addEventListener('click', function(e) {
                if (!userMenuToggle.contains(e.target) && !userDropdown.contains(e.target)) {
                    userDropdown.classList.remove('active');
                }
            });
        }
        
        // Script pour le menu utilisateur dropdown (mobile)
        const mobileUserToggle = document.getElementById('mobile-user-toggle');
        const mobileUserDropdown = document.getElementById('mobile-user-dropdown');
        
        if (mobileUserToggle && mobileUserDropdown) {
            mobileUserToggle.addEventListener('click', function(e) {
                e.preventDefault();
                mobileUserDropdown.classList.toggle('active');
            });
        }
    });
</script> 