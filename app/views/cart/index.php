<?php
/**
 * Vue du panier
 */
?>

<div class="container mt-5 themed-container">
    <h1 class="mb-4">Mon panier</h1>
    
    <?php if (empty($cartItems)): ?>
        <div class="alert alert-info">
            <i class="fas fa-info-circle me-2"></i> Votre panier est vide.
        </div>
        <div class="text-center mt-4">
            <a href="<?= BASE_URL ?>/index.php?route=trips" class="btn btn-primary">
                <i class="fas fa-search me-2"></i> Découvrir nos voyages
            </a>
        </div>
    <?php else: ?>
        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Voyage</th>
                            <th>Durée</th>
                            <th>Prix</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($cartItems as $item): ?>
                            <tr>
                                <td>
                                    <a href="<?= BASE_URL ?>/index.php?route=trip&id=<?= $item['trip']['id'] ?? 0 ?>" class="text-decoration-none">
                                        <strong><?= htmlspecialchars($item['trip']['title'] ?? 'Voyage inconnu') ?></strong>
                                    </a>
                                    <div class="small text-muted"><?= htmlspecialchars($item['trip']['region'] ?? 'Région inconnue') ?></div>
                                    
                                    <form action="<?= BASE_URL ?>/index.php?route=cart/update" method="post" class="mt-2">
                                        <input type="hidden" name="trip_id" value="<?= $item['trip']['id'] ?? 0 ?>">
                                        
                                        <div class="form-group mb-2">
                                            <label class="small mb-1"><i class="fas fa-users me-1"></i> Voyageurs</label>
                                            <select name="nb_travelers" class="form-select form-select-sm">
                                                <?php for ($i = 1; $i <= 10; $i++): ?>
                                                <option value="<?= $i ?>" <?= $item['nb_travelers'] == $i ? 'selected' : '' ?>>
                                                    <?= $i ?> voyageur<?= $i > 1 ? 's' : '' ?>
                                                </option>
                                                <?php endfor; ?>
                                            </select>
                                        </div>
                                        
                                        <?php if (!empty($item['trip']['options'])): ?>
                                        <div class="form-group mb-2">
                                            <label class="small mb-1"><i class="fas fa-plus-circle me-1"></i> Options</label>
                                            <?php foreach ($item['trip']['options'] as $optId => $option): ?>
                                            <div class="form-check">
                                                <input type="checkbox" name="options[]" value="<?= $optId ?>" 
                                                       id="opt_<?= $item['trip']['id'] ?>_<?= $optId ?>" class="form-check-input"
                                                       <?= in_array($optId, array_column($item['selectedOptions'], 'id')) ? 'checked' : '' ?>>
                                                <label for="opt_<?= $item['trip']['id'] ?>_<?= $optId ?>" class="form-check-label small">
                                                    <?= htmlspecialchars($option['title']) ?> (+<?= number_format($option['price'], 0, ',', ' ') ?> €)
                                                </label>
                                            </div>
                                            <?php endforeach; ?>
                                        </div>
                                        <?php endif; ?>
                                        
                                        <button type="submit" class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-sync-alt me-1"></i> Mettre à jour
                                        </button>
                                    </form>
                                </td>
                                <td><?= $item['trip']['duration'] ?? 0 ?> jours</td>
                                <td><?= number_format($item['total'] ?? 0, 0, ',', ' ') ?> €</td>
                                <td>
                                    <form method="post" action="<?= BASE_URL ?>/index.php?route=cart/remove" class="d-inline">
                                        <input type="hidden" name="trip_id" value="<?= $item['trip']['id'] ?? 0 ?>">
                                        <button type="submit" class="btn btn-sm btn-outline-danger" 
                                                onclick="return confirm('Êtes-vous sûr de vouloir retirer ce voyage du panier?')">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                        <tr class="fw-bold">
                            <td colspan="2" class="text-end">Total :</td>
                            <td><?= number_format($totalPrice, 0, ',', ' ') ?> €</td>
                            <td></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
        
        <div class="d-flex justify-content-between">
            <form method="post" action="<?= BASE_URL ?>/index.php?route=cart/clear">
                <button type="submit" class="btn btn-outline-secondary" 
                        onclick="return confirm('Êtes-vous sûr de vouloir vider votre panier?')">
                    <i class="fas fa-trash-alt me-2"></i> Vider le panier
                </button>
            </form>
            
            <div>
                <a href="<?= BASE_URL ?>/index.php?route=trips" class="btn btn-outline-primary me-2">
                    <i class="fas fa-arrow-left me-2"></i> Continuer les achats
                </a>
                <a href="<?= BASE_URL ?>/index.php?route=cart/checkout" class="btn btn-success">
                    <i class="fas fa-cash-register me-2"></i> Passer à la caisse
                </a>
            </div>
        </div>
    <?php endif; ?>
</div> 