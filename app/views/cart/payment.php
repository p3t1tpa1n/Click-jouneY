<?php
/**
 * Vue pour la page de paiement du panier
 * 
 * Cette page affiche le formulaire de paiement CY Bank
 */
?>

<div class="container my-5 themed-container">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h1 class="h4 mb-0">Paiement de votre commande</h1>
                </div>
                <div class="card-body">
                    <!-- Résumé de la commande -->
                    <div class="alert alert-info mb-4">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-info-circle fa-2x me-3"></i>
                            <div>
                                <h4 class="h5 mb-1">Récapitulatif</h4>
                                <p class="mb-0">Montant total : <strong><?= number_format($totalPrice, 0, ',', ' ') ?> €</strong></p>
                                <p class="mb-0">Numéro de transaction : <strong><?= $transactionId ?></strong></p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Liste des voyages -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h3 class="h5 mb-0">Détails de votre commande</h3>
                        </div>
                        <div class="card-body p-0">
                            <table class="table table-striped mb-0">
                                <thead>
                                    <tr>
                                        <th>Voyage</th>
                                        <th>Région</th>
                                        <th class="text-end">Prix</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($cartItems as $trip): ?>
                                    <tr>
                                        <td>
                                            <strong><?= htmlspecialchars($trip['title']) ?></strong>
                                        </td>
                                        <td><?= htmlspecialchars($trip['region'] ?? 'N/A') ?></td>
                                        <td class="text-end"><?= number_format($trip['price'], 0, ',', ' ') ?> €</td>
                                    </tr>
                                    <?php endforeach; ?>
                                    
                                    <tr class="table-primary">
                                        <th colspan="2">Total</th>
                                        <th class="text-end"><?= number_format($totalPrice, 0, ',', ' ') ?> €</th>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    
                    <!-- Formulaire de paiement CY Bank -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h3 class="h5 mb-0">Paiement sécurisé CY Bank</h3>
                        </div>
                        <div class="card-body">
                            <div class="text-center mb-4">
                                <!-- <img src="<?= BASE_URL ?>/public/assets/images/cybank-logo.png" alt="CY Bank" class="img-fluid mb-3" style="max-width: 200px;"> -->
                                <h3 class="text-primary">CY Bank</h3>
                                <p>Vous allez être redirigé vers la plateforme de paiement sécurisée CY Bank pour finaliser votre commande.</p>
                            </div>
                            
                            <!-- Formulaire généré par CY Bank -->
                            <div class="cybank-form">
                                <?= $cyBankForm ?>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Actions -->
                    <div class="d-flex justify-content-between">
                        <a href="<?= BASE_URL ?>/index.php?route=cart/checkout" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left me-2"></i> Retour au récapitulatif
                        </a>
                        <button type="button" onclick="document.querySelector('.cybank-form form').submit();" class="btn btn-success">
                            <i class="fas fa-credit-card me-2"></i> Procéder au paiement
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Script pour soumettre automatiquement le formulaire CY Bank -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Soumettre automatiquement le formulaire après un court délai
        setTimeout(function() {
            const cyBankForm = document.querySelector('.cybank-form form');
            if (cyBankForm) {
                // cyBankForm.submit();
                // Commenté pour ne pas soumettre automatiquement pendant les tests
            }
        }, 5000);
    });
</script> 