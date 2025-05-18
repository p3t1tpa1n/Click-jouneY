<?php
/**
 * Vue de l'historique des voyages
 */
?>

<div class="container mt-5 themed-container">
    <h1 class="mb-4">Mon historique de voyages</h1>
    
    <div class="row">
        <div class="col-md-12 mb-4">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-shopping-bag me-2"></i> Mes voyages achetés
                    </h5>
                </div>
                <div class="card-body">
                    <?php if (empty($purchasedTrips)): ?>
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i> Vous n'avez pas encore acheté de voyage.
                        </div>
                        <div class="text-center">
                            <a href="<?= BASE_URL ?>/trips" class="btn btn-outline-primary">
                                <i class="fas fa-search me-2"></i> Découvrir nos voyages
                            </a>
                        </div>
                    <?php else: ?>
                        <div class="row row-cols-1 row-cols-md-3 g-4">
                            <?php foreach ($purchasedTrips as $trip): ?>
                                <div class="col">
                                    <div class="card h-100 trip-card">
                                        <?php
                                        // Utiliser le bon chemin d'image pour chaque voyage selon son ID
                                        $folderId = $trip['id'];
                                        if ($folderId == 1) {
                                            $imagePath = BASE_URL . '/ClickJourney/1.Chicago Los Angeles/arnaud-steckle-MtYedjwRgAA-unsplash.jpg';
                                        } elseif ($folderId == 2) {
                                            $imagePath = BASE_URL . '/ClickJourney/2.Floride/aurora-kreativ-UN4cs4zNCYo-unsplash.jpg';
                                        } elseif ($folderId == 3) {
                                            $imagePath = BASE_URL . '/ClickJourney/3.Parcs Nationaux/bailey-zindel-NRQV-hBF1OM-unsplash.jpg';
                                        } elseif ($folderId == 4) {
                                            $imagePath = BASE_URL . '/ClickJourney/4.New York/alexander-rotker--sQ4FsomXEs-unsplash.jpg';
                                        } elseif ($folderId == 5) {
                                            $imagePath = BASE_URL . '/ClickJourney/5.Côte Ouest/andrea-leopardi-QfhbZfIf0nA-unsplash.jpg';
                                        } elseif ($folderId == 6) {
                                            $imagePath = BASE_URL . '/ClickJourney/6.La Musique du Sud/eric-tompkins-Z8rKwWR2Ij8-unsplash.jpg';
                                        } elseif ($folderId == 7) {
                                            $imagePath = BASE_URL . '/ClickJourney/7.Alaska/christian-bowen-uknf_4Umtqc-unsplash.jpg';
                                        } elseif ($folderId == 8) {
                                            $imagePath = BASE_URL . '/ClickJourney/8.Hawaii/pexels-lastly-412681.jpg';
                                        } elseif ($folderId == 9) {
                                            $imagePath = BASE_URL . '/ClickJourney/9.Route Historique/belia-koziak-lXv4TsJRZao-unsplash.jpg';
                                        } elseif ($folderId == 10) {
                                            $imagePath = BASE_URL . '/ClickJourney/10.Grands Lacs et Chicago/edward-koorey-Gcc3c6MfSM0-unsplash.jpg';
                                        } elseif ($folderId == 11) {
                                            $imagePath = BASE_URL . '/ClickJourney/11. Texas/pexels-chase-mcbride-2105250-3731950.jpg';
                                        } elseif ($folderId == 12) {
                                            $imagePath = BASE_URL . '/ClickJourney/13.Colorado/taylor-brandon-LQek-wh0BCA-unsplash.jpg';
                                        } elseif ($folderId == 13) {
                                            $imagePath = BASE_URL . '/ClickJourney/14.Washington D.C/andrea-garcia-ckUB5JRAtz0-unsplash.jpg';
                                        } else {
                                            $imagePath = BASE_URL . '/public/assets/images/logo/default.jpg';
                                        }
                                        ?>
                                        <img src="<?= $imagePath ?>" class="card-img-top" alt="<?= htmlspecialchars($trip['title']) ?>"
                                             style="height: 150px; object-fit: cover;">
                                        <div class="card-body">
                                            <h5 class="card-title"><?= htmlspecialchars($trip['title']) ?></h5>
                                            <p class="card-text small"><?= htmlspecialchars($trip['region']) ?></p>
                                            <div class="text-end">
                                                <a href="<?= BASE_URL ?>/trip?id=<?= $trip['id'] ?>" class="btn btn-sm btn-primary">
                                                    <i class="fas fa-eye me-1"></i> Voir
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        
        <div class="col-md-12">
            <div class="card shadow-sm">
                <div class="card-header bg-secondary text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="fas fa-history me-2"></i> Mes voyages consultés
                    </h5>
                    <?php if (!empty($viewedTrips)): ?>
                        <small class="text-white-50">Les <?= count($viewedTrips) ?> derniers voyages consultés</small>
                    <?php endif; ?>
                </div>
                <div class="card-body">
                    <?php if (empty($viewedTrips)): ?>
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i> Vous n'avez pas encore consulté de voyage.
                        </div>
                        <div class="text-center">
                            <a href="<?= BASE_URL ?>/trips" class="btn btn-outline-primary">
                                <i class="fas fa-search me-2"></i> Découvrir nos voyages
                            </a>
                        </div>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Voyage</th>
                                        <th>Région</th>
                                        <th>Prix</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($viewedTrips as $trip): ?>
                                        <tr>
                                            <td>
                                                <a href="<?= BASE_URL ?>/trip?id=<?= $trip['id'] ?>" class="text-decoration-none fw-bold">
                                                    <?= htmlspecialchars($trip['title']) ?>
                                                </a>
                                            </td>
                                            <td><?= htmlspecialchars($trip['region']) ?></td>
                                            <td><?= number_format($trip['price'], 0, ',', ' ') ?> €</td>
                                            <td>
                                                <div class="btn-group btn-group-sm">
                                                    <a href="<?= BASE_URL ?>/trip?id=<?= $trip['id'] ?>" class="btn btn-outline-primary">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="<?= BASE_URL ?>/cart/add/<?= $trip['id'] ?>" class="btn btn-outline-success">
                                                        <i class="fas fa-cart-plus"></i>
                                                    </a>
                                                    <form method="post" action="<?= BASE_URL ?>/user/remove-from-history" class="d-inline">
                                                        <input type="hidden" name="trip_id" value="<?= $trip['id'] ?>">
                                                        <button type="submit" class="btn btn-outline-danger" 
                                                                onclick="return confirm('Supprimer ce voyage de votre historique ?')">
                                                            <i class="fas fa-trash-alt"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    
    <div class="d-flex justify-content-between mt-4">
        <a href="<?= BASE_URL ?>/profile" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i> Retour au profil
        </a>
        <a href="<?= BASE_URL ?>/trips" class="btn btn-primary">
            <i class="fas fa-search me-2"></i> Explorer d'autres voyages
        </a>
    </div>
</div> 