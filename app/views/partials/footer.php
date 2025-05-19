</main>

    <!-- Les scripts d'animation ont été déplacés dans main.js et mobile-nav.js -->

    <!-- Footer Section -->
    <footer class="bg-light text-dark pt-5">
        <div class="container">
            <div class="row">
                <div class="col-md-3 mb-4">
                    <h5>À propos</h5>
                    <p>Click-Journey est votre guide pour explorer la mythique Route 66 et vivre une aventure unique de Chicago à Los Angeles.</p>
                    <div>
                        <a href="#" class="text-dark me-2"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="text-dark me-2"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="text-dark me-2"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="text-dark"><i class="fab fa-youtube"></i></a>
                    </div>
                </div>
                <div class="col-md-3 mb-4">
                    <h5>Liens rapides</h5>
                    <ul class="list-unstyled">
                        <li><a href="<?= BASE_URL ?>/" class="text-dark">Accueil</a></li>
                        <li><a href="<?= BASE_URL ?>/trips" class="text-dark">Voyages</a></li>
                        <li><a href="<?= BASE_URL ?>/about" class="text-dark">À propos</a></li>
                        <li><a href="<?= BASE_URL ?>/faq" class="text-dark">FAQ</a></li>
                        <li><a href="<?= BASE_URL ?>/contact" class="text-dark">Contact</a></li>
                    </ul>
                </div>
                <div class="col-md-3 mb-4">
                    <h5>Aide</h5>
                    <ul class="list-unstyled">
                        <li><a href="<?= BASE_URL ?>/terms" class="text-dark">Conditions d'utilisation</a></li>
                        <li><a href="<?= BASE_URL ?>/privacy" class="text-dark">Politique de confidentialité</a></li>
                        <li><a href="<?= BASE_URL ?>/cancellation" class="text-dark">Politique d'annulation</a></li>
                        <li><a href="<?= BASE_URL ?>/support" class="text-dark">Support client</a></li>
                    </ul>
                </div>
                <div class="col-md-3 mb-4">
                    <h5>Contact</h5>
                    <p><i class="fas fa-map-marker-alt me-2"></i>123 Avenue de la Route 66, 75000 Paris, France</p>
                    <p><i class="fas fa-phone me-2"></i>+33 1 23 45 67 89</p>
                    <p><i class="fas fa-envelope me-2"></i>contact@click-journey.com</p>
                </div>
            </div>
            <div class="text-center pt-3 border-top">
                <small>&copy; <?= date('Y') ?> Click-JourneY. Tous droits réservés.</small>
            </div>
        </div>
    </footer>

    <!-- Cookie Consent -->
    <div id="cookie-consent" class="cookie-banner">
        <div class="cookie-content">
            <p>Nous utilisons des cookies pour améliorer votre expérience sur notre site. En poursuivant votre navigation, vous acceptez notre <a href="<?= BASE_URL ?>/privacy">politique de confidentialité</a>.</p>
            <div class="cookie-actions">
                <button id="accept-cookies" class="btn btn-primary btn-sm">Accepter</button>
                <button id="decline-cookies" class="btn btn-outline btn-sm">Refuser</button>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="<?= BASE_URL ?>/public/assets/js/theme-switcher.js" defer></script>
    <script src="<?= BASE_URL ?>/public/assets/js/mobile-nav.js" defer></script>
    <script src="<?= BASE_URL ?>/public/assets/js/main.js" defer></script>
    <script src="<?= BASE_URL ?>/public/assets/js/cookie-consent.js" defer></script>
    <script src="<?= BASE_URL ?>/public/assets/js/form-validation.js" defer></script>
    <script src="<?= BASE_URL ?>/public/assets/js/profile-editor.js" defer></script>
    <script src="<?= BASE_URL ?>/public/assets/js/admin-delay.js" defer></script>
    <script src="<?= BASE_URL ?>/public/assets/js/trip-sorter.js" defer></script>
    <script src="<?= BASE_URL ?>/public/assets/js/trip-price-calculator.js" defer></script>

    <!-- Page specific scripts (if any) -->
    <?php if (isset($pageScripts)): ?>
        <?php foreach ($pageScripts as $script): ?>
            <script src="<?= BASE_URL ?>/public/assets/js/<?= $script ?>" defer></script>
        <?php endforeach; ?>
    <?php endif; ?>

</body>
</html> 