<?php
/**
 * Vue pour l'affichage de la liste des voyages
 * 
 * Cette page affiche les voyages disponibles avec une barre de recherche et des filtres
 */
?>

<section class="search-hero">
    <div class="search-overlay"></div>
    <div class="container">
        <div class="search-hero-content">
            <h1><?= $title ?></h1>
            <p>Découvrez nos circuits personnalisés sur la mythique Route 66</p>
        </div>
    </div>
</section>

<section class="search-section">
    <div class="container themed-container">
        <!-- Recherche simple uniquement -->
        <div class="search-box mb-5">
            <form action="<?= BASE_URL ?>/index.php" method="GET" id="search-form">
                <input type="hidden" name="route" value="trips">
                
                <div class="search-form-content">
                    <div class="form-group">
                        <label for="query">Recherche par mots-clés</label>
                        <div class="input-with-icon">
                            <i class="fas fa-search"></i>
                            <input type="text" class="form-control form-control-lg" id="query" name="query" value="<?= htmlspecialchars($query) ?>" placeholder="Où souhaitez-vous voyager sur la Route 66 ?">
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="region">Région</label>
                            <div class="input-with-icon">
                                <i class="fas fa-map-marker-alt"></i>
                                <select class="form-control" id="region" name="region">
                                    <option value="">Toutes les régions</option>
                                    <?php foreach ($regions as $r): ?>
                                    <option value="<?= htmlspecialchars($r) ?>" <?= $region == $r ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($r) ?>
                                    </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        
                        <div class="form-group col-md-4">
                            <label for="min-price">Prix min</label>
                            <div class="input-with-icon">
                                <i class="fas fa-euro-sign"></i>
                                <input type="number" class="form-control" id="min-price" name="min_price" value="<?= $minPrice ?>" placeholder="0">
                            </div>
                        </div>
                        
                        <div class="form-group col-md-4">
                            <label for="max-price">Prix max</label>
                            <div class="input-with-icon">
                                <i class="fas fa-euro-sign"></i>
                                <input type="number" class="form-control" id="max-price" name="max_price" value="<?= $maxPrice ?>" placeholder="10000">
                            </div>
                        </div>
                    </div>
                    
                    <div class="search-actions">
                        <button type="reset" class="btn btn-outline-secondary">
                            <i class="fas fa-redo"></i> Réinitialiser
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-filter"></i> Filtrer les résultats
                        </button>
                    </div>
                </div>
            </form>
        </div>
        
        <?php if (empty($trips)): ?>
        <!-- Message "aucun voyage trouvé" avec classes de thème -->
        <div id="no-results-absolute" class="theme-element">
            <div class="no-results-icon">
                <i class="fas fa-search theme-icon"></i>
            </div>
            <h2 class="theme-text">Aucun voyage ne correspond à votre recherche</h2>
            <p class="theme-text">Essayez d'autres critères ou parcourez tous nos voyages ci-dessous.</p>
            <a href="index.php?route=trips" class="btn theme-button">
                <i class="fas fa-redo"></i> Voir tous les voyages
            </a>
        </div>
        <?php else: ?>
        
        <!-- Résultats de recherche -->
        <div class="search-results">
            <div class="search-results-header d-flex justify-content-between align-items-center mb-4">
                <div class="results-count">
                    <h2 class="h5 mb-0 section-title"><?= count($trips) ?> voyage(s) trouvé(s)</h2>
                </div>
                <div class="results-sort">
                    <select class="form-select" id="sort-results">
                        <option value="price-asc">Prix croissant</option>
                        <option value="price-desc">Prix décroissant</option>
                        <option value="duration-asc">Durée croissante</option>
                        <option value="duration-desc">Durée décroissante</option>
                    </select>
                </div>
            </div>
            
            <div class="trips-grid">
                <?php foreach ($trips as $trip): ?>
                <div class="trip-card theme-card" data-price="<?= $trip['price'] ?? 0 ?>" data-duration="<?= isset($trip['duration']) ? $trip['duration'] : 0 ?>">
                    <div class="trip-image">
                        <?php
                        // ID du voyage
                        $folderId = $trip['id'] ?? 1;

                        // Chemin et nom exacts des images pour chaque voyage
                        if ($folderId == 1) {
                            $imagePath = BASE_URL . '/ClickJourney/1.Chicago Los Angeles/arnaud-steckle-MtYedjwRgAA-unsplash.jpg';
                        } elseif ($folderId == 2) {
                            $imagePath = BASE_URL . '/ClickJourney/2.Floride/aurora-kreativ-UN4cs4zNCYo-unsplash.jpg';
                        } elseif ($folderId == 3) {
                            $imagePath = BASE_URL . '/ClickJourney/3.Parcs Nationaux/bailey-zindel-NRQV-hBF1OM-unsplash.jpg';
                        } elseif ($folderId == 4) {
                            $imagePath = BASE_URL . '/ClickJourney/4.New York/alexander-rotker--aQ4FsonXEs-unsplash.jpg';
                        } elseif ($folderId == 5) {
                            $imagePath = BASE_URL . '/ClickJourney/5.Côte Ouest/andrea-leopardi-QfhbZfIf0nA-unsplash.jpg';
                        } elseif ($folderId == 6) {
                            $imagePath = BASE_URL . '/ClickJourney/6.La Musique du Sud/eric-tompkins-CfknQWR2jj8-unsplash.jpg';
                        } elseif ($folderId == 7) {
                            $imagePath = BASE_URL . '/ClickJourney/7.Alaska/christian-bowen-ukxrl_4Umfqc-unsplash.jpg';
                        } elseif ($folderId == 8) {
                            $imagePath = BASE_URL . '/ClickJourney/8.Hawaii/pexels-lastly-412681.jpg';
                        } elseif ($folderId == 9) {
                            $imagePath = BASE_URL . '/ClickJourney/9.Route Historique/bella-kozak-lVx4TsJRZao-unsplash.jpg';
                        } elseif ($folderId == 10) {
                            $imagePath = BASE_URL . '/ClickJourney/10.Grands Lacs et Chicago/edward-koorey-Gcc3c6MFSM0-unsplash.jpg';
                        } else {
                            // Image par défaut si l'ID n'est pas reconnu
                            $imagePath = BASE_URL . '/assets/images/backgrounds/route66-hero.jpg';
                        }

                        // Image de fallback
                        $fallbackImage = BASE_URL . '/assets/images/backgrounds/route66-hero.jpg';
                        ?>
                        <img src="<?= $imagePath ?>" class="card-img-top" alt="<?= htmlspecialchars($trip['title'] ?? 'Voyage Route 66') ?>" 
                             onerror="this.onerror=null; this.src='<?= $fallbackImage ?>'" 
                             style="height: 200px; object-fit: cover;">
                        
                        <div class="trip-badges">
                            <?php if (isset($trip['region'])): ?>
                            <span class="badge bg-info"><?= htmlspecialchars($trip['region']) ?></span>
                            <?php endif; ?>
                            
                            <?php if (isset($trip['duration'])): ?>
                            <span class="badge bg-secondary trip-duration">
                                <i class="far fa-clock"></i> <?= $trip['duration'] ?> jours
                            </span>
                            <?php endif; ?>
                        </div>
                    </div>
                    
                    <div class="trip-content">
                        <h3 class="trip-title"><?= htmlspecialchars($trip['title'] ?? 'Circuit Route 66') ?></h3>
                        <div class="trip-highlights">
                            <?php 
                            // Générer quelques points forts aléatoires
                            $highlights = [
                                '<i class="fas fa-map-marker-alt"></i> Étapes emblématiques',
                                '<i class="fas fa-hotel"></i> Hôtels authentiques',
                                '<i class="fas fa-camera"></i> Spots photos uniques',
                                '<i class="fas fa-utensils"></i> Diners typiques',
                                '<i class="fas fa-car"></i> Location de véhicule',
                                '<i class="fas fa-mountain"></i> Paysages variés',
                                '<i class="fas fa-monument"></i> Sites historiques'
                            ];
                            shuffle($highlights);
                            $selectedHighlights = array_slice($highlights, 0, 3);
                            ?>
                            
                            <ul class="trip-features">
                                <?php foreach ($selectedHighlights as $highlight): ?>
                                <li><?= $highlight ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                        <p class="trip-description"><?= htmlspecialchars(substr($trip['description'] ?? 'Découvrez ce circuit étonnant à travers l\'Amérique', 0, 120)) ?>...</p>
                        
                        <div class="trip-footer">
                            <div class="trip-price">
                                <span class="trip-price-prefix">À partir de</span><br>
                                <?= number_format($trip['price'] ?? 0, 2, ',', ' ') ?> €
                            </div>
                            <a href="<?= BASE_URL ?>/index.php?route=trip&id=<?= $trip['id'] ?>" class="btn btn-primary btn-sm">
                                <i class="fas fa-info-circle"></i> Détails
                            </a>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            
            <?php if (isset($pagination) && $pagination['total_pages'] > 1): ?>
            <div class="pagination-container text-center mt-5">
                <ul class="pagination">
                    <?php if ($pagination['current_page'] > 1): ?>
                    <li class="page-item">
                        <a class="page-link" href="<?= BASE_URL ?>/index.php?route=trips&page=<?= $pagination['current_page'] - 1 ?>&query=<?= urlencode($query) ?>&region=<?= urlencode($region) ?>&min_price=<?= $minPrice ?>&max_price=<?= $maxPrice ?>">
                            <i class="fas fa-chevron-left"></i> Précédent
                        </a>
                    </li>
                    <?php endif; ?>
                    
                    <?php for ($i = max(1, $pagination['current_page'] - 2); $i <= min($pagination['total_pages'], $pagination['current_page'] + 2); $i++): ?>
                    <li class="page-item <?= $i == $pagination['current_page'] ? 'active' : '' ?>">
                        <a class="page-link" href="<?= BASE_URL ?>/index.php?route=trips&page=<?= $i ?>&query=<?= urlencode($query) ?>&region=<?= urlencode($region) ?>&min_price=<?= $minPrice ?>&max_price=<?= $maxPrice ?>">
                            <?= $i ?>
                        </a>
                    </li>
                    <?php endfor; ?>
                    
                    <?php if ($pagination['current_page'] < $pagination['total_pages']): ?>
                    <li class="page-item">
                        <a class="page-link" href="<?= BASE_URL ?>/index.php?route=trips&page=<?= $pagination['current_page'] + 1 ?>&query=<?= urlencode($query) ?>&region=<?= urlencode($region) ?>&min_price=<?= $minPrice ?>&max_price=<?= $maxPrice ?>">
                            Suivant <i class="fas fa-chevron-right"></i>
                        </a>
                    </li>
                    <?php endif; ?>
                </ul>
            </div>
            <?php endif; ?>
            
        </div>
        <?php endif; ?>
    </div>
</section>

<!-- Séparateur visuel entre le contenu principal et le pied de page -->
<div class="page-divider">
    <div class="container">
        <div class="divider-content">
            <div class="divider-line"></div>
            <div class="divider-icon">
                <i class="fas fa-route"></i>
            </div>
            <div class="divider-line"></div>
        </div>
    </div>
</div>

<script>
// Script simplifié pour le tri des résultats
document.addEventListener('DOMContentLoaded', function() {
    const sortSelect = document.getElementById('sort-results');
    if (sortSelect) {
        sortSelect.addEventListener('change', function() {
            const tripsGrid = document.querySelector('.trips-grid');
            if (!tripsGrid) return;
            
            const tripCards = Array.from(tripsGrid.querySelectorAll('.trip-card'));
            
            tripCards.sort((a, b) => {
                const aPrice = parseFloat(a.dataset.price);
                const bPrice = parseFloat(b.dataset.price);
                const aDuration = parseInt(a.dataset.duration);
                const bDuration = parseInt(b.dataset.duration);
                
                switch (sortSelect.value) {
                    case 'price-asc':
                        return aPrice - bPrice;
                    case 'price-desc':
                        return bPrice - aPrice;
                    case 'duration-asc':
                        return aDuration - bDuration;
                    case 'duration-desc':
                        return bDuration - aDuration;
                    default:
                        return 0;
                }
            });
            
            // Vider la grille et réinsérer les éléments triés
            tripsGrid.innerHTML = '';
            tripCards.forEach(card => tripsGrid.appendChild(card));
        });
    }
});
</script> 