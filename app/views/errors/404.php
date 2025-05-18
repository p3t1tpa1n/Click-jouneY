<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 text-center">
            <div class="error-page mb-5">
                <h1 class="display-1 text-danger">404</h1>
                <h2 class="mb-4">Page non trouvée</h2>
                <div class="alert alert-warning">
                    <p>La page que vous recherchez n'existe pas ou a été déplacée.</p>
                </div>
                <p class="lead">Que souhaitez-vous faire maintenant ?</p>
                <div class="mt-4">
                    <a href="<?= BASE_URL ?>" class="btn btn-primary">
                        <i class="fas fa-home me-2"></i> Retour à l'accueil
                    </a>
                    <a href="<?= BASE_URL ?>/index.php?route=trips" class="btn btn-outline-primary ms-2">
                        <i class="fas fa-compass me-2"></i> Explorer nos voyages
                    </a>
                </div>
            </div>
            
            <div class="card mt-5">
                <div class="card-body">
                    <h3 class="h5 mb-3">Vous cherchiez peut-être...</h3>
                    <div class="list-group">
                        <a href="<?= BASE_URL ?>/index.php?route=trips" class="list-group-item list-group-item-action">
                            <i class="fas fa-map-marked-alt me-2"></i> Nos voyages disponibles
                        </a>
                        <a href="<?= BASE_URL ?>/index.php?route=contact" class="list-group-item list-group-item-action">
                            <i class="fas fa-envelope me-2"></i> Nous contacter
                        </a>
                        <a href="<?= BASE_URL ?>/index.php?route=presentation" class="list-group-item list-group-item-action">
                            <i class="fas fa-info-circle me-2"></i> À propos de nous
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> 