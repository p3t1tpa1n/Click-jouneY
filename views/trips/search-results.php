<?php if (empty($searchResults)): ?>
    <div class="row">
        <div class="col-12">
            <div class="no-results theme-element text-center p-5 mb-5">
                <div class="no-results-icon mb-4">
                    <i class="fas fa-search theme-icon fa-3x"></i>
                </div>
                <h2 class="theme-text mb-3">Aucun voyage trouvé</h2>
                <p class="theme-text mb-4">Nous n'avons pas trouvé de voyages correspondant à vos critères. Essayez d'autres options de recherche.</p>
                <a href="<?= BASE_URL ?>/trips" class="btn btn-outline-primary theme-button">Voir tous les voyages</a>
            </div>
        </div>
    </div>
<?php else: ?> 