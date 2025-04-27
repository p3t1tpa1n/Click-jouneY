</main>

    <footer>
        <div class="container">
            <div class="footer-content">
                <div class="footer-column">
                    <h3>À propos</h3>
                    <p>Route 66 Odyssey est l'agence de voyage spécialisée dans la découverte de la Route 66, cette route mythique qui traverse les États-Unis d'est en ouest.</p>
                    <p class="mt-2">
                        <a href="?route=presentation" class="btn btn-outline">En savoir plus</a>
                    </p>
                </div>

                <div class="footer-column">
                    <h3>Liens rapides</h3>
                    <ul>
                        <li><a href="index.php">Accueil</a></li>
                        <li><a href="?route=trips">Voyages</a></li>
                        <li><a href="?route=presentation">À propos</a></li>
                        <li><a href="?route=contact">Contact</a></li>
                        <?php if (isLoggedIn()): ?>
                            <li><a href="?route=profile">Mon profil</a></li>
                            <?php if (isAdmin()): ?>
                                <li><a href="?route=admin">Administration</a></li>
                            <?php endif; ?>
                        <?php else: ?>
                            <li><a href="?route=login">Connexion</a></li>
                            <li><a href="?route=register">Inscription</a></li>
                        <?php endif; ?>
                    </ul>
                </div>

                <div class="footer-column">
                    <h3>Contactez-nous</h3>
                    <p><i class="fas fa-map-marker-alt"></i> 123 Route 66, Chicago, IL</p>
                    <p><i class="fas fa-phone"></i> +1 (555) 123-4567</p>
                    <p><i class="fas fa-envelope"></i> contact@route66odyssey.com</p>
                    <div class="social-icons mt-2">
                        <a href="#" target="_blank"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" target="_blank"><i class="fab fa-twitter"></i></a>
                        <a href="#" target="_blank"><i class="fab fa-instagram"></i></a>
                        <a href="#" target="_blank"><i class="fab fa-youtube"></i></a>
                    </div>
                </div>

                <div class="footer-column">
                    <h3>Newsletter</h3>
                    <p>Abonnez-vous à notre newsletter pour recevoir nos meilleures offres et actualités.</p>
                    <form action="#" method="post" class="newsletter-form mt-2">
                        <input type="email" placeholder="Votre adresse email" required>
                        <button type="submit" class="btn">S'abonner</button>
                    </form>
                </div>
            </div>
            
            <div class="footer-bottom">
                <p>&copy; <?= date('Y') ?> <?= APP_NAME ?>. Tous droits réservés.</p>
                <p class="mt-1">
                    <a href="#">Mentions légales</a> | 
                    <a href="#">Politique de confidentialité</a> | 
                    <a href="#">CGV</a>
                </p>
            </div>
        </div>
    </footer>

    <!-- Scripts JavaScript -->
    <script>
        // Animation pour les éléments au scroll
        document.addEventListener('DOMContentLoaded', function() {
            // Ajout de la classe fade-in aux sections au scroll
            const sections = document.querySelectorAll('section');
            const fadeInObserver = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('fade-in');
                    }
                });
            }, { threshold: 0.1 });
            
            sections.forEach(section => {
                fadeInObserver.observe(section);
            });
            
            // Menu mobile
            const menuToggle = document.querySelector('.mobile-menu-toggle');
            const navMenu = document.querySelector('.nav-menu');
            
            if (menuToggle && navMenu) {
                menuToggle.addEventListener('click', function() {
                    navMenu.classList.toggle('active');
                    menuToggle.classList.toggle('active');
                });
            }
            
            // Menu utilisateur
            const userMenuToggle = document.querySelector('.user-menu-toggle');
            const userDropdown = document.querySelector('.user-dropdown');
            
            if (userMenuToggle && userDropdown) {
                userMenuToggle.addEventListener('click', function() {
                    userDropdown.classList.toggle('active');
                });
                
                // Fermer le menu au clic en dehors
                document.addEventListener('click', function(event) {
                    if (!userMenuToggle.contains(event.target) && !userDropdown.contains(event.target)) {
                        userDropdown.classList.remove('active');
                    }
                });
            }
        });
    </script>
</body>
</html> 