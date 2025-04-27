<?php
/**
 * Vue pour la page de paiement
 * 
 * Cette page affiche le formulaire de paiement pour finaliser la réservation du voyage
 */
?>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h1 class="h4 mb-0">Paiement</h1>
                </div>
                <div class="card-body">
                    <!-- Résumé de la commande -->
                    <div class="mb-4">
                        <h2 class="h5 mb-3">Résumé de votre commande</h2>
                        <div class="d-flex justify-content-between">
                            <div>
                                <p class="mb-0"><strong><?= htmlspecialchars($trip['title']) ?></strong></p>
                                <p class="text-muted">Transaction #<?= $transactionId ?></p>
                            </div>
                            <div class="text-end">
                                <p class="h4 text-primary mb-0"><?= number_format($totalPrice, 2, ',', ' ') ?> €</p>
                                <p class="text-muted"><?= $nbTravelers ?> voyageur(s)</p>
                            </div>
                        </div>
                    </div>
                    
                    <hr class="my-4">
                    
                    <!-- Récapitulatif des produits -->
                    <div class="mb-4">
                        <h3 class="h5 mb-3">Détail de votre réservation</h3>
                        <table class="table table-striped">
                            <thead class="table-light">
                                <tr>
                                    <th>Description</th>
                                    <th class="text-center">Quantité</th>
                                    <th class="text-end">Prix</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><?= htmlspecialchars($trip['title']) ?></td>
                                    <td class="text-center"><?= $nbTravelers ?></td>
                                    <td class="text-end"><?= number_format($trip['price'] * $nbTravelers, 2, ',', ' ') ?> €</td>
                                </tr>
                                
                                <?php foreach ($options as $option): ?>
                                <tr>
                                    <td><em><?= htmlspecialchars($option['title']) ?></em></td>
                                    <td class="text-center"><?= $nbTravelers ?></td>
                                    <td class="text-end"><?= number_format($option['price'] * $nbTravelers, 2, ',', ' ') ?> €</td>
                                </tr>
                                <?php endforeach; ?>
                                
                                <tr class="table-primary">
                                    <th colspan="2">Total</th>
                                    <th class="text-end"><?= number_format($totalPrice, 2, ',', ' ') ?> €</th>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    
                    <hr class="my-4">
                    
                    <!-- Paiement sécurisé -->
                    <div class="text-center mb-4">
                        <h3 class="h5 mb-3">Paiement sécurisé via CYBank</h3>
                        <p class="mb-4">
                            Cliquez sur le bouton ci-dessous pour être redirigé vers notre partenaire de paiement sécurisé.
                            <br>
                            <small class="text-muted">Vos informations bancaires ne sont pas stockées sur notre site.</small>
                        </p>
                        
                        <div class="alert alert-info">
                            <p class="mb-0">
                                <i class="fas fa-info-circle me-2"></i>
                                <strong>Note :</strong> Pour tester le paiement, utilisez la carte suivante :
                            </p>
                            <ul class="text-start mt-2 mb-0">
                                <li>Numéro de carte : 5555 1234 5678 9000</li>
                                <li>Cryptogramme : 555</li>
                                <li>Date d'expiration : n'importe quelle date future</li>
                                <li>Titulaire : n'importe quel nom</li>
                            </ul>
                        </div>
                        
                        <div class="mt-4">
                            <!-- Conditions d'utilisation -->
                            <div class="form-check text-start mb-4">
                                <input class="form-check-input" type="checkbox" id="terms" required>
                                <label class="form-check-label" for="terms">
                                    J'accepte les <a href="#" data-bs-toggle="modal" data-bs-target="#termsModal">conditions générales de vente</a> et la <a href="#" data-bs-toggle="modal" data-bs-target="#privacyModal">politique de confidentialité</a>.
                                </label>
                            </div>
                            
                            <!-- Boutons d'action -->
                            <div class="d-flex justify-content-between">
                                <a href="?route=trip-recap&id=<?= $trip['id'] ?>" class="btn btn-outline-secondary">
                                    <i class="fas fa-arrow-left"></i> Retour au récapitulatif
                                </a>
                                <div id="payment-button-container" style="opacity: 0.5; pointer-events: none;">
                                    <?= $cyBankForm ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-center">
                    <small class="text-muted">
                        <i class="fas fa-shield-alt"></i> Paiement sécurisé par CYBank. Vos informations sont cryptées.
                    </small>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Conditions Générales -->
<div class="modal fade" id="termsModal" tabindex="-1" aria-labelledby="termsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="termsModalLabel">Conditions Générales de Vente</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h6>1. Réservation et paiement</h6>
                <p>La réservation n'est effective qu'après paiement complet du voyage. Le paiement s'effectue en ligne par carte bancaire.</p>
                
                <h6>2. Annulation et remboursement</h6>
                <p>En cas d'annulation de votre part, des frais peuvent s'appliquer selon le délai avant le départ :</p>
                <ul>
                    <li>Plus de 30 jours : 10% du prix total</li>
                    <li>De 30 à 15 jours : 50% du prix total</li>
                    <li>Moins de 15 jours : 100% du prix total</li>
                </ul>
                
                <h6>3. Modifications</h6>
                <p>Toute modification de réservation peut entraîner des frais supplémentaires.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Politique de confidentialité -->
<div class="modal fade" id="privacyModal" tabindex="-1" aria-labelledby="privacyModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="privacyModalLabel">Politique de Confidentialité</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Nous collectons vos données personnelles uniquement dans le but de traiter votre réservation et d'améliorer votre expérience sur notre site.</p>
                <p>Vos informations bancaires sont sécurisées et ne sont jamais stockées sur nos serveurs.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
            </div>
        </div>
    </div>
</div>

<script>
// Activer/désactiver le bouton de paiement selon la case à cocher des conditions
document.getElementById('terms').addEventListener('change', function() {
    const paymentContainer = document.getElementById('payment-button-container');
    
    if (this.checked) {
        paymentContainer.style.opacity = '1';
        paymentContainer.style.pointerEvents = 'auto';
    } else {
        paymentContainer.style.opacity = '0.5';
        paymentContainer.style.pointerEvents = 'none';
    }
});
</script> 