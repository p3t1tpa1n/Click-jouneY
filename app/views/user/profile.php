<?php
/**
 * Vue du profil utilisateur
 */
?>

<div class="container mt-5 themed-container">
    <div class="row">
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-user me-2"></i> Informations personnelles</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <h5 class="fw-bold"><?= htmlspecialchars($user['name'] ?? 'Utilisateur') ?></h5>
                        <p class="text-muted mb-0">Membre depuis <?= date('d/m/Y', strtotime($user['registration_date'])) ?></p>
                    </div>
                    
                    <div class="mb-3">
                        <p><strong>Login :</strong> <?= htmlspecialchars($user['login']) ?></p>
                        <p><strong>Email :</strong> <?= htmlspecialchars($user['email'] ?? 'Non renseigné') ?></p>
                        <p><strong>Statut :</strong> 
                            <span class="badge bg-<?= ($user['status'] === 'active') ? 'success' : 'warning' ?>">
                                <?= ($user['status'] === 'active') ? 'Actif' : 'Inactif' ?>
                            </span>
                        </p>
                    </div>
                    
                    <div class="d-grid gap-2">
                        <a href="<?= BASE_URL ?>/user/update-profile" class="btn btn-outline-primary">
                            <i class="fas fa-edit me-2"></i> Modifier mon profil
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-8">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="fas fa-history me-2"></i> Mes derniers voyages consultés</h5>
                    <a href="<?= BASE_URL ?>/history" class="text-white">
                        <small>Voir tout <i class="fas fa-arrow-right ms-1"></i></small>
                    </a>
                </div>
                <div class="card-body">
                    <?php if (empty($viewedTrips)): ?>
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i> Vous n'avez pas encore consulté de voyage.
                        </div>
                        <div class="text-center">
                            <a href="<?= BASE_URL ?>/trips" class="btn btn-sm btn-outline-primary">
                                <i class="fas fa-search me-2"></i> Découvrir nos voyages
                            </a>
                        </div>
                    <?php else: ?>
                        <div class="row row-cols-1 row-cols-md-3 g-4">
                            <?php foreach (array_slice($viewedTrips, 0, 3) as $trip): ?>
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
                                             style="height: 120px; object-fit: cover;">
                                        <div class="card-body p-2">
                                            <h6 class="card-title"><?= htmlspecialchars($trip['title']) ?></h6>
                                            <p class="card-text small text-muted"><?= number_format($trip['price'], 0, ',', ' ') ?> €</p>
                                            <div class="d-flex gap-1 justify-content-end">
                                                <a href="<?= BASE_URL ?>/trip?id=<?= $trip['id'] ?>" class="btn btn-sm btn-outline-primary">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="<?= BASE_URL ?>/cart/add/<?= $trip['id'] ?>" class="btn btn-sm btn-outline-success">
                                                    <i class="fas fa-cart-plus"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        
                        <?php if (count($viewedTrips) > 3): ?>
                            <div class="text-center mt-3">
                                <a href="<?= BASE_URL ?>/history" class="btn btn-outline-primary">
                                    Voir tous les voyages consultés (<?= count($viewedTrips) ?>)
                                </a>
                            </div>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
            </div>
            
            <div class="card shadow-sm">
                <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="fas fa-shopping-bag me-2"></i> Mes voyages achetés</h5>
                    <a href="<?= BASE_URL ?>/history" class="text-white">
                        <small>Voir tout <i class="fas fa-arrow-right ms-1"></i></small>
                    </a>
                </div>
                <div class="card-body">
                    <?php if (empty($purchasedTrips)): ?>
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i> Vous n'avez pas encore acheté de voyage.
                        </div>
                        <div class="text-center">
                            <a href="<?= BASE_URL ?>/trips" class="btn btn-sm btn-outline-primary">
                                <i class="fas fa-search me-2"></i> Découvrir nos voyages
                            </a>
                        </div>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Voyage</th>
                                        <th>Date d'achat</th>
                                        <th>Prix</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($purchasedTrips as $index => $trip): 
                                        // On simule une date d'achat pour l'exemple
                                        $purchaseDate = date('d/m/Y', strtotime('-' . ($index + 1) . ' months')); 
                                    ?>
                                        <tr>
                                            <td>
                                                <a href="<?= BASE_URL ?>/trip?id=<?= $trip['id'] ?>" class="text-decoration-none fw-bold">
                                                    <?= htmlspecialchars($trip['title']) ?>
                                                </a>
                                            </td>
                                            <td><?= $purchaseDate ?></td>
                                            <td><?= number_format($trip['price'], 0, ',', ' ') ?> €</td>
                                            <td>
                                                <a href="<?= BASE_URL ?>/trip?id=<?= $trip['id'] ?>" class="btn btn-sm btn-outline-primary">
                                                    <i class="fas fa-eye"></i> Voir
                                                </a>
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
</div>
