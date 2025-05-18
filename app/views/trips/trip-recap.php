<?php
/**
 * Vue pour le récapitulatif du voyage
 * 
 * Cette page affiche le récapitulatif du voyage choisi avec les options sélectionnées
 * avant de procéder au paiement
 */
?>

<div class="container my-5">
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= BASE_URL ?>/">Accueil</a></li>
            <li class="breadcrumb-item"><a href="<?= BASE_URL ?>/index.php?route=trips">Voyages</a></li>
            <li class="breadcrumb-item"><a href="<?= BASE_URL ?>/index.php?route=trip&id=<?= $trip['id'] ?>"><?= htmlspecialchars($trip['title']) ?></a></li>
            <li class="breadcrumb-item active" aria-current="page">Récapitulatif</li>
        </ol>
    </nav>

    <div class="row">
        <div class="col-lg-8 mx-auto">
            <!-- Message de notification pour les sauvegardes -->
            <div id="save-notification" class="alert alert-success alert-dismissible fade" role="alert">
                <span id="notification-message">Vos sélections ont été enregistrées avec succès.</span>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fermer"></button>
            </div>
            
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-primary text-white">
                    <h1 class="h3 mb-0">Récapitulatif de votre voyage</h1>
                </div>
                <div class="card-body">
                    <h2 class="h4 mb-3"><?= htmlspecialchars($trip['title']) ?></h2>
                    
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <?php 
                            $folderId = $trip['id'] ?? 1;
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
                            <img src="<?= $imagePath ?>" class="img-fluid rounded" alt="<?= htmlspecialchars($trip['title']) ?>">
                        </div>
                        <div class="col-md-6">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <span>Durée</span>
                                    <span><?= isset($trip['duration']) ? $trip['duration'] . ' jours' : 'Non spécifié' ?></span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <span>Région</span>
                                    <span><?= htmlspecialchars($trip['region'] ?? 'Non spécifié') ?></span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <span>Nombre de voyageurs</span>
                                    <div class="d-flex align-items-center">
                                        <button class="btn btn-sm btn-outline-primary me-2" id="decrease-travelers">-</button>
                                        <span id="travelers-count"><?= (int)($_GET['nb_travelers'] ?? 1) ?></span>
                                        <button class="btn btn-sm btn-outline-primary ms-2" id="increase-travelers">+</button>
                                        <input type="hidden" id="nb-travelers" name="nb_travelers" value="<?= (int)($_GET['nb_travelers'] ?? 1) ?>">
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <h3 class="h5 mb-3">Détails du prix</h3>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead class="table-light">
                                    <tr>
                                        <th>Désignation</th>
                                        <th class="text-end">Prix unitaire</th>
                                        <th class="text-center">Quantité</th>
                                        <th class="text-end">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Forfait voyage de base</td>
                                        <td class="text-end"><?= number_format($trip['price'], 2, ',', ' ') ?> €</td>
                                        <td class="text-center"><span id="travelers-display"><?= (int)($_GET['nb_travelers'] ?? 1) ?></span></td>
                                        <td class="text-end"><span id="base-price-total"><?= number_format($trip['price'] * ((int)($_GET['nb_travelers'] ?? 1)), 2, ',', ' ') ?></span> €</td>
                                    </tr>
                                    
                                    <?php if (isset($_GET['options']) && is_array($_GET['options']) && !empty($trip['options'])): ?>
                                        <?php foreach ($_GET['options'] as $optionId): ?>
                                            <?php if (isset($trip['options'][$optionId])): ?>
                                                <tr class="option-row" data-option-id="<?= $optionId ?>" data-price="<?= $trip['options'][$optionId]['price'] ?>">
                                                    <td>
                                                        <?= htmlspecialchars($trip['options'][$optionId]['title']) ?>
                                                        <div class="form-check">
                                                            <input class="form-check-input option-checkbox" type="checkbox" id="option-<?= $optionId ?>" data-option-id="<?= $optionId ?>" checked>
                                                            <label class="form-check-label small text-muted" for="option-<?= $optionId ?>">
                                                                Inclus dans le voyage
                                                            </label>
                                                        </div>
                                                    </td>
                                                    <td class="text-end"><?= number_format($trip['options'][$optionId]['price'], 2, ',', ' ') ?> €</td>
                                                    <td class="text-center">1</td>
                                                    <td class="text-end"><span class="option-price"><?= number_format($trip['options'][$optionId]['price'], 2, ',', ' ') ?></span> €</td>
                                                </tr>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                    
                                    <tr class="table-light fw-bold">
                                        <td colspan="3" class="text-end">Total</td>
                                        <td class="text-end"><span id="total-price"><?= number_format(
                                            $trip['price'] * ((int)($_GET['nb_travelers'] ?? 1)) + 
                                            (isset($_GET['options']) && is_array($_GET['options']) ? 
                                                array_reduce($_GET['options'], function($total, $optionId) use ($trip) {
                                                    return $total + (isset($trip['options'][$optionId]) ? $trip['options'][$optionId]['price'] : 0);
                                                }, 0) : 0)
                                        , 2, ',', ' ') ?></span> €</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    
                    <div class="d-grid gap-2">
                        <a href="<?= BASE_URL ?>/index.php?route=checkout&trip_id=<?= $trip['id'] ?>&nb_travelers=<?= (int)($_GET['nb_travelers'] ?? 1) ?><?= 
                            isset($_GET['options']) && is_array($_GET['options']) ? '&' . http_build_query(['options' => $_GET['options']]) : '' 
                        ?>" class="btn btn-primary btn-lg">
                            Procéder au paiement
                        </a>
                        <a href="<?= BASE_URL ?>/index.php?route=trip&id=<?= $trip['id'] ?>" class="btn btn-outline-secondary">
                            Modifier ma sélection
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Variables pour les calculs de prix
    const basePrice = <?= floatval($trip['price']) ?>;
    let nbTravelers = parseInt(document.getElementById('nb-travelers').value) || 1;
    
    // Éléments du DOM
    const decreaseBtn = document.getElementById('decrease-travelers');
    const increaseBtn = document.getElementById('increase-travelers');
    const travelersCount = document.getElementById('travelers-count');
    const travelersDisplay = document.getElementById('travelers-display');
    const basePriceTotal = document.getElementById('base-price-total');
    const totalPrice = document.getElementById('total-price');
    const optionCheckboxes = document.querySelectorAll('.option-checkbox');
    
    // Fonction pour mettre à jour le nombre de voyageurs
    function updateTravelers(change) {
        nbTravelers = Math.max(1, Math.min(10, nbTravelers + change));
        document.getElementById('nb-travelers').value = nbTravelers;
        travelersCount.textContent = nbTravelers;
        travelersDisplay.textContent = nbTravelers;
        updatePrices();
        saveSelections();
    }
    
    // Fonction pour mettre à jour tous les prix
    function updatePrices() {
        // Calculer le prix de base
        const basePriceTotalValue = basePrice * nbTravelers;
        basePriceTotal.textContent = formatPrice(basePriceTotalValue);
        
        // Calculer le total des options sélectionnées
        let optionsTotal = 0;
        document.querySelectorAll('.option-row').forEach(row => {
            const optionId = row.dataset.optionId;
            const checkbox = document.querySelector(`#option-${optionId}`);
            const priceElement = row.querySelector('.option-price');
            const optionPrice = parseFloat(row.dataset.price);
            
            if (checkbox.checked) {
                optionsTotal += optionPrice;
                row.classList.remove('text-muted');
                priceElement.textContent = formatPrice(optionPrice);
            } else {
                row.classList.add('text-muted');
                priceElement.textContent = '0,00';
            }
        });
        
        // Mettre à jour le prix total
        const finalTotal = basePriceTotalValue + optionsTotal;
        totalPrice.textContent = formatPrice(finalTotal);
        
        // Mettre à jour l'URL du bouton de paiement
        const checkoutBtn = document.querySelector('a.btn-primary');
        if (checkoutBtn) {
            let url = `<?= BASE_URL ?>/index.php?route=checkout&trip_id=<?= $trip['id'] ?>&nb_travelers=${nbTravelers}`;
            
            // Ajouter les options sélectionnées à l'URL
            const selectedOptions = [];
            optionCheckboxes.forEach(checkbox => {
                if (checkbox.checked) {
                    selectedOptions.push(checkbox.dataset.optionId);
                }
            });
            
            if (selectedOptions.length > 0) {
                url += '&' + selectedOptions.map(id => `options[]=${id}`).join('&');
            }
            
            checkoutBtn.href = url;
        }
        
        // Animer les prix qui changent
        totalPrice.classList.add('price-updated');
        setTimeout(() => {
            totalPrice.classList.remove('price-updated');
        }, 500);
    }
    
    // Fonction pour enregistrer les sélections via AJAX
    function saveSelections() {
        // Collecter les options sélectionnées
        const selectedOptions = [];
        optionCheckboxes.forEach(checkbox => {
            if (checkbox.checked) {
                selectedOptions.push(checkbox.dataset.optionId);
            }
        });
        
        // Créer les données à envoyer
        const data = new FormData();
        data.append('action', 'save_recap_selections');
        data.append('trip_id', <?= $trip['id'] ?>);
        data.append('nb_travelers', nbTravelers);
        selectedOptions.forEach(optionId => {
            data.append('options[]', optionId);
        });
        
        // Envoyer la requête AJAX
        fetch('<?= BASE_URL ?>/index.php?route=ajax-save-selections', {
            method: 'POST',
            body: data,
            credentials: 'same-origin',
            headers: {
                'Cache-Control': 'no-cache',
            }
        })
        .then(response => response.json())
        .then(data => {
            console.log('Sélections sauvegardées', data);
            
            // Afficher la notification
            const notification = document.getElementById('save-notification');
            const message = document.getElementById('notification-message');
            message.textContent = 'Vos sélections ont été enregistrées avec succès.';
            notification.classList.add('show');
            
            // Masquer la notification après 3 secondes
            setTimeout(() => {
                notification.classList.remove('show');
            }, 3000);
            
            // Mettre à jour l'URL de la page pour éviter la perte de données au rafraîchissement
            const url = new URL(window.location.href);
            url.searchParams.set('nb_travelers', nbTravelers);
            
            // Enlever toutes les options existantes
            url.searchParams.delete('options[]');
            
            // Ajouter les options sélectionnées
            selectedOptions.forEach(optionId => {
                url.searchParams.append('options[]', optionId);
            });
            
            // Mettre à jour l'URL sans recharger la page
            window.history.replaceState({}, '', url.toString());
        })
        .catch(error => {
            console.error('Erreur lors de la sauvegarde des sélections:', error);
            
            // Afficher une notification d'erreur
            const notification = document.getElementById('save-notification');
            const message = document.getElementById('notification-message');
            message.textContent = 'Une erreur est survenue lors de la sauvegarde de vos sélections.';
            notification.classList.remove('alert-success');
            notification.classList.add('alert-danger', 'show');
            
            // Masquer la notification après 4 secondes
            setTimeout(() => {
                notification.classList.remove('show');
                notification.classList.remove('alert-danger');
                notification.classList.add('alert-success');
            }, 4000);
        });
    }
    
    // Fonction pour formater les prix
    function formatPrice(price) {
        return new Intl.NumberFormat('fr-FR', { 
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        }).format(price);
    }
    
    // Événements pour les boutons de nombre de voyageurs
    decreaseBtn.addEventListener('click', () => updateTravelers(-1));
    increaseBtn.addEventListener('click', () => updateTravelers(1));
    
    // Événements pour les cases à cocher des options
    optionCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', () => {
            updatePrices();
            saveSelections();
        });
    });
    
    // Initialiser les prix
    updatePrices();
    
    // Ajouter une animation pour la mise à jour des prix
    const style = document.createElement('style');
    style.textContent = `
        @keyframes priceUpdate {
            0% { color: var(--bs-primary); }
            50% { color: var(--bs-success); }
            100% { color: var(--bs-primary); }
        }
        .price-updated {
            animation: priceUpdate 0.5s ease;
        }
    `;
    document.head.appendChild(style);
});
</script> 