<?php
/**
 * Vue pour le récapitulatif du voyage avant paiement
 * 
 * Cette page affiche un résumé du voyage et des options sélectionnées
 * avant de procéder au paiement
 */
?>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h1 class="h4 mb-0">Récapitulatif de votre voyage</h1>
                </div>
                <div class="card-body">
                    <h2 class="h5 mb-4"><?= htmlspecialchars($trip['title']) ?></h2>
                    
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <?php if (isset($trip['main_image'])): ?>
                            <img src="/assets/images/trips/<?= htmlspecialchars($trip['main_image']) ?>" class="img-fluid rounded" alt="<?= htmlspecialchars($trip['title']) ?>">
                            <?php endif; ?>
                        </div>
                        <div class="col-md-6">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item d-flex justify-content-between">
                                    <strong>Durée:</strong>
                                    <span><?= isset($trip['duration']) ? $trip['duration'] . ' jours' : 'Non spécifié' ?></span>
                                </li>
                                <?php if (isset($trip['region'])): ?>
                                <li class="list-group-item d-flex justify-content-between">
                                    <strong>Région:</strong>
                                    <span><?= htmlspecialchars($trip['region']) ?></span>
                                </li>
                                <?php endif; ?>
                                <li class="list-group-item d-flex justify-content-between">
                                    <strong>Nombre de voyageurs:</strong>
                                    <span><?= $nbTravelers ?></span>
                                </li>
                            </ul>
                        </div>
                    </div>
                    
                    <!-- Récapitulatif des prix -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h3 class="h5 mb-0">Détail des prix</h3>
                        </div>
                        <div class="card-body p-0">
                            <table class="table table-striped mb-0">
                                <thead>
                                    <tr>
                                        <th>Description</th>
                                        <th class="text-end">Prix unitaire</th>
                                        <th class="text-center">Quantité</th>
                                        <th class="text-end">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Forfait de base</td>
                                        <td class="text-end"><?= number_format($trip['price'], 2, ',', ' ') ?> €</td>
                                        <td class="text-center"><?= $nbTravelers ?></td>
                                        <td class="text-end"><?= number_format($trip['price'] * $nbTravelers, 2, ',', ' ') ?> €</td>
                                    </tr>
                                    
                                    <?php foreach ($options as $option): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($option['title']) ?></td>
                                        <td class="text-end"><?= number_format($option['price'], 2, ',', ' ') ?> €</td>
                                        <td class="text-center"><?= $nbTravelers ?></td>
                                        <td class="text-end"><?= number_format($option['price'] * $nbTravelers, 2, ',', ' ') ?> €</td>
                                    </tr>
                                    <?php endforeach; ?>
                                    
                                    <tr class="table-primary">
                                        <th colspan="3">Total</th>
                                        <th class="text-end"><?= number_format($totalPrice, 2, ',', ' ') ?> €</th>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    
                    <!-- Actions -->
                    <div class="d-flex justify-content-between">
                        <a href="/trip?id=<?= $trip['id'] ?>" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-left"></i> Modifier mes options
                        </a>
                        <a href="/payment?id=<?= $trip['id'] ?>" class="btn btn-primary">
                            Procéder au paiement <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> 