<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h2 class="h4 mb-0">Simulation CY Bank - Paiement sécurisé</h2>
                </div>
                <div class="card-body">
                    <div class="text-center mb-4">
                        <h3 class="text-primary">CY Bank</h3>
                        <p class="lead">Interface de paiement (SIMULATION)</p>
                        <div class="alert alert-warning">
                            <strong>Attention :</strong> Ceci est une simulation de paiement pour les tests. Aucune transaction réelle n'est effectuée.
                        </div>
                    </div>

                    <div class="card mb-4">
                        <div class="card-header">
                            <h3 class="h5 mb-0">Détails de la transaction</h3>
                        </div>
                        <div class="card-body">
                            <table class="table">
                                <tr>
                                    <th>Identifiant de transaction :</th>
                                    <td><?= htmlspecialchars($transaction) ?></td>
                                </tr>
                                <tr>
                                    <th>Montant :</th>
                                    <td><?= htmlspecialchars($montant) ?> €</td>
                                </tr>
                                <tr>
                                    <th>Vendeur :</th>
                                    <td><?= htmlspecialchars($vendeur) ?></td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <div class="card mb-4">
                        <div class="card-header">
                            <h3 class="h5 mb-0">Informations de carte (Simulation)</h3>
                        </div>
                        <div class="card-body">
                            <form action="<?= BASE_URL ?>/index.php?route=payment-complete-simulation" method="POST">
                                <div class="mb-3">
                                    <label for="card_number" class="form-label">Numéro de carte</label>
                                    <input type="text" class="form-control" id="card_number" value="5555 1234 5678 9000" readonly>
                                    <div class="form-text">Carte de test préremplie pour la simulation</div>
                                </div>
                                
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="expiry" class="form-label">Date d'expiration</label>
                                        <input type="text" class="form-control" id="expiry" value="12/25" readonly>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="cvv" class="form-label">Code de sécurité (CVV)</label>
                                        <input type="text" class="form-control" id="cvv" value="555" readonly>
                                    </div>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="cardholder" class="form-label">Titulaire de la carte</label>
                                    <input type="text" class="form-control" id="cardholder" value="UTILISATEUR TEST" readonly>
                                </div>
                                
                                <hr class="my-4">
                                
                                <div class="mb-3">
                                    <label class="form-label">Simuler le résultat du paiement :</label>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="payment_status" id="payment_success" value="accepted" checked>
                                        <label class="form-check-label" for="payment_success">
                                            Paiement accepté
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="payment_status" id="payment_failure" value="refused">
                                        <label class="form-check-label" for="payment_failure">
                                            Paiement refusé
                                        </label>
                                    </div>
                                </div>
                                
                                <div class="d-grid">
                                    <button type="submit" class="btn btn-success btn-lg">
                                        <i class="fas fa-check-circle me-2"></i> Valider le paiement
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                    
                    <div class="text-center">
                        <small class="text-muted">
                            <i class="fas fa-shield-alt me-1"></i> Simulation sécurisée - Aucune donnée réelle n'est traitée
                        </small>
                    </div>
                </div>
                <div class="card-footer text-center">
                    <a href="<?= BASE_URL ?>" class="btn btn-outline-secondary">
                        <i class="fas fa-times me-2"></i> Annuler le paiement
                    </a>
                </div>
            </div>
        </div>
    </div>
</div> 