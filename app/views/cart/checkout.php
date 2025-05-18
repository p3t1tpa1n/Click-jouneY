<?php
/**
 * Vue pour le récapitulatif de commande (panier)
 * 
 * Cette page affiche un résumé de tous les voyages du panier
 * avant de procéder au paiement
 */
?>

<div class="container my-5 themed-container">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h1 class="h4 mb-0">Récapitulatif de votre commande</h1>
                </div>
                <div class="card-body">
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i> 
                        Bonjour <strong><?= htmlspecialchars($userName) ?></strong>, voici le récapitulatif de votre commande.
                    </div>
                    
                    <!-- Liste des voyages -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h3 class="h5 mb-0">Voyages sélectionnés</h3>
                        </div>
                        <div class="card-body p-0">
                            <table class="table table-striped mb-0">
                                <thead>
                                    <tr>
                                        <th>Voyage</th>
                                        <th>Région</th>
                                        <th>Durée</th>
                                        <th class="text-end">Prix</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($cartItems as $trip): ?>
                                    <tr>
                                        <td>
                                            <a href="<?= BASE_URL ?>/index.php?route=trip&id=<?= $trip['id'] ?>" class="text-decoration-none">
                                                <strong><?= htmlspecialchars($trip['title']) ?></strong>
                                            </a>
                                        </td>
                                        <td><?= htmlspecialchars($trip['region'] ?? 'N/A') ?></td>
                                        <td><?= isset($trip['duration']) ? $trip['duration'] . ' jours' : 'N/A' ?></td>
                                        <td class="text-end"><?= number_format($trip['price'], 0, ',', ' ') ?> €</td>
                                    </tr>
                                    <?php endforeach; ?>
                                    
                                    <tr class="table-primary">
                                        <th colspan="3">Total</th>
                                        <th class="text-end"><?= number_format($totalPrice, 0, ',', ' ') ?> €</th>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    
                    <!-- Informations de paiement -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h3 class="h5 mb-0">Informations de paiement</h3>
                        </div>
                        <div class="card-body">
                            <p>Votre paiement sera traité de manière sécurisée par CY Bank.</p>
                            <p>Pour rappel, le montant total de votre commande est de <strong><?= number_format($totalPrice, 0, ',', ' ') ?> €</strong>.</p>
                            <p>En cliquant sur le bouton ci-dessous, vous serez redirigé vers la plateforme de paiement sécurisée.</p>
                        </div>
                    </div>
                    
                    <!-- Actions -->
                    <div class="d-flex justify-content-between">
                        <a href="<?= BASE_URL ?>/index.php?route=cart" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left me-2"></i> Retour au panier
                        </a>
                        <a href="<?= BASE_URL ?>/index.php?route=cart/payment" class="btn btn-success">
                            <i class="fas fa-credit-card me-2"></i> Procéder au paiement
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> 