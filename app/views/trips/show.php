<?php
/**
 * Vue pour l'affichage des détails d'un voyage
 * 
 * Cette page affiche les informations complètes d'un voyage et permet
 * de sélectionner des options avant de procéder au paiement
 */
?>

<div class="container my-5">
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= BASE_URL ?>/">Accueil</a></li>
            <li class="breadcrumb-item"><a href="<?= BASE_URL ?>/index.php?route=trips">Voyages</a></li>
            <li class="breadcrumb-item active" aria-current="page"><?= htmlspecialchars($trip['title']) ?></li>
        </ol>
    </nav>

    <div class="row">
        <!-- Colonne principale -->
        <div class="col-lg-8">
            <h1 class="mb-4"><?= htmlspecialchars($trip['title']) ?></h1>
            
            <!-- Galerie d'images -->
            <?php if (isset($trip['images']) && !empty($trip['images'])): ?>
            <div id="tripCarousel" class="carousel slide mb-4" data-bs-ride="carousel">
                <div class="carousel-indicators">
                    <?php foreach ($trip['images'] as $index => $image): ?>
                    <button type="button" data-bs-target="#tripCarousel" data-bs-slide-to="<?= $index ?>" <?= $index === 0 ? 'class="active" aria-current="true"' : '' ?> aria-label="Slide <?= $index + 1 ?>"></button>
                    <?php endforeach; ?>
                </div>
                <div class="carousel-inner rounded">
                    <?php foreach ($trip['images'] as $index => $image): ?>
                    <div class="carousel-item <?= $index === 0 ? 'active' : '' ?>">
                        <img src="<?= BASE_URL ?>/assets/public/assets/images/trips/<?= htmlspecialchars($image) ?>" class="d-block w-100" alt="<?= htmlspecialchars($trip['title']) ?> - Image <?= $index + 1 ?>">
                    </div>
                    <?php endforeach; ?>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#tripCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Précédent</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#tripCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Suivant</span>
                </button>
            </div>
            <?php elseif (isset($trip['main_image'])): ?>
            <div class="mb-4">
                <img src="<?= BASE_URL ?>/assets/public/assets/images/trips/<?= htmlspecialchars($trip['main_image']) ?>" class="img-fluid rounded" alt="<?= htmlspecialchars($trip['title']) ?>">
            </div>
            <?php endif; ?>
            
            <!-- Description -->
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title">Description</h5>
                    <p class="card-text"><?= nl2br(htmlspecialchars($trip['description'])) ?></p>
                </div>
            </div>
            
            <!-- Étapes du voyage -->
            <?php if (isset($trip['steps']) && !empty($trip['steps'])): ?>
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Étapes du voyage</h5>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush">
                        <?php foreach ($trip['steps'] as $index => $step): ?>
                        <div class="list-group-item">
                            <div class="d-flex align-items-center mb-2">
                                <div class="bg-primary rounded-circle text-white d-flex align-items-center justify-content-center" style="width: 30px; height: 30px;">
                                    <?= $index + 1 ?>
                                </div>
                                <h6 class="ms-3 mb-0"><?= htmlspecialchars($step['location']) ?></h6>
                            </div>
                            <p class="mb-0"><?= nl2br(htmlspecialchars($step['description'])) ?></p>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
            <?php endif; ?>
            
            <!-- Options du voyage -->
            <?php if (isset($trip['options']) && !empty($trip['options'])): ?>
            <form action="index.php" method="GET" id="tripOptionsForm">
                <input type="hidden" name="route" value="trip-recap">
                <input type="hidden" name="id" value="<?= $trip['id'] ?>">
                
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">Options du voyage</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="nb-travelers" class="form-label">Nombre de voyageurs</label>
                            <input type="number" class="form-control" id="nb-travelers" name="nb_travelers" min="1" max="10" value="1">
                        </div>
                        
                        <div class="row">
                            <?php foreach ($trip['options'] as $optId => $option): ?>
                            <div class="col-md-6 mb-3">
                                <div class="card h-100">
                                    <div class="card-body">
                                        <h5 class="card-title"><?= htmlspecialchars($option['title']) ?></h5>
                                        <p class="card-text"><?= htmlspecialchars($option['description']) ?></p>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span class="text-primary fw-bold"><?= number_format($option['price'], 2, ',', ' ') ?> €</span>
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" id="option-<?= $optId ?>" name="options[]" value="<?= $optId ?>">
                                                <label class="form-check-label" for="option-<?= $optId ?>">Ajouter</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
                
                <div class="d-grid">
                    <button type="submit" class="btn btn-primary btn-lg">Continuer vers le récapitulatif</button>
                </div>
            </form>
            <?php endif; ?>
        </div>
        
        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Informations de base -->
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title">Informations</h5>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span>Prix de base</span>
                            <span class="text-primary fw-bold"><?= number_format($trip['price'], 2, ',', ' ') ?> €</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span>Durée</span>
                            <span><?= isset($trip['duration']) ? $trip['duration'] . ' jours' : 'Non spécifié' ?></span>
                        </li>
                        <?php if (isset($trip['region'])): ?>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span>Région</span>
                            <span><?= htmlspecialchars($trip['region']) ?></span>
                        </li>
                        <?php endif; ?>
                        <?php if (isset($trip['difficulty'])): ?>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span>Difficulté</span>
                            <span><?= htmlspecialchars($trip['difficulty']) ?></span>
                        </li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
            
            <!-- Voyages similaires -->
            <?php if (!empty($similarTrips)): ?>
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Voyages similaires</h5>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush">
                        <?php foreach ($similarTrips as $similarTrip): ?>
                        <a href="<?= BASE_URL ?>/index.php?route=trip&id=<?= $similarTrip['id'] ?>" class="list-group-item list-group-item-action">
                            <div class="d-flex align-items-center">
                                <?php if (isset($similarTrip['main_image'])): ?>
                                <img src="<?= BASE_URL ?>/assets/public/assets/images/trips/<?= htmlspecialchars($similarTrip['main_image']) ?>" class="img-thumbnail me-3" style="width: 70px; height: 50px; object-fit: cover;" alt="<?= htmlspecialchars($similarTrip['title']) ?>">
                                <?php endif; ?>
                                <div>
                                    <h6 class="mb-0"><?= htmlspecialchars($similarTrip['title']) ?></h6>
                                    <span class="text-primary"><?= number_format($similarTrip['price'], 2, ',', ' ') ?> €</span>
                                </div>
                            </div>
                        </a>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div> 